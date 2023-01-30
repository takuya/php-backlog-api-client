<?php

namespace Takuya\BacklogApiClient;

use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class BacklogAPIClient {
  
  use BacklogAPIv2Methods;
  use CacherTrait;
  
  public function __construct( protected $space,
                               protected $key,
                               protected $tld = 'com', ) {
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
  
  public function call_api( $method, $path, $query = [] ) {
    $query = array_merge_recursive(['apiKey' => $this->key], $query);
    $res = $this->send_request($method, $path, ['query' => $query]);
    if( str_contains($res->getHeader("Content-Type")[0], 'json') ) {
      return json_decode($res->getBody()->getContents());
    }
    
    return $res->getBody()->getContents();
  }
  
  protected function send_request( $method, $path, $opts ) {
    try {
      $client = new Client(['base_uri' => $this->base_uri()]);
      $res = $client->request($method, $path, $opts);
      
      return $res;
    } catch (ClientException $e) {
      dump($e->getRequest()->getUri()->__toString(), $e->getResponse()->getBody()->getContents());
      throw $e;
      // return $e->getResponse();
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

