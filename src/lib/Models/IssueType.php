<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class IssueType extends BaseModel {
  
  use HasID;
  use HasProjectId;
  public string  $name;
  public string  $color;
  public int     $displayOrder;
  public ?string $templateSummary;
  public ?string $templateDescription;
}