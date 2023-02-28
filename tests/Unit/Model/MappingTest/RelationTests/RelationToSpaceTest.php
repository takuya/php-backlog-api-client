<?php

namespace tests\Unit\Model\ProjectRelationTests;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Backlog;

class RelationToSpaceTest extends TestCaseBacklogModels {
  

  public function test_relation_to_space () {
    $space = $this->cli->space();
    //
    $res = $space->disk_usage();
    $this->assertEquals( $space->spaceKey, $res->getSpaceKey() );
    //
    $res = $space->resolutions();
    $this->assertEquals( $space->spaceKey, $res[0]->getSpaceKey() );
    //
    $project = $space->my_projects()[0];
    $this->assertEquals( $space->spaceKey, $project->getSpaceKey() );
    //
    $pid = $space->project_ids( Backlog::PROJECTS_ONLY_MINE )[0];
    $this->assertEquals( $space->spaceKey, $this->cli->project( $pid )->getSpaceKey() );
    //
    $prios = $space->priorities();
    $this->assertEquals( $space->spaceKey, $prios[0]->getSpaceKey());
    //
    $licence = $space->licence();
    $this->assertEquals( $space->spaceKey, $licence->getSpaceKey());
    //
    $users = $space->users();
    $this->assertEquals( $space->spaceKey, $users[0]->getSpaceKey());
    //
    $teams = $space->teams();
    $this->assertEquals( $space->spaceKey, $teams[0]->getSpaceKey());
  }
  
  
}