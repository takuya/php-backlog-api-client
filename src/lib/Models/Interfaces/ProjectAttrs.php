<?php

namespace Takuya\BacklogApiClient\Models\Interfaces;

use Takuya\BacklogApiClient\Models\Team;

interface ProjectAttrs {
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\User[]
   */
  public function users ();
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Team[]
   */
  public function teams ();
}

