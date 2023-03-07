<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

use function Takuya\Utils\array_select;

trait CopyMilestone {
  
  public function copyProjectMileStone ( $src_project_id, $dst_project_id ) {
    $src_dst_id_mapping =[];
    $keys = ["name", "description", "startDate", "releaseDueDate"];
    $getIssueTypeByUniq = function( $project_id, $api) use ( $keys ) {
      $ret = $api->getVersionMilestoneList( $project_id );
      $a = array_map( fn( $e ) => (array)$e, $ret );
      $a = array_combine( array_map( fn( $e ) => md5( join( '', array_select( $keys, $e ) ) ), $a ), $a );
      return $a;
    };
    $src = $getIssueTypeByUniq( $src_project_id, $this->src_cli );
    $dst = $getIssueTypeByUniq( $dst_project_id, $this->dst_cli );
    $diff = array_diff_key( $src, $dst );
    foreach ( $diff as $uniq => $item ) {
      $dst[$uniq] = (array)$this->dst_cli->addVersionMilestone( $dst_project_id, array_select( $keys, $item ) );
    }
    foreach ( array_keys( $src ) as $uniq ) {
      $x = $src[$uniq]['id'];
      $y = $dst[$uniq]['id'];
      $src_dst_id_mapping[$x] = $y;
    }
    // 旧=>新IDマッピングを返す.
    return $src_dst_id_mapping;
  }
}