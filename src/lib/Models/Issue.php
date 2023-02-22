<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\BacklogAPIClient;
use Takuya\BacklogApiClient\Models\Traits\HasID;

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
  public int     $projectId;
  public string  $issueKey;
  public int     $keyId;
  public object  $issueType;
  public string  $summary;
  public string  $description;
  public ?object  $resolution;//
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
  public object  $createdUser;
  public string  $created;
  public object  $updatedUser;
  public string  $updated;
  /**
   * @var array | CustomFieldInputted[]
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
  public array $stars;
  
  public function __construct( object $json, BacklogAPIClient $api, BaseModel $parent = null ) {
    parent::__construct($json, $api, $parent);
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
  
  /**
   * override
   * @return void
   */
  protected function auto_mapping() {
    parent::auto_mapping();
    $mapping = [
      ['attachments', IssueAttachment::class],
    ];
    foreach ($mapping as $e) {
      property_exists($this, $e[0]) && $this->remapping_to_model($e[0], $e[1]);
    }
  }
}