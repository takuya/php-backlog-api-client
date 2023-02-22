<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;

class Webhook extends BaseModel {
  use HasID;
  public int    $projectId;
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