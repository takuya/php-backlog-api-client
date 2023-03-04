<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

trait CopySharedFile {
  public function copySharedFiles ( $src_project_id, $dst_project_id ) {
    $list = $this->src_cli->getListOfSharedFiles( $src_project_id, '' );
    
    $mapping = [];
    foreach ( $list as $item ) {
      $path = $item->dir.DIRECTORY_SEPARATOR.$item->name;
      $content = $this->src_cli->getFile( $src_project_id, $item->id );
      $this->dst_cli->addSharedFile( $dst_project_id, $path, $content );
      $id = $this->dst_cli->getSharedFileId( $dst_project_id, $path );
      $mapping[$item->id] = $id;
    }
    return $mapping;
  }
  
}