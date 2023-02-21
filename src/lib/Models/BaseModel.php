<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Models\Traits\ApiMapping;
use Takuya\BacklogApiClient\Models\Traits\ModelObjectConvert;

class BaseModel {
  
  use ApiMapping;
  use ModelObjectConvert;
  
  public int $id;
  protected ?BaseModel $parent;
  protected BacklogAPIClient $api;
  
  /**
   * @param object                                         $json
   * @param \Takuya\BacklogApiClient\BacklogAPIClient      $api
   * @param \Takuya\BacklogApiClient\Models\BaseModel|null $parent
   */
  public function __construct( object $json, BacklogAPIClient $api, BaseModel $parent = null ) {
    $this->mapping($json, $this);
    $this->api = $api;
    $this->parent = $parent;
    $this->auto_mapping();
  }
  public static function listModelClass():array{
  
    $list = array_merge(glob(__DIR__.'/*.php'),glob(__DIR__.'/**/*.php'));
    $list = array_map(fn($e)=>str_replace(__DIR__.DIRECTORY_SEPARATOR,'',$e),$list);
    $list = array_filter($list,fn($e)=>!str_contains(strtolower($e),'traits'));
    $list = array_filter($list,fn($e)=>!str_contains(basename($e),basename(__FILE__)));
    $list = array_map(fn($e)=>str_replace('.php','',$e),$list);
    $list = array_map(fn($e)=>str_replace('/','\\',$e),$list);
    $list = array_map(fn($e)=>__NAMESPACE__.'\\'.$e,$list);
    return $list;
  }
  
  /**
   * クラス名とJSONプロパティ名をDIする。
   * @return void
   */
  protected function auto_mapping() {
    $mapping = [
      ['stars', Star::class],
      ['user', User::class],
      ['members', User::class],
      ['presenter', User::class],
      ['createdUser', User::class],
      ['updatedUser', User::class],
      ['nulabAccount', NulabAccount::class],
      ['attachments', IssueAttachment::class],
      ['sharedFiles', SharedFile::class],
      ['customFields', CustomFieldInputted::class],
      ['notifications', Notification::class],
    ];
    foreach ($mapping as $e) {
      property_exists($this, $e[0]) && $this->remapping_to_model($e[0], $e[1]);
    }
  }
  
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