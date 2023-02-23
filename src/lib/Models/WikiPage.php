<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;

/**
 * @property-read int                  $id
 * @property-read int                  $projectId
 * @property-read string               $name
 * @property-read string               $content
 * @property-read WikiTag[]            $tags
 * @property-read WikiPageAttachment[] $attachments
 * @property-read SharedFile           $sharedFile;
 * @property-read array                $stars
 * @property-read User                 $createdUser
 * @property-read string               $created
 * @property-read User                 $updatedUser
 * @property-read string               $updated
 */
class WikiPage extends BaseModel {
  use HasID;
  use HasProjectId;
  
  public string $name;
  public string $content;
  /** @var WikiTag[] */
  /** @var array|object[] */
  public array $tags;
  /** @var WikiPageAttachment[] */
  public ?array $attachments;
  public ?array $sharedFile;
  /** @var array | Star[] */
  public array $stars;
  /** @var User */
  
  public object $createdUser;
  public string $created;
  /** @var User */
  public object $updatedUser;
  public string $updated;
  
  
  /*
   * @return array| History[]
   */
  public function histories() {
    return $this->api( WikiHistory::class, 'getWikiPageHistory',
      [
        'wikiId' => $this->id,
        'query_options' => ['order' => 'desc', 'count' => 100],
      ], $this );
  }
  public static function attribute_mapping_list (): array {
    $list = parent::attribute_mapping_list();
    $mapping = [
      ['attachments', WikiPageAttachment::class],
      ['tags', WikiTag::class],
    ];
    return array_merge($list,$mapping);
  }
}