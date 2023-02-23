<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToProject {
  protected ?int $project_id;
  public function getProjectId():int{
    return $this->project_id;
  }
  public function relation($parent=null):void{
    parent::relation($parent);
    $this->project_id = null;
    $this->project_id = $this->project_id??$this->projectId ?? $parent?->id ?? null;
  }
}