<?php

namespace tests\Unit\HTTP;

use tests\TestCase;
use GuzzleHttp\Client;

class HttpBuildQueryTest extends TestCase {
  
  public function test_http_build_query(){
    $data = ['a'=>1,'b'=>"あ[0]=あああ",'names'=>['a','b','c'],'assoc'=>['key'=>'value']];
    $ret = http_build_query($data,false,null,PHP_QUERY_RFC3986);
    $ret = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '%5B%5D=', $ret);
    //
    $this->assertStringNotContainsString('names[0]=', urldecode($ret));
    $this->assertStringContainsString('names[]=', urldecode($ret));
    $this->assertStringContainsString('あ[0]=', urldecode($ret));
  }
  //public function test_guzzle_http(){
  //  $cli = new Client(['base_uri' => 'http://localhost:8080']);
  //  $ret = $cli->request('GET','/?b[]=1',['query'=>'a=1']);
  //  dd($ret->getBody()->getContents());
  //}
  
}