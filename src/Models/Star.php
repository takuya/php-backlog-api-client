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

class Star extends BaseModel {
  
  public int     $id;
  public ?string $comment;
  public string  $url;
  public string  $title;
  public object  $presenter;
  public string  $created;
}