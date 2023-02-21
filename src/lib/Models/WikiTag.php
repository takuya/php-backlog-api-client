<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\BaseModel;

class WikiTag extends BaseModel {
  public int $projectId;
  public string $name;
}