<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class WikiSharedFiles extends BaseModel {
  use HasID;
  use HasProjectId;
  public string $type;
  public string $dir;
  public string $name;
  public string $size;
  public object $createdUser;
  public string $created;
  public object $updatedUser;
  public string $updated;
}