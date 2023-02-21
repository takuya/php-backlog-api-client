<?php

namespace Tests\Unit;

use Tests\TestCase;
use Takuya\BacklogApiClient\BacklogAPIClient;

class TestCaseBacklogApiTest extends TestCase {
  protected BacklogAPIClient $cli;
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new BacklogAPIClient($space, $key);
  }
}