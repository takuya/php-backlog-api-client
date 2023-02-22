<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\HasIssueId;

class Comment extends BaseModel {
  
  use HasID;
  use HasProjectId;
  use HasIssueId;
  public ?string $content;
  public ?array  $changeLog;
  /** @var object|\Takuya\BacklogApiClient\Models\User */
  public object $createdUser;
  public string $created;
  public string $updated;
  /** @var array | \Takuya\BacklogApiClient\Models\Star[] */
  public array $stars;
  /** @var array | \Takuya\BacklogApiClient\Models\CommentNotification */
  public array $notifications;
}