<?php

namespace Takuya\Utils;

if ( !function_exists( __NAMESPACE__.'\array_map_with_key' ) ) {
  function array_map_with_key (array $array, callable $callable): array {
    return array_combine(array_keys($array),array_values(array_map($callable,array_keys($array),array_values($array))));
  }
}
if ( !function_exists( __NAMESPACE__.'\array_map_on_keys' ) ) {
  function array_map_on_keys (array $keys,array $array, callable $callable): array {
    return array_combine(array_keys($array),array_map(fn($k,$v)=> in_array($k,$keys)? $callable($v):$v,array_keys($array),array_values($array)));
  }
}
if ( !function_exists( __NAMESPACE__.'\array_select' ) ) {
  function array_select (array $keys_to_select,array $array): array {
    return array_filter( $array, fn( $k ) => in_array( $k, $keys_to_select ), ARRAY_FILTER_USE_KEY );
  }
}
if ( !function_exists( __NAMESPACE__.'\array_subtract' ) ) {
  function array_subtract (array $minuend,array $subtrahend): array {
    return array_values(array_udiff( $minuend, $subtrahend, function( $x, $y ) {
      return ( $x == $y )?0:-1;
    } ));
  }
}
if ( !function_exists( __NAMESPACE__.'\array_column_select' ) ) {
  function array_column_select (array $column_names, array $array_of_array): array {
    return array_map(fn($e)=>array_select( $column_names,$e), $array_of_array );
  }
}
if ( !function_exists( __NAMESPACE__.'\array_each_with_key' ) ) {// foreach 同等
  function array_each_with_key (array $array, callable $function): void {
    foreach ( $array as $key => $value ) {
      $function($key,$value);
    }
  }
}



