<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class WikiTag extends BaseModel {
  use HasProjectId;
  public string $name;
}