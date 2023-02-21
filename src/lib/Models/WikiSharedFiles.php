<?php

namespace Takuya\BacklogApiClient\Models;

class WikiSharedFiles extends BaseModel {
  public int $projectId;
  public string $type;
  public string $dir;
  public string $name;
  public string $size;
  public object $createdUser;
  public string $created;
  public object $updatedUser;
  public string $updated;
}