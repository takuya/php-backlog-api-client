<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;

class Group extends BaseModel {
  
  use HasID;
  
  public string $name;
  /** @var User[] */
  public array $members;
}