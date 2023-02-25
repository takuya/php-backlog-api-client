<?php

namespace tests\Unit\Api;

use tests\TestCase;
use Takuya\BacklogApiClient\BacklogAPIClient;

class ParseBacklogURLTest extends TestCase {
  
  public function test_parse_backlog_url() {
    
    $urls[] = [
      'https://xxxx.backlog.com/',
      ["spaceKey" => "xxxx", 'action' => '', "projectId" => null, "projectKey" => null, 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com',
      ["spaceKey" => "xxxx", 'action' => '', "projectId" => null, "projectKey" => null, 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/dashboard?from_globalbar',
      ["spaceKey" => "xxxx", 'action' => 'dashboard', "projectId" => null, "projectKey" => null, 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/projects/NY-PROJ',
      ["spaceKey" => "xxxx", 'action' => 'projects', "projectId" => null, "projectKey" => 'NY-PROJ', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/view/SAMPLEX01X-40#comment-223448408',
      ["spaceKey" => "xxxx", 'action' => 'view', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/ViewSharedFile.action?projectKey=99999&sharedFileId=32276732',
      [
        "spaceKey"   => "xxxx",
        'action'     => 'ViewSharedFile',
        "projectId"  => null,
        "projectKey" => '99999',
        'wiki'       => null,
      ],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/wiki/SAMPLEX01X/Home',
      [
        "spaceKey"   => "xxxx",
        'action'     => 'wiki',
        "projectId"  => null,
        "projectKey" => 'SAMPLEX01X',
        'wiki'       => ['page' => 'Home'],
      ],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/alias/wiki/12345',
      [
        "spaceKey"   => "xxxx",
        'action'     => 'alias/wiki',
        "projectId"  => null,
        "projectKey" => null,
        'wiki'       => ['id' => '12345'],
      ],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/ViewWikiAttachment.action?attachmentId=1234',
      [
        "spaceKey"   => "xxxx",
        'action'     => 'ViewWikiAttachment',
        "projectId"  => null,
        "projectKey" => null,
        'wiki'       => null,
      ],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/file/SAMPLEX01X',
      ["spaceKey" => "xxxx", 'action' => 'file', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/EditProject.action?project.id=99999',
      ["spaceKey" => "xxxx", 'action' => 'EditProject', "projectId" => '99999', "projectKey" => null, 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/ListIssueType.action?projectId=99999',
      ["spaceKey" => "xxxx", 'action' => 'ListIssueType', "projectId" => '99999', "projectKey" => null, 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/ViewPermission.action?projectId=99999',
      [
        "spaceKey"   => "xxxx",
        'action'     => 'ViewPermission',
        "projectId"  => '99999',
        "projectKey" => null,
        'wiki'       => null,
      ],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/gantt/SAMPLEX01X',
      ["spaceKey" => "xxxx", 'action' => 'gantt', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/board/SAMPLEX01X',
      ["spaceKey" => "xxxx", 'action' => 'board', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/find/SAMPLEX01X?projectId=99999&',
      ["spaceKey" => "xxxx", 'action' => 'find', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/add/SAMPLEX01X',
      ["spaceKey" => "xxxx", 'action' => 'add', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    $urls[] = [
      'https://xxxx.backlog.com/projects/SAMPLEX01X',
      ["spaceKey" => "xxxx", 'action' => 'projects', "projectId" => null, "projectKey" => 'SAMPLEX01X', 'wiki' => null],
    ];
    foreach ($urls as [$url, $expected]) {
      $ret = BacklogAPIClient::parseBackLogUrl($url);
      $this->assertEquals($expected, $ret);
    }
  }
}