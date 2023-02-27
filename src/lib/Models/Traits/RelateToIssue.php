<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToIssue {
  protected ?int $issue_id;
  public function getIssueId():int{
    return $this->issue_id;
  }
  public function relation($parent=null):void{
    parent::relation($parent);
    $this->issue_id = $parent->issueId ?? $parent->issue_id?? $parent->id ?? null;
  }
}