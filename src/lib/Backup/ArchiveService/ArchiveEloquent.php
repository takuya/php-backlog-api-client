<?php

namespace Takuya\BacklogApiClient\Backup\ArchiveService;

use Takuya\BacklogApiClient\Backup\Contracts\ArchiverContract;
use Takuya\BacklogApiClient\Backup\BacklogArchiver;
use Takuya\BacklogApiClient\Utils\StrTool;

class ArchiveEloquent  implements ArchiverContract {
  public function saveBacklogModel ( string $name, array $arr ):bool {
    $arr = $this->snake_case_key( $arr );
    $app_model_class = 'App\\Models\\'.$name;
    return ( new $app_model_class( $arr ) )->save();
  }
  
  protected function snake_case_key ( $arr ) {
    foreach ( $arr as $k => $v ) {
      unset( $arr[$k] );
      $arr[StrTool::snake( $k )] = $v;
    }
    
    return $arr;
  }
}