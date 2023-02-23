<?php

namespace tests\Unit\Model;

use Takuya\BacklogApiClient\Backlog;
use Takuya\BacklogApiClient\Models\User;
use Takuya\BacklogApiClient\Models\Status;
use Takuya\BacklogApiClient\Models\Webhook;
use Takuya\BacklogApiClient\Models\Version;
use Takuya\BacklogApiClient\Models\Category;
use Takuya\BacklogApiClient\Models\DiskUsage;
use Takuya\BacklogApiClient\Models\IssueType;
use Takuya\BacklogApiClient\Models\CustomField;
use Takuya\BacklogApiClient\Models\SharedFile;

class BacklogProjectModelTest extends TestCaseBacklogModels {
  
  
  public function test_project_model_attributes () {
    $project_id = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE )[0];
    $project = $this->cli->project( $project_id );
    $attrs =
      "id projectKey name chartEnabled useResolvedForChart subtaskingEnabled projectLeaderCanEditProjectLeader"
      ." useWiki useFileSharing useWikiTreeView useSubversion useGit"
      ." useOriginalImageSizeAtWiki textFormattingRule archived displayOrder useDevAttributes";
    foreach ( preg_split( '/\s/i', $attrs ) as $name ) {
      $this->assertPropIsExists( $name, $project );
    }
  }
  
  public function test_project_shared_file_get_content () {
    $project_ids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    // shared_files
    foreach ( $project_ids as $project_id ) {
      $project = $this->cli->project( $project_id );
      $shared_files = $project->shared_files();
      if ( sizeof( $shared_files ) > 0 ) {
        /** @var SharedFile $shared_file */
        foreach ( $shared_files as $shared_file ) {
          if ( $shared_file->isDir() ) {
            continue;
          }
          $bin = $shared_file->getContent();
          $this->assertEquals( $shared_file->size, strlen( $bin ) );
          break 2;
        }
      }
    }
  }
  
  public function test_project_custom_fields () {
    $project_ids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    $this->assertIsArray( $project_ids );
    // issue types
    foreach ( $project_ids as $project_id ) {
      $cf_list = $this->cli->project( $project_id )->custom_fields();
      $this->assertIsArray( $cf_list );
      foreach ( $cf_list as $cf ) {
        $this->assertEquals( CustomField::class, get_class( $cf ) );
        $this->assertIsInt( $cf->id );
        $this->assertIsInt( $cf->displayOrder );
        $this->assertIsInt( $cf->typeId );
        $this->assertIsString( $cf->name );
        $this->assertIsString( $cf->description );
        $this->assertIsBool( $cf->required );
        $this->assertIsBool( $cf->useIssueType );
        $this->assertIsArray( $cf->applicableIssueTypes );
        isset( $cf->allowAddItem ) && $this->assertIsBool( $cf->allowAddItem );
        isset( $cf->items ) && $this->assertIsArray( $cf->items );
        $this->assertContains( $cf->typeId, [
          CustomField::TYPE_STRING,
          CustomField::TYPE_TEXT,
          CustomField::TYPE_NUMBER,
          CustomField::TYPE_DATE,
          CustomField::TYPE_SELECT_SINGLE,
          CustomField::TYPE_SELECT_MULTI,
          CustomField::TYPE_CHECKBOX,
          CustomField::TYPE_RADIO_BUTTON,
        ] );
      }
    }
  }
  
  public function test_project_model_other_methods () {
    $project_ids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    // issue types
    foreach ( $project_ids as $project_id ) {
      foreach ( $this->cli->project( $project_id )->issue_types() as $issue_type ) {
        $this->assertEquals( IssueType::class, get_class( $issue_type ) );
        $this->assertIsInt( $issue_type->id );
        $this->assertIsInt( $issue_type->projectId );
        $this->assertIsInt( $issue_type->displayOrder );
        $this->assertIsString( $issue_type->name );
        $this->assertIsString( $issue_type->color );
        break 2;
      }
    }
    // users
    $users = $this->cli->project( $project_ids[0] )->users();
    $this->assertIsArray( $users );
    $this->assertGreaterThan( 0, sizeof( $users ) );
    $this->assertEquals( User::class, get_class( $users[0] ) );
    // versions
    foreach ( $project_ids as $project_id ) {
      foreach ( $this->cli->project( $project_id )->versions() as $version ) {
        $this->assertEquals( Version::class, get_class( $version ) );
        $this->assertIsBool( $version->archived );
        $this->assertIsInt( $version->id );
        $this->assertIsInt( $version->projectId );
        $this->assertIsInt( $version->displayOrder );
        $this->assertIsString( $version->name );
        $this->assertIsString( $version->releaseDueDate );
        $this->assertIsString( $version->startDate );
      }
    }
    // status list
    foreach ( $project_ids as $project_id ) {
      $project = $this->cli->project( $project_id );
      $statuses = $project->statuses();
      if ( sizeof( $statuses ) > 0 ) {
        foreach ( $statuses as $status ) {
          $this->assertEquals( Status::class, get_class( $status ) );
          $this->assertIsInt( $status->id );
          $this->assertIsInt( $status->projectId );
          $this->assertIsInt( $status->displayOrder );
          $this->assertIsString( $status->color );
          $this->assertIsString( $status->name );
        }
        break;
      }
    }
    // category
    foreach ( $this->cli->project( $project_ids[0] )->categories() as $cate ) {
      $this->assertEquals( Category::class, get_class( $cate ) );
      $this->assertIsInt( $cate->id );
      $this->assertIsInt( $cate->displayOrder );
      $this->assertIsString( $cate->name );
      break;
    }
    // diskusage
    $du = $this->cli->project( $project_ids[0] )->disk_usage();
    $this->assertEquals( DiskUsage::class, get_class( $du ) );
    // webhook
    foreach ( $project_ids as $project_id ) {
      $project = $this->cli->project( $project_id );
      $webhooks = $project->webhooks();
      if ( sizeof( $webhooks ) > 0 ) {
        $this->assertEquals( Webhook::class, get_class( $webhooks[0] ) );
      }
    }
    // icon
    $project = $this->cli->project( $project_ids[0] );
    $this->assertNotFalse( imagecreatefromstring( $project->icon() ) );
  }
  
  public function test_project_webhook () {
    $project_ids = $this->cli->space()->project_ids( Backlog::PROJECTS_ONLY_MINE );
    foreach ( $project_ids as $project_id ) {
      $prj = $this->cli->project( $project_id );
      $hooks = $prj->webhooks();
      $this->assertIsArray( $hooks );
      if ( sizeof( $hooks ) > 0 ) {
        $this->assertGreaterThan( 0, sizeof( $hooks ) );
        $obj = json_decode( json_encode( $hooks[0] ) );
        $keys = explode(
          ' ',
          "id name description hookUrl allEvent activityTypeIds created createdUser updated updatedUser" );
        foreach ( $keys as $key ) {
          $this->assertPropIsExists( $key, $obj );
        }
        break;
      }
    }
  }
}