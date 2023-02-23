<?php

namespace tests\Unit\Model\MappingTest;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Backlog;

class ModelToArrayTest extends TestCaseBacklogModels {
  
  public function test_to_array_model_in_issue () {
    $space = $this->cli->space();
    $user = $space->users()[0];
    $project_id = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE )[0];
    $project = $this->cli->project( $project_id );
    $issue = $this->find_issue_has_comments();
    $comment = $issue->comments()[0];
    //
    $this->assertArrayIsConsitsOfPermitiveType( $space->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $user->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $project->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $project->users()[0]->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $issue->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $issue->toArray() );
    $this->assertArrayIsConsitsOfPermitiveType( $comment->toArray() );
  }
}