<?php

namespace Takuya\BacklogApiClient\Models;

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
  
  public int     $id;
  public int     $projectId;
  public string  $name;
  public ?string $description;
  public ?string $startDate;
  public ?string $releaseDueDate;
  public bool    $archived;
  public int     $displayOrder;
}