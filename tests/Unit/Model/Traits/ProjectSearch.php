<?php

namespace tests\Unit\Model\Traits;

use Takuya\BacklogApiClient\Models\Project;
use Takuya\BacklogApiClient\Backlog;

trait ProjectSearch {
  public function find_project_has_webhook () {
    return $this->find_project( fn( Project $e ) => sizeof( $e->webhooks() ) > 0 );
  }
  
  protected function find_project ( callable $condition ) {
    $pids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    shuffle( $pids );
    foreach ( $pids as $id ) {
      $project = $this->cli->project( $id );
      if ( $condition( $project ) ) {
        return $project;
      }
    }
  }
  
  public function find_project_has_shared_file () {
    return $this->find_project( fn( Project $e ) => sizeof( $e->shared_files() ) > 0 );
  }
  
  public function find_project_has_milestone () {
    return $this->find_project( fn( Project $e ) => sizeof( $e->versions() ) > 0 );
  }
  
}