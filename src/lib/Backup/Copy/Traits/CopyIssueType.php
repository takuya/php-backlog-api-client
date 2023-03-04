<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

use function Takuya\Utils\array_select;

trait CopyIssueType {
  
  
  public function copyIssueType ( $src_project_id, $dst_project_id ) {
    $keys = ["name", "color", "templateSummary", "templateDescription"];
    $getIssueTypeByUniq = function( $project_id, $api ) use ( $keys ) {
      $types = $api->getIssueTypeList( $project_id );
      $a = array_map( fn( $e ) => (array)$e, $types );
      // 名前・配色・テンプレートでユニークキーを取る。
      $a = array_combine( array_map( fn( $e ) => md5( join( '', array_select( $keys, $e ) ) ), $a ), $a );
      return $a;
    };
    //
    $src_types = $getIssueTypeByUniq( $src_project_id, $this->src_cli );
    $dst_types = $getIssueTypeByUniq( $dst_project_id, $this->dst_cli );
    // ユニークキーを比較し、元プロジェクトにないものを追加する。
    $diff_types = array_diff_key( $src_types, $dst_types );
    
    foreach ( $diff_types as $uniq => $item ) {
      $dst_types[$uniq] = (array)$this->dst_cli->addIssueType( $dst_project_id, array_select( $keys, $item ) );
    }
    $src_dst_id_mapping = [];//
    foreach ( array_keys( $src_types ) as $uniq ) {
      $x = $src_types[$uniq]['id'];
      $y = $dst_types[$uniq]['id'];
      $src_dst_id_mapping[$x] = $y;
    }
    // 旧=>新 のIssueTypeIDマッピングを返す.
    return $src_dst_id_mapping;
  }
  
}