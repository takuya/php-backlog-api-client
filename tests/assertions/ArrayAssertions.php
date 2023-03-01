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
  public function assertArrayIsSubArrayOf( $expected_main_array, $sub_array){
    self::assertEmpty(array_diff($sub_array,$expected_main_array));
  }
  public static function assertArrayIsSameValues($expected,$arr){
    sort($expected);
    sort($arr);
    self::assertEquals($expected,$arr);
  }
  public static function assertIsArrayOfString ( $array ) {
    array_walk_recursive( $array, function( $v ) {
      self::assertIsString( $v );
    } );
  }
  
  public static function assertIsArrayOfInt ( $array ) {
    array_walk_recursive( $array, function( $v ) {
      self::assertIsInt( $v );
    } );
  }
  
  public static function assertIsArrayOfArray ( $array ) {
    array_map(function( $v ) {
      self::assertIsArray( $v );
    },$array);
  }
}