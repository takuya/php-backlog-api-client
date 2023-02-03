<?php

namespace Takuya\BacklogApiClient\Models;

class User extends BaseModel {
  
  public int     $id;
  public string  $userId;
  public string  $name;
  public int     $roleType;
  public ?string  $lang;
  public string  $mailAddress;
  public ?object $nulabAccount;
  public string  $keyword;
  public ?string $lastLoginTime;
  
  public function icon() {
    return $this->api->getUserIcon($this->id);
  }
}