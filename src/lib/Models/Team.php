<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Interfaces\HasIcon;
use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToSpace;

class Team extends BaseModel implements HasIcon {
  
  use HasID;
  use RelateToSpace;
  public string  $name;
  /** @var array | User[] */
  public array   $members;
  public int     $displayOrder;
  /** @var User  */
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