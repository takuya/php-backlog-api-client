<?php

namespace Takuya\BacklogApiClient\Utils;

class JsonMapper {
  
  public function map(string $class, object $data){
    $ref = new \ReflectionClass($class);
    $new = $ref->newInstance();
    $arr = (array)$data;
    foreach ($arr as $key => $value){
    
    }
  }
}