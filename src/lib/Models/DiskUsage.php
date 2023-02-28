<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\RelateToSpace;

class DiskUsage extends BaseModel {
  
  use HasProjectId;
  use RelateToSpace;
  public int $issue;
  public int $wiki;
  public int $file;
  public int $subversion;
  public int $git;
  public int $gitLFS;
  public int $pullRequest;
}