<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Interfaces\HasContent;
use Takuya\BacklogApiClient\Models\Traits\HasID;

abstract class Attachment extends BaseModel implements HasContent{
  
  use HasID;
  public string $name;
  public int $size;
  /**
   * @var object|\Takuya\BacklogApiClient\Models\User
   */
  public object $createdUser;
  public string $created;
  
  /**
   * @param ?string $filename
   * @return int
   */
  public function download ( string $filename = null ): int {
    return file_put_contents( $filename ?? $this->name, $this->getContent() );
  }
  
  /**
   * @return string
   */
  abstract public function getContent():string;
}