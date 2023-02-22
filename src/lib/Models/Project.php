<?php

namespace Takuya\BacklogApiClient\Models;

class Project extends BaseModel {
  
  public int    $id;
  public string $projectKey;
  public string $name;
  public bool   $chartEnabled;
  public bool   $useResolvedForChart;
  public bool   $subtaskingEnabled;
  public bool   $projectLeaderCanEditProjectLeader;
  public bool   $useWiki;
  public bool   $useFileSharing;
  public bool   $useWikiTreeView;
  public ?bool  $useSubversion;
  public ?bool  $useGit;
  public bool   $useOriginalImageSizeAtWiki;
  public string $textFormattingRule;
  public bool   $archived;
  public int    $displayOrder;
  public int    $useDevAttributes;
  
  /**
   * @return \Takuya\BacklogApiClient\Models\Issue[]
   */
  public function issues() {
    /** @var Issue[] $list */
    $list = [];
    foreach ($this->issues_ids() as $issue_id) {
      $list[] = $this->api(Issue::class, 'getIssue', ['issueIdOrKey' => $issue_id], $this);
    }
    
    return $list;
  }
  
  /**
   * @return array|int[]
   */
  public function issues_ids():array {
    return $this->api->issue_ids($this->id);
  }
  
  /**
   * @return array|WikiPage[]
   */
  public function wiki_pages() {
    /** @var WikiPage[] */
    $list = [];
    foreach ($this->api->getWikiPageList(['projectIdOrKey' => $this->id]) as $w) {
      $list[] = $this->api(WikiPage::class, 'getWikiPage', ['wikiId' => $w->id], $this);
    }
    
    return $list;
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Team[]
   */
  public function teams() {
    return $this->api(Team::class, 'getProjectTeamList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Status[]
   */
  public function statuses() {
    return $this->api(Status::class, 'getStatusListOfProject', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\User[]
   */
  public function users() {
    return $this->api(User::class, 'getProjectUserList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\IssueType[]
   */
  public function issue_types() {
    return $this->api(IssueType::class, 'getIssueTypeList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Category[]
   */
  public function categories() {
    return $this->api(Category::class, 'getCategoryList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Version[]
   */
  public function versions() {
    return $this->api(Version::class, 'getVersionMilestoneList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\CustomField[]
   */
  public function custom_fields() {
    return $this->api(CustomField::class, 'getCustomFieldList', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\SharedFile[]
   */
  public function shared_files() {
    return $this->api(SharedFile::class, 'getListOfSharedFiles', ['projectIdOrKey' => $this->id, 'path' => ''], $this);
  }
  
  /**
   * @return \Takuya\BacklogApiClient\Models\DiskUsage
   */
  public function disk_usage() {
    return $this->api(DiskUsage::class, 'getProjectDiskUsage', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return array|\Takuya\BacklogApiClient\Models\Webhook[]
   */
  public function webhooks() {
    return $this->api(Webhook::class, 'getListOfWebhooks', ['projectIdOrKey' => $this->id], $this);
  }
  
  /**
   * @return string image binary of string.
   */
  public function icon():string {
    return $this->api->getProjectIcon($this->id);
  }
}