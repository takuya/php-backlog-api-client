<?php

namespace Takuya\BacklogApiClient\Models;

class Webhook extends BaseModel {
  public int    $id;
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