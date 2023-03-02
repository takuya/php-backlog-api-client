<?php

namespace Tests\Unit\Storable;

use Tests\TestCase;
use Tests\Assertions\ArrayAssertions;
use Takuya\BacklogApiClient\Models\Project;
use tests\Unit\Traits\ProjectSearch;

class ProjectStorableTest extends TestCase {
  use ProjectSearch;
  use ArrayAssertions;
  
  protected function assert_project_is_storable ( $arr ) {
    $ref = new \ReflectionClass( Project::class );
    $names = array_map( fn( $e ) => $e->getName(), $ref->getProperties( \ReflectionProperty::IS_PUBLIC ) );
    $names = array_merge( $names, ['icon', 'users', 'teams', 'spaceKey'] );
    //
    $this->assertArrayIsSameValues( $names, array_keys( $arr ) );
    $this->assertIsArrayOfInt( $arr['users'] );
    $this->assertNotEmpty( $arr['users'] );
    $this->assertIsArray( $arr['teams'] );
    $this->assertIsArrayOfInt( $arr['teams'] );
    $this->assertIsString( $arr['icon'] );
    $this->assertNotEmpty( $arr['icon'] );
  }
  
  public function test_project_storable (): void {
    $archiver = $this->archiver_client();
    $project = $this->find_project_has_shared_file();
    $this->assert_project_is_storable( $arr = $archiver->storable( $project ) );
    $project = $this->find_project_has_milestone();
    $this->assert_project_is_storable( $arr = $archiver->storable( $project ) );
    $project = $this->find_project_has_webhook();
    $this->assert_project_is_storable( $arr = $archiver->storable( $project ) );
    $project = $this->find_project_has_teams();
    $this->assert_project_is_storable( $arr = $archiver->storable( $project ) );
  }
  
}