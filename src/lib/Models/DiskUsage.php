<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

class DiskUsage extends BaseModel {
  
  use HasProjectId;
  public int $issue;
  public int $wiki;
  public int $file;
  public int $subversion;
  public int $git;
  public int $gitLFS;
  public int $pullRequest;
}