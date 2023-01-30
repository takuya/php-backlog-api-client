<?php

namespace Takuya\BacklogApiClient\Models;

/**
 * @property-read int    $id
 * @property-read int    $projectId
 * @property-read string $name
 * @property-read string $color
 * @property-read int    $displayOrder
 */
class Status extends BaseModel {
  
  public int    $id;
  public int    $projectId;
  public string $name;
  public string $color;
}