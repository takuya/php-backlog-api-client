<?php

namespace Tests\Feature;

use Tests\TestCase;
use RuntimeException;
use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Space;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Project;
use Takuya\BacklogApiClient\Models\ProjectTeam;
use Takuya\BacklogApiClient\Models\NulabAccount;

class BacklogModelTest extends TestCaseBacklogModelTest {
  
  
  public function test_get_user_and_user_icon() {
    foreach ($this->cli->space()->users() as $user) {
      $icon = $user->icon();
      $this->assertNotFalse(imagecreatefromstring($icon));
      break;
    }
  }
  
  public function test_get_space() {
    $ret = $this->cli->space();
    $this->assertEquals(Space::class, get_class($ret));
    $this->assertNotEmpty($ret->spaceKey);
  }

  public function test_get_user_nulab_account(){
    $user=$this->cli->space()->users()[0];
    $nulab_account = $user->nulabAccount;
    $this->assertEquals(NulabAccount::class,get_class($nulab_account));
    $obj = json_decode(json_encode($nulab_account));
    $this->assertTrue(property_exists($obj,'name'));
    $this->assertTrue(property_exists($obj,'nulabId'));
    $this->assertTrue(property_exists($obj,'uniqueId'));
  }
  
  public function test_get_project() {
    $project_id = $this->cli->space()->project_ids(Backlog::PROJECTS_ONLY_MINE)[0];
    $ret = $this->cli->project($project_id);
    $this->assertPropIsExists('projectKey', $ret);
    $this->assertEquals(Project::class, get_class($ret));
  }
  
  public function test_get_teams_of_team() {
    foreach ($this->cli->space()->project_ids(Backlog::PROJECTS_ONLY_MINE) as $project_id) {
      $project = $this->cli->project($project_id);
      $teams = $project->teams();
      if( sizeof($teams) > 0 ) {
        break;
      }
    }
    if (sizeof($teams)){
      $team = $teams[0];
      $this->assertIsArray($team->members);
      $this->assertPropIsExists('name', $team);
      $this->assertPropIsExists('id', $team);
      $this->assertPropIsExists('created', $team);
      $this->assertEquals(ProjectTeam::class, get_class($team));
      $user = $team->members[0];
      $this->assertEquals(User::class, get_class($user));
      $this->assertEquals(json_encode($team), json_encode($this->cli->team($team->id)));
    }else{
      $this->assertIsArray($teams);
    }
  }
  
  public function test_get_project_by_ProjectIdOrKey() {
    $project_id = $this->cli->space()->project_ids(Backlog::PROJECTS_ONLY_MINE)[0];
    $prj = $this->cli->project($project_id);
    $this->assertEquals(json_encode($prj), json_encode($this->cli->project($prj->projectKey)));
    $this->assertEquals(json_encode($prj), json_encode($this->cli->project($prj->id)));
  }
  
  public function test_get_issue_by_IssueIdOrKey() {
    $issue = null;
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      if( sizeof($project->issues()) > 0 ) {
        $issue = $project->issues()[0];
        break;
      }
    }
    if( empty($issue) ) {
      throw new RuntimeException('issue not found.');
    }
    $this->assertEquals(json_encode($issue), json_encode($this->cli->issue($issue->id)));
    $this->assertEquals(json_encode($issue), json_encode($this->cli->issue($issue->issueKey)));
  }
  
  public function test_get_issue_in_project() {
    $project_id = $this->cli->space()->project_ids(Backlog::PROJECTS_ONLY_MINE)[0];
    $ret = $this->cli->project($project_id)->issues()[0];
    $this->assertPropIsExists('issueKey', $ret);
    $this->assertEquals(Issue::class, get_class($ret));
  }
  
  public function test_get_user_and_find_user() {
    $users = $this->cli->space()->users();
    $this->assertIsArray($users);
    $this->assertEquals(User::class, get_class($users[0]));
    $this->assertEquals(json_encode($users[0]), json_encode($this->cli->findUser($users[0]->name)));
    $this->assertEquals(json_encode($users[0]), json_encode($this->cli->findUser($users[0]->mailAddress)));
    $this->assertEquals(json_encode($users[0]), json_encode($this->cli->findUser($users[0]->id)));
    $this->assertEquals(json_encode($users[0]), json_encode($this->cli->findUser($users[0]->keyword)));
    $this->assertEquals(json_encode($users[0]), json_encode($this->cli->findUser($users[0]->userId)));
  }
  
}