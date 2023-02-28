<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait RelateToSpace {
  protected ?string $space_key;
  
  public function getSpaceKey (): ?string {
    return $this->space_key ?? null;
  }
  
  public function setSpaceKey ( $key ) {
    $this->space_key = $key;
  }
  
  public function relation ( $parent = null ): void {
    parent::relation( $parent );
    $this->space_key = null;
    $this->space_key = $parent?->spaceKey ?? null;
    if ( $parent && method_exists( $parent, 'getSpaceKey' ) ) {
      $this->space_key = $parent->getSpaceKey() ?? null;
    }
  }
}