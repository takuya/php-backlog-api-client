<?php

namespace tests\Unit\Model\Generators;

use Takuya\Php\GeneratorArrayAccess;
use Takuya\BacklogApiClient\Models\Issue;
use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\Project;
use Takuya\BacklogApiClient\Models\WikiPage;

class BacklogWikiGeneatorTest extends TestCaseBacklogModels {
  public function test_project_wikis_as_generator(){
    $proj = $this->cli->space()->my_projects()[0];
    $iter = $proj->wiki_pages();
    $this->assertIsClass(GeneratorArrayAccess::class,$iter);
    $this->assertIsClass(WikiPage::class, $iter[0]);
  }
}