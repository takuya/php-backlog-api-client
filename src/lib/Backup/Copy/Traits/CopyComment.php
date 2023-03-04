<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

trait CopyComment {
  
  public function copyCommentList ( $src_issue, $dst_issue ) {
    $comments = $this->src_cli->getCommentList( $src_issue->id );
    
    // TODO 編集を再現するためには、ChageLogを考慮する必要がある。めんどくさすぎる。
    $ids = [];
    foreach ( array_filter( $comments, fn( $c ) => $c->content ) as $comment ) {
      $ids[] = $this->copyCommentContent( $comment, $dst_issue->id, !empty( $comment->stars ) );
    }
    return $ids;
  }
  
  public function copyCommentContent ( $src_comment, $dst_issue_id, $stared = false, $append_user = true ) {
    if ( $append_user ) {
      $src_comment = $this->addUserInfoIntoCommentHead( $src_comment );
    }
    
    
    $ret = $this->dst_cli->addComment( $dst_issue_id, ['content' => $src_comment->content] );
    if ( $stared ) {//☆がついてたら星を入れる。正確にやるには全ユーザーのアカウントに切り替える必要がある。
      $params = ['commentId' => $ret->id];
      $this->dst_cli->addStar( $params );
    }
    return $ret;
  }
  
  public function addUserInfoIntoCommentHead ( $comment ) {
    $creator = $comment->createdUser->name;
    $created = substr( $comment->created, 0, 10 ).' '.substr( $comment->created, 11, 5 );
    // 失われる情報を本文に残す
    $header = sprintf( <<<EOS
      %s / %s
      ----
      
      EOS, $creator, $created, );
    
    $comment->content = $header.$comment->content;
    return $comment;
  }
  
}