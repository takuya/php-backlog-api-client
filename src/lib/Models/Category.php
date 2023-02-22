<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class Category extends BaseModel {
  
  use HasID;
  use HasProjectId;
  public string $name;
  public int    $displayOrder;
}