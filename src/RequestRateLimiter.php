<?php

namespace Takuya\BacklogApiClient;

class RequestRateLimiter {
  
  protected int  $RateLimitThreshold        = 10;
  protected int  $current_rate_limit_remains;
  protected int  $rate_limit_per_min;
  protected int  $rate_limit_reset_at;
  protected bool $enable_rate_limit_waiting = true;
  
  public function disableRateLimitWaiting() {
    $this->enable_rate_limit_waiting = false;
  }
  
  public function enableRateLimitWaiting() {
    $this->enable_rate_limit_waiting = true;
  }
  
  public function waitForRateLimit() {
    while( ! $this->canSendRequest()) {
      // print("waiting {$this->waitTime()}sec for api limit\n");
      sleep($this->waitTime());
    }
  }
  
  protected function canSendRequest():bool {
    if( $this->enable_rate_limit_waiting === false ) {
      return true;
    }
    $firstTry = empty($this->getRateLimitInfo()['X-RateLimit-Remaining']);
    $not_exceeded = ! $this->isRateLimitExceeded();
    $waited = $this->waitTime() < 2;
    
    return $firstTry || $not_exceeded || $waited;
  }
  
  public function getRateLimitInfo() {
    return [
      'X-RateLimit-Reset'     => $this->rate_limit_reset_at ?? null,
      'X-RateLimit-Limit'     => $this->rate_limit_per_min ?? null,
      'X-RateLimit-Remaining' => $this->current_rate_limit_remains ?? null,
    ];
  }
  public function parseRateLimit(\GuzzleHttp\Psr7\Response $res){
    $header = $res->getHeaders();
    $this->rate_limit_per_min = ! isset($header["X-RateLimit-Limit"])?:(int)$header["X-RateLimit-Limit"][0];
    $this->rate_limit_reset_at =!isset($header["X-RateLimit-Reset"])?:(int)$header["X-RateLimit-Reset"][0];
    $this->current_rate_limit_remains = !isset($header["X-RateLimit-Remaining"])?:(int)$header["X-RateLimit-Remaining"][0];
  }
  
  protected function isRateLimitExceeded():bool {
    return $this->getRateLimitRemainsCount() < $this->RateLimitThreshold;
  }
  
  protected function getRateLimitRemainsCount():int {
    return $this->current_rate_limit_remains ?? 0;
  }
  
  protected function waitTime() {
    
    // dump($this->getRateLimitRemainsCount());
    if( $this->isRateLimitExceeded() ) {
      $reset = $this->getRateLimitResetTime()->getTimestamp();
      $now = time();
      
      return ( $reset - $now ) + 1;
    } else {
      return 1;
    }
  }
  
  protected function getRateLimitResetTime():\DateTimeImmutable {
    return ( new \DateTimeImmutable(
      'now', new \DateTimeZone('Asia/Tokyo')) )->setTimestamp($this->rate_limit_reset_at ?? time());
  }
}