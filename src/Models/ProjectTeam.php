<?php

namespace Takuya\BacklogApiClient\Models;

class ProjectTeam extends BaseModel {
  
  public int     $id;
  public string  $name;
  public array   $members;
  public int     $displayOrder;
  public ?string $createdUser;
  public string  $created;
  public ?string $updatedUser;
  public string  $updated;
}