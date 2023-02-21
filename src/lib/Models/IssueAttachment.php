<?php

namespace Takuya\BacklogApiClient\Models;

class IssueAttachment extends Attachment {
  public int $issueId;
  public function getContent():string {
    return $this->api->getIssueAttachment($this->parent->id, $this->id);
  }
}