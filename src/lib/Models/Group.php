<?php

namespace Takuya\BacklogApiClient\Models;

class Group extends BaseModel {
  
  public int    $id;
  public string $name;
  /** @var User[] */
  public array $members;
}