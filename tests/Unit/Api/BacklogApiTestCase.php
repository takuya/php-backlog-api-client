<?php

namespace tests\Unit\Api;

use tests\TestCase;
use Takuya\BacklogApiClient\BacklogAPIClient;

class BacklogApiTestCase extends TestCase {
  protected BacklogAPIClient $cli;
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new BacklogAPIClient($space, $key);
  }
}