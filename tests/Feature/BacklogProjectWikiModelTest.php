<?php

namespace Tests\Feature;

use Tests\TestCase;
use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\Wiki\History;
use Takuya\BacklogApiClient\Models\Wiki\Page as WikiPage;
use Takuya\BacklogApiClient\Models\Wiki\WikiPageAttachment;

class BacklogProjectWikiModelTest extends TestCaseBacklogModelTest {
  
  
  public function test_get_wiki_pages_in_a_project() {
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      if( ! $project->useWiki ) {
        continue;
      }
      $ret = $project->wiki_pages();
      $this->assertEquals(WikiPage::class, get_class($ret[0]));
      $this->assertPropIsExists('createdUser', $ret[0]);
      $this->assertPropIsExists('created', $ret[0]);
      $this->assertPropIsExists('name', $ret[0]);
      $this->assertPropIsExists('content', $ret[0]);
      break;
    }
  }
  
  public function test_get_wiki_page_attachment_in_a_project_wiki() {
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      if( ! $project->useWiki ) {
        continue;
      }
      $ret = $project->wiki_pages();
      foreach ($project->wiki_pages() as $wiki_page) {
        if( sizeof($wiki_page->attachments) < 1 ) {
          continue;
        }
        $this->assertIsArray($wiki_page->attachments);
        $this->assertEquals(WikiPageAttachment::class, get_class($wiki_page->attachments[0]));
        $this->assertPropIsExists('created', $wiki_page->attachments[0]);
        $this->assertPropIsExists('createdUser', $wiki_page->attachments[0]);
        $this->assertPropIsExists('name', $wiki_page->attachments[0]);
        $this->assertPropIsExists('size', $wiki_page->attachments[0]);
        //
        $file = $wiki_page->attachments[0];
        $this->assertEquals($file->size, strlen($file->getContent()));
        break 2;
      }
    }
  }
  
  public function test_get_wiki_page_history_in_a_project_wiki() {
    foreach ($this->cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $project) {
      if( ! $project->useWiki ) {
        continue;
      }
      $ret = $project->wiki_pages();
      foreach ($project->wiki_pages() as $wiki_page) {
        if( sizeof($wiki_page->histories()) < 1 ) {
          continue;
        }
        $ret = $wiki_page->histories();
        $this->assertEquals(History::class, get_class($ret[0]));
        $this->assertPropIsExists('content', $ret[0]);
        $this->assertPropIsExists('version', $ret[0]);
        $this->assertPropIsExists('createdUser', $ret[0]);
        break 2;
      }
    }
  }
  
 
}