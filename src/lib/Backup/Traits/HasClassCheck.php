<?php

namespace Takuya\BacklogApiClient\Backup\Traits;

use Takuya\BacklogApiClient\Models\BaseModel;

trait HasClassCheck {
  protected function hasInterface ( $class, $interface ) {
    $ref = new \ReflectionClass( $class );
    $result = array_filter( $ref->getInterfaceNames(), fn( $e ) => $e == $interface );
    return sizeof( $result ) > 0;
  }
  
  protected function hasTrait ( $class, $trait ) {
    $ref = new \ReflectionClass( $class );
    $result = array_filter( $ref->getTraitNames(), fn( $e ) => $e == $trait );
    return sizeof( $result ) > 0;
  }
  protected function isClass($obj,$class){
    return get_class($obj)==$class;
  }
  protected function findTraits( $class, callable $func){
    $ref = new \ReflectionClass( $class );
    $relates = array_filter( $ref->getTraitNames(), $func );
    $traits = [];
    $props = [];
    foreach ( $relates as $relate ) {
      $traits[] = $ref->getTraits()[$relate];
    }
    return $traits;
  }
  protected function findRelationTraits($class){
    return $this->findTraits($class,fn( $e ) => str_contains( $e, '\RelateTo' ));
  }
  
  public function findClass ( $short_class_name ) {
    $list = BaseModel::listModelClass();
    foreach ( $list as $item ) {
      if ( str_ends_with( $item, $short_class_name, ) ) {
        return $item;
      }
    }
    throw new \RuntimeException( "class {$short_class_name} not found" );
  }
  
}