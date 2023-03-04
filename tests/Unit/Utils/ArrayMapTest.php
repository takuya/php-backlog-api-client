<?php

namespace tests\Unit\Utils;

use PHPUnit\Framework\TestCase;
use function Takuya\Utils\array_map_with_key;
use function Takuya\Utils\array_map_on_keys;
use function Takuya\Utils\array_subtract;
use function Takuya\Utils\array_column_select;

class ArrayMapTest extends TestCase {
  
  public function test_array_map_with_key () {
    $array = ['a' => 1, 'b' => 2];
    
    $result = array_map_with_key( $array, fn( $k, $v ) => $k == 'b' ? $v*$v : $v );
    $this->assertEquals( ['a' => 1, 'b' => 4], $result );
    
    $result = array_map_with_key( $array, fn( $k, $v ) => $v );
    $this->assertEquals( $array, $result );
  }
  
  public function test_array_map_on_keys () {
    $array = ['a' => 1, 'b' => 2];
    $result = array_map_on_keys( ['a'], $array, fn( $e ) => $e*2 );
    $this->assertEquals( ['a' => 2, 'b' => 2], $result );
  }
  
  public function test_array_subtract () {
    $p = [['a' => 1], ['b' => 1], ['c' => 1]];
    $q = [['a' => 1], ['b' => 1], ['d' => 1]];
    $r = array_subtract( $p, $q );
    $this->assertEquals( [['c' => 1]], $r );
  }
  
  public function test_array_column_select () {
    $x = [
      ['a' => 1, 'b' => 1, 'c' => 1],
      ['a' => 2, 'b' => 2, 'c' => 2],
    ];
    $y = array_column_select( ['a', 'b'], $x );
    $this->assertEquals( [['a' => 1, 'b' => 1,],['a' => 2, 'b' => 2,],], $y );
  }
}