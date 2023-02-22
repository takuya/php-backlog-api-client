<?php

namespace Takuya\BacklogApiClient\Models;

class Priority extends BaseModel {
  public ?string $space_key;
  public int $id;
  public string $name;
}