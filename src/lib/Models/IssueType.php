<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;

class IssueType extends BaseModel {
  
  use HasID;
  public int     $projectId;
  public string  $name;
  public string  $color;
  public int     $displayOrder;
  public ?string $templateSummary;
  public ?string $templateDescription;
}