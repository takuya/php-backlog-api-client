<?php

namespace Takuya\BacklogApiClient\Models;

class DiskUsage extends BaseModel {
  
  public int $projectId;
  public int $issue;
  public int $wiki;
  public int $file;
  public int $subversion;
  public int $git;
  public int $gitLFS;
  public int $pullRequest;
}