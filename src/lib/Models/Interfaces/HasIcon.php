<?php

namespace Takuya\BacklogApiClient\Models\Interfaces;

interface HasIcon {
  /**
   * @return string binary data.
   */
  public function icon():string;
  
}