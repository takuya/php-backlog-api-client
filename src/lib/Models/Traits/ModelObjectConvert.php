<?php

namespace Takuya\BacklogApiClient\Models\Traits;


use Takuya\BacklogApiClient\Models\BaseModel;

trait ModelObjectConvert {
  
  public function toArray (): array {
    $ref = new \ReflectionClass( $this );
    $arr = (array)$this;
    // remove protected.
    foreach ( $arr as $k=>$v ) {
      if ( str_contains($k,"\x00*\x00")){
        unset($arr[$k]);
      }
    }
    foreach ($arr as $k=>$v){
      if( is_object($v) && method_exists($v,'toArray')){
        $arr[$k] = $v->toArray();
      }
    }
    return json_decode(json_encode($arr),JSON_OBJECT_AS_ARRAY);
  }
  public function toJson (): string {
    $o = JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS|JSON_PRETTY_PRINT;
    return json_encode($this->toArray(),$o);
  }
}