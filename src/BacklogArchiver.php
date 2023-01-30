<?php

namespace Takuya\BacklogApiClient;

class BacklogArchiver {
  
  protected BacklogAPIClient $cli;
  
  public function __construct( protected $space,
                               protected $key,
                               protected $tld = 'com', ) {
    $this->cli = new BacklogAPIClient($this->space, $key, $tld);
  }
  
  public function dumpUsers() {
    $list = $this->cli->getUserList();
    
    return $list;
  }
  
  public function dumpIssue( $issue_id ) {
    $issue = $this->cli->getIssue($issue_id);
    $issue->comments = $this->cli->getCommentList($issue_id, ['count' => 100, 'order' => 'asc']);
    $issue->attachments = $this->cli->getIssueAttachment($issue_id, ['count' => 100, 'order' => 'asc']);
  
    return json_decode(json_encode($issue));
  }
  
  public function projectIds() {
    $list = $this->cli->getProjectList();
    
    return array_map(fn( $e ) => $e->id, $list);
  }
  
  public function dumpProjectInfo( $project_id ) {
    $proj = $this->cli->getProject($project_id);
    // $proj->status = $this->cli->getStatusListOfProject($project_id);
    // $proj->icon = $this->cli->getProjectIcon($project_id);
    // $proj->users = $this->cli->getProjectUserList($project_id);
    // $proj->admins = $this->cli->getListOfProjectAdministrators($project_id);
    // $proj->issue_types = $this->cli->getIssueTypeList($project_id);
    // $proj->categories = $this->cli->getCategoryList($project_id);
    // $proj->versions = $this->cli->getVersionMilestoneList($project_id);
    // $proj->custom_fields = $this->cli->getCustomFieldList($project_id);
    // $proj->files = $this->cli->getListOfSharedFiles($project_id, '.');
    // $proj->disk_usage = $this->cli->getProjectDiskUsage($project_id);
    // $proj->webhooks = $this->cli->getListOfWebhooks($project_id);
    // $proj->groups = $this->cli->getProjectGroupList($project_id);
    // $proj->teams = $this->cli->getProjectTeamList($project_id);
    return $proj;
  }
}