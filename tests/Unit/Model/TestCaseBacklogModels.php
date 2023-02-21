<?php

namespace tests\Unit\Model;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;

class TestCaseBacklogModels extends TestCase {
  protected Backlog $cli;
  
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new Backlog($space, $key);
  }
  
}