<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToWikiPage {
  protected ?int $wiki_id;
  public function getWikiPageId():int{
    return $this->wiki_id;
  }
  public function relation($parent=null):void{
    parent::relation($parent);
    $this->wiki_id = $parent?->id ?? null;
  }
  
}