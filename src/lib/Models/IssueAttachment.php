<?php

namespace Takuya\BacklogApiClient\Models;


use Takuya\BacklogApiClient\Models\Traits\HasID;

class IssueAttachment extends Attachment {
  public int $issueId;
  use HasID;
  public function getContent():string {
    return $this->api->getIssueAttachment($this->parent->id, $this->id);
  }
}