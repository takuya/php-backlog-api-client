<?php


namespace tests\Feature\TestCase\Trait;
trait EntitySearch {
  public function findIssueTypeId () {
    $api = $this->api;
    $project_id = $this->project_id ?? 91928;
    $list = $api->getIssueTypeList( $project_id );
    usort( $list, fn( $a, $b ) => $a->id <=> $b->id );
    return $list[0];
  }
  
  public function findSampleIssueId(){
    return $this->findSampleIssue()->id;
  }
  public function findSampleIssue(){
    $api = $this->api;
    $project_id = $this->findProjectIdHasIssue();
    $issues = $api->getIssueList(['projectId'=>[$project_id],'sort'=>'updated','order'=>'desc','count'=>20]);
    shuffle($issues);
    return $issues[0];
  }
  public function findProjectIdHasIssue(){
    $api = $this->api;
    $projects = $api->getProjectList();
    shuffle($projects);
    foreach ( $projects as $project ) {
      $ret = $api->countIssue(['projectId'=>[$project->id]]);
      if($ret->count>0){
        return $project->id;
      }
    }
    return null;
  }
  public function findIssueHasVersion (){
    $api = $this->api;
    $projects = $api->getProjectList();
    shuffle($projects);
    foreach ( $projects as $project ) {
      $ret = $api->getVersionMilestoneList($project->id);
      if (sizeof($ret)>0){
        shuffle($ret);
        break;
      }
    }
    $id = $ret[0]->id;
    $list = $api->getIssueList(['versionId'=>[$id]]);
    if (empty($list)){return null;}
    return $list[0];
  }
  public function myUserId(){
    return $this->api->getOwnUser()->id;
  }
  public function findAdminUser () {
    if ( $this->admin_user ?? false ) {
      return $this->admin_user;
    }
    $api = $this->api;
    $list = $api->getUserList();
    $list = array_filter( $list, fn( $e ) => $e->roleType == 1 );
    usort($list,fn($a,$b)=>$a->id<=>$b->id);
    //usort( $list, fn( $a, $b ) => $b->id <=> $a->id );
    $this->admin_user = $list[0];
    return $this->admin_user;
  }
  
}