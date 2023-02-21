<?php

namespace tests\Unit\Model;

class ModelToJsonTest extends TestCaseBacklogModels {
  // JSONに戻しても、元のデータと同じになってることを調べる。
  public function test_project_model_to_json(){
    $space = $this->cli->space();
    $project = $space->my_projects()[0];
    $json_from_model =$project->toJson();
    $api = $this->api_client();
    $api_result = $api->getProject($project->id);
    $this->assertTrue(json_decode($json_from_model)==$api_result);
  }
  public function test_issue_model_to_json(){
    $space = $this->cli->space();
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
    $api = $this->api_client();
    $this->assertTrue(json_decode($issue->toJson())==$api->getIssue($issue->id));
    $this->assertTrue(json_decode($comment->toJson())==$api->getComment($issue->id,$comment->id));
  }
  
}