<?php

namespace tests\Unit\Model\MappingTest\MapToUser;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\User;

class MapToUserOfIssueTest extends TestCaseBacklogModels {
  public function test_map_to_user_in_issue () {
    $issue = $this->find_issue_has_stars();
    $this->assertIsClass(User::class,$issue->stars[0]->presenter);

    $issue = $this->find_issue_has_attachment();
    $this->assertIsClass(User::class,$issue->attachments[0]->createdUser);

    $issue = $this->find_issue_has_assignee_and_updatedUser();
    $this->assertIsClass(User::class,$issue->createdUser);
    $this->assertIsClass(User::class,$issue->updatedUser);
    $this->assertIsClass(User::class,$issue->assignee);
  }
}