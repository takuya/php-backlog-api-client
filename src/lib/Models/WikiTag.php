<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\RelateToWikiPage;
use Takuya\BacklogApiClient\Models\Traits\RelateToProject;
use Takuya\BacklogApiClient\Models\Traits\HasID;

class WikiTag extends BaseModel {
  use RelateToProject;
  use HasID;
  public string $name;
}