<?php

namespace tests\Unit\Model;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;

class TestCaseBacklogModels extends TestCase {
  protected Backlog $cli;
  
  protected function setUp():void {
    parent::setUp();
    $this->cli = $this->model_client();
  }
  
}