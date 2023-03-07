<?php

namespace tests\Unit\HTTP;

use tests\TestCase;
use GuzzleHttp\Client;
use function Takuya\Utils\array_map_with_key;

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
  public function test_custom_field_for_http_build_query(){
    $data = ['customField_1234'=>1,'customField_1235'=>['a','b','c'],'customField_1236'=>['あ','い','う']];
    $cust_array = array_filter($data,fn($v,$k)=>preg_match('/custom/',$k)&&is_array($v),ARRAY_FILTER_USE_BOTH);
    // 処理
    $query = join('&',
      array_map_with_key($cust_array,function($k,$values){
        return join('&',array_map(fn($v)=> sprintf("%s=%s",urldecode($k),urlencode($v)),$values));
      }));
    
    $this->assertEquals("customField_1235=a&customField_1235=b&customField_1235=c".
      "&customField_1236=%E3%81%82&customField_1236=%E3%81%84&customField_1236=%E3%81%86",$query);
    
    
  }
}