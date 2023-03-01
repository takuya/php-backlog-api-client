<?php

namespace tests\Unit\Traits;

use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\Issue;

trait IssueSearch {
  public function find_issue_has_comments () {
    return $this->find_issue( function( Issue $issue ) { return !empty( $issue->comments() ); }, 5 );
  }
  
  protected function find_issue ( callable $func, $limit_per_project = 3 ) {
    $cli = $this->model_client();
    $pids = $cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    shuffle( $pids );
    foreach ( $pids as $pid ) {
      $project = $cli->project( $pid );
      foreach ( array_slice( $project->issues_ids(), 0, $limit_per_project ) as $issue_id ) {
        $issue = $cli->issue( $issue_id );
        if ( $func( $issue ) ) {
          return $issue;
        }
      }
    }
  }
  
  public function find_issue_has_stars (): ?Issue {
    return $this->find_issue_has_attribute( 'stars',15 );
  }
  
  public function find_issue_has_attribute ( $name, $limit=5 ): ?Issue {
    return $this->find_issue( function( Issue $issue ) use ( $name ) { return !empty( $issue->$name ); }, $limit );
  }
  
  public function find_issue_has_attachment (): ?Issue {
    return $this->find_issue( function( Issue $issue ) { return !empty( $issue->attachments ); }, 5 );
  }
  
  public function find_issue_has_resolution (): ?Issue {
    return $this->find_issue( function( Issue $issue ) { return !empty( $issue->resolution ); }, 5 );
  }
  
  public function find_issue_uses_custom_field (): ?Issue {
    $func = function( Issue $issue ) { return !empty( $issue->customFields ); };
    return $this->find_issue( $func, 3 );
  }
  
  public function find_issue_has_assignee_and_updatedUser (): ?Issue {
    return $this->find_issue( function( Issue $issue ) {
      return !empty( $issue->assignee ) && !empty( $issue->updated );
    } );
  }
  
  public function find_issue_has_star_comment () {
    return $this->find_issue( function( Issue $issue ) {
      foreach ( $issue->comments() as $comment ) {
        if ( $comment->hasStar() ) {
          return true;
        }
      }
      return false;
    }, 5 );
  }
  
  public function find_issue_has_comment_notify () {
    return $this->find_issue( function( Issue $issue ) {
      foreach ( $issue->comments() as $comment ) {
        if ( sizeof( $comment->notifications ) > 0 ) {
          return true;
        }
      }
      return false;
    }, 5 );
  }
  
  
}