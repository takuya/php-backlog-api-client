<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;

class Resolution extends BaseModel {
  public ?string $space_key;
  use HasID;
  public string $name;
}