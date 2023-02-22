<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToSpace;

class Priority extends BaseModel {
  use RelateToSpace;
  use HasID;
  public string $name;
}