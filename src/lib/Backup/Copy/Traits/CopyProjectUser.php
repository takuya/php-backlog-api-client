<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

trait CopyProjectUser {
  public function copyProjectUser ( $src_project_id, $dst_project_id ) {
    $src_user_ids = array_column( $this->src_cli->getProjectUserList( $src_project_id ), 'id' );
    $dst_user_ids = array_column( $this->dst_cli->getProjectUserList( $dst_project_id ), 'id' );
    $user_diff = array_diff( $src_user_ids, $dst_user_ids );
    if ($this->assignee_user_id){// ユーザをプロジェクトに追加で、通知が飛ぶを避ける。
      $user_diff = [$this->assignee_user_id];
    }
    foreach ( $user_diff as $id ) {
      $this->dst_cli->addProjectUser( $dst_project_id, ['userId' => $id] );
    }
    // 追加したユーザーのID
    return $user_diff;
  }
}