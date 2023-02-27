<?php

namespace Takuya\BacklogApiClient\Models;

use RuntimeException;
use Takuya\BacklogApiClient\Models\Interfaces\HasFileContent;
use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

/**
 * @property-read int     $id
 * @property-read int     $projectId
 * @property-read string  $type "directory" or "file"
 * @property-read string  $dir
 * @property-read string  $name
 * @property-read ?string $size filesize. dir is null.
 * @property-read object  $createdUser
 * @property-read string  $created
 * @property-read ?string $updatedUser
 * @property-read ?string $updated
 */
class SharedFile extends BaseModel implements HasFileContent {
  
  use HasID;
  use HasProjectId;
  public string  $type;
  public string  $dir;
  public string  $name;
  public ?string $size;
  /** @var User */
  public object  $createdUser;
  public string  $created;
  /** @var ?User */
  public ?object $updatedUser;
  public ?string $updated;
  
  public function isDir(): bool {
    return $this->type == "directory";
  }
  
  public function getContent():string {
    if( ! $this->isFile() ) {
      throw new RuntimeException('Directory');
    }
    
    return $this->api->getFile($this->projectId, $this->id);
  }
  
  public function isFile(): bool {
    return $this->type == "file";
  }
}