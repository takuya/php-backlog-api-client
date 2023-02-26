<?php

namespace Takuya\BacklogApiClient;

trait LoggerTrait {
  
  protected bool    $enable_logging = false;
  protected ?object $logger         = null;
  
  public function log( $message, $level = 'debug' ):void {
    if( ! $this->enable_logging ) {
      return;
    }
    if( ! is_string($message) ) {
      $message = json_encode($message, 2496).PHP_EOL;
    }
    // expect monolog.
    $this->getLogger()?->$level($message);
  }
  
  protected function getLogger() {
    return $this->logger ?? new class {
        
        public function debug( $mess ):void {
          file_put_contents("php://stderr", $mess);
        }
      };
  }
  
  public function setLogger( $logger ):void {
    $this->logger = $logger;
  }
  
  public function enableLogging():void {
    $this->enable_logging = true;
  }
  
  public function disableLogging():void {
    $this->enable_logging = false;
  }
}