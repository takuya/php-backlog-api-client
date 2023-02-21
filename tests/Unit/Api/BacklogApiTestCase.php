<?php

namespace tests\Unit\Api;

use tests\TestCase;
use Takuya\BacklogApiClient\BacklogAPIClient;

class BacklogApiTestCase extends TestCase {
  protected BacklogAPIClient $cli;
  protected function setUp():void {
    parent::setUp();
    $this->cli = $this->api_client();
  }
}