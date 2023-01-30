<?php

namespace Tests\Feature;

use Tests\TestCase;
use Takuya\BacklogApiClient\BacklogAPIClient;

class CallApiTest extends TestCase {
  
  protected BacklogAPIClient $cli;
  
  public function test_call_api_get_space() {
    $ret = $this->cli->getSpace();
    $ret = json_decode(json_encode($ret), JSON_OBJECT_AS_ARRAY);
    $keys = "spaceKey name ownerId lang timezone reportSendTime textFormattingRule created updated";
    foreach (explode(' ', $keys) as $key) {
      $this->assertArrayHasKey($key, $ret);
    }
  }
  
  public function test_api_get_user_list_and_get_user() {
    $userList = $this->cli->getUserList();
    $this->assertIsArray($userList);
    $this->assertGreaterThan(0, sizeof($userList));
    $this->assertObjectHasAttribute('id', $userList[0]);
    $this->assertObjectHasAttribute('userId', $userList[0]);
    $this->assertObjectHasAttribute('name', $userList[0]);
    $user = $this->cli->getUser($userList[0]->id);
    $this->assertEquals($user, $userList[0]);
  }
  
  public function test_api_project_list_and_project() {
    $list = $this->cli->getProjectList();
    $this->assertGreaterThan(0, sizeof($list));
    $this->assertObjectHasAttribute('id', $list[0]);
    $this->assertObjectHasAttribute('projectKey', $list[0]);
    $this->assertObjectHasAttribute('name', $list[0]);
    $entry = $this->cli->getProject($list[0]->id);
    $this->assertEquals($entry->id, $list[0]->id);
  }
  
  public function test_api_get_user_icon() {
    $list = $this->cli->getUserList();
    $res = $this->cli->getUserIcon($list[0]->id);
    $this->assertGreaterThan(1000, strlen($res));
  }
  
  public function test_api_query_options_user_starts() {
    $list = $this->cli->getUserList();
    foreach ($list as $e) {
      $res = $this->cli->countUserReceivedStars($e->id);
      if( $res->count > 0 ) {
        $user_id_has_star = $e->id;
        break;
      }
    }
    $start_count = $this->cli->countUserReceivedStars($user_id_has_star)->count;
    $res = $this->cli->getReceivedStarList($user_id_has_star, ['count' => 100, 'order' => 'asc', 'minId' => 1]);
    // アーカイブ・プロジェクトや削除ユーザがあると件数が合わないので注意する。
    $this->assertEquals($start_count, sizeof($res));
  }
  
  public function test_api_project_files() {
    $list = $this->cli->getProjectList();
    // TODO: $path 引数のデフォルト値が必要
    $files = $this->cli->getListOfSharedFiles($list[0]->id, '');
    $this->assertIsArray($files);
    $files = $this->cli->getListOfSharedFiles($list[0]->id, '.');
    $this->assertIsArray($files);
  }
  
  public function test_issue_comment_is_same_get_comment() {
    // コメントは、単体で取得しても、一覧で取得しても同じものが得られるようです。
    $list = $this->cli->getIssueList(['count' => 100]);
    $id_has_child = null;
    foreach ($list as $e) {
      $ret = $this->cli->countComment($e->id);
      if( $ret->count > 1 ) {
        $id_has_child = $e->id;
        break;
      }
    }
    $list = $this->cli->getCommentList($id_has_child, ['count' => 100, 'order' => 'asc']);
    $comment = $this->cli->getComment($id_has_child, $list[0]->id);
    $this->assertEquals($list[0], $comment);
  }
  
  public function test_issue_attachment_is_not_same_get_attachment() {
    // 添付ファイルは、
    // 単体取得と一覧取得で、同じものが得られ無い。結果が異なる。めんどくさい。
    // 単体取得はファイルの中身が、一覧取得は、メタ情報が得られる。
    $list = $this->cli->getIssueList(['count' => 100]);
    $id_has_child = null;
    foreach ($list as $e) {
      if( sizeof($e->attachments) > 1 ) {
        $id_has_child = $e->id;
        break;
      }
    }
    $list = $this->cli->getListOfIssueAttachments($id_has_child, ['count' => 100, 'order' => 'asc']);
    $attachment = $this->cli->getIssueAttachment($id_has_child, $list[0]->id);
    $this->assertNotEquals($attachment, $list[0]);
    $this->assertObjectHasAttribute('name', $list[0]);
    $this->assertObjectHasAttribute('size', $list[0]);
    $this->assertEquals($list[0]->size, strlen($attachment));
  }
  
  protected function setUp():void {
    parent::setUp();
    $key = getenv('backlog_api_key');
    $space = getenv('backlog_space');
    $this->cli = new BacklogAPIClient($space, $key);
  }
}
