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
}