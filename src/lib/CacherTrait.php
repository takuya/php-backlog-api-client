<?php

namespace Takuya\BacklogApiClient;

trait CacherTrait {
  
  protected bool $cache_enabled = false;
  
  public function enable_cache() {
    $this->setCacheEnabled(true);
  }
  
  public function disable_cache() {
    $this->setCacheEnabled(false);
  }
  
  public function cache_path( $file ) {
    $cache_dir = __DIR__.'/../cache/';
    if( ! file_exists($cache_dir) ) {
      mkdir($cache_dir);
    }
    
    return $cache_dir.$file;
  }
  
  protected function getCacheEnabled():bool {
    return $this->cache_enabled;
  }
  
  protected function is_cache_enabled():bool {
    return $this->getCacheEnabled();
  }
  
  protected function setCacheEnabled( bool $bool ) {
    $this->cache_enabled = $bool;
  }
}