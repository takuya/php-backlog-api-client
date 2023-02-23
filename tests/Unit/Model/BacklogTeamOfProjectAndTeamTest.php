<?php

namespace tests\Unit\Model;

use Takuya\BacklogApiClient\Backlog;

class BacklogTeamOfProjectAndTeamTest extends TestCaseBacklogModels {
  
  public function test_team_in_project () {
    $teams = $this->cli->space()->teams();
    $team_ids = array_map( fn( $t ) => $t->id, $teams );
    $project_ids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    foreach ( $project_ids as $pid ) {
      $proj = $this->cli->project( $pid );
      foreach ( $proj->teams() as $team ) {
        $this->assertContains( $team->id, $team_ids );
        break 2;
      }
    }
  }
  
}