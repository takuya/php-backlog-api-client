<?php

namespace tests\Unit\Model\ProjectRelationTests;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Comment;
use Takuya\BacklogApiClient\Models\CommentNotification;
use Takuya\BacklogApiClient\Models\CustomFieldSelectedValue;
use Takuya\BacklogApiClient\Models\Traits\RelateToIssue;

class RelationToIssueTest extends TestCaseBacklogModels {
  
  protected array $sample_comment_notifications;
  protected array $sample_issue_custom_filed;
  
  protected function find_issue_costomFiled_used (): array {
    if ( !empty( $this->sample_issue_custom_filed ) ) {
      return $this->sample_issue_custom_filed;
    }
    $issue = null;
    $custom_filed_values = null;
    $projects = $this->cli->space()->projects( Backlog::PROJECTS_ONLY_MINE );
    usort( $projects, fn( $a, $b ) => $a->id < $b->id );
    foreach ( $projects as $project ) {
      foreach ( array_slice($project->issues_ids(),0,3) as $issue_id ) {
        $issue = $this->cli->issue($issue_id);
        $custom_filed_values = $issue->customFields;
        if ( sizeof( $custom_filed_values ) > 0 ) {
          break 2;
        }
      }
    }
    return [$custom_filed_values, $issue];
  }
  
  protected function find_comment_notifications (): array {
    if ( !empty( $this->sample_comment_notifications ) ) {
      return $this->sample_comment_notifications;
    }
    $issue = null;
    $notifications = null;
    $comment = null;
    foreach ( $this->cli->space()->projects( Backlog::PROJECTS_ONLY_MINE ) as $project ) {
      foreach ( array_slice($project->issues_ids(),0,5) as $issue_id ) {
        $issue = $this->cli->issue($issue_id);
        foreach ( $issue->comments() as $comment ) {
          $notifications = $comment->notifications;
          if ( sizeof( $notifications ) > 0 ) {
            break 3;
          }
        }
      }
    }
    return [$notifications, $comment, $issue];
  }
  
  public function test_notification_relation_to_issue () {
    $api = $this->api_client();
    /** @var Issue $issue */
    /** @var Comment $comment */
    /** @var CommentNotification[] $notifications */
    [$notifications, $comment, $issue] = $this->find_comment_notifications();
    $this->assertNotEmpty( $notifications );
    $this->assertEquals( $notifications[0]->getIssueId(), $issue->id );
    // クラスへ封入がAPIレスポンスを破壊してないことの確認
    $this->assertEquals(
      json_decode( $notifications[0]->toJson() ),
      $api->getListOfCommentNotifications( $issue->id, $comment->id )[0]
    );
  }
  
  public function test_custom_field_values_relation_to_issue () {
    $api = $this->api_client();
    /** @var Issue $issue */
    /** @var CustomFieldSelectedValue[] $custom_filed_values */
    [$custom_filed_values, $issue] = $this->find_issue_costomFiled_used();
    $this->assertNotEmpty( $custom_filed_values );
    $this->assertClassHasTrait( RelateToIssue::class, $issue->customFields[0] );
    $this->assertEquals( $custom_filed_values[0]->getIssueId(), $issue->id );
    $this->assertEquals(
      json_decode( $custom_filed_values[0]->toJson() ),
      $api->getIssue( $issue->id )->customFields[0]
    );
  }
}