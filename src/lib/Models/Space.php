<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Backlog;

class Space extends BaseModel {
  
  public string $spaceKey;
  public string $name;
  public int    $ownerId;
  public string $lang;
  public string $timezone;
  public string $reportSendTime;
  public string $textFormattingRule;
  public string $created;
  public string $updated;
  
  /**
   * @return array|User[]
   */
  public function users() {
    return $this->api->into_class(User::class, 'getUserList');
  }
  
  /**
   * @return array|Project[]
   */
  public function projects( $all = Backlog::PROJECTS_ALL ) {
    return array_map(
      function ( $id ) { return $this->api->into_class(Project::class, 'getProject', ['projectIdOrKey' => $id]); },
      $this->project_ids($all));
  }
  
  /**
   * @return array|Project[]
   */
  public function project_ids( $all = Backlog::PROJECTS_ALL ) {
    $project_list = $this->api->into_class(
      Project::class,
      'getProjectList',
      ['query_options' => ['all' => $all ? 'true' : 'false']]);
    
    return array_map(fn( $e ) => $e->id, $project_list);
  }
}