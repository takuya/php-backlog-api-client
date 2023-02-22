<?php

namespace Takuya\BacklogApiClient\Models;

class Resolution extends BaseModel {
  public ?string $space_key;
  public int $id;
  public string $name;
}