<?php

namespace Tests\Feature;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;

class BacklogRateLimitTest extends TestCase {
  
  protected Backlog $cli;
  
  public function test_get_api_rate_limit() {
    $this->cli->space()->projects();
    $ret = $this->cli->rate_limit();
    $this->assertArrayHasKey("rate-limit-will-all-reset",$ret);
    $this->assertArrayHasKey("rate-limit-per-minute",$ret);
    $this->assertArrayHasKey("rate-limit-count-remains",$ret);
    
  }
  
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new Backlog($space, $key);
  }
}