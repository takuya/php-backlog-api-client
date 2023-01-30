<?php

namespace Takuya\BacklogApiClient\Models\Wiki;

use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\BaseModel;
use Takuya\BacklogApiClient\Models\SharedFile;

/**
 * @property-read int                  $id
 * @property-read int                  $projectId
 * @property-read string               $name
 * @property-read string               $content
 * @property-read Tag[]                $tags
 * @property-read WikiPageAttachment[] $attachments
 * @property-read SharedFile           $sharedFile;
 * @property-read array                $stars
 * @property-read User                 $createdUser
 * @property-read string               $created
 * @property-read User                 $updatedUser
 * @property-read string               $updated
 */
class Page extends BaseModel {
  
  /*
   * @return array| Tag[]
   */
  public function tags() {
    return $this->api(
      Tag::class,
      'getWikiPageTagList',
      ['query_options' => ['projectIdOrKey' => $this->parent->id]],
      $this);
  }
  
  /*
   * @return array| History[]
   */
  public function histories() {
    return $this->api(History::class, 'getWikiPageHistory', ['wikiId' => $this->id], $this);
  }
  
  /**
   * override
   * @return void
   */
  protected function auto_mapping() {
    parent::auto_mapping();
    $mapping = [
      ['attachments', WikiPageAttachment::class],
    ];
    foreach ($mapping as $e) {
      property_exists($this, $e[0]) && $this->remapping_to_model($e[0], $e[1]);
    }
  }
}