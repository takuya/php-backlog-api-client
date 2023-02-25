<?php

namespace tests\Unit\Model;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;
use tests\Unit\Model\Traits\ProjectSearch;
use tests\Unit\Model\Traits\IssueSearch;
use tests\Unit\Model\Traits\WikiSearch;

abstract class TestCaseBacklogModels extends TestCase {
  protected Backlog $cli;
  use ProjectSearch;
  use IssueSearch;
  use WikiSearch;
  
  protected function setUp (): void {
    parent::setUp();
    $this->cli = $this->model_client();
  }
  
  
}
