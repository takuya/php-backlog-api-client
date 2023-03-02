<?php

namespace Takuya\BacklogApiDocScraping;

require_once __DIR__.'/../../../vendor/autoload.php';
class BacklogDocToClass {
  
  public static function cache_path($file){
    $cache_dir = __DIR__.'/../../cache/';
    if ( !file_exists($cache_dir)){
      mkdir($cache_dir);
    }
    return $cache_dir.$file;
  }
  public static function execute():int {
  
    $self = new BacklogDocToClass();
    $ret = $self->api_list_json();
    $class_def = $self->generate_class_def($ret);
    $html = $self->render_table($ret);
    //file_put_contents(__DIR__.'/BacklogAPIv2Methods.php',$class_def);
  
    file_put_contents(__DIR__.'/api.html', $html);
    file_put_contents(__DIR__.'/../../../src/BacklogAPIv2Methods.php', $class_def);
    return 0;
  }
  protected function api_list_json() {
    $f_name = self::cache_path('out.json');
    if( file_exists($f_name) ) {
      return json_decode(file_get_contents($f_name));
    }
    $links = $this->get_api_links();
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-pull-request/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-notification/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/add-user/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-issue-participant-list/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-space-logo/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-activity/'];
    // $links = ['https://developer.nulab.com/ja/docs/backlog/api/2/get-received-star-list/'];
    $docs = [];
    foreach ($links as $idx=> $link) {
      try {
        dump($idx,$link);
        $ret = $this->parse_page($link);
        $docs[] = $ret;
      } catch (\Exception $e) {
        dump($link);
        throw $e;
      }
    }
    $json = json_encode($docs);
    file_put_contents($f_name, $json);
    dump('scraping saved.');
    return json_decode($json);
  }
  protected function get_api_links() {
    $url = 'https://developer.nulab.com/ja/docs/backlog/api/2/get-space/';
    $xquery = "//li[contains(.,'Backlog API')]//a[@class='sidebar__links'][contains(@href,'docs/backlog/api/2/')]";
    $html = file_get_contents($url);
    $dom = new \DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new \DOMXPath($dom);
    $links = $xpath->query($xquery);
    $ret = array_map(function ( $el ) use ( $url ) {
      /** @var \DOMElement $el */
      $href = $el->getAttribute('href');
      $page_url = url_join($url, $href);
      
      return $page_url;
    }, iterator_to_array($links));
    
    return $ret;
  }
  protected function parse_page( $url ) {
    $html = file_get_contents($url);
    $dom = new \DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new \DOMXPath($dom);
    print($url.PHP_EOL);
    $info = [
      'method' => '//*[contains(@id,"メソ") or contains(@id,"meth")][1]/following-sibling::pre[1]/code',
      'path'   => '//*[contains(@id,"url")][1]/following-sibling::pre[1]/code',
      'title'  => '//main//h1 | //main//h2[1]',# 一部構成が狂ってるページが有る。
      'priv'   => '//*[contains(@id,"権限") or contains(@id,"role")][1]/following-sibling::pre[1]/code',
      'response' => '//*[contains(@id,"ボデ") or contains(@id,"res")][1]/following-sibling::pre[1]/code'
    ];
    
    foreach ($info as $k => $q) {
      $r = $xpath->evaluate($q);
      $info[$k] = $r[0]?->textContent ?? '';
    }
    $info = array_map('trim', $info);
    // response sample
    if ( isset($info['response'] ) && !empty($info['response']) ){
      $response = $this->parse_response_json_sample($info['response'],basename(parse_url($url)['path']));
      // dd($response);
      $info['response'] = $response;
    }
    // url params
    $table = $xpath->evaluate('//h2[contains(@id,"url-パラ") or contains(@id,"url-para")]/following-sibling::table[1]/tbody');
    if( sizeof($table) > 0 ) {
      $args = array_map(function ( $tr ) use ( $xpath ) {
        return array_map(fn( $e ) => $e->textContent, iterator_to_array($xpath->evaluate('./td', $tr)));
      }, iterator_to_array($xpath->evaluate('./tr', $table[0])));
      $info['url_args'] = $args;
    }
    //query params
    $table = $xpath->evaluate('//h2[contains(@id,"クエリパラ") or contains(@id,"query-para")]/following-sibling::table[1]/tbody');
    if( sizeof($table) > 0 ) {
      $trs = $xpath->evaluate('./tr', $table[0]);
      $args = array_map(function ( $tr ) use ( $xpath ) {
        $tds = $xpath->evaluate('./td', $tr);
        $tds = array_map(fn( $e ) => $e->textContent, iterator_to_array($tds));
        return $tds;
      }, iterator_to_array($trs));
      $info['query_args'] = $args;
    }
    // リクエスト・パラメタ
    $table = $xpath->evaluate('//h2[contains(@id,"リクエストパラ") or contains(@id,"query-para")]/following-sibling::table[1]/tbody');
    if( sizeof($table) > 0 ) {
      $trs = $xpath->evaluate('./tr', $table[0]);
      $args = array_map(function ( $tr ) use ( $xpath ) {
        $tds = $xpath->evaluate('./td', $tr);
        $tds = array_map(fn( $e ) => $e->textContent, iterator_to_array($tds));
        return $tds;
      }, iterator_to_array($trs));
      $info['request_args'] = $args;
    }
    
    $info['doc_url'] = $url;
    $info['kebab'] = basename(parse_url($url)['path']);
    $info['Camel'] = kababToCamel($info['kebab']);
    return $info;
  }
  protected function parse_response_json_sample($json,$api_name){
    // 記述ミスを修正
    $json = preg_replace('|,\s+\.\.\.|i',"\n",$json);
    switch($api_name){
      case "get-notification":
        $json = preg_replace('|,,|m',',',$json);
        $json = preg_replace('|"id": 2 \n|m','"id": 2,',$json);
        break;
      case 'get-pull-request':
        $json = preg_replace("|(mailAddress[^,]+) \n|m","\$1,\n",$json);
        break;
      
    }
    // file_put_contents('sample.json',$json);
    $ret = json_decode($json,null,512,JSON_THROW_ON_ERROR);
    if (empty($ret)){
      throw  new \RuntimeException($ret);
    }
    // if (is_array($ret)){
    //   sizeof($ret) > 1 && $ret=$ret[0];
    // }
    // if(is_object($ret) && get_class($ret) == \stdClass::class){
    //   $ret = (array)$ret;
    // }
    return $ret;
    
  }
  protected function generate_class_def($ret){
    $method_definitions = [];
    foreach ($ret as $item) {
      $method_definitions[]=$this->doc_to_method($item);
    };
    $body = implode("\n\n",$method_definitions);
    $class_def = <<<EOF
    <?php
    namespace Takuya\BacklogApiClient;
    trait BacklogAPIv2Methods {
      $body
    }
    EOF;
    //
    dump('class definition saved.');
    return $class_def;
  }
  protected function doc_to_method($info){

    $http_meth= $info->method;
    $http_path = $info->path;
    $doc_url = $info->doc_url;
    dump($doc_url);
    $name = $info->Camel;
  

    if ($name == 'postAttachmentFile'){
      $info->request_args=[['multipart[]','','']];
    }
  
  
    $res_shape = $this->response_sample_to_array_shape($info->response);
    $path_params = [];
    if (str_contains($info->path,':')){
      preg_match_all('/:(\w+)/',$http_path,$m);
      $m = $m[1];
      $path_params = array_map(fn($e)=>'$'.$e, $m);
      $http_path = str_replace(':','$',$http_path);
    }
  
    $request_args_shape= '';
    $func_args = $path_params;
    if (!empty($info->request_args)){
      
      $assoc = $info->request_args;
      $assoc = array_map(fn($e)=>$e[0],$assoc);
      $assoc = array_map(fn($e)=>preg_replace('/[^A-z]/','',$e),$assoc);
      $assoc = array_map(fn($e)=>"'${e}'=>null",$assoc);
      $assoc = array_map(fn($e)=>str_replace("[]'=>null","'=>[]",$e),$assoc);
      if ($name == 'postAttachmentFile') {// マルチパート
        $assoc = ["'multipart'=>['name'=>'','filename'=>'','contents'=>'',]"];
      }
      $func_args[] = str_replace('{assoc}',implode(', ',$assoc),'$params=[{assoc}]');
      
      
      $array_shape = $assoc;
      $array_shape = array_map(fn($e)=>str_replace("'",'',$e),$array_shape);
      $array_shape = array_map(fn($e)=>preg_split('/=>/',$e),$array_shape);
      $array_shape = array_map(function($e){$e[1]=$e[1]=='null'?null:$e[1];return $e;},$array_shape);
      $array_shape = array_map(function($e){$e[1]=$e[1]=='[]'?[]:$e[1];return $e;},$array_shape);
      $array_shape = array_combine(array_map(fn($e)=>$e[0],$array_shape),array_map(fn($e)=>$e[1],$array_shape));
      $request_args_shape =  $this->response_sample_to_array_shape((object)$array_shape);
      if ($name == 'postAttachmentFile'){
        $request_args_shape = "array{ multipart: array{name: string,filename:string,contents:string}}";
      }
    }else if(!empty($info->query_args)){
      $func_args[] ='$query_options=[]';
    }
    $func_args = implode(', ', array_filter($func_args));
    dump($func_args);
    $func_def = [];
    $func_def[] = "/**";
    $func_def[] = "*  {$info->title}";
    $func_def[] = "*";
    foreach ($path_params as $path_param){
      $func_def[] = !empty($path_param) ? "* @param string|int $path_param":null;
    }
    $func_def[] = !empty($info->query_args) ? '* @param array $query_options':null;
    $func_def[] = !empty($info->request_args) ? "* @param $request_args_shape \$params":null;
    $func_def[] = "* @return {$res_shape}";
    $func_def[] = "* @link {$info->doc_url}";
    $func_def[] = "*/";
    $func_def[] = "public function $name($func_args){";
    if (!empty($info->query_args)){
      $func_body = sprintf( '  return $this->call_api("%s", "%s", $query_options );', $http_meth,$http_path, );
    }
    else if (!empty($info->request_args)){
      $func_body = sprintf( '  return $this->call_api("%s", "%s",[], $params );', $http_meth,$http_path, );
    }else{
      $func_body = sprintf( '  return $this->call_api("%s", "%s" );', $http_meth,$http_path, );
    }
    $func_def[] = $func_body;
    $func_def[] = "}";
    $func_def = array_filter($func_def);
    $func_def = "  ".implode(PHP_EOL."  ",$func_def);
    

    // dump($http_path);
    // if( preg_match('/image/i',$http_path) ){
    //   dd($info);
    // }
    return $func_def;
  }
  protected function response_sample_to_array_shape($res){
    if (is_object($res)){
      return $this->convert_object_to_array_shape($res);
    }
    if (is_array($res)){
      $entry = $this->convert_object_to_array_shape($res[0]);
      return "array< {$entry} >";
    }
  }
  protected function convert_object_to_array_shape($obj){
    $shape = (array)$obj;
    $shape = array_map('gettype',$shape);
    $shape=  array_combine(array_keys($shape),array_map(fn($e)=>$e=='NULL'?'?string':$e,$shape));
    $shape = json_encode($shape);
    $shape = str_replace('"','',$shape);
    $shape = str_replace(':',': ',$shape);
    $shape = str_replace(',',', ',$shape);
    $shape = is_array($obj)?'array':'object'.$shape;
    return $shape;
  }
  protected function render_table( $docs ) {
    $table = "<table class='main'>";
    foreach ($docs as $page) {
      $args = '';
      if( isset($page->args) ) {
        $args = implode(
          '',
          array_map(function ( $e ) {
            return "<tr><td>{$e[0]}</td><td>{$e[1]}</td><td>{$e[2]}</td></tr>";
          }, $page->args));
        $args = "<table>{$args}</table>";
      }
      $rec = <<<EOF
        <tr>
          <td><a href="{$page->doc_url}">{$page->title}</a></td>
          <td>{$page->Camel}</td>
          <td>{$page->method}</td>
          <td>{$page->path}</td>
        <tr>
      EOF;
      $table .= $rec;
    }
    $table .= '</table>';
    $html = <<<EOF
    <html>
      <head>
        <meta lang="ja">
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
          body {
            margin: 0 auto;
            padding: 0;
          
          }
          table.main{
            border-collapse: collapse;
            width: 1000px;
            left:0;
            right: 0;
            margin: 0 auto;
          }
          table.main > th,td {
            border: solid 1px;
            padding: 3px;
            word-wrap: break-word;
            word-break: break-all;
            overflow-wrap: break-word;
            width: 25%;
            overflow: scroll;
            font-size: 12px;
            font-family: monospace;
          }
          table tr > td:nth-child(1){
            width: 10%;
          }
          table tr > td:nth-child(2){
            width: 10%;
          }
          table tr > td:nth-child(3){
            width: 3%;
          }
          table tr > td:nth-child(4){
            width: 30%;
          }
          table.main table {
            border-collapse: collapse;
            width: auto;
          }
          table.main table  > td,th{
            border: 0.5px solid aliceblue;
          }
      </style>
      </head>
      <body>
        {$table}
      </body>
      </html>

    EOF;
    
    return $html;
  }
  
  
  
}