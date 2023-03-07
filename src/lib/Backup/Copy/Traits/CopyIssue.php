<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

use function Takuya\Utils\array_each_with_key;

trait CopyIssue {
  
  use CopyComment;
  
  public function copyIssueList($src_project_id,$dst_project_id){
    foreach ( $this->src_cli->issue_ids($src_project_id) as $issue_id ) {
      $this->copyIssue($issue_id,$dst_project_id);
    }
  }
  public function copyIssue ( $src_issue_id, $dst_project_id ) {
    // ただし、コメント・課題の作成者はAPIの制限で変更が不可能。
    $src_issue = $this->src_cli->getIssue( $src_issue_id );
    // ユーザー・種別・マイルストーンを一致させる。
    $file_ids = $this->getIdMapping( 'sharedFiles' );
    $user_ids = $this->getIdMapping( 'userIds' );
    $type_ids = $this->getIdMapping( 'typeIds' );
    $version_ids = $this->getIdMapping( 'versionIds' );
    
    
    // 課題をコピー
    $data = $this->formatIssue( $src_issue );
    $data = $this->remapiId( $data, 'issueTypeId', $type_ids );
    $data = $this->remapiId( $data, 'versionsId', $version_ids );
    $data['projectId'] = $dst_project_id;
    $dst_issue = $this->dst_cli->addIssue( $data );
    // 共有ファイルをリンクし直し
    $this->copyLinkSharedFiles( $src_issue, $dst_issue, $file_ids );
    // 添付ファイルをコピー
    $this->copyIssueAttachments( $src_issue, $dst_issue );
    // 課題の状態を更新して合わせる。
    $dst_issue = $this->updateIssueAttributes( $src_issue, $dst_issue );
    // コメントをコピーする
    $this->copyCommentList( $src_issue, $dst_issue );
    // スターをコピー
    
    
    return $dst_issue;
  }
  
  public function getIdMapping ( $name ) {
    // TODO 変数依存を切る。メソッドを作ってメソッド内部で、API取得して比較する。
    return $this->id_mapping[$name];
  }
  
  protected function formatIssue ( object $issue_api_result, $add_user_name = true,$assignee ='' ) {
    if ( $add_user_name ) {
      $issue_api_result = $this->addUserInfoIntoBody( $issue_api_result );
    }
    
    $issue = (array)$issue_api_result;
    $keys = [
      //'id',
      //"issueKey",
      //"keyId",
      "summary",
      //"parentIssueId",//todo
      "description",
      "startDate",
      "dueDate",
      "estimatedHours",
      "actualHours",
      "issueType",
      "category",
      "versions",
      "priority",
      "assignee",// ユーザIDが不一致になる可能性がある。
      //"resolution", //
      //"status", //
      //"milestone",//
      //"createdUser",
      //"created",
      //"updatedUser",
      //"updated",
      // TODO parentIssueId をどうするか。
      // TODO attachment, customField
    ];
    $map_entry = [
      "assignee"  => fn( $e ) => $e['id'] ?? $e,
      'category'  => fn( $x ) => array_map( fn( $e ) => $e['id'], $x ),
      'issueType' => fn( $e ) => $e['id'] ?? $e,
      'versions'  => fn( $x ) => array_map( fn( $e ) => $e['id'], $x ),
      'priority'  => fn( $e ) => $e['id'] ?? $e,
      'startDate' => fn( $e ) => substr( $e, 0, 10 ),
      'dueDate'   => fn( $e ) => substr( $e, 0, 10 ),
    ];
    $map_key = [
      "assignee"  => "assigneeId",
      'category'  => 'categoryId',
      'issueType' => 'issueTypeId',
      'versions'  => 'versionsId',
      'priority'  => 'priorityId',
    ];
    $issue = json_decode( json_encode( $issue ), JSON_OBJECT_AS_ARRAY );
    $issue = array_filter( $issue, fn( $k ) => in_array( $k, $keys ), ARRAY_FILTER_USE_KEY );
    array_each_with_key( $map_entry, function( $k, $f ) use ( &$issue ) { $issue[$k] = $f( $issue[$k] ); } );
    array_each_with_key( $map_key, function( $old, $new ) use ( &$issue ) {
      $issue[$new] = $issue[$old];
      unset( $issue[$old] );
    } );
    if(!empty($assignee)){
      $issue->assignee = $assignee;
    }
    return $issue;
  }
  
  protected function addUserInfoIntoBody ( object $issue_api_result ) {
    $issue = $issue_api_result;

    $TZ = new \DateTimeZone('Asia/Tokyo');
    $creator = $issue->createdUser->name;
    $created = (new \DateTime($issue->created))->setTimezone($TZ)->format('Y-m-d H:i');
    $updator = $issue->updatedUser->name;
    $updated = (new \DateTime($issue->updated))->setTimezone($TZ)->format('Y-m-d H:i');
    // 失われる情報を本文に残す
    $footer = sprintf( <<<EOS
      
      
      
      ----
      作成 ( %s   |  %s )
      更新 ( %s   |  %s )
      
      EOS, $creator, $created, $updator, $updated );
    
    $issue->description = $issue->description.$footer;
    return $issue;
  }
  
  protected function remapiId ( $data, $key, $mapping ) {
    if ( !is_array( $data[$key] ) ) {
      $data[$key] = $mapping[$data[$key]];
    }
    if ( is_array( $data[$key] ) ) {
      foreach ( $mapping as $old_id => $new_id ) {
        foreach ( $data[$key] as $idx => $value ) {
          if ( $value == $old_id ) {
            $data[$key][$idx] = $new_id;
          }
        }
      }
    }
    return $data;
  }
  
  protected function copyLinkSharedFiles ( $src_issue, $dst_issue, $file_ids ) {
    if ( empty( $src_issue->sharedFiles ) ) {
      return;
    }
    $ids = array_map( fn( $e ) => $e->id, $src_issue->sharedFiles );
    foreach ( $ids as $old_id ) {
      $new_id = $file_ids[$old_id];
      $this->dst_cli->linkSharedFilesToIssue( $dst_issue->id, ['fileId' => [$new_id]] );
    }
  }
  
  protected function copyIssueAttachments ( $src_issue, $dst_issue ) {
    if ( empty( $src_issue->attachments ) ) {
      return [];
    }
    $mapping = [];
    foreach ( $src_issue->attachments as $src_attachment ) {
      $part = [
        'name'     => "file",
        'contents' => $this->src_cli->getIssueAttachment( $src_issue->id, $src_attachment->id ),
        "filename" => $src_attachment->name,
      ];
      $param = ['multipart' => [$part]];
      $result = $this->dst_cli->postAttachmentFile( $param );
      $mapping[$src_attachment->id] = $result->id;
    }
    $params = ['attachmentId' => array_values( $mapping )];
    $this->dst_cli->updateIssue( $dst_issue->id, $params );
    return $mapping;
  }
  
  protected function updateIssueAttributes ( object $src_issue, object $dst_issue ) {
    $params = [];
    if ( $src_issue->status->id != $dst_issue->status->id ) {
      $params['statusId'] = $src_issue->status->id;
    }
    if ( $src_issue->resolution?->id != $dst_issue->resolution?->id ) {
      $params['resolution'] = $src_issue->resolution->id;
    }
    
    return !empty( $params ) ? $this->dst_cli->updateIssue( $dst_issue->id, $params ) : $dst_issue;
  }
  
  
}