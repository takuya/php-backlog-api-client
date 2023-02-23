<?php

namespace tests\Unit\Model\MappingTest\MapToUser;

use tests\Unit\Model\TestCaseBacklogModels;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\WikiPageAttachment;
use Takuya\BacklogApiClient\Models\Star;

class MapToUserOfWikiTest extends TestCaseBacklogModels {
  public function test_map_to_user_in_wiki () {
    //
    $wiki = $this->find_wiki_has_attachments();
    $this->assertIsClass( WikiPageAttachment::class, $wiki->attachments[0] );
    //
    $wiki = $this->find_wiki_has_stars();
    $this->assertIsClass( Star::class, $wiki->stars[0] );
  }
}