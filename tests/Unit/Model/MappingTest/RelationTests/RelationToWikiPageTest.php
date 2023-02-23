<?php

namespace tests\Unit\Model\ProjectRelationTests;

use tests\Unit\Model\TestCaseBacklogModels;

class RelationToWikiPageTest extends TestCaseBacklogModels {
  
  public function test_wiki_attachment_relate_to_wikipage(){
    
    //
    $wiki = $this->find_wiki_has_attachments();
    $this->assertEquals($wiki->id,$wiki->attachments[0]->getWikiPageId());
    //
    $wiki = $this->find_wiki_has_history();
    $this->assertEquals($wiki->id,$wiki->histories()[0]->getWikiPageId());
    
  }
}