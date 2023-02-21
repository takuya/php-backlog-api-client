<?php

namespace tests\Unit\Model;

use tests\TestCase;
use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Project;

class ModelClassListTest extends TestCase {
  public function test_list_declared_class_in_model(){
    $models = BaseModel::listModelClass();
    foreach ( $models as $model ) {
      $ref = new \ReflectionClass($model);
      $ns = $ref->getNamespaceName();
      $this->assertStringContainsString("Takuya\BacklogApiClient\Models",$ns);
    }
    $this->assertContains(Issue::class,$models);
    $this->assertContains(Project::class,$models);
  }
  
}