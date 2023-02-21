<?php

namespace Tests\assertions;

trait PropertyAssertions  {
  public static function assertPropIsExists($prop_name,$obj){
    $ret = property_exists($obj,$prop_name);
    self::assertThat($ret, static::isTrue($ret));
  }
  public static function assertHasProperties(array $property_names, $obj){
    foreach ( $property_names as $property_name ) {
      self::assertPropIsExists($property_name,$obj);
    }
    
  }
  

}