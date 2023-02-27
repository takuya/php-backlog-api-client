<?php

namespace Takuya\BacklogApiClient\Models\Traits;

use stdClass;
use Takuya\BacklogApiClient\Models\Star;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\NulabAccount;
use Takuya\BacklogApiClient\Models\IssueAttachment;
use Takuya\BacklogApiClient\Models\SharedFile;
use Takuya\BacklogApiClient\Models\CommentNotification;
use Takuya\BacklogApiClient\Models\BaseModel;

trait ApiToModelMapping {
  
  protected ?BaseModel $parent;//TODO::消す
  /**
   * @param object $json   Json Result Object by json_decode
   * @param object $target target object copy to.
   * @return void
   */
  protected function mapping( object $json, object $target ) {
    array_map(function ( $prop ) use ( $json, $target ) { $target->$prop = $json->$prop; }, array_keys((array)$json));
  }
  
  /**
   * @param string $property_name property name of object.
   * @param string $class         Name of Class to construct.
   * @return void
   */
  protected function remapping_to_model( string $property_name, string $class ): void {
    if( is_array($this->$property_name) ) {
      foreach ($this->$property_name as $idx => $e) {
        $obj = ( get_class($e) === stdClass::class ) ? $e : ( json_decode(json_encode($e)) );
        $this->$property_name[$idx] = new $class($obj, $this->api, $this);
      }
    }
    if( is_object($this->$property_name) ) {
      $this->$property_name = new $class($this->$property_name, $this->api, $this);
    }
  }  /**
 * クラス名とJSONプロパティ名をDIする。
 * @return void
 */
  protected function auto_mapping (): void {
    $mapping= static::attribute_mapping_list();
    foreach ($mapping as $e) {
      property_exists($this, $e[0]) && $this->remapping_to_model($e[0], $e[1]);
    }
  }
  
  public static function attribute_mapping_list(): array {
    $mapping = [
      ['stars', Star::class],
      ['user', User::class],
      ['members', User::class],
      ['presenter', User::class],
      ['createdUser', User::class],
      ['updatedUser', User::class],
      ['assignee', User::class],
      ['nulabAccount', NulabAccount::class],
      ['attachments', IssueAttachment::class],
      ['sharedFiles', SharedFile::class],
      ['notifications', CommentNotification::class],
    ];
    return $mapping;
  }
}