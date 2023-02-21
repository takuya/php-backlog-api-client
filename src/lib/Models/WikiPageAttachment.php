<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Attachment;

class WikiPageAttachment extends Attachment {
  
  public function getContent():string {
    return $this->api->getWikiPageAttachment($this->parent->id, $this->id);
  }
}