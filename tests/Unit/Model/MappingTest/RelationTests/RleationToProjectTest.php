<?php

namespace tests\Unit\Model\ProjectRelationTests;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Backlog;

class RleationToProjectTest extends TestCaseBacklogModels {
  
  protected array $sample_webhooks;
  
  public function test_relation_to_project () {
    [$hooks, $project] = $this->find_webhooks();
    $this->assertEquals( $project->id, $hooks[0]->getProjectId() );
  }
  
  protected function find_webhooks (): array {
    if ( !empty( $this->sample_webhooks ) ) {
      return $this->sample_webhooks;
    }
    $space = $this->cli->space();
    $hooks = null;
    $project = null;
    foreach ( $space->projects( Backlog::PROJECTS_ONLY_MINE ) as $project ) {
      $hooks = $project->webhooks();
      if ( sizeof( $hooks ) > 0 ) {
        $this->assertIsInt( $hooks[0]->getProjectId() );
        break;
      }
    }
    return $this->sample_webhooks = [$hooks, $project];
  }
  
  public function test_issue_model_to_json () {
    $api = $this->api_client();
    [$hooks, $project] = $this->find_webhooks();
    $this->assertEquals( $project->id, $hooks[0]->getProjectId() );
    // クラスへ封入がAPIレスポンスを破壊してないことの確認
    $this->assertEquals(
      json_decode( $hooks[0]->toJson() ),
      $api->getListOfWebhooks( $hooks[0]->getProjectId() )[0]
    );
  }
}