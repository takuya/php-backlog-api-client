<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Models\Traits\ApiToModelMapping;
use Takuya\BacklogApiClient\Models\Traits\ModelObjectConvert;
use Takuya\BacklogApiClient\Models\Traits\ListUpModelClas;

abstract class BaseModel {
  
  use ApiToModelMapping;
  use ModelObjectConvert;
  use ListUpModelClas;
  
  protected BacklogAPIClient $api;
  
  /**
   * @param object                                         $json
   * @param \Takuya\BacklogApiClient\BacklogAPIClient      $api
   * @param \Takuya\BacklogApiClient\Models\BaseModel|null $parent
   */
  public function __construct ( object $json, BacklogAPIClient $api, BaseModel $parent = null ) {
    $this->mapping( $json, $this );
    $this->api = $api;
    $this->auto_mapping();
    $this->relation( $parent );
  }
  protected function relation ( $parent = null ): void{}
  
  
  /**
   * @param string                                         $into_class
   * @param string                                         $api_method
   * @param array                                          $query
   * @param \Takuya\BacklogApiClient\Models\BaseModel|null $parent
   * @return array|\Takuya\BacklogApiClient\Models\BaseModel[]|\Takuya\BacklogApiClient\Models\BaseModel
   */
  protected function api( string $into_class, string $api_method, $query = [], $parent = null ) {
    return $this->api->into_class($into_class, $api_method, $query, $parent);
  }
}