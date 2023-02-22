<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Interfaces\HasIcon;
use Takuya\BacklogApiClient\Models\Traits\HasID;

class Team extends BaseModel implements HasIcon {
  
  use HasID;
  public ?string $space_key;
  public string  $name;
  public array   $members;
  public int     $displayOrder;
  public ?string $createdUser;
  public string  $created;
  public ?string $updatedUser;
  public string  $updated;
  
  /**
   * @return string image binary of string.
   */
  public function icon():string {
    return $this->api->getTeamIcon($this->id);
  }
}