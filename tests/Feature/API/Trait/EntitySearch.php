<?php


namespace tests\Feature\API\Trait;
trait EntitySearch {
  public function findIssueTypeId () {
    $api = $this->api;
    $project_id = $this->project_id ?? 91928;
    $list = $api->getIssueTypeList( $project_id );
    usort( $list, fn( $a, $b ) => $a->id <=> $b->id );
    return $list[0];
  }
  
  public function findAdminUser () {
    if ( $this->admin_user ) {
      return $this->admin_user;
    }
    $api = $this->api;
    $list = $api->getUserList();
    $list = array_filter( $list, fn( $e ) => $e->roleType == 1 );
    //usort($list,fn($a,$b)=>$a->id<=>$b->id);
    usort( $list, fn( $a, $b ) => $b->id <=> $a->id );
    $this->admin_user = $list[0];
    return $this->admin_user;
  }
  
}