<?php

namespace tests\Unit\Model;

class ModelToArrayTest extends TestCaseBacklogModels {
  
  public function test_model_to_array () {
    $space = $this->cli->space();
    $user = $space->users()[0];
    $project = $space->my_projects()[0];
    $issue = null;
    $comment = null;
    foreach ( $project->issues() as $e ) {
      if ( sizeof( $e->comments() ) > 0 ) {
        $issue = $e;
        $comment = $e->comments()[0];
        break;
      }
    }
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