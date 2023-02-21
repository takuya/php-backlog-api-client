<?php

namespace tests\Unit\Model;

use Takuya\BacklogApiClient\Backlog;

class WorkingTest extends TestCaseBacklogModels {
  public function test_for_coding(){
    $this->assertTrue(true);
    //$pids = $this->cli->space()->project_ids(Backlog::PROJECTS_ONLY_MINE);
    //foreach ( $pids as $pid ) {
    //  $proj = $this->cli->project($pid);
    //  $types = $proj->issue_types();
    //  $issue_ids = $proj->issues_ids();
    //  foreach ( $issue_ids as $issue_id ) {
    //    $issue = $this->cli->issue($issue_id);
    //    dump([$pid,$issue_id,$issue->resolution]);
    //  }
    //
    //}
  }
  
}