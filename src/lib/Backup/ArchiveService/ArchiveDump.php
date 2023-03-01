<?php

namespace Takuya\BacklogApiClient\Backup\ArchiveService;

use Takuya\BacklogApiClient\Backup\Contracts\ArchiverContract;

class ArchiveDump implements ArchiverContract {
  public function __construct( public $file='php:/stdout'){
  
  }
  public function saveBacklogModel ( string $name, array $arr ):bool {
    
    $ret = var_export([$name,$arr],true);
    file_put_contents($this->file,$ret);
    return true;
  }
  
}