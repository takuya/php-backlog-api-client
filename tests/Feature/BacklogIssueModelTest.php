<?php

namespace Tests\Feature;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Comment;
use Takuya\BacklogApiClient\Models\SharedFile;
use Takuya\BacklogApiClient\Models\Notification;
use Takuya\BacklogApiClient\Models\IssueAttachment;

class BacklogIssueModelTest extends TestCase {
  
  protected Backlog $cli;
  
  public function test_get_issue_has_parent() {
    $q = ['parentChild' => Issue::PARENT_CHILD['子課題'], 'count' => 1];
    $issue = $this->cli->findIssues(['query_options' => $q])[0];
    $parentIssue = $issue->parentIssue();
    $this->assertEquals($issue->parentIssueId, $parentIssue->id);
  }
  
  public function test_get_issue_has_child() {
    $q = ['parentChild' => Issue::PARENT_CHILD['親課題'], 'count' => 1];
    $issue = $this->cli->findIssues(['query_options' => $q])[0];
    $q = ['parentIssueId' => [$issue->id], 'count' => 20];
    $sub_issue_list = $this->cli->findIssues(['query_options' => $q]);
    foreach ($sub_issue_list as $sub_issue) {
      $this->assertTrue($sub_issue->isChildIssue());
      $this->assertEquals($sub_issue->parentIssueId, $issue->id);
    }
  }
  
  public function test_get_notification_of_issue_comment() {
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      foreach ($project->issues() as $issue) {
        foreach ($issue->comments() as $comment) {
          if( sizeof($comment->notifications) == 0 ) {
            continue;
          }
          /** @var Notification $notification */
          foreach ($comment->notifications as $notification) {
            $this->assertEquals(Notification::class, get_class($notification));
            $this->assertEquals(User::class, get_class($notification->user));
            $this->assertContains($notification->reason, Notification::REASON);
          }
          break 3;
        }
      }
    }
  }
  
  public function test_get_shared_file_of_isseue() {
    $ret = $this->cli->findIssues(['query_options' => ['sharedFile' => 'true', 'count' => 1]]);
    // これはバックログ上ではただのリンクです。
    $this->assertEquals(SharedFile::class, get_class($ret[0]->sharedFiles[0]));
  }
  
  public function test_get_attachment_of_issue() {
    $issues = $this->cli->findIssues(['query_options' => ['attachment' => 'true', 'count' => 1]]);
    $attachment = $issues[0]->attachments[0];
    $this->assertEquals(IssueAttachment::class, get_class($attachment));
    $this->assertEquals($attachment->size, strlen($attachment->getContent()));
  }
  
  public function test_get_comment_of_issue_in_project() {
    
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      foreach ($project->issues() as $issue) {
        foreach ($issue->comments() as $comment) {
          $this->assertEquals(Comment::class, get_class($comment));
          $this->assertObjectHasAttribute('content', $comment);
          $this->assertObjectHasAttribute('changeLog', $comment);
          $this->assertObjectHasAttribute('createdUser', $comment);
          break 3;
        }
      }
    }
  }
  
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new Backlog($space, $key);
  }
}