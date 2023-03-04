<?php

namespace tests\Feature\TestCase;

class TestCaseIssueApiClientForUpdate extends TestCaseProjectApiClientForUpdate {
  
  protected $issue_id;
  protected $issue_key;
  
  public function __construct ( ?string $name = null, array $data = [], $dataName = '' ) {
    parent::__construct( $name, $data, $dataName );
    $this->api->disableLogging();
  }
  
  
  protected function setUp (): void {
    //return;
    parent::setUp();
    if ( !$this->hasIssue() ) {
      $this->createIssue();
      usleep(2000);
    }
  }
  
  protected function tearDown (): void {
    //return;
    if ( $this->hasIssue() ) {
      $this->deleteIssue();
      usleep(200);
    }
    parent::tearDown();
  }
  
  public function hasIssue () {
    try {
      $ret = $this->api->getIssue( $this->issue_id );
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
  
  public function createIssue () {
    $params = ['projectId' => $this->project_id,
      'summary' => 'apiからのテスト',
      'description' => 'API経由で課題を作成しますー担当もします。',
      'issueTypeId' => $this->findIssueTypeId()->id,
      'priorityId' => 2,
      'notifiedUserId' => [$this->myUserId()],
      'assigneeId' => $this->myUserId(),
    ];
    $ret = $this->api->addIssue( $params );
    $this->issue_id = $ret->id;
    $this->issue_key = $ret->issueKey;
    $this->wait(fn()=>$this->hasIssue()!==true,100,'  issue create');
    return $ret;
  }
  
  public function deleteIssue () {
    $ret = $this->api->deleteIssue( $this->issue_id );
    $this->wait(fn()=>$this->hasIssue()!==false,100,'  issue delete');
    return $ret;
  }
  
}