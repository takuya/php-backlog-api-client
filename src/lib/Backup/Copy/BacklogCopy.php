<?php

namespace Takuya\BacklogApiClient\Backup\Copy;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Backup\Copy\Traits\CopyProject;
use Takuya\BacklogApiClient\Backup\Copy\Traits\CopyIssue;

class BacklogCopy {
  
  use CopyProject;
  use CopyIssue;
  
  protected array $id_mapping;
  protected BacklogAPIClient $src_cli;
  protected BacklogAPIClient $dst_cli;
  
  public function __construct ( BacklogAPIClient $api_client,  $dst_space=null, ) {
    $this->src_cli = $api_client;
    $this->dst_cli = $this->dst_space ?? $api_client;
  }
  
  
}