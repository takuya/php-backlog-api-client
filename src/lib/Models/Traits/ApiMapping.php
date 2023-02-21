<?php

namespace Takuya\BacklogApiClient\Models\Traits;

use stdClass;

trait ApiMapping {
  
  /**
   * @param object $json   Json Result Object by json_decode
   * @param object $target target object copy to.
   * @return void
   */
  protected function mapping( object $json, object $target ) {
    array_map(function ( $prop ) use ( $json, $target ) { $target->$prop = $json->$prop; }, array_keys((array)$json));
  }
  
  /**
   * @param string $property_name property name of object.
   * @param string $class         Name of Class to construct.
   * @return void
   */
  protected function remapping_to_model( string $property_name, string $class ) {
    if( is_array($this->$property_name) ) {
      foreach ($this->$property_name as $idx => $e) {
        $obj = ( get_class($e) === stdClass::class ) ? $e : ( json_decode(json_encode($e)) );
        $this->$property_name[$idx] = new $class($obj, $this->api, $this);
      }
    }
    if( is_object($this->$property_name) ) {
      $this->$property_name = new $class($this->$property_name, $this->api, $this);
    }
  }
}