<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToSpace {
  protected ?string $space_key;
  public function getSpaceKey():string{
    return $this->space_key;
  }
  public function setSpaceKey($key){
    $this->space_key = $key;
  }
  
  public function relation($parent=null):void{
    parent::relation($parent);
    $this->space_key = null;
    $this->space_key = $this->space_key ?? $parent?->spaceKey ?? null;
  }
}