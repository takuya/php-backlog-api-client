<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;

use function Takuya\Utils\array_select;

trait CopyProjectCustomField {
  public function copyProjectCustomField ( int $src_project_id, array $type_ids, int $dst_project_id ) {
    $list = $this->src_cli->getCustomFieldList( $src_project_id );
    $map = [];
    foreach ( $list as $item ) {
      $data = $this->formatCustomField( $item, $type_ids );
      $ret = $this->dst_cli->addCustomField($dst_project_id,$data);
      $map[$item->id]=$ret->id;
    }
    return $map;
  }
  
  protected function formatCustomField ( object $customField, array $type_ids ) {
    $keys = [
      'typeId',
      'name',
      'description',
      'required',
      'min',
      'max',
      'initialValue',
      'unit',
      'initialValueType',
      'initialDate',
      'initialShift',
      'items',
      'allowInput',
      'allowAddItem',
      'applicableIssueTypes',
    ];
    $data = array_select( $keys, json_decode( json_encode( $customField ), JSON_OBJECT_AS_ARRAY ) );
    $data = array_filter($data,fn($e)=>!empty($e));
    $data = array_combine(array_keys($data),array_values($data));
    
    if ( !empty( $data['applicableIssueTypes'] ) ) {
      foreach ( $data['applicableIssueTypes'] as $idx => $old_key ) {
        $new_key = $type_ids[$old_key];
        $data['applicableIssueTypes'][$idx] = $new_key;
      }
    }
    if (!empty($data['items'])){
      $values = array_column($data['items'],'name');
      $data['items'] = $values;
    }
    //
    return $data;
  }
  
}