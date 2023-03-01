<?php

namespace Tests\Unit\Storable;

use Tests\TestCase;
use Tests\Assertions\ArrayAssertions;
use Takuya\BacklogApiClient\Models\Issue;
use tests\Unit\Traits\IssueSearch;

class IssueStorableTest extends TestCase {
  use IssueSearch;
  use ArrayAssertions;
  protected function assert_issue_is_storable($arr){
    
    $ref = new \ReflectionClass( Issue::class );
    $names = array_map( fn( $e ) => $e->getName(), $ref->getProperties( \ReflectionProperty::IS_PUBLIC ) );
    $names = array_merge( $names, [] );
    $this->assertArrayIsSameValues($names,array_keys($arr));
    //
    $this->assertIsArray($arr['priority']);
    $this->assertIsArrayOfInt($arr['attachments']);
    $this->assertIsArrayOfInt($arr['customFields']);
    $this->assertIsArrayOfInt($arr['stars']);
    $this->assertIsArrayOfInt($arr['sharedFiles']);
    $this->assertIsArrayOfInt($arr['category']);
    $this->assertIsInt($arr['issueType']);
    $this->assertIsInt($arr['status']);
    $this->assertIsString($arr['createdUser']);
    $this->assertIsString($arr['assignee']);
    
  }
  
  public function test_issue_storable(): void {
    $archiver = $this->archiver_client();
    $issue = $this->find_issue_has_attachment();
    $this->assert_issue_is_storable($arr = $archiver->storable( $issue ));
    $issue = $this->find_issue_has_stars();
    $this->assert_issue_is_storable($arr = $archiver->storable( $issue ));
    $issue = $this->find_issue_has_assignee_and_updatedUser();
    $this->assert_issue_is_storable($arr = $archiver->storable( $issue ));
  }
  
}