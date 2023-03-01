<?php

namespace Takuya\BacklogApiClient\Backup\Contracts;

interface ArchiverContract {
  public function saveBacklogModel (  string $name , array $arr ):bool;
  
}