<?php

namespace Takuya\BacklogApiClient;

use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use function Takuya\Utils\sub_domain;
use function Takuya\Utils\base_domain;
use function Takuya\Utils\parent_domain;
use function Takuya\Utils\assert_str_is_domain;
use League\Flysystem\WebDAV\WebDAVAdapter;
use League\Flysystem\Filesystem;
use function Takuya\Utils\array_map_with_key;

class BacklogAPIClient {
  
  use BacklogAPIv2Methods;
  use CacherTrait;
  use LoggerTrait;
  
  protected RequestRateLimiter $limiter;
  protected string             $space;
  protected string             $tld;
  
  public function __construct( protected $spaceId_or_url, protected $key ) {
    [$this->space, $this->tld] = $this->validateSpaceId($spaceId_or_url);
    $this->limiter = new RequestRateLimiter();
  }
  public function addSharedFile($projectId,$path,$content, $userName=null,$password=null){
    $user = $userName ?? getenv('BACKLOG_USER');
    $pass = $password ?? getenv('BACKLOG_PASS');
    $client = new \Sabre\DAV\Client([
      'baseUri' => $this->getDavAddress($projectId),
      'userName' => $user,
      'password' => $pass
    ]);
    $adapter = new WebDAVAdapter($client);
    $filesystem = new Filesystem($adapter);
    $filesystem->write($path,$content);
  }
  public function getSharedFileId( $projectId,$path ){
    $list = $this->getListOfSharedFiles($projectId,'');
    foreach ( $list as $item ) {
      if ($path == $item->dir.DIRECTORY_SEPARATOR.$item->name){
        return $item->id;
      }
    }
    return null;
  }
  public function getDavAddress(int|string $project_id_or_key){
    $key = null;
    if (is_int($project_id_or_key)){
      $key = $this->getProject($project_id_or_key)->projectKey;
    }else{
      $key = $project_id_or_key;
    }
    return sprintf('%s/dav/%s/',$this->base_uri(),$key);
  }
  
  protected function validateSpaceId( string $spaceId_or_url ):array {
    if( str_starts_with($spaceId_or_url, 'http') ) {
      $spaceId_or_url = parse_url($spaceId_or_url)['host'];
    }
    if( assert_str_is_domain($spaceId_or_url) ) {
      $space_id = sub_domain($spaceId_or_url);
      $tld = parent_domain(base_domain($spaceId_or_url), false);
    }
    $space_id = $space_id ?? $spaceId_or_url;
    $tld = $tld ?? 'com';
    
    return [$space_id, $tld];
  }
  
  public static function parseBackLogUrl( $url ) {
    $projectKey = $action = $spaceKey = $projectId = $wiki = null;
    $spaceKey = sub_domain(parse_url($url)['host']);
    $path = parse_url($url)['path'] ?? '/';
    preg_match('|^/([^/]+)|', $path, $m);
    $top_dir = $m[1] ?? null;
    $action = $top_dir ?? '';
    if( preg_match('|^(.+)\.action$|', $action, $m) > 0 ) {
      $action = $m[1];
      preg_match('/project.?id=([^&]+)/i', parse_url($url)['query'], $m);
      $projectId = $m[1] ?? null;
      preg_match('/projectKey=([^&]+)/i', parse_url($url)['query'], $m);
      $projectKey = $m[1] ?? null;
    }
    if( preg_match('|wiki|', $path) ) {
      if( preg_match('|/wiki/([^/]+)?|', $path, $m) ) {
        $a = preg_split('|/|', $path);
        $projectKey = $a[2];
        $wiki = ['page' => $a[3],];
      }
      if( preg_match('|/alias/([^/]+)/([^/]+)|', $path, $m) ) {
        $action = 'alias/wiki';
        $projectKey = null;
        $wiki = ['id' => $m[2],];
      }
    } else {
      if( ctype_lower($action) ) {
        preg_match('|^/([^/]+)/([^/]+)|', $path, $m);
        $projectKey = $m[2] ?? '';
        if( preg_match('|-\d+$|', $projectKey) ) {
          $comment_id = array_slice(explode('-', $projectKey), -1, 1)[0];
          $projectKey = str_replace("-{$comment_id}", "", $projectKey);
        }
      }
    }
    
    return compact('spaceKey', 'action', 'projectId', 'projectKey', 'wiki');
  }
  
  public function spaceKey():string {
    return $this->space;
  }
  
  public function enableRateLimiter() {
    $this->limiter->enableRateLimitWaiting();
  }
  
  public function disableRateLimiter() {
    $this->limiter->disableRateLimitWaiting();
  }
  
  public function getRateLimiterInfo() {
    return $this->limiter->getRateLimitInfo();
  }
  
  /**
   * @param string $class  BaseModel::class string for json mapping
   * @param string $method HTTP Method, GET / PUT / POST / DELETE.
   * @param        $query  array of query for BacklogApiClient.
   * @param        $parent
   * @return array|\Takuya\BacklogApiClient\Models\BaseModel[]
   */
  public function into_class( string $class, string $method, $query = [], $parent = null ) {
    $ret = $this->$method(...$query);
    if( is_array($ret) ) {
      return array_map(fn( $obj ) => new $class($obj, $this, $parent), $ret);
    }
    if( is_object($ret) ) {
      return new $class($ret, $this, $parent);
    }
    throw new RuntimeException('failed to mapping');
  }
  
  public function call_api( $method, $path, $query = null, $params=null) {
    $method = strtoupper($method);
    $key = ['apiKey' => $this->key];
    $options = ['query' => $key ];

    if ('GET'==$method && !empty($query)){
      $query = array_merge_recursive($key, $query??[]);
      $options = ['query' => $this->http_build_query($query)];
    }else if (in_array($method,['POST','PUT','PATCH','DELETE'] )&& !empty($params)){
      if (!empty($params['multipart'])){
        $options = array_merge_recursive($options,$params);
      }else{
        $options['body'] = $this->http_build_query($params['form_params']??$params);
      }
    }
    //
    $res = $this->send_request($method, $path,$options );
    if( str_contains($res->getHeader("Content-Type")[0] ?? '', 'json') ) {
      return json_decode($res->getBody()->getContents());
    }
    
    return $res->getBody()->getContents();
  }
  protected function http_build_query($data,$numeric_prefix=false,$arg_separator=null,$encoding_type=PHP_QUERY_RFC3986) {
    // custom field は複数キーが許可される。
    $cust_array = array_filter( $data, fn( $v, $k ) => preg_match( '/custom/', $k ) && is_array( $v ),
      ARRAY_FILTER_USE_BOTH );
    if ( sizeof( $cust_array ) > 0 ) {
      $cf_list = '&'.join( '&',
          array_map_with_key( $cust_array, function( $k, $values ) {
            return join( '&', array_map( fn( $v ) => sprintf( "%s=%s", urldecode( $k ), urlencode( $v ) ), $values ) );
          } ) );
    }else{
      $cf_list = '';
    }
  
    // bool値が name=1 になるのを避けて、 name=true にする。
    array_walk_recursive( $data, function( &$v ) {
      if ( is_bool( $v ) ) {
        $v = json_encode( $v );
      }
    } );
    // 配列が name[0]=value になるのを避けて、name[]=value にする
    $str = http_build_query( $data, $numeric_prefix, $arg_separator = null, $encoding_type );
    $str = preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '%5B%5D=', $str );
    return $str.$cf_list;
  }
  
  protected function send_request( $method, $path, $opts ) {
    try {
      $this->limiter->waitForRateLimit();
      $client = new Client(['base_uri' => $this->base_uri()]);
      $this->log([$method, $path, $opts],'debug');
      $res = $client->request($method, $path, $opts);
      $this->limiter->parseRateLimit($res);
      
      return $res;
    } catch (ClientException $e) {
      $this->log($e->getRequest()->getUri()->__toString());
      $this->log($e->getResponse()->getBody()->getContents());
      //$r = $e->getRequest()->getBody();
      //$r->rewind();
      //dump(urldecode($r->getContents()));
      throw $e;
       //return $e->getResponse();
    }
  }
  
  public function base_uri() {
    return "https://{$this->space}.backlog.{$this->tld}";
  }
  
  public function issue_ids( $project_id ) {
    $q = ['projectId[]' => $project_id, 'sort' => 'created', 'order' => 'asc', 'count' => 100, 'offset' => 0];
    $list = $this->list_all('getIssueList', [$q]);
    
    return array_map(fn( $e ) => $e->id, $list);
  }
  
  protected function list_all( $method, $q = [] ) {
    // TODO:GENERATOR にする。課題が１０００件あると１０回もリクエストがおきる。
    $params = &$q[sizeof($q) - 1];
    $limit = $params['count'];
    $params['offset'] = ! empty($params['offset']) ? $params['offset'] : 0;
    $list = [];
    do {
      $result = $this->$method(...$q);
      $params['offset'] = $params['offset'] + $limit;
      array_push($list, ...$result);
    } while(sizeof($result) == $limit);
    
    return json_decode(json_encode($list));
  }
}

