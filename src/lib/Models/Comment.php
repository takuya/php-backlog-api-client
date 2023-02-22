<?php

namespace Takuya\BacklogApiClient\Models;

class Comment extends BaseModel {
  
  public int $id;
  public ?int $projectId;
  public int $issueId;
  public ?string $content;
  public ?array  $changeLog;
  /** @var object|\Takuya\BacklogApiClient\Models\User */
  public object $createdUser;
  public string $created;
  public string $updated;
  /** @var array | \Takuya\BacklogApiClient\Models\Star[] */
  public array $stars;
  /** @var array | \Takuya\BacklogApiClient\Models\Notification */
  public array $notifications;
}