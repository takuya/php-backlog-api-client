<?php

namespace tests\Unit\Model\Traits;

use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\WikiPage;

trait WikiSearch {
  protected function find_wiki ( callable $func, $check_limit_per_project = 10 ) {
    $pids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    shuffle( $pids );
    foreach ( $pids as $pid ) {
      $project = $this->cli->project( $pid );
      // プロジェクトごとにだいたい同じ使われ方なので、
      // 見つからない場合同じプロジェクト内部を探し回るだけ無駄。
      foreach ( array_slice( $project->wiki_page_ids(), 0, $check_limit_per_project ) as $wiki_id ) {
        $wiki = $this->cli->wiki( $wiki_id );
        if ( $func( $wiki ) ) {
          return $wiki;
        }
      }
    }
  }
  
  public function find_wiki_has_history (): ?WikiPage {
    return $this->find_wiki( function( WikiPage $wiki ) { return !empty( $wiki->histories() ); } );
  }
  
  public function find_wiki_has_attribute ( $name ): ?WikiPage {
    return $this->find_wiki( function( WikiPage $wiki ) use ( $name ) { return !empty( $wiki->$name ); } );
  }
  
  public function find_wiki_has_stars (): ?WikiPage {
    return $this->find_wiki_has_attribute( 'stars' );
  }
  
  public function find_wiki_has_attachments (): ?WikiPage {
    return $this->find_wiki_has_attribute( 'attachments' );
  }
  
  public function find_wiki_has_tags (): ?WikiPage {
    return $this->find_wiki_has_attribute( 'tags' );
  }
}