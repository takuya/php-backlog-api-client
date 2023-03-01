<?php

namespace Takuya\BacklogApiClient\Utils;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;

class StrTool {
  protected static Inflector $inflector;
  
  public static function inflector (): Inflector {
    return static::$inflector ??= InflectorFactory::createForLanguage( 'english' )->build();
  }
  
  public static function singular ( string $str ) {
    return static::inflector()->singularize( $str );
  }
  
  public static function plural ( string $str ) {
    return static::inflector()->pluralize( $str );
  }
  
  public static function isSingular ( string $str ) {
    return $str == static::singular( $str );
  }
  
  public static function isPlural ( string $str ) {
    return $str == static::plural( $str );
  }
  
  public static function snake ( $value, $delimiter = '_' ) {
    $value = preg_replace( '/\s+/u', '', ucwords( $value ) );
    $value = preg_replace( '/(.)(?=[A-Z])/u', '$1'.$delimiter, $value );
    $value = mb_strtolower( $value, 'UTF-8' );
    return $value;
  }
}

