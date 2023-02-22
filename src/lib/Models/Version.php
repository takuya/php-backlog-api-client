<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

/**
 * @property-read int    $id
 * @property-read int    $projectId
 * @property-read string $name
 * @property-read string $description
 * @property-read string $startDate
 * @property-read string $releaseDueDate
 * @property-read bool   $archived
 * @property-read int    $displayOrder
 */
class Version extends BaseModel {
  
  use HasID;
  use HasProjectId;
  public string  $name;
  public ?string $description;
  public ?string $startDate;
  public ?string $releaseDueDate;
  public bool    $archived;
  public int     $displayOrder;
}