<?php

namespace Takuya\BacklogApiClient\Models;

/*
* @property-read int $id;
* @property-read int $fieldTypeId;
* @property-read string $name;
* @property-read object{ id: int, name: string,displayOrder: int } $value;
*/

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasIssueId;

class CustomFieldInputted extends BaseModel {
  
  use HasID;
  use HasIssueId;
  
  public int $fieldTypeId;
  public string $name;
  /** @var object{ id: int, name: string,displayOrder: int } */
  public $value;
}