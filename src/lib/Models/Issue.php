<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\HasProjectId;
use Takuya\BacklogApiClient\Models\Traits\HasStar;

class Issue extends BaseModel {
  
  public const PARENT_CHILD = [
    //親子課題の条件
    "すべて"            => 0,
    "子課題以外"          => 1,
    "子課題"            => 2,
    "親課題でも子課題でもない課題" => 3,
    "親課題"            => 4,
  ];
  use HasID;
  use HasProjectId;
  use HasStar;
  public string  $issueKey;
  public int     $keyId;
  public object  $issueType;
  public string  $summary;
  public string  $description;
  public ?object  $resolution;//「解決済み」
  public object  $priority;
  public object  $status;
  public ?object $assignee;
  public array   $category;
  public array   $versions;
  public array   $milestone;
  public ?string $startDate;
  public ?string $dueDate;
  public ?string $estimatedHours;
  public ?string $actualHours;
  public ?string $parentIssueId;
  /** @var User  */
  public object  $createdUser;
  public string  $created;
  /** @var User  */
  public object  $updatedUser;
  public string  $updated;
  /**
   * @var array| CustomFieldSelectedValue[]
   */
  public array $customFields;
  /**
   * @var array | IssueAttachment[]
   */
  public array $attachments;
  /**
   * @var array | SharedFile[]
   */
  public array $sharedFiles;
  /**
   * @var array | Star[]
   */
  public array $stars;
  
  public function __construct( object $json, BacklogAPIClient $api, BaseModel $parent = null ) {
    parent::__construct($json, $api, $parent);
  }
  public function hasAttachment(){
    return !empty($this->attachments);
  }
  public function hasCustomField(){
    return !empty($this->customFields);
  }
  
  /**
   * @return \Takuya\BacklogApiClient\Models\Issue|null
   */
  public function parentIssue() {
    if( ! $this->isChildIssue() ) {
      return null;
    }
    
    return $this->api->into_class(Issue::class, 'getIssue', ['issueIdOrKey' => $this->parentIssueId]);
  }
  
  public function isChildIssue() {
    return isset($this->parentIssueId);
  }
  
  public function project() {
    /** @var Project $p */
    $p = $this->api->into_class(Project::class, 'getProject', ['projectIdOrKey' => $this->projectId]);
    
    return $p;
  }
  
  public function comments() {
    /** @var Comment[] $c */
    $c = $this->api->into_class(Comment::class, 'getCommentList', ['issueIdOrKey' => $this->id], $this);
    
    return $c;
  }
  
  public static function attribute_mapping_list (): array {
    $list = parent::attribute_mapping_list();
    $mapping = [
      ['customFields', CustomFieldSelectedValue::class],
      ['attachments', IssueAttachment::class],
    ];
    return array_unique(array_merge($list,$mapping),SORT_REGULAR);
  }
}