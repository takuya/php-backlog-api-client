<?php

namespace tests\Unit\Model\MappingTest;

use tests\Unit\Model\TestCaseBacklogModels;

class ModelToJsonTest extends TestCaseBacklogModels {
  // JSONに戻しても、元のデータと同じになってることを調べる。
  public function test_model_to_json_is_same_api_result(){
    $space = $this->cli->space();
    $project = $space->my_projects()[0];
    $issue = $this->find_issue_has_comments();
    $comment = $issue->comments()[0];
    $api = $this->api_client();
    //$a = (array)json_decode($comment->toJson());
    //$b = (array)$api->getComment($issue->id,$comment->id);
    //ksort($a);ksort($b);
    //dd([$a,$b]);
    $this->assertEquals(json_decode($project->toJson()),$api->getProject($project->id));
    $this->assertEquals(json_decode($issue->toJson()),$api->getIssue($issue->id));
    $this->assertEquals(json_decode($comment->toJson()),$api->getComment($issue->id,$comment->id));
  }
  
}