<?php

namespace Takuya\BacklogApiClient\Models;

class IssueType extends BaseModel {
  
  public int     $id;
  public int     $projectId;
  public string  $name;
  public string  $color;
  public int     $displayOrder;
  public ?string $templateSummary;
  public ?string $templateDescription;
}