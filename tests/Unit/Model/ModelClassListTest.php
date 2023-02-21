<?php

namespace tests\Unit\Model;

use tests\TestCase;
use Takuya\BacklogApiClient\Models\BaseModel;

class ModelClassListTest extends TestCase {
  public function test_list_declared_class_in_model(){
    $models = BaseModel::listModelClass();
    foreach ( $models as $model ) {
      $ref = new \ReflectionClass($model);
      $ns = $ref->getNamespaceName();
      $this->assertStringContainsString("Takuya\BacklogApiClient\Models",$ns);
    }
  }
  
}