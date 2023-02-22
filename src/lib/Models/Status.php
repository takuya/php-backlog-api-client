<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

/**
 * @property-read int    $id
 * @property-read int    $projectId
 * @property-read string $name
 * @property-read string $color
 * @property-read int    $displayOrder
 */
class Status extends BaseModel {
  
  use HasID;
  use HasProjectId;
  public string $name;
  public string $color;
  public int    $displayOrder;
}