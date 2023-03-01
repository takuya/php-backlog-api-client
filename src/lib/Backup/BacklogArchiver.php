<?php

namespace Takuya\BacklogApiClient\Backup;

use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Backup\Traits\HasClassCheck;
use Takuya\BacklogApiClient\Models\Interfaces\HasIcon;
use Takuya\BacklogApiClient\Models\Interfaces\ProjectAttrs;
use Takuya\BacklogApiClient\Models\Interfaces\HasFileContent;
use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Backup\Traits\ArchiveMethods;
use Takuya\BacklogApiClient\Utils\StrTool;
use Takuya\BacklogApiClient\Backup\Contracts\ArchiverContract;

class BacklogArchiver {
  
  use HasClassCheck;
  use ArchiveMethods;
  
  protected Backlog $cli;
  
  public function __construct (protected ArchiverContract $archiverContract) {
  }
  
  public function saveBacklogModel ( \Takuya\BacklogApiClient\Models\BaseModel $obj ): void {
    $arr = $this->storable($obj);
    $ref = new \ReflectionClass( $obj );
    $name = $ref->getShortName();
    $this->archiverContract->saveBacklogModel($name, $arr);
  }
  
  public function storable ( BaseModel $obj ): array {
    $arr = $obj->toArray();
    $arr = $this->filterAttr( $arr, get_class( $obj ) );
    $arr = array_merge( $arr, $this->getTraitRelation( $obj ), $this->getInterfaceAttrs( $obj ) );
    return $arr;
  }
  
  protected function filterAttrUser ( $arr, $class ) {
    $map = $class::attribute_mapping_list();
    $userAttrNames = array_map( fn( $e ) => $e[0], array_filter( $map, fn( $e ) => str_ends_with( $e[1], 'User' ) ) );
    $userArrayAttrNames = array_filter( $userAttrNames, fn( $str ) => $str == StrTool::plural( $str ) );
    $userAttrNames = array_filter( $userAttrNames, fn( $str ) => $str == StrTool::singular( $str ) );
    foreach ( $arr as $k => $v ) {
      if ( $k == 'nulabAccount' ) {
        $arr[$k] = $v['nulabId'] ?? null;
      }
      if ( in_array( $k, $userArrayAttrNames ) ) {
        $arr[$k] = array_map( fn( $e ) => $e["userId"], $v );
      }
      if ( in_array( $k, $userAttrNames ) ) {
        $arr[$k] = $v["userId"] ?? null;
      }
    }
  
    return $arr;
  }
  protected function filterAttribnutes($arr,$class,$attrName){
    if ( !empty( $arr[$attrName] ) ) {
      $attr = $arr[$attrName];
      if ( is_array( $attr ) && array_key_exists( 0, $attr ) ) {
        $values = array_map( fn( $e ) => $e['id'], $attr );
        $arr[$attrName] = $values;
      }
      if ( is_array( $attr ) && array_key_exists( 'id', $attr ) ) {
        $arr[$attrName] = $attr['id'];
      }
    }
    return $arr;
  }
  protected function filterAttr( $arr, $class ) {
    $arr = $this->filterAttrUser($arr, $class);
    $arr = $this->filterAttribnutes($arr,$class, 'attachments');
    $arr = $this->filterAttribnutes($arr,$class, 'stars');
    $arr = $this->filterAttribnutes($arr,$class, 'sharedFiles');
    $arr = $this->filterAttribnutes($arr,$class, 'category');
    $arr = $this->filterAttribnutes($arr,$class, 'customFields');
    $arr = $this->filterAttribnutes($arr,$class, 'status');
    $arr = $this->filterAttribnutes($arr,$class, 'issueType');
    $arr = $this->filterAttribnutes($arr,$class, 'tags');
    return $arr;
  }
  
  protected function getTraitRelation( $obj ) {
    $traits = $this->findRelationTraits($obj);
    $cols = [];
    foreach ($traits as $trait) {
      if( str_ends_with(strtolower($trait->getName()), 'space') ) {
        $cols['spaceKey'] = $obj->getSpaceKey();
      }
      if( str_ends_with(strtolower($trait->getName()), 'project') ) {
        $cols['projectId'] = $obj->getProjectId();
      }
      if( str_ends_with(strtolower($trait->getName()), 'issue') ) {
        $cols['issueId'] = $obj->getIssueId();
      }
      if( str_ends_with(strtolower($trait->getName()), 'comment') ) {
        $cols['commentId'] = $obj->getCommentId();
      }
      if( str_ends_with(strtolower($trait->getName()), 'wikipage') ) {
        $cols['wikiId'] = $obj->getWikiPageId();
      }
    }
    return $cols;
  }
  
  protected function getInterfaceAttrs( $obj ) {
    $cols = [];
    if( $this->hasInterface($obj, HasIcon::class) ) {
      $cols['icon'] = $obj->icon();
    }
    if( $this->hasInterface($obj, HasFileContent::class) ) {
      $mem_max = ini_get('memory_limit');// ファイル取得が必要なのでメモリ上限を引き上げる。
      ini_set( 'memory_limit', '-1' );
      /** @var HasFileContent $obj */
      if($this->isClass($obj,\Takuya\BacklogApiClient\Models\SharedFile::class)){
        /** @var \Takuya\BacklogApiClient\Models\SharedFile $obj */
        $cols['content'] = $obj->isFile() ? $obj->getContent() : null;
      }else{
        $cols['content'] = $obj->getContent();
      }
      // ini_set('memory_limit',$mem_max);
    }
    if( $this->hasInterface($obj, ProjectAttrs::class) ) {
      /** @var ProjectAttrs $obj */
      $cols['teams'] = array_map(fn( $e ) => $e->id, $obj->teams());
      $cols['users'] = array_map(fn( $e ) => $e->userId, $obj->users());
    }
    
    return $cols;
  }
  
  
  
}