<?php

namespace tests\assertions;

trait ClassAssertsions {
  public static function assertClassHasTrait($expected_trait, $class_or_object){
    $ref = new \ReflectionClass($class_or_object);
    $names = $ref->getTraitNames();
    static::assertThat(in_array($expected_trait,$names),static::isTrue());
  }
  public static function assertIsClass($expected,$object){
    
    $ref = new \ReflectionClass($object);
    static::assertEquals($expected,$ref->name);
  }
}