<?php

namespace tests\Unit\Model\MappingTest\MapToUser;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\User;

class MapToUserOfProjectTest extends TestCaseBacklogModels {
  public function test_map_to_user_in_webhook () {
    $project = $this->find_project_has_webhook();
    $hooks = $project->webhooks();
    $this->assertIsClass( User::class, $hooks[0]->createdUser );
  }
  
  public function test_map_to_user_in_project () {
    $project = $this->find_project_has_shared_file();
    $files = $project->shared_files();
    $this->assertIsClass( User::class, $files[0]->createdUser );
  }
  
  public function test_map_to_user_in_space () {
    $teams = $this->cli->space()->teams();
    $team = $teams[0];
    $this->assertIsClass( User::class, $team->members[0] );
  }
}