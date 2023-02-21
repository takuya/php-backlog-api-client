<?php

namespace tests\assertions;

trait ArrayAssertions {
  public static function assertArrayHasKeyOfList(array $keys, $array){
    foreach ( $keys as $key ) {
      self::assertArrayHasKey($key,$array);
    }
  }
  public static function assertArrayIsConsitsOfPermitiveType( $array){
    array_walk_recursive($array,function($v){
      self::assertTrue(
        is_array($v)||
        is_numeric($v)||
        is_string($v)||
        is_bool($v)||
        is_null($v)
      );
      
    } );
  
  }
}