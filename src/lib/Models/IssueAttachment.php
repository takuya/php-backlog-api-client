<?php

namespace Takuya\BacklogApiClient\Models;


use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasIssueId;

class IssueAttachment extends Attachment {
  use HasIssueId;
  use HasID;
  public function getContent():string {
    return $this->api->getIssueAttachment($this->parent->id, $this->id);
  }
}