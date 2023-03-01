<?php

namespace Takuya\BacklogApiClient\Backup\ArchiveService;

use Takuya\BacklogApiClient\Backup\Contracts\ArchiverContract;

class ArchiveJson implements ArchiverContract {
  public function saveBacklogModel ( string $name, array $arr ):bool {
    $str = json_encode($arr);
    $key = md5($str);
    return file_put_contents("$name.$key.json",$str );
  }
  
}