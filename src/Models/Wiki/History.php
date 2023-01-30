<?php

namespace Takuya\BacklogApiClient\Models\Wiki;

use Takuya\BacklogApiClient\Models\BaseModel;

/**
 * @property-read int    $pageId
 * @property-read int    $version
 * @property-read string $name
 * @property-read string $content
 * @property-read object $createdUser
 * @property-read string $created
 */
class History extends BaseModel {
  
  public int    $pageId;
  public int    $version;
  public string $name;
  public string $content;
  public object $createdUser;
  public string $created;
}