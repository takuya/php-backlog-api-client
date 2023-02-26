<?php

namespace tests\Unit\Model\Generators;

use Takuya\Php\GeneratorArrayAccess;
use Takuya\BacklogApiClient\Models\Issue;
use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\Project;

class BacklogIssuesGeneatorTest extends TestCaseBacklogModels {
  public function test_project_issues_as_generator(){
    $proj = $this->cli->space()->my_projects()[0];
    $iter = $proj->issues();
    $this->assertClassHasInterface(\Iterator::class,$iter);
    $this->assertIsClass(GeneratorArrayAccess::class,$iter);
    foreach ( $iter as $item) {
      $this->assertIsClass(Issue::class,$item);
      break;
    }
  }
}