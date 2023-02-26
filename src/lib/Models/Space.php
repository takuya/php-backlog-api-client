<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Backlog;
use Takuya\Php\GeneratorArrayAccess;

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
    return $this->api->into_class(User::class, 'getUserList',[],$this);
  }
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Team[]
   */
  public function teams(){
    return $this->api->into_class(Team::class,'getListOfTeams',['query_options'=>['count'=>100]],$this);
  }
  
  /**
   * @return Priority[]
   */
  public function priorities(){
    return $this->api->into_class(Priority::class,'getPriorityList',[],$this);
  }
  
  /**
   * @return Resolution[]
   */
  public function resolutions(){
    return $this->api->into_class(Resolution::class,'getResolutionList',[],$this);
  }
  
  /**
   * @return Licence
   */
  public function licence(){
    return $this->api->into_class(Licence::class,'getLicence',[],$this);
  }
  
  /**
   * @return Project[]| GeneratorArrayAccess
   */
  public function projects( $all = Backlog::PROJECTS_ALL ) {
    $generator = (function () use($all){
      foreach ($this->project_ids($all) as $id ){
        yield $this->api->into_class(Project::class, 'getProject', ['projectIdOrKey' => $id],$this);
      }
    })();
    return new GeneratorArrayAccess($generator);
  }
  public function my_projects(){
    return $this->projects(Backlog::PROJECTS_ONLY_MINE);
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