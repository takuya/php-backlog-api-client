<?php

namespace tests\Unit\Model\MappingTest\MapToUser;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\NulabAccount;

class MapToNulabAccountModelTest extends TestCaseBacklogModels {
  public function test_user_has_nulab_model () {
    $users = $this->cli->users();
    foreach ( $users as $user ) {
      $this->assertIsClass( NulabAccount::class, $user->nulabAccount );
    }
    foreach ( $this->cli->space()->teams() as $team ) {
      foreach ( $team->members as $member ) {
        $this->assertIsClass( NulabAccount::class, $member->nulabAccount );
      }
    }
  }
  
}