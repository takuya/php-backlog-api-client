<?php

namespace Takuya\BacklogApiDocScraping;


class JsonPropCodeGen {
  
  /**
   * json オブジェクトから、プロパティ宣言を作る
   * @param object $obj
   * @return string
   */
  public static function generate_code_for_property( object $obj ):string {
    $keys = array_filter(array_keys((array)$obj), function ( $e ) { return ! str_contains($e, "\x00"); });
    $ret = implode(
      PHP_EOL,
      array_map(function ( $p ) use ( $obj ) { return sprintf('public %s $%s;', gettype($obj->$p), $p); }, $keys));
    $ret = str_replace('integer', 'int', $ret);
    $ret = str_replace('boolean', 'bool', $ret);
    $ret = str_replace('NULL', 'string', $ret);
    $ret = $ret.PHP_EOL;
    
    return $ret;
  }
  
  /**
   * オブジェクトからPHPDocを作る
   * @param object $obj
   * @return string
   */
  public static function generate_phpdoc_block_for_property( object $obj ):string {
    $keys = array_filter(array_keys((array)$obj), function ( $e ) { return ! str_contains($e, "\x00"); });
    $ret = implode(
      PHP_EOL,
      array_map(
        function ( $p ) use ( $obj ) { return sprintf('* @property-read %s $%s', gettype($obj->$p), $p); },
        $keys));
    $ret = str_replace('integer', 'int', $ret);
    $ret = str_replace('boolean', 'bool', $ret);
    $ret = str_replace('NULL', 'string', $ret);
    $ret = implode(PHP_EOL, ['/**', $ret, '*/']);
    
    return $ret;
  }
}