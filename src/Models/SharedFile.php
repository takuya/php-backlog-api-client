<?php

namespace Takuya\BacklogApiClient\Models;

use RuntimeException;

/**
 * @property-read int     $id
 * @property-read string  $type "directory" or "file"
 * @property-read string  $dir
 * @property-read string  $name
 * @property-read ?string $size filesize. dir is null.
 * @property-read object  $createdUser
 * @property-read string  $created
 * @property-read ?string $updatedUser
 * @property-read ?string $updated
 */
class SharedFile extends BaseModel {
  
  public int     $id;
  public string  $type;
  public string  $dir;
  public string  $name;
  public ?string $size;
  public object  $createdUser;
  public string  $created;
  public ?string $updatedUser;
  public ?string $updated;
  
  public function isDir() {
    return $this->type == "directory";
  }
  
  public function getContent():string {
    if( ! $this->isFile() ) {
      throw new RuntimeException('Directory');
    }
    
    return $this->api->getFile($this->parent->id, $this->id);
  }
  
  public function isFile() {
    return $this->type == "file";
  }
}