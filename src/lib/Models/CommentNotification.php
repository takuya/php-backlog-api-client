<?php

namespace Takuya\BacklogApiClient\Models;

use Takuya\BacklogApiClient\Models\Traits\HasID;
use Takuya\BacklogApiClient\Models\Traits\RelateToIssue;
use Takuya\BacklogApiClient\Models\Traits\RelateToComment;

/**
 * @property-read int    $id
 * @property-read bool   $alreadyRead
 * @property-read int    $reason
 * @property-read object $user
 * @property-read bool   $resourceAlreadyRead
 */
class CommentNotification extends BaseModel {
  
  /**
   * 連番に欠番あり。
   * @link https://developer.nulab.com/ja/docs/backlog/api/2/add-comment-notification/#%E3%83%AC%E3%82%B9%E3%83%9D%E3%83%B3%E3%82%B9%E3%83%9C%E3%83%87%E3%82%A3
   * @var
   */
  const REASON = [
    '課題の担当者に設定'      => 1,
    '課題にコメント'        => 2,
    '課題の追加'          => 3,
    '課題の更新'          => 4,
    'ファイルを追加'        => 5,
    'プロジェクトユーザーの追加'  => 6,
    'その他'            => 9,
    'プルリクエストの担当者に設定' => 10,
    'プルリクエストにコメント'   => 11,
    'プルリクエストの追加'     => 12,
    'プルリクエストの更新'     => 13,
  ];
  use HasID;
  use RelateToIssue;
  use RelateToComment;
  public bool   $alreadyRead;
  public int    $reason;
  public object $user;
  public bool   $resourceAlreadyRead;
}