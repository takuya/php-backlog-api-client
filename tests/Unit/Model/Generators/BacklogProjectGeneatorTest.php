<?php

namespace tests\Unit\Model\Generators;

use Takuya\Php\GeneratorArrayAccess;
use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\Project;

class BacklogProjectGeneatorTest extends TestCaseBacklogModels {
  
  public function test_projects_as_generator() {
    $iter = $this->cli->space()->my_projects();
    $proj= $iter[0];
    $this->assertIsClass(GeneratorArrayAccess::class,$iter);
    $this->assertIsClass(Project::class, $proj);
  }
}