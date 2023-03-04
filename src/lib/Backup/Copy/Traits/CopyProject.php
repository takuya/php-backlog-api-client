<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

trait CopyProject {
  use CopyProjectUser;
  use CopyIssueType;
  use CopyMilestone;
  use CopySharedFile;
  use CopyWiki;
  
  public function copyProjectWebhook ( $src_project_id, $dst_project_id ) {
    $hooks = $this->src_cli->getListOfWebhooks( $src_project_id );
    $map = [];
    foreach ( $hooks as $hook ) {
      $params = [
        'description'     => $hook->description,
        'name'            => $hook->name,
        'hookUrl'         => $hook->hookUrl,
        'allEvent'        => json_encode( $hook->allEvent ),
        'activityTypeIds' => $hook->activityTypeIds,
      ];
      $ret = $this->dst_cli->addWebhook( $dst_project_id, $params );
      $map[$hook->id] = $ret->id;
    }
    return $map;
  }
  
  protected function copyProjectConf ( $src_project_id, $dst_project_id ) {
    // ユーザー・種別・マイルストーンを一致させる。
    // アイコンはAPIがない。WEBサイトをスクレーピングするしかない。あーめんどくさい。
    // TODO TeamチームはユーザIDが一致しないといけないので、本当にめんどくさい。
    /**
     * - ユーザー
     * - マイルストーン
     * - 課題の種別
     * - 共有ファイル
     * - カテゴリ
     */
    $webhookIds = $this->copyProjectWebhook( $src_project_id, $dst_project_id );
    $type_ids = $this->copyIssueType( $src_project_id, $dst_project_id );
    $version_ids = $this->copyProjectMileStone( $src_project_id, $dst_project_id );
    $file_ids = $this->copySharedFiles( $src_project_id, $dst_project_id );
    $user_ids = $this->copyProjectUser( $src_project_id, $dst_project_id );
    $wiki_ids = $this->copyWiki( $src_project_id, $dst_project_id );
    
    $this->id_mapping = [
      'webhookIds'  => $webhookIds,
      'sharedFiles' => $file_ids,
      'userIds'     => $user_ids,
      'typeIds'     => $type_ids,
      'versionIds'  => $version_ids,
      'wikiIds'     => $wiki_ids,
    ];
    return $this->id_mapping;
  }
  
  public function copyProject ( $src_project_id, $dst_project_id ) {
    $this->copyProjectConf( $src_project_id, $dst_project_id );
    $this->copyIssueList( $src_project_id, $dst_project_id );
  }
}