<?php

namespace tests;


use tests\assertions\PropertyAssertions;
use tests\assertions\ArrayAssertions;
use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Backlog;

abstract class TestCase extends \PHPUnit\Framework\TestCase {
  use PropertyAssertions;
  use ArrayAssertions;
  public function api_client(){
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    return new BacklogAPIClient($space, $key);
  }
  public function model_client(){
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    return new Backlog($space, $key);
  }

}
