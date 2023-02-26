<?php

namespace Takuya\BacklogApiClient;

use Takuya\BacklogApiClient\Models\Star;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Issue;
use Takuya\BacklogApiClient\Models\Space;
use Takuya\BacklogApiClient\Models\Project;
use Takuya\BacklogApiClient\Models\Team;
use Takuya\BacklogApiClient\Models\WikiPage as WikiPage;
use DateTimeZone;
use DateTimeImmutable;

/**
 * Nulab Backlog Api v2. PHP Library for reading , structural data access.
 * @author  takuya (github/@takuya)
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 * @since   2023-01-27
 */
class Backlog {
  
  public const PROJECTS_ALL = true;
  public const PROJECTS_ONLY_MINE = false;
  protected BacklogAPIClient $api;
  
  /**
   * @param string $space spaceId ( xxx in "https://xxx.backlog.com/" )
   * @param string $key   api key for user ( not a OAUTH key )
   * @param string $tld   default is 'com'. if your space is "https://xxx.backlog.jp/" enter "jp"
   */
  public function __construct ( string $spaceId_or_url, string $key ) {
    $this->api = new BacklogAPIClient( $spaceId_or_url, $key );
  }
  
  /**
   * @param int|string $wikiId
   * @return WikiPage
   */
  public function wiki ( $wikiId ) {
    $res = $this->api->getWikiPage( $wikiId );
    
    return new WikiPage( $res, $this->api, $this->project( $res->projectId ) );
  }
  
  /**
   * @param int|string $projectIdOrKey
   * @return Project
   */
  public function project ( $projectIdOrKey ) {
    /** @var Project $p */
    $dummy_parent = new \stdClass();
    $p = $this->api->into_class( Project::class, 'getProject', ['projectIdOrKey' => $projectIdOrKey] );
    $p->setSpaceKey($this->api->spaceKey());
    return $p;
  }
  
  /**
   * @param int|string $userId
   * @return Star[]
   */
  public function stars ( $userId ) {
    /** @var Star[] $list */
    $list = [];
    $limit = 100;
    $offset = 0;
    do {
      $q = ['userId' => $userId, 'query_options' => ['count' => $limit, 'order' => 'asc', 'minId' => $offset]];
      /** @var Star[] $result */
      $result = $this->api->into_class( Star::class, 'getReceivedStarList', $q );
      if ( !empty( $result ) ) {
        array_push( $list, ...$result );
        $last = end( $result );
        $offset = $last->id;
      }
    } while ( sizeof( $result ) == $limit );
    
    return $list;
  }
  
  /**
   * @param int|string $issueIdOrKey
   * @return Issue
   */
  public function issue ( $issueIdOrKey ) {
    /** @var Issue $iss */
    $iss = $this->api->into_class( Issue::class, 'getIssue', ['issueIdOrKey' => $issueIdOrKey] );
    
    return $iss;
  }
  
  /**
   * @param int $allow_all Backlog::PROJECTS_ALL or Backlog::PROJECTS_ONLY_MINE
   * @return array|Project[]
   */
  public function projects ( $allow_all = Backlog::PROJECTS_ONLY_MINE ) {
    return $this->space()->projects( $allow_all );
  }
  
  /**
   * @return Space
   */
  public function space () {
    /** @var Space $sp */
    $sp = $this->api->into_class( Space::class, 'getSpace' );
    
    return $sp;
  }
  
  /**
   * @param $team_id
   * @return Team
   */
  public function team ( $team_id ) {
    /** @var Team $team */
    $team = $this->api->into_class( Team::class, 'getTeam', ['teamId' => $team_id] );
    
    return $team;
  }
  
  /**
   * @return User|null
   */
  public function findUser ( string $keyword ) {
    $keyword = preg_quote( $keyword );
    /** @var User[] $users */
    $users = $this->users();
    $search_data = array_map(
      fn( $u ) => [
        'id' => $u->id,
        'text' => implode( ',', [$u->id, $u->name, preg_quote( $u->userId ), $u->keyword, $u->mailAddress] ),
      ],
      $users );
    foreach ( $search_data as $e ) {
      if ( preg_match( "/$keyword/", $e['text'] ) ) {
        $r = array_filter( $users, fn( $u ) => $u->id == $e['id'] );
        
        return array_shift( $r );
      }
    }
    
    return null;
  }
  
  /**
   * @return array|User[]
   */
  public function users () {
    return $this->space()->users();
  }
  
  /**
   * @return array|Issue[]
   * @example <code>
   * $cli->findIssues(['query_options'=>['projectId'=>[1111,2222,3333,],'count'=>100,]]);
   * $cli->findIssues(['query_options'=>['sharedFile'=>'true']]);
   * $cli->findIssues(['query_options'=>['attachment'=>'true']]);
   * <code>
   */
  public function findIssues ( $query_options = [] ) {
    return $this->api->into_class( Issue::class, 'getIssueList', $query_options );
  }
  
  /**
   * @param string $projectKey_to_search
   * @return int id of project
   */
  public function projectIdByKeyName ( string $projectKey_to_search ) {
    $proj = $this->api->getProject( $projectKey_to_search );
    
    return $proj->id;
  }
  
  /**
   * @param string $issue_key_to_search
   * @return int id of issue
   */
  public function issueIdByKeyName ( string $issue_key_to_search ) {
    $issue = $this->api->getIssue( $issue_key_to_search );
    
    return $issue->id;
  }
  
  public function rate_limit () {
    $info = $this->api->getRateLimiterInfo();
    $at = ( new DateTimeImmutable(
      'now', new DateTimeZone( 'Asia/Tokyo' ) ) )->setTimestamp( $info['X-RateLimit-Reset'] );
    
    return [
      'rate-limit-will-all-reset' => $at->format( 'c' ),
      'rate-limit-per-minute' => $info['X-RateLimit-Limit'],
      'rate-limit-count-remains' => $info['X-RateLimit-Remaining'],
    ];
  }
  public function setLogging(bool $enable,$logger=null){
    $enable ? $this->api->enableLogging():$this->api->disableLogging();
    $logger && $this->api->setLogger($logger);
  }
}