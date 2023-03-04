<?php

namespace tests\Feature\TestCase;

use tests\TestCase;
use tests\Feature\TestCase\Trait\EntitySearch;

class TestCaseProjectApiClientForUpdate extends TestCase {
  protected $project_id = null;
  protected $project_key = 'API_SAMPLE';
  protected $api = null;
  use EntitySearch;
  
  public function __construct ( ?string $name = null, array $data = [], $dataName = '' ) {
    parent::__construct( $name, $data, $dataName );
    $rand = join( array_map( fn( $e ) => chr( random_int( 65, 90 ) ), range( 0, 3 ) ) );
    $this->project_key = $this->project_key.'_'.$rand.random_int( 100, 999 );
    $this->api = $this->api_client();
    $this->api->disableLogging();
  }
  protected function sample_jpeg_file(){
    $sample_filename = realpath(__DIR__.'/../../sample-data/sample.jpg');
    return [
      'name' => basename($sample_filename),
      'content'=> file_get_contents($sample_filename)
    ];
  }
  
  protected function createProject () {
    $params = ['form_params' => ['key' => $this->project_key, 'name' => 'APIから作成テスト']];
    $p = $this->api->addProject( $params );
    $this->project_id = $p->id;
    $this->wait( fn() => $this->hasProject() !== true, 100,'project create' );
  }
  
  protected function wait ( callable $cond, $max=100, $mess='post' ) {
    foreach ( range( 0, $max) as $item ) {
      if ( $cond() ) {
        //dump( $mess.' waiting.' );
        sleep( 1 );
      } else {
        //dump( $mess.' end.' );
        break;
      }
    }
  }
  
  protected function hasProject () {
    try {
      $this->api->getProject( $this->project_id );
      return true;
    } catch (\Exception) {
      return false;
    }
  }
  
  protected function setUp (): void {
    if ( !$this->hasProject() ) {
      $this->createProject();
      usleep( 100 );
    }
  }
  
  protected function tearDown (): void {
    if ( $this->hasProject() ) {
      $this->deleteProject();
      usleep( 100 );
    }
  }
  
  
  protected function deleteProject () {
    $this->api->deleteProject( $this->project_key );
    $this->wait( fn() => $this->hasProject() !== false , 100,'project delete');
  }
}