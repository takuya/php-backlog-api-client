<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Interfaces\HasIcon;
use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToSpace;

class User extends BaseModel implements HasIcon {
  
  use HasID;
  use RelateToSpace;
  public string  $userId;
  public string  $name;
  public int     $roleType;
  public ?string  $lang;
  public string  $mailAddress;
  public ?object $nulabAccount;
  public string  $keyword;
  public ?string $lastLoginTime;
  
  public function icon():string {
    return $this->api->getUserIcon($this->id);
  }
}