<?php

namespace Takuya\BacklogApiClient\Models;

class Category extends BaseModel {
  
  public int    $id;
  public string $name;
  public int    $displayOrder;
}