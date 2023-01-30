## Nulab Backlog APIアクセス用

目標：NulabのBacklog APIに快適にアクセスして、全データを取り出せるようにする。

## 基本的な使い方。
```php
<?php
use Takuya\BacklogApiClient\BacklogAPIClient;
$key = getenv('backlog_api_key');
$space = getenv('backlog_space');
$cli = new BacklogAPIClient($space, $key);
$cli->getSpace();
$cli->getIssue(['query_options'=>['projectIds'=>[1,2,3],'count'=>100]]);
$cli->getComment("PRJ-234",1)

```
## 提供するクラス
２つのクラスファイルを提供しています。
- `class BacklogAPIClient`
- `class Backlog`
```php
<?php
// Apiで呼び出し
use Takuya\BacklogApiClient\BacklogAPIClient;
$cli = new BacklogAPIClient($space, $key);
$cli->getProject("PRJEKEY");
$cli->getIssue("PRJEKEY-123");
// オブジェクト・モデルでアクセス。
use Takuya\BacklogApiClient\Backlog;
$cli = new Backlog($space, $key);
$cli->project('PRJKEY');
$cli->issue('PRJKEY-123');
```
`class Backlog` はID探索のために読み込み用に作っています。更新は実装していません。
## 特長

PHPStormのIDE自動補完を使えるようにした。

データモデルをModelクラスとして作成した。これにより`スペース→プロジェクト→課題->コメント->通知` のBacklog階層構造を辿れる。

階層構造でたどれば、全体を取得しやすくなる。

サンプル
```php
<?php
use Takuya\BacklogApiClient\Backlog;
$key = getenv('backlog_api_key');
$space = getenv('backlog_space');
$cli = new Backlog($space, $key);
// スペースの取得->プロジェクト一覧->課題一覧
foreach ($cli->space()->projects(Backlog::PROJECTS_ONLY_MINE) as $prj){
  foreach ($prj->issues() as $issue) {
    foreach ($issue->comments() as $comment) {
       print([
        $prj->id,
        $issue->id,
        $comment->id]
    )} 
  }
}
```

