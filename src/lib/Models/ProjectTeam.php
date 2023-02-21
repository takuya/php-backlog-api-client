<?php

namespace Takuya\BacklogApiClient\Models;

class ProjectTeam extends BaseModel {
  
  public int     $projectId;
  public string  $name;
  public array   $members;
  public int     $displayOrder;
  public ?string $createdUser;
  public string  $created;
  public ?string $updatedUser;
  public string  $updated;
  
  /**
   * @return string image binary of string.
   */
  public function icon():string {
    return $this->api->getTeamIcon($this->id);
  }
}