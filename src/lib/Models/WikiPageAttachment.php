<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Attachment;
use Takuya\BacklogApiClient\Models\Traits\HasID;

class WikiPageAttachment extends Attachment {

  use HasID;
  public ?int $wikiId;
  public string $name;
  public int $size;
  public function getContent():string {
    return $this->api->getWikiPageAttachment($this->parent->id, $this->id);
  }
}