<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\RelateToProject;

class Webhook extends BaseModel {
  use HasID;
  use RelateToProject;
  public string $name;
  public string $description;
  public string $hookUrl;
  public string $allEvent;
  public array $activityTypeIds;
  public string $created;
  /** @var User  */
  public object $createdUser;
  public string $updated;
  /** @var User  */
  public object $updatedUser;
}