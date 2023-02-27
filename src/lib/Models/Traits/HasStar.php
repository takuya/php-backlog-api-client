<?php

namespace Takuya\BacklogApiClient\Models\Traits;

use Takuya\BacklogApiClient\Models\Star;

trait HasStar {
  /** @var array | Star[] */
  public array $stars;
  public function hasStar(){
    return !empty($this->stars);
  }
}