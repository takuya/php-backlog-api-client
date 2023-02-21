<?php

namespace Tests\Feature;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;
use Tests\assertions\PropertyAssertions;

class TestCaseBacklogModelTest extends TestCase {
  protected Backlog $cli;
  
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new Backlog($space, $key);
  }
  
}