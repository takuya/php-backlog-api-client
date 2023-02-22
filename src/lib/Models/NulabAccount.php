<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\RelateToUser;

class NulabAccount extends BaseModel {
  public ?string $nulabId;
  public ?string $name;
  public ?string $uniqueId;
}