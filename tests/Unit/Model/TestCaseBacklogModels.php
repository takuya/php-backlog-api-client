<?php

namespace tests\Unit\Model;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;
use tests\Unit\Traits\ProjectSearch;
use tests\Unit\Traits\IssueSearch;
use tests\Unit\Traits\WikiSearch;

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
