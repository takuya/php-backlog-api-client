<?php

namespace Takuya\BacklogApiClient\Backup\Copy\Traits;


use function Takuya\Utils\array_select;
use function Takuya\Utils\array_column_select;
use function Takuya\Utils\array_subtract;

trait CopyWiki {
  public function copyWiki ( $src_project_id, $dst_project_id ) {
    $map = [];
    // 作業データ取得
    $src = $this->src_cli->getWikiPageList(['projectIdOrKey' => $src_project_id] );
    $dst = $this->dst_cli->getWikiPageList(['projectIdOrKey' => $dst_project_id] );
    $src = json_decode(json_encode($src),JSON_OBJECT_AS_ARRAY);
    $dst = json_decode(json_encode($dst),JSON_OBJECT_AS_ARRAY);
    
    $a = array_column($src,'name');
    $b = array_column($dst,'name');
    // $bにあって$aにないものを消す。
    $only_b = array_column(array_filter($dst,fn($n)=>in_array($n['name'],array_diff($b,$a))),'id');
    foreach ( $only_b as $id ) {
      $this->dst_cli->deleteWikiPage($id);
    }
    // $aにあって、$bにないものを作る。
    $only_a = array_column(array_filter($src,fn($n)=>in_array($n['name'],array_diff($a,$b))),'id');
    foreach ( $only_a as $id ) {
      $ret=$this->copyWikiPage($id, $dst_project_id);
      $map[$id]=$ret->id;
    }
    // Homeの内容を同期する
    $src_wiki_home_id = array_values(array_filter($src,fn($n)=>$n['name']=='Home'))[0]['id'];
    $dst_wiki_home_id = array_values(array_filter($dst,fn($n)=>$n['name']=='Home'))[0]['id'];
    $content = $this->src_cli->getWikiPage($src_wiki_home_id)->content;
    $this->dst_cli->updateWikiPage($dst_wiki_home_id,['name'=>'Home','content'=>$content]);
    $map[$src_wiki_home_id]=$dst_wiki_home_id;
    
    return $map;
  }

  public function copyWikiPage ( $src_wiki_id, $dst_project_id ) {
    $src_page = $this->src_cli->getWikiPage( $src_wiki_id );
    $prefix = join('',array_map(fn($n)=>"[$n->name]",$src_page->tags));
    $name = $prefix.$src_page->name;
    $dst_page = $this->dst_cli->addWikiPage([
      'projectId'=>$dst_project_id,
      'name'=>$name,
      'content'=>$src_page->content]);
    if (sizeof($src_page->attachments)>0){
      $this->copyWikiAttachment($src_wiki_id,$dst_page->id);
    }
    if (sizeof($src_page->sharedFiles)>0){
      $ids = array_map(fn($e)=>$e->id,$src_page->sharedFiles);
      $this->dst_cli->linkSharedFilesToWiki($dst_page->id,['fileId'=>$ids]);
    }
    if (sizeof($src_page->stars)>0){
      $this->dst_cli->addStar($dst_page->id);
    }
    return $dst_page;
  }
  
  public function copyWikiAttachment ( $src_wiki_id,$dst_wiki_id ) {
    $src = $this->src_cli->getWikiPage($src_wiki_id);
    $ids = [];
    foreach ( $src->attachments as $item ) {
      $part = [
        'name'=>"file",
        'contents' => $this->src_cli->getWikiPageAttachment($src_wiki_id,$item->id),
        "filename"=>$item->name
      ];
      $ids[]=$this->dst_cli->postAttachmentFile(['multipart' => [$part]])->id;
    }
    $this->dst_cli->attachFileToWiki($dst_wiki_id,['attachmentId'=>$ids]);
    
  }
  
  
  
}