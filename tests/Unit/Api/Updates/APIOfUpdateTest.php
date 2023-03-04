<?php

namespace tests\Unit\Api\Updates;

use tests\TestCase;
use GuzzleHttp\Exception\RequestException;

class APIOfUpdateTest extends TestCase {
  public function test_work(){
    $this->assertTrue(true);
  }
  public function test_add_delete_project () {
    $api = $this->api_client();
    $params = ['form_params' => ['key' => 'API_SAMPLE_'.rand(100,999), 'name' => 'APIから作成テスト']];
    $a = $api->addProject( $params );
    usleep(200);//ちょっとだけ待つ
    //
    $info = $api->getProject($a->id);
    $this->assertEquals($params['form_params']['name'],$info->name);
    $this->assertEquals($params['form_params']['key'],$info->projectKey);
    //
    $b = $api->deleteProject( $params['form_params']['key'] );
    usleep(200);//ちょっとだけ待つ
    $this->assertEquals( $a->id, $b->id );
    // 削除チェック
    $this->expectException(RequestException::class);
    $api->getProject($a->id);
  }
  public function test_remove_project(){
    $list =$this->model_client()->space()->my_projects();
    foreach ( $list as $item ) {
      if ($item->name == 'APIから作成テスト'){
        $this->api_client()->deleteProject($item->id);
      }
    }
  }
}