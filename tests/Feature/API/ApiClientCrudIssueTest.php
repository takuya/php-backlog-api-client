<?php

namespace tests\Feature\API;

use tests\Feature\TestCase\TestCaseIssueApiClientForUpdate;

class ApiClientCrudIssueTest extends TestCaseIssueApiClientForUpdate {
  //class ApiClientCrudIssueTest extends TestCaseProjectApiClientForUpdate {
  
  protected $admin_user;

  public function test_create_update_delete_backlog_project_issue () {
    $api = $this->api;
    //
    $projectId = $this->project_id;
    $issueId = $this->issue_id;
    $issueKey = $this->issue_key;
    $this->assertIsInt( $projectId );
    $this->assertIsInt( $issueId );
    $this->assertNotEmpty($issueKey);
    // コメント＋添付ファイル
    $com = $this->addCommentWithAttachment();
    $this->assertIsInt( $com->id );
    // コメント追加
    $com = $this->addComment( 'これはサンプルです。' );
    $this->assertIsInt( $com->id );
    // 課題の更新。
    $description = "API経由で課題を作成。通知、担当者設定。\n\n\n\n画像を貼り付ける\n\n![image][sample.jpg]";
    $iss = $this->updateIssue( $description );
    $this->assertIsInt( $iss->id );
    $this->assertEquals( $issueId, $iss->id );
    $this->assertEquals( $issueKey, $iss->issueKey );
    $this->assertEquals( $description, $iss->description );
    //　コメント履歴を取る。
    $comment_history = $api->getCommentList( $issueId, ['order' => 'asc'] );//旧ー＞新
    //３件.更新処理してるので取得結果は３件になる。。
    $this->assertEquals( 3, count( $comment_history ) );
    // コメント履歴一覧には、コメント以外に、課題への変更が入っている。
    $this->assertEquals( $comment_history[0]->changeLog[0]->field, 'attachment'/*添付ファイル作成のChangelog*/ );
    $this->assertEquals( $comment_history[1]->changeLog, []/* コメント投稿のChangelog */ );
    $this->assertEquals( $comment_history[2]->changeLog[0]->field, 'description'/*description変更のChangelog*/ );
  }
  protected function updateIssue($description=''){
      $api = $this->api;
      $params = [
        'description'=>$description
      ];
      $ret = $api->updateIssue($this->issue_id,$params);
      return $ret;
  }
  
  protected function addComment($content='コメント'){
    $api = $this->api;
    $params = [
      'content' => $content,
      'notifiedUserId' => [$this->findAdminUser()->id],
    ];
    $ret = $api->addComment($this->issue_id,$params);
    return $ret;
  }
  
  protected function addAttachment () {
    $sample = $this->sample_jpeg_file();
    $api = $this->api;
    $param = ['multipart' => [[
      'name' => "file",
      'contents' => $sample['content'],
      "filename" => $sample['name'],
    ]]];
    $ret = $api->postAttachmentFile( $param );
    return $ret;
  }
  
  protected function addCommentWithAttachment () {
    $attach = $this->addAttachment();
    $params = [
      'content' => sprintf( "画像を貼り付ける\n![image][%s]", $attach->name ),
      'attachmentId' => [$attach->id],
    ];
    $api = $this->api;
    $ret = $api->addComment( $this->issue_id, $params );
    return $ret;
  }
  
  
  
}