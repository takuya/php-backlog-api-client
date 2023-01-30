<?php
namespace Takuya\BacklogApiClient;
trait BacklogAPIv2Methods {
    /**
  *  スペース情報の取得
  *
  * @return array{spaceKey: string,name: string,ownerId: integer,lang: string,timezone: string,reportSendTime: string,textFormattingRule: string,created: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-space/
  */
  public function getSpace(){
    return $this->call_api('GET', "/api/v2/space" );
  }

  /**
  *  最近の更新の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,project: object,type: integer,content: object,notifications: array,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-recent-updates/
  */
  public function getRecentUpdates($query_options=[]){
    return $this->call_api('GET', "/api/v2/space/activities",$query_options );
  }

  /**
  *  アクティビティの取得
  *
  * @params string|int $activityId
  * @return array{id: integer,project: object,type: integer,content: object,notifications: array,createdUser: object,created: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-activity/
  */
  public function getActivity($activityId){
    return $this->call_api('GET', "/api/v2/activities/$activityId" );
  }

  /**
  *  スペースアイコン画像の取得
  *
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-space-logo/
  */
  public function getSpaceLogo(){
    return $this->call_api('GET', "/api/v2/space/image" );
  }

  /**
  *  スペースのお知らせの取得
  *
  * @return array{content: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-space-notification/
  */
  public function getSpaceNotification(){
    return $this->call_api('GET', "/api/v2/space/notification" );
  }

  /**
  *  スペースのお知らせの更新
  *
  * @return array{content: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-space-notification/
  */
  public function updateSpaceNotification(){
    return $this->call_api('PUT', "/api/v2/space/notification" );
  }

  /**
  *  スペースの容量使用状況の取得
  *
  * @return array{capacity: integer,issue: integer,wiki: integer,file: integer,subversion: integer,git: integer,gitLFS: integer,details: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-space-disk-usage/
  */
  public function getSpaceDiskUsage(){
    return $this->call_api('GET', "/api/v2/space/diskUsage" );
  }

  /**
  *  添付ファイルの送信
  *
  * @return array{id: integer,name: string,size: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/post-attachment-file/
  */
  public function postAttachmentFile(){
    return $this->call_api('POST', "/api/v2/space/attachment" );
  }

  /**
  *  ユーザー一覧の取得
  *
  * @return array< array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-user-list/
  */
  public function getUserList(){
    return $this->call_api('GET', "/api/v2/users" );
  }

  /**
  *  ユーザー情報の取得
  *
  * @params string|int $userId
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-user/
  */
  public function getUser($userId){
    return $this->call_api('GET', "/api/v2/users/$userId" );
  }

  /**
  *  ユーザーの追加
  *
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-user/
  */
  public function addUser(){
    return $this->call_api('POST', "/api/v2/users" );
  }

  /**
  *  ユーザーの更新
  *
  * @params string|int $userId
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-user/
  */
  public function updateUser($userId){
    return $this->call_api('PATCH', "/api/v2/users/$userId" );
  }

  /**
  *  ユーザーの削除
  *
  * @params string|int $userId
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-user/
  */
  public function deleteUser($userId){
    return $this->call_api('DELETE', "/api/v2/users/$userId" );
  }

  /**
  *  認証ユーザー情報の取得
  *
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-own-user/
  */
  public function getOwnUser(){
    return $this->call_api('GET', "/api/v2/users/myself" );
  }

  /**
  *  ユーザーアイコンの取得
  *
  * @params string|int $userId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-user-icon/
  */
  public function getUserIcon($userId){
    return $this->call_api('GET', "/api/v2/users/$userId/icon" );
  }

  /**
  *  ユーザーの最近の活動の取得
  *
  * @params string|int $userId
  * @params array $query_options
  * @return array< array{id: integer,project: object,type: integer,content: object,notifications: array,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-user-recent-updates/
  */
  public function getUserRecentUpdates($userId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/users/$userId/activities",$query_options );
  }

  /**
  *  ユーザーの受け取ったスター一覧の取得
  *
  * @params string|int $userId
  * @params array $query_options
  * @return array< array{id: integer,comment: NULL,url: string,title: string,presenter: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-received-star-list/
  */
  public function getReceivedStarList($userId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/users/$userId/stars",$query_options );
  }

  /**
  *  ユーザーの受け取ったスターの数の取得
  *
  * @params string|int $userId
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-user-received-stars/
  */
  public function countUserReceivedStars($userId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/users/$userId/stars/count",$query_options );
  }

  /**
  *  自分が最近見た課題一覧の取得
  *
  * @params array $query_options
  * @return array{issue: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-recently-viewed-issues/
  */
  public function getListOfRecentlyViewedIssues($query_options=[]){
    return $this->call_api('GET', "/api/v2/users/myself/recentlyViewedIssues",$query_options );
  }

  /**
  *  自分が最近見た課題の追加
  *
  * @return array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-recently-viewed-issue/
  */
  public function addRecentlyViewedIssue(){
    return $this->call_api('POST', "/api/v2/users/myself/recentlyViewedIssues" );
  }

  /**
  *  自分が最近見たプロジェクト一覧の取得
  *
  * @params array $query_options
  * @return array{project: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-recently-viewed-projects/
  */
  public function getListOfRecentlyViewedProjects($query_options=[]){
    return $this->call_api('GET', "/api/v2/users/myself/recentlyViewedProjects",$query_options );
  }

  /**
  *  自分が最近見たWiki一覧の取得
  *
  * @params array $query_options
  * @return array{page: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-recently-viewed-wikis/
  */
  public function getListOfRecentlyViewedWikis($query_options=[]){
    return $this->call_api('GET', "/api/v2/users/myself/recentlyViewedWikis",$query_options );
  }

  /**
  *  自分が最近見たWikiの追加
  *
  * @return array{id: integer,projectId: integer,name: string,content: string,tags: array,attachments: array,sharedFiles: array,stars: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-recently-viewed-wiki/
  */
  public function addRecentlyViewedWiki(){
    return $this->call_api('POST', "/api/v2/users/myself/recentlyViewedWikis" );
  }

  /**
  *  グループ一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-groups/
  */
  public function getListOfGroups($query_options=[]){
    return $this->call_api('GET', "/api/v2/groups",$query_options );
  }

  /**
  *  グループの追加
  *
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-group/
  */
  public function addGroup(){
    return $this->call_api('POST', "/api/v2/groups" );
  }

  /**
  *  グループ情報の取得
  *
  * @params string|int $groupId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-group/
  */
  public function getGroup($groupId){
    return $this->call_api('GET', "/api/v2/groups/$groupId" );
  }

  /**
  *  グループ情報の更新
  *
  * @params string|int $groupId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-group/
  */
  public function updateGroup($groupId){
    return $this->call_api('PATCH', "/api/v2/groups/$groupId" );
  }

  /**
  *  グループの削除
  *
  * @params string|int $groupId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-group/
  */
  public function deleteGroup($groupId){
    return $this->call_api('DELETE', "/api/v2/groups/$groupId" );
  }

  /**
  *  状態一覧の取得
  *
  * @return array< array{id: integer,name: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-status-list/
  */
  public function getStatusList(){
    return $this->call_api('GET', "/api/v2/statuses" );
  }

  /**
  *  プロジェクトの状態一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-status-list-of-project/
  */
  public function getStatusListOfProject($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/statuses" );
  }

  /**
  *  優先度一覧の取得
  *
  * @return array< array{id: integer,name: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-priority-list/
  */
  public function getPriorityList(){
    return $this->call_api('GET', "/api/v2/priorities" );
  }

  /**
  *  完了理由一覧の取得
  *
  * @return array< array{id: integer,name: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-resolution-list/
  */
  public function getResolutionList(){
    return $this->call_api('GET', "/api/v2/resolutions" );
  }

  /**
  *  プロジェクト一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,projectKey: string,name: string,chartEnabled: boolean,useResolvedForChart: boolean,subtaskingEnabled: boolean,projectLeaderCanEditProjectLeader: boolean,useWiki: boolean,useFileSharing: boolean,useWikiTreeView: boolean,useOriginalImageSizeAtWiki: boolean,textFormattingRule: string,archived: boolean,displayOrder: integer,useDevAttributes: boolean} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-list/
  */
  public function getProjectList($query_options=[]){
    return $this->call_api('GET', "/api/v2/projects",$query_options );
  }

  /**
  *  プロジェクトの追加
  *
  * @return array{id: integer,projectKey: string,name: string,chartEnabled: boolean,useResolvedForChart: boolean,subtaskingEnabled: boolean,projectLeaderCanEditProjectLeader: boolean,useWiki: boolean,useFileSharing: boolean,useWikiTreeView: boolean,useOriginalImageSizeAtWiki: boolean,useSubversion: boolean,useGit: boolean,textFormattingRule: string,archived: boolean,displayOrder: integer,useDevAttributes: boolean}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-project/
  */
  public function addProject(){
    return $this->call_api('POST', "/api/v2/projects" );
  }

  /**
  *  プロジェクト情報の取得
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectKey: string,name: string,chartEnabled: boolean,useResolvedForChart: boolean,subtaskingEnabled: boolean,projectLeaderCanEditProjectLeader: boolean,useWiki: boolean,useFileSharing: boolean,useWikiTreeView: boolean,useOriginalImageSizeAtWiki: boolean,useSubversion: boolean,useGit: boolean,textFormattingRule: string,archived: boolean,displayOrder: integer,useDevAttributes: boolean}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project/
  */
  public function getProject($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey" );
  }

  /**
  *  プロジェクト情報の更新
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectKey: string,name: string,chartEnabled: boolean,useResolvedForChart: boolean,subtaskingEnabled: boolean,projectLeaderCanEditProjectLeader: boolean,useWiki: boolean,useFileSharing: boolean,useWikiTreeView: boolean,useOriginalImageSizeAtWiki: boolean,useSubversion: boolean,useGit: boolean,textFormattingRule: string,archived: boolean,displayOrder: integer,useDevAttributes: boolean}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-project/
  */
  public function updateProject($projectIdOrKey){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey" );
  }

  /**
  *  プロジェクトの削除
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectKey: string,name: string,chartEnabled: boolean,useResolvedForChart: boolean,subtaskingEnabled: boolean,projectLeaderCanEditProjectLeader: boolean,useWiki: boolean,useFileSharing: boolean,useWikiTreeView: boolean,useOriginalImageSizeAtWiki: boolean,textFormattingRule: string,archived: boolean,displayOrder: integer,useDevAttributes: boolean}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-project/
  */
  public function deleteProject($projectIdOrKey){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey" );
  }

  /**
  *  プロジェクトアイコンの取得
  *
  * @params string|int $projectIdOrKey
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-icon/
  */
  public function getProjectIcon($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/image" );
  }

  /**
  *  プロジェクトの最近の活動の取得
  *
  * @params string|int $projectIdOrKey
  * @params array $query_options
  * @return array< array{id: integer,project: object,type: integer,content: object,notifications: array,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-recent-updates/
  */
  public function getProjectRecentUpdates($projectIdOrKey,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/activities",$query_options );
  }

  /**
  *  プロジェクトユーザーの追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-project-user/
  */
  public function addProjectUser($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/users" );
  }

  /**
  *  プロジェクトユーザー一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @params array $query_options
  * @return array< array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-user-list/
  */
  public function getProjectUserList($projectIdOrKey,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/users",$query_options );
  }

  /**
  *  プロジェクトユーザーの削除
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-project-user/
  */
  public function deleteProjectUser($projectIdOrKey){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/users" );
  }

  /**
  *  プロジェクト管理者の追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-project-administrator/
  */
  public function addProjectAdministrator($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/administrators" );
  }

  /**
  *  プロジェクト管理者一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-project-administrators/
  */
  public function getListOfProjectAdministrators($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/administrators" );
  }

  /**
  *  プロジェクト管理者の削除
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-project-administrator/
  */
  public function deleteProjectAdministrator($projectIdOrKey){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/administrators" );
  }

  /**
  *  状態の追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-status/
  */
  public function addStatus($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/statuses" );
  }

  /**
  *  状態情報の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-status/
  */
  public function updateStatus($projectIdOrKey,$id){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/statuses/$id" );
  }

  /**
  *  状態の削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-status/
  */
  public function deleteStatus($projectIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/statuses/$id" );
  }

  /**
  *  状態の並び替え
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-order-of-status/
  */
  public function updateOrderOfStatus($projectIdOrKey){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/statuses/updateDisplayOrder" );
  }

  /**
  *  種別一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer,templateSummary: string,templateDescription: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-issue-type-list/
  */
  public function getIssueTypeList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/issueTypes" );
  }

  /**
  *  種別の追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer,templateSummary: string,templateDescription: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-issue-type/
  */
  public function addIssueType($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/issueTypes" );
  }

  /**
  *  種別情報の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer,templateSummary: string,templateDescription: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-issue-type/
  */
  public function updateIssueType($projectIdOrKey,$id){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/issueTypes/$id" );
  }

  /**
  *  種別の削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,color: string,displayOrder: integer,templateSummary: string,templateDescription: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-issue-type/
  */
  public function deleteIssueType($projectIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/issueTypes/$id" );
  }

  /**
  *  カテゴリー一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,name: string,displayOrder: integer} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-category-list/
  */
  public function getCategoryList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/categories" );
  }

  /**
  *  カテゴリーの追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-category/
  */
  public function addCategory($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/categories" );
  }

  /**
  *  カテゴリー情報の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,name: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-category/
  */
  public function updateCategory($projectIdOrKey,$id){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/categories/$id" );
  }

  /**
  *  カテゴリーの削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,name: string,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-category/
  */
  public function deleteCategory($projectIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/categories/$id" );
  }

  /**
  *  バージョン(マイルストーン)一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,projectId: integer,name: string,description: string,startDate: NULL,releaseDueDate: NULL,archived: boolean,displayOrder: integer} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-version-milestone-list/
  */
  public function getVersionMilestoneList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/versions" );
  }

  /**
  *  バージョン(マイルストーン)の追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,projectId: integer,name: string,description: string,startDate: NULL,releaseDueDate: NULL,archived: boolean,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-version-milestone/
  */
  public function addVersionMilestone($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/versions" );
  }

  /**
  *  バージョン(マイルストーン)情報の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,description: string,startDate: NULL,releaseDueDate: NULL,archived: boolean,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-version-milestone/
  */
  public function updateVersionMilestone($projectIdOrKey,$id){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/versions/$id" );
  }

  /**
  *  バージョン(マイルストーン)の削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,projectId: integer,name: string,description: string,startDate: NULL,releaseDueDate: NULL,archived: boolean,displayOrder: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-version/
  */
  public function deleteVersion($projectIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/versions/$id" );
  }

  /**
  *  カスタム属性一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array,allowAddItem: boolean,items: array} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-custom-field-list/
  */
  public function getCustomFieldList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/customFields" );
  }

  /**
  *  カスタム属性の追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-custom-field/
  */
  public function addCustomField($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/customFields" );
  }

  /**
  *  カスタム属性の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-custom-field/
  */
  public function updateCustomField($projectIdOrKey,$id){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/customFields/$id" );
  }

  /**
  *  カスタム属性の削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-custom-field/
  */
  public function deleteCustomField($projectIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/customFields/$id" );
  }

  /**
  *  選択リストカスタム属性のリスト項目の追加
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array,allowAddItem: boolean,items: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-list-item-for-list-type-custom-field/
  */
  public function addListItemForListTypeCustomField($projectIdOrKey,$id){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/customFields/$id/items" );
  }

  /**
  *  選択リストカスタム属性のリスト項目の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @params string|int $itemId
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array,allowAddItem: boolean,items: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-list-item-for-list-type-custom-field/
  */
  public function updateListItemForListTypeCustomField($projectIdOrKey,$id,$itemId){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/customFields/$id/items/$itemId" );
  }

  /**
  *  選択リストカスタム属性のリスト項目の削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $id
  * @params string|int $itemId
  * @return array{id: integer,typeId: integer,name: string,description: string,required: boolean,applicableIssueTypes: array,allowAddItem: boolean,items: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-list-item-for-list-type-custom-field/
  */
  public function deleteListItemForListTypeCustomField($projectIdOrKey,$id,$itemId){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/customFields/$id/items/$itemId" );
  }

  /**
  *  共有ファイル一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $path
  * @params array $query_options
  * @return array< array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: NULL,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-shared-files/
  */
  public function getListOfSharedFiles($projectIdOrKey,$path,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/files/metadata/$path",$query_options );
  }

  /**
  *  共有ファイルのダウンロード
  *
  * @params string|int $projectIdOrKey
  * @params string|int $sharedFileId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-file/
  */
  public function getFile($projectIdOrKey,$sharedFileId){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/files/$sharedFileId" );
  }

  /**
  *  プロジェクトの容量使用状況の取得
  *
  * @params string|int $projectIdOrKey
  * @return array{projectId: integer,issue: integer,wiki: integer,file: integer,subversion: integer,git: integer,gitLFS: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-disk-usage/
  */
  public function getProjectDiskUsage($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/diskUsage" );
  }

  /**
  *  Webhook一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,name: string,description: string,hookUrl: string,allEvent: boolean,activityTypeIds: array,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-webhooks/
  */
  public function getListOfWebhooks($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/webhooks" );
  }

  /**
  *  Webhookの追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,description: string,hookUrl: string,allEvent: boolean,activityTypeIds: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-webhook/
  */
  public function addWebhook($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/webhooks" );
  }

  /**
  *  Webhookの取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $webhookId
  * @return array{id: integer,name: string,description: string,hookUrl: string,allEvent: boolean,activityTypeIds: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-webhook/
  */
  public function getWebhook($projectIdOrKey,$webhookId){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/webhooks/$webhookId" );
  }

  /**
  *  Webhookの更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $webhookId
  * @return array{id: integer,name: string,description: string,hookUrl: string,allEvent: boolean,activityTypeIds: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-webhook/
  */
  public function updateWebhook($projectIdOrKey,$webhookId){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/webhooks/$webhookId" );
  }

  /**
  *  Webhookの削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $webhookId
  * @return array{id: integer,name: string,description: string,hookUrl: string,allEvent: boolean,activityTypeIds: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-webhook/
  */
  public function deleteWebhook($projectIdOrKey,$webhookId){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/webhooks/$webhookId" );
  }

  /**
  *  課題一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-issue-list/
  */
  public function getIssueList($query_options=[]){
    return $this->call_api('GET', "/api/v2/issues",$query_options );
  }

  /**
  *  課題数の取得
  *
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-issue/
  */
  public function countIssue($query_options=[]){
    return $this->call_api('GET', "/api/v2/issues/count",$query_options );
  }

  /**
  *  課題の追加
  *
  * @return array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-issue/
  */
  public function addIssue(){
    return $this->call_api('POST', "/api/v2/issues" );
  }

  /**
  *  課題情報の取得
  *
  * @params string|int $issueIdOrKey
  * @return array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-issue/
  */
  public function getIssue($issueIdOrKey){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey" );
  }

  /**
  *  課題情報の更新
  *
  * @params string|int $issueIdOrKey
  * @return array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-issue/
  */
  public function updateIssue($issueIdOrKey){
    return $this->call_api('PATCH', "/api/v2/issues/$issueIdOrKey" );
  }

  /**
  *  課題の削除
  *
  * @params string|int $issueIdOrKey
  * @return array{id: integer,projectId: integer,issueKey: string,keyId: integer,issueType: object,summary: string,description: string,resolution: NULL,priority: object,status: object,assignee: object,category: array,versions: array,milestone: array,startDate: NULL,dueDate: NULL,estimatedHours: NULL,actualHours: NULL,parentIssueId: NULL,createdUser: object,created: string,updatedUser: object,updated: string,customFields: array,attachments: array,sharedFiles: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-issue/
  */
  public function deleteIssue($issueIdOrKey){
    return $this->call_api('DELETE', "/api/v2/issues/$issueIdOrKey" );
  }

  /**
  *  課題コメントの取得
  *
  * @params string|int $issueIdOrKey
  * @params array $query_options
  * @return array< array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-comment-list/
  */
  public function getCommentList($issueIdOrKey,$query_options=[]){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/comments",$query_options );
  }

  /**
  *  課題コメントの追加
  *
  * @params string|int $issueIdOrKey
  * @return array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-comment/
  */
  public function addComment($issueIdOrKey){
    return $this->call_api('POST', "/api/v2/issues/$issueIdOrKey/comments" );
  }

  /**
  *  課題コメント数の取得
  *
  * @params string|int $issueIdOrKey
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-comment/
  */
  public function countComment($issueIdOrKey){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/comments/count" );
  }

  /**
  *  課題コメント情報の取得
  *
  * @params string|int $issueIdOrKey
  * @params string|int $commentId
  * @return array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-comment/
  */
  public function getComment($issueIdOrKey,$commentId){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/comments/$commentId" );
  }

  /**
  *  課題コメントの削除
  *
  * @params string|int $issueIdOrKey
  * @params string|int $commentId
  * @return array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-comment/
  */
  public function deleteComment($issueIdOrKey,$commentId){
    return $this->call_api('DELETE', "/api/v2/issues/$issueIdOrKey/comments/$commentId" );
  }

  /**
  *  課題コメント情報の更新
  *
  * @params string|int $issueIdOrKey
  * @params string|int $commentId
  * @return array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-comment/
  */
  public function updateComment($issueIdOrKey,$commentId){
    return $this->call_api('PATCH', "/api/v2/issues/$issueIdOrKey/comments/$commentId" );
  }

  /**
  *  課題コメントのお知らせ一覧の取得
  *
  * @params string|int $issueIdOrKey
  * @params string|int $commentId
  * @return array< array{id: integer,alreadyRead: boolean,reason: integer,user: object,resourceAlreadyRead: boolean} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-comment-notifications/
  */
  public function getListOfCommentNotifications($issueIdOrKey,$commentId){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/comments/$commentId/notifications" );
  }

  /**
  *  課題コメントにお知らせを追加
  *
  * @params string|int $issueIdOrKey
  * @params string|int $commentId
  * @return array{id: integer,content: string,changeLog: NULL,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-comment-notification/
  */
  public function addCommentNotification($issueIdOrKey,$commentId){
    return $this->call_api('POST', "/api/v2/issues/$issueIdOrKey/comments/$commentId/notifications" );
  }

  /**
  *  課題添付ファイル一覧の取得
  *
  * @params string|int $issueIdOrKey
  * @return array< array{id: integer,name: string,size: integer,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-issue-attachments/
  */
  public function getListOfIssueAttachments($issueIdOrKey){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/attachments" );
  }

  /**
  *  課題添付ファイルのダウンロード
  *
  * @params string|int $issueIdOrKey
  * @params string|int $attachmentId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-issue-attachment/
  */
  public function getIssueAttachment($issueIdOrKey,$attachmentId){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/attachments/$attachmentId" );
  }

  /**
  *  課題添付ファイルの削除
  *
  * @params string|int $issueIdOrKey
  * @params string|int $attachmentId
  * @return array{id: integer,name: string,size: integer,createdUser: object,created: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-issue-attachment/
  */
  public function deleteIssueAttachment($issueIdOrKey,$attachmentId){
    return $this->call_api('DELETE', "/api/v2/issues/$issueIdOrKey/attachments/$attachmentId" );
  }

  /**
  *  課題の参加者一覧の取得
  *
  * @params string|int $issueIdOrKey
  * @return array< array{id: integer,userId: string,name: string,roleType: integer,lang: string,mailAddress: string,lastLoginTime: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-issue-participant-list/
  */
  public function getIssueParticipantList($issueIdOrKey){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/participants" );
  }

  /**
  *  課題共有ファイル一覧の取得
  *
  * @params string|int $issueIdOrKey
  * @return array< array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-linked-shared-files/
  */
  public function getListOfLinkedSharedFiles($issueIdOrKey){
    return $this->call_api('GET', "/api/v2/issues/$issueIdOrKey/sharedFiles" );
  }

  /**
  *  課題に共有ファイルをリンク
  *
  * @params string|int $issueIdOrKey
  * @return array< array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/link-shared-files-to-issue/
  */
  public function linkSharedFilesToIssue($issueIdOrKey){
    return $this->call_api('POST', "/api/v2/issues/$issueIdOrKey/sharedFiles" );
  }

  /**
  *  課題の共有ファイルのリンクを解除
  *
  * @params string|int $issueIdOrKey
  * @params string|int $id
  * @return array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/remove-link-to-shared-file-from-issue/
  */
  public function removeLinkToSharedFileFromIssue($issueIdOrKey,$id){
    return $this->call_api('DELETE', "/api/v2/issues/$issueIdOrKey/sharedFiles/$id" );
  }

  /**
  *  Wikiページ一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,projectId: integer,name: string,tags: array,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page-list/
  */
  public function getWikiPageList($query_options=[]){
    return $this->call_api('GET', "/api/v2/wikis",$query_options );
  }

  /**
  *  Wikiページ数の取得
  *
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-wiki-page/
  */
  public function countWikiPage($query_options=[]){
    return $this->call_api('GET', "/api/v2/wikis/count",$query_options );
  }

  /**
  *  Wikiページタグ一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,name: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page-tag-list/
  */
  public function getWikiPageTagList($query_options=[]){
    return $this->call_api('GET', "/api/v2/wikis/tags",$query_options );
  }

  /**
  *  Wikiページの追加
  *
  * @return array{id: integer,projectId: integer,name: string,content: string,tags: array,attachments: array,sharedFiles: array,stars: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-wiki-page/
  */
  public function addWikiPage(){
    return $this->call_api('POST', "/api/v2/wikis" );
  }

  /**
  *  Wikiページ情報の取得
  *
  * @params string|int $wikiId
  * @return array{id: integer,projectId: integer,name: string,content: string,tags: array,attachments: array,sharedFiles: array,stars: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page/
  */
  public function getWikiPage($wikiId){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId" );
  }

  /**
  *  Wikiページ情報の更新
  *
  * @params string|int $wikiId
  * @return array{id: integer,projectId: integer,name: string,content: string,tags: array,attachments: array,sharedFiles: array,stars: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-wiki-page/
  */
  public function updateWikiPage($wikiId){
    return $this->call_api('PATCH', "/api/v2/wikis/$wikiId" );
  }

  /**
  *  Wikiページの削除
  *
  * @params string|int $wikiId
  * @return array{id: integer,projectId: integer,name: string,content: string,tags: array,attachments: array,sharedFiles: array,stars: array,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-wiki-page/
  */
  public function deleteWikiPage($wikiId){
    return $this->call_api('DELETE', "/api/v2/wikis/$wikiId" );
  }

  /**
  *  Wiki添付ファイル一覧の取得
  *
  * @params string|int $wikiId
  * @return array< array{id: integer,name: string,size: integer} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-wiki-attachments/
  */
  public function getListOfWikiAttachments($wikiId){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId/attachments" );
  }

  /**
  *  Wiki添付ファイルの追加
  *
  * @params string|int $wikiId
  * @return array< array{id: integer,name: string,size: integer,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/attach-file-to-wiki/
  */
  public function attachFileToWiki($wikiId){
    return $this->call_api('POST', "/api/v2/wikis/$wikiId/attachments" );
  }

  /**
  *  Wiki添付ファイルのダウンロード
  *
  * @params string|int $wikiId
  * @params string|int $attachmentId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page-attachment/
  */
  public function getWikiPageAttachment($wikiId,$attachmentId){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId/attachments/$attachmentId" );
  }

  /**
  *  Wiki添付ファイルの削除
  *
  * @params string|int $wikiId
  * @params string|int $attachmentId
  * @return array{id: integer,name: string,size: integer,createdUser: object,created: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/remove-wiki-attachment/
  */
  public function removeWikiAttachment($wikiId,$attachmentId){
    return $this->call_api('DELETE', "/api/v2/wikis/$wikiId/attachments/$attachmentId" );
  }

  /**
  *  Wiki共有ファイル一覧の取得
  *
  * @params string|int $wikiId
  * @return array< array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: NULL,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-shared-files-on-wiki/
  */
  public function getListOfSharedFilesOnWiki($wikiId){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId/sharedFiles" );
  }

  /**
  *  Wikiに共有ファイルをリンク
  *
  * @params string|int $wikiId
  * @return array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/link-shared-files-to-wiki/
  */
  public function linkSharedFilesToWiki($wikiId){
    return $this->call_api('POST', "/api/v2/wikis/$wikiId/sharedFiles" );
  }

  /**
  *  Wikiの共有ファイルのリンクを解除
  *
  * @params string|int $wikiId
  * @params string|int $id
  * @return array{id: integer,type: string,dir: string,name: string,size: integer,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/remove-link-to-shared-file-from-wiki/
  */
  public function removeLinkToSharedFileFromWiki($wikiId,$id){
    return $this->call_api('DELETE', "/api/v2/wikis/$wikiId/sharedFiles/$id" );
  }

  /**
  *  Wikiページ更新履歴一覧の取得
  *
  * @params string|int $wikiId
  * @params array $query_options
  * @return array< array{pageId: integer,version: integer,name: string,content: string,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page-history/
  */
  public function getWikiPageHistory($wikiId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId/history",$query_options );
  }

  /**
  *  Wikiページのスター一覧の取得
  *
  * @params string|int $wikiId
  * @return array< array{id: integer,comment: NULL,url: string,title: string,presenter: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-wiki-page-star/
  */
  public function getWikiPageStar($wikiId){
    return $this->call_api('GET', "/api/v2/wikis/$wikiId/stars" );
  }

  /**
  *  スターの追加
  *
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-star/
  */
  public function addStar(){
    return $this->call_api('POST', "/api/v2/stars" );
  }

  /**
  *  お知らせ一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,alreadyRead: boolean,reason: integer,resourceAlreadyRead: boolean,project: object,issue: object,comment: object,pullRequest: NULL,pullRequestComment: NULL,sender: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-notification/
  */
  public function getNotification($query_options=[]){
    return $this->call_api('GET', "/api/v2/notifications",$query_options );
  }

  /**
  *  お知らせ数の取得
  *
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-notification/
  */
  public function countNotification($query_options=[]){
    return $this->call_api('GET', "/api/v2/notifications/count",$query_options );
  }

  /**
  *  お知らせ数のリセット
  *
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/reset-unread-notification-count/
  */
  public function resetUnreadNotificationCount(){
    return $this->call_api('POST', "/api/v2/notifications/markAsRead" );
  }

  /**
  *  お知らせの既読化
  *
  * @params string|int $id
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/read-notification/
  */
  public function readNotification($id){
    return $this->call_api('POST', "/api/v2/notifications/$id/markAsRead" );
  }

  /**
  *  Gitリポジトリ一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,projectId: integer,name: string,description: string,hookUrl: NULL,httpUrl: string,sshUrl: string,displayOrder: integer,pushedAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-git-repositories/
  */
  public function getListOfGitRepositories($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories" );
  }

  /**
  *  Gitリポジトリの取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @return array{id: integer,projectId: integer,name: string,description: string,hookUrl: NULL,httpUrl: string,sshUrl: string,displayOrder: integer,pushedAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-git-repository/
  */
  public function getGitRepository($projectIdOrKey,$repoIdOrName){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName" );
  }

  /**
  *  プルリクエスト一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params array $query_options
  * @return array< array{id: integer,projectId: integer,repositoryId: integer,number: integer,summary: string,description: string,base: string,branch: string,status: object,assignee: object,issue: object,baseCommit: NULL,branchCommit: NULL,mergeCommit: NULL,closeAt: NULL,mergeAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-pull-request-list/
  */
  public function getPullRequestList($projectIdOrKey,$repoIdOrName,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests",$query_options );
  }

  /**
  *  プルリクエスト数の取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-number-of-pull-requests/
  */
  public function getNumberOfPullRequests($projectIdOrKey,$repoIdOrName,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/count",$query_options );
  }

  /**
  *  プルリクエストの追加
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @return array{id: integer,projectId: integer,repositoryId: integer,number: integer,summary: string,description: string,base: string,branch: string,status: object,assignee: object,issue: object,baseCommit: NULL,branchCommit: NULL,closeAt: NULL,mergeAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-pull-request/
  */
  public function addPullRequest($projectIdOrKey,$repoIdOrName){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests" );
  }

  /**
  *  プルリクエストの取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @return array{id: integer,projectId: integer,repositoryId: integer,number: integer,summary: string,description: string,base: string,branch: string,status: object,assignee: object,issue: object,baseCommit: NULL,branchCommit: NULL,mergeCommit: NULL,closeAt: NULL,mergeAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string,attachments: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-pull-request/
  */
  public function getPullRequest($projectIdOrKey,$repoIdOrName,$number){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number" );
  }

  /**
  *  プルリクエストの更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @return array{id: integer,projectId: integer,repositoryId: integer,number: integer,summary: string,description: string,base: string,branch: string,status: object,assignee: object,issue: object,baseCommit: NULL,branchCommit: NULL,mergeCommit: NULL,closeAt: NULL,mergeAt: NULL,createdUser: object,created: string,updatedUser: object,updated: string,attachments: array,stars: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-pull-request/
  */
  public function updatePullRequest($projectIdOrKey,$repoIdOrName,$number){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number" );
  }

  /**
  *  プルリクエストコメントの取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @params array $query_options
  * @return array< array{id: integer,content: string,changeLog: array,createdUser: object,created: string,updated: string,stars: array,notifications: array} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-pull-request-comment/
  */
  public function getPullRequestComment($projectIdOrKey,$repoIdOrName,$number,$query_options=[]){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/comments",$query_options );
  }

  /**
  *  プルリクエストコメントの追加
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @return array{id: integer,content: string,changeLog: array,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-pull-request-comment/
  */
  public function addPullRequestComment($projectIdOrKey,$repoIdOrName,$number){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/comments" );
  }

  /**
  *  プルリクエストコメント数の取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-number-of-pull-request-comments/
  */
  public function getNumberOfPullRequestComments($projectIdOrKey,$repoIdOrName,$number){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/comments/count" );
  }

  /**
  *  プルリクエストコメント情報の更新
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @params string|int $commentId
  * @return array{id: integer,content: string,changeLog: array,createdUser: object,created: string,updated: string,stars: array,notifications: array}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-pull-request-comment-information/
  */
  public function updatePullRequestCommentInformation($projectIdOrKey,$repoIdOrName,$number,$commentId){
    return $this->call_api('PATCH', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/comments/$commentId" );
  }

  /**
  *  プルリクエスト添付ファイル一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @return array< array{id: integer,name: string,size: integer,createdUser: object,created: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-pull-request-attachment/
  */
  public function getListOfPullRequestAttachment($projectIdOrKey,$repoIdOrName,$number){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/attachments" );
  }

  /**
  *  プルリクエスト添付ファイルのダウンロード
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @params string|int $attachmentId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/download-pull-request-attachment/
  */
  public function downloadPullRequestAttachment($projectIdOrKey,$repoIdOrName,$number,$attachmentId){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/attachments/$attachmentId" );
  }

  /**
  *  プルリクエスト添付ファイルの削除
  *
  * @params string|int $projectIdOrKey
  * @params string|int $repoIdOrName
  * @params string|int $number
  * @params string|int $attachmentId
  * @return array{id: integer,name: string,size: integer,createdUser: object,created: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-pull-request-attachments/
  */
  public function deletePullRequestAttachments($projectIdOrKey,$repoIdOrName,$number,$attachmentId){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/git/repositories/$repoIdOrName/pullRequests/$number/attachments/$attachmentId" );
  }

  /**
  *  ウォッチ一覧の取得
  *
  * @params string|int $userId
  * @params array $query_options
  * @return array< array{id: integer,resourceAlreadyRead: boolean,note: string,type: string,issue: object,lastContentUpdated: string,created: string,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-watching-list/
  */
  public function getWatchingList($userId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/users/$userId/watchings",$query_options );
  }

  /**
  *  ウォッチ数の取得
  *
  * @params string|int $userId
  * @params array $query_options
  * @return array{count: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/count-watching/
  */
  public function countWatching($userId,$query_options=[]){
    return $this->call_api('GET', "/api/v2/users/$userId/watchings/count",$query_options );
  }

  /**
  *  ウォッチ情報の取得
  *
  * @params string|int $watchingId
  * @return array{id: integer,alreadyRead: boolean,note: string,type: string,issue: object,lastContentUpdated: string,created: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-watching/
  */
  public function getWatching($watchingId){
    return $this->call_api('GET', "/api/v2/watchings/$watchingId" );
  }

  /**
  *  ウォッチの追加
  *
  * @return array{id: integer,note: string,type: string,issue: object,lastContentUpdated: string,created: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-watching/
  */
  public function addWatching(){
    return $this->call_api('POST', "/api/v2/watchings" );
  }

  /**
  *  ウォッチの更新
  *
  * @params string|int $watchingId
  * @return array{id: integer,note: string,type: string,issue: object,lastContentUpdated: string,created: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-watching/
  */
  public function updateWatching($watchingId){
    return $this->call_api('PATCH', "/api/v2/watchings/$watchingId" );
  }

  /**
  *  ウォッチの削除
  *
  * @params string|int $watchingId
  * @return array{id: integer,note: string,type: string,issue: object,lastContentUpdated: string,created: string,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-watching/
  */
  public function deleteWatching($watchingId){
    return $this->call_api('DELETE', "/api/v2/watchings/$watchingId" );
  }

  /**
  *  ウォッチの既読化
  *
  * @params string|int $watchingId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/mark-watching-as-read/
  */
  public function markWatchingAsRead($watchingId){
    return $this->call_api('POST', "/api/v2/watchings/$watchingId/markAsRead" );
  }

  /**
  *  プロジェクトグループ一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-group-list/
  */
  public function getProjectGroupList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/groups" );
  }

  /**
  *  プロジェクトグループの追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-project-group/
  */
  public function addProjectGroup($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/groups" );
  }

  /**
  *  プロジェクトグループの削除
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-project-group/
  */
  public function deleteProjectGroup($projectIdOrKey){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/groups" );
  }

  /**
  *  グループアイコンの取得
  *
  * @params string|int $groupId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-group-icon/
  */
  public function getGroupIcon($groupId){
    return $this->call_api('GET', "/api/v2/groups/$groupId/icon" );
  }

  /**
  *  ライセンス情報の取得
  *
  * @return array{active: boolean,attachmentLimit: integer,attachmentLimitPerFile: integer,attachmentNumLimit: integer,attribute: boolean,attributeLimit: integer,burndown: boolean,commentLimit: integer,componentLimit: integer,fileSharing: boolean,gantt: boolean,git: boolean,issueLimit: integer,licenceTypeId: integer,limitDate: string,nulabAccount: boolean,parentChildIssue: boolean,postIssueByMail: boolean,projectLimit: integer,pullRequestAttachmentLimitPerFile: integer,pullRequestAttachmentNumLimit: integer,remoteAddress: boolean,remoteAddressLimit: integer,startedOn: string,storageLimit: integer,subversion: boolean,subversionExternal: boolean,userLimit: integer,versionLimit: integer,wikiAttachment: boolean,wikiAttachmentLimitPerFile: integer,wikiAttachmentNumLimit: integer}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-licence/
  */
  public function getLicence(){
    return $this->call_api('GET', "/api/v2/space/licence" );
  }

  /**
  *  チーム一覧の取得
  *
  * @params array $query_options
  * @return array< array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-list-of-teams/
  */
  public function getListOfTeams($query_options=[]){
    return $this->call_api('GET', "/api/v2/teams",$query_options );
  }

  /**
  *  チームの追加
  *
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-team/
  */
  public function addTeam(){
    return $this->call_api('POST', "/api/v2/teams" );
  }

  /**
  *  チーム情報の取得
  *
  * @params string|int $teamId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-team/
  */
  public function getTeam($teamId){
    return $this->call_api('GET', "/api/v2/teams/$teamId" );
  }

  /**
  *  チーム情報の更新
  *
  * @params string|int $teamId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/update-team/
  */
  public function updateTeam($teamId){
    return $this->call_api('PATCH', "/api/v2/teams/$teamId" );
  }

  /**
  *  チームの削除
  *
  * @params string|int $teamId
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-team/
  */
  public function deleteTeam($teamId){
    return $this->call_api('DELETE', "/api/v2/teams/$teamId" );
  }

  /**
  *  チームアイコンの取得
  *
  * @params string|int $teamId
  * @return 
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-team-icon/
  */
  public function getTeamIcon($teamId){
    return $this->call_api('GET', "/api/v2/teams/$teamId/icon" );
  }

  /**
  *  プロジェクトチーム一覧の取得
  *
  * @params string|int $projectIdOrKey
  * @return array< array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string} >
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-project-team-list/
  */
  public function getProjectTeamList($projectIdOrKey){
    return $this->call_api('GET', "/api/v2/projects/$projectIdOrKey/teams" );
  }

  /**
  *  プロジェクトチームの追加
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-project-team/
  */
  public function addProjectTeam($projectIdOrKey){
    return $this->call_api('POST', "/api/v2/projects/$projectIdOrKey/teams" );
  }

  /**
  *  プロジェクトチームの削除
  *
  * @params string|int $projectIdOrKey
  * @return array{id: integer,name: string,members: array,displayOrder: NULL,createdUser: object,created: string,updatedUser: object,updated: string}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/delete-project-team/
  */
  public function deleteProjectTeam($projectIdOrKey){
    return $this->call_api('DELETE', "/api/v2/projects/$projectIdOrKey/teams" );
  }

  /**
  *  レート制限情報の取得
  *
  * @return array{rateLimit: object}
  * @link https://developer.nulab.com/ja/docs/backlog/api/2/get-rate-limit/
  */
  public function getRateLimit(){
    return $this->call_api('GET', "/api/v2/rateLimit" );
  }
}