<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToComment {

  public ?int $commentId;
  
  /**
   * @return int|null
   */
  public function getCommentId (): ?int {
    return $this->commentId;
  }
  public function relation($parent=null):void{
    parent::relation($parent);
    $this->commentId = $parent->commentId ?? $parent->id ?? null;
  }
  
}