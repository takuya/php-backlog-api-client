<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Models\Traits\RelateToWikiPage;

/**
 * @property-read int    $pageId
 * @property-read int    $version
 * @property-read string $name
 * @property-read string $content
 * @property-read object $createdUser
 * @property-read string $created
 */
class WikiHistory extends BaseModel {
  
  use RelateToWikiPage;
  public int    $pageId;
  public int    $version;
  public string $name;
  public string $content;
  /** @var User  */
  public object $createdUser;
  public string $created;
}