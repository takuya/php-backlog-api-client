<?php

namespace tests\assertions;

trait ArrayAssertions {
  public static function assertArrayHasKeyOfList(array $keys, $array){
    foreach ( $keys as $key ) {
      self::assertArrayHasKey($key,$array);
    }
  }
}