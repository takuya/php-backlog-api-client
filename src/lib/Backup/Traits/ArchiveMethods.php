<?php

namespace Takuya\BacklogApiClient\Backup\Traits;

use Takuya\BacklogApiClient\Utils\StrTool;
use ReflectionClass;
use Takuya\BacklogApiClient\Models\BaseModel;


trait ArchiveMethods {
  public function saveSpace ( \Takuya\BacklogApiClient\Models\Space $space ): void {
    $pairs = [
      ['users', 'method'],
      ['teams', 'method'],
      ['priorities', 'method'],
      ['licence', 'method'],
      ['resolutions', 'method'],
      ['disk_usage', 'method'],
    ];
    $this->saveBacklogModel( $space );
    $this->saveModelProperties( $space, $pairs );
  }
  
  public function saveProject ( \Takuya\BacklogApiClient\Models\Project $project, $include_issue = false,
                                                                        $include_wiki = false ) {
      $list = [
        ['statuses', 'method'],
        ['issue_types', 'method'],
        ['categories', 'method'],
        ['versions', 'method'],
        ['custom_fields', 'method'],
        ['webhooks', 'method'],
        ['disk_usage', 'method'],
        ['shared_files', 'method'],
      ];
      $this->saveBacklogModel( $project );
      $this->saveModelProperties( $project, $list );
      if ( $include_issue ) {
        $this->saveIssues( $project );
      }
      if ( $project->useWiki && $include_wiki ) {
        $this->saveProjectWiki( $project );
      }
  }
  public function saveProjectWiki(\Takuya\BacklogApiClient\Models\Project $project): void {
      foreach ( $project->wiki_tags() as $wiki_tag ) {
        $this->saveBacklogModel( $wiki_tag );
      }
      foreach ( $project->wiki_pages() as $wiki_page ) {
        $this->saveWiki( $wiki_page );
      }
  }
  
  public function saveWiki ( \Takuya\BacklogApiClient\Models\WikiPage $wiki ) {
    $this->saveBacklogModel( $wiki );
    $this->saveModelProperties( $wiki, [
      ['attachments', 'property'],
      ['histories', 'method'],
    ] );
  }
  
  public function saveIssues ( \Takuya\BacklogApiClient\Models\Project $project ) {
    foreach ( $project->issues() as $issue ) {
      $this->saveIssue( $issue );
    }
  }
  
  public function saveIssue ( \Takuya\BacklogApiClient\Models\Issue $issue, $include_comment = true ) {
      $list = [
        ['stars', 'property'],
        ['attachments', 'property'],
        ['customFields', 'property'],
      ];
      $this->saveBacklogModel( $issue );
      $this->saveModelProperties( $issue, $list );
    
      if ( $include_comment ) {
        foreach ( $issue->comments() as $comment ) {
          $this->saveIssueComment( $comment );
        }
      }
  }
  
  public function saveIssueComment ( \Takuya\BacklogApiClient\Models\Comment $comment ) {
      $list = [
        ['stars', 'property'],
        ['notifications', 'property'],
      ];
      $this->saveModelProperties( $comment, $list );
      $this->saveBacklogModel( $comment );
  }
  
  public function saveBacklogModel ( BaseModel $obj ) {
    $ref = new ReflectionClass( $obj );
    $name = $ref->getShortName();
    $app_model_class = 'App\\Models\\'.$name;
    return ( new $app_model_class() )->save();
  }
  
  protected function saveModelProperties ( $obj, $prop_list ) {
      foreach ( $prop_list as [$name, $method_or_property] ) {
        if ( StrTool::isPlural( $name ) ) {
          $values = $method_or_property == 'method' ? $obj->{$name}() : $obj->{$name};
          foreach ( $values as $value ) {
            //dump([get_class($value),$value,$value->toArray()]);
            $this->saveBacklogModel( $value );
          }
        } else if ( StrTool::isSingular( $name ) ) {
          $value = $method_or_property == 'method' ? $obj->{$name}() : $obj->{$name};
          $this->saveBacklogModel( $value );
        }
      }
  }
  
  public function saveIssueAttachment ( \Takuya\BacklogApiClient\Models\IssueAttachment $attachment ) {
    $this->saveBacklogModel( $attachment );
  }
  
  public function saveWikiPageAttachment ( \Takuya\BacklogApiClient\Models\WikiPageAttachment $attachment ) {
    $this->saveBacklogModel( $attachment );
  }
  
  public function saveWikiHistory ( \Takuya\BacklogApiClient\Models\WikiHistory $history ) {
    $this->saveBacklogModel( $history );
  }
  
  public function saveStar ( \Takuya\BacklogApiClient\Models\Star $star ) {
    $this->saveBacklogModel( $star );
  }
  
  public function saveNotification ( \Takuya\BacklogApiClient\Models\Notification $notification ) {
    $this->saveBacklogModel( $notification );
  }
  
}