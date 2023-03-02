<?php

namespace tests\Unit\Api\Updates;

use tests\TestCase;

class APIOfUpdateTest extends TestCase {
  public function test_work(){
    $this->assertTrue(true);
  }
  public function test_add_delete_project () {
    $api = $this->api_client();
    $params = ['form_params' => ['key' => 'API_SAMPLE', 'name' => 'APIから作成テスト']];
    $a = $api->addProject( $params );
    $b = $api->deleteProject( $params['form_params']['key'] );
    $this->assertEquals( $a->id, $b->id );
  }
}