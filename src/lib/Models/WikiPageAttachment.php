<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Attachment;
use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToWikiPage;

class WikiPageAttachment extends Attachment {

  use HasID;
  use RelateToWikiPage;
  public string $name;
  public int $size;
  
  
  public function getContent():string {
    return $this->api->getWikiPageAttachment($this->parent->id, $this->id);
  }
}