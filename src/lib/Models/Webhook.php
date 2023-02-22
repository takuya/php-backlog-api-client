<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class Webhook extends BaseModel {
  use HasID;
  use HasProjectId;
  public string $name;
  public string $description;
  public string $hookUrl;
  public string $allEvent;
  public array $activityTypeIds;
  public string $created;
  public object $createdUser;
  public string $updated;
  public object $updatedUser;
}