<?php

namespace Takuya\BacklogApiClient\Backup\Copy;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Backup\Copy\Traits\CopyProject;
use Takuya\BacklogApiClient\Backup\Copy\Traits\CopyIssue;

class BacklogCopy {
  
  use CopyProject;
  
  protected array $id_mapping;
  protected BacklogAPIClient $src_cli;
  protected BacklogAPIClient $dst_cli;
  protected int $assignee_user_id;
  
  public function __construct ( BacklogAPIClient $api_client,  $dst_space=null, ) {
    $this->src_cli = $api_client;
    $this->dst_cli = $this->dst_space ?? $api_client;
  }
  public function setAssignee(int $user_id){
    // 課題をコピーするときに別プロジェクト二ユーザーがいないとき、代わりに使うユーザ
    $this->assignee_user_id= $user_id;
  }
  
}