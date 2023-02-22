<?php

namespace Takuya\BacklogApiClient\Models;

class Category extends BaseModel {
  
  public int $id;
  public ?int $projectId;
  public string $name;
  public int    $displayOrder;
}