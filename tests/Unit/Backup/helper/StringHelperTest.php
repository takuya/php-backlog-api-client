<?php

namespace Tests\Unit\helper;

use Tests\TestCase;
use Takuya\BacklogApiClient\Utils\StrTool;

class StringHelperTest extends TestCase {
  
  public function test_string_helper(){
  
    $this->assertEquals('history',StrTool::singular("histories"));
    $this->assertEquals('Status',StrTool::singular("Statuses"));
    $this->assertEquals('Statuses',StrTool::plural("Statuses"));
    $this->assertEquals('user_id',StrTool::snake("UserId"));
  
  }
  
}