<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;

class Category extends BaseModel {
  
  use HasID;
  public ?int $projectId;
  public string $name;
  public int    $displayOrder;
}