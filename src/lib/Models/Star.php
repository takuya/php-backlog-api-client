<?php

namespace Takuya\BacklogApiClient\Models;

/*
* @property-read int $id;
* @property-read string $comment;
* @property-read string $url;
* @property-read string $title;
* @property-read object $presenter;
* @property-read string $created;
*/

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToUser;

class Star extends BaseModel {
  
  use HasID;
  use RelateToUser;
  public ?string $comment;
  public string  $url;
  public string  $title;
  /** @var User */
  public object  $presenter;
  public string  $created;
}