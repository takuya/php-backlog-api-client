<?php

namespace Takuya\BacklogApiClient\Models;


use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasIssueId;
use Takuya\BacklogApiClient\Models\Traits\RelateToIssue;

class IssueAttachment extends Attachment {
  use RelateToIssue;
  use HasID;
  public function getContent():string {
    return $this->api->getIssueAttachment($this->issue_id, $this->id);
  }
}