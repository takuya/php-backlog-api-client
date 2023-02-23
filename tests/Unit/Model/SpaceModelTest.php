<?php

namespace tests\Unit\Model;

use Takuya\BacklogApiClient\Models\Priority;
use Takuya\BacklogApiClient\Models\Licence;
use Takuya\BacklogApiClient\Models\Resolution;

class SpaceModelTest extends TestCaseBacklogModels {
  
  public function test_get_list_of_priorities () {
    $list = $this->cli->space()->priorities();
    $this->assertInstanceOf( Priority::class, $list[0] );
  }
  
  public function test_space_licence () {
    $licence = $this->cli->space()->licence();
    $this->assertInstanceOf( Licence::class, $licence );
  }
  
  public function test_space_resolutions () {
    $res = $this->cli->space()->resolutions();
    $this->assertInstanceOf( Resolution::class, $res[0] );
  }
  
}