<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\HasIssueId;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Star;
use Takuya\BacklogApiClient\Models\Notification;
use Takuya\BacklogApiClient\Models\Traits\HasStar;

class Comment extends BaseModel {
  
  use HasID;
  use HasProjectId;
  use HasIssueId;
  use HasStar;
  public ?string $content;
  public ?array  $changeLog;
  /** @var object|User */
  public object $createdUser;
  public string $created;
  public string $updated;
  /** @var array | Star[] */
  public array $stars;
  /** @var array | Notification[] */
  public array $notifications;
}