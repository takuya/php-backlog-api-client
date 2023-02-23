<?php

namespace tests\Unit\Model;

use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Comment;
use Takuya\BacklogApiClient\Models\SharedFile;
use Takuya\BacklogApiClient\Models\CommentNotification;
use Takuya\BacklogApiClient\Models\IssueAttachment;

class BacklogIssueModelTest extends TestCaseBacklogModels {
  
  
  public function test_get_issue_has_parent () {
    // 有料プランのみ。
    $q = ['parentChild' => Issue::PARENT_CHILD['子課題'], 'count' => 1];
    $sub_issues = $this->cli->findIssues( ['query_options' => $q] );
    $this->assertIsArray( $sub_issues );
    if ( sizeof( $sub_issues ) ) {
      $issue = $sub_issues[0];
      $parentIssue = $issue->parentIssue();
      $this->assertEquals( $issue->parentIssueId, $parentIssue->id );
    }
  }
  
  public function test_get_issue_has_child () {
    $q = ['parentChild' => Issue::PARENT_CHILD['親課題'], 'count' => 1];
    $parent_issues = $this->cli->findIssues( ['query_options' => $q] );
    $this->assertIsArray( $parent_issues );
    if ( sizeof( $parent_issues ) ) {//有料プランのみ
      $issue = $parent_issues[0];
      $q = ['parentIssueId' => [$issue->id], 'count' => 20];
      $sub_issue_list = $this->cli->findIssues( ['query_options' => $q] );
      foreach ( $sub_issue_list as $sub_issue ) {
        $this->assertTrue( $sub_issue->isChildIssue() );
        $this->assertEquals( $sub_issue->parentIssueId, $issue->id );
      }
    }
  }
  
  public function test_get_notification_of_issue_comment () {
    $space = $this->cli->space();
    foreach ( $space->project_ids( Backlog::PROJECTS_ONLY_MINE ) as $pid ) {
      $project = $this->cli->project( $pid );
      foreach ( $project->issues_ids() as $issue_id ) {
        $issue = $this->cli->issue( $issue_id );
        foreach ( $issue->comments() as $comment ) {
          $this->assertIsArray( $comment->notifications );
          if ( sizeof( $comment->notifications ) == 0 ) {
            continue;
          }
          /** @var CommentNotification $notification */
          foreach ( $comment->notifications as $notification ) {
            $this->assertEquals( CommentNotification::class, get_class( $notification ) );
            $this->assertEquals( User::class, get_class( $notification->user ) );
            $this->assertContains( $notification->reason, CommentNotification::REASON );
          }
          break 3;
        }
      }
    }
  }
  
  public function test_get_shared_file_of_issue () {
    $ret = $this->cli->findIssues( ['query_options' => ['sharedFile' => 'true', 'count' => 1]] );
    // これはバックログ上ではただのリンクです。
    $this->assertEquals( SharedFile::class, get_class( $ret[0]->sharedFiles[0] ) );
  }
  
  public function test_get_attachment_of_issue () {
    $issues = $this->cli->findIssues( ['query_options' => ['attachment' => 'true', 'count' => 1]] );
    $attachment = $issues[0]->attachments[0];
    $this->assertEquals( IssueAttachment::class, get_class( $attachment ) );
    $this->assertEquals( $attachment->size, strlen( $attachment->getContent() ) );
  }
  
  public function test_get_comment_of_issue_in_project () {
    foreach ( $this->cli->space()->projects( Backlog::PROJECTS_ONLY_MINE ) as $project ) {
      foreach ( $project->issues() as $issue ) {
        foreach ( $issue->comments() as $comment ) {
          $this->assertEquals( Comment::class, get_class( $comment ) );
          $this->assertPropIsExists( 'content', $comment );
          $this->assertPropIsExists( 'changeLog', $comment );
          $this->assertPropIsExists( 'createdUser', $comment );
          break 3;
        }
      }
    }
  }
}