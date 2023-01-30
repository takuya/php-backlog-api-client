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
- `class BacklogAPIClient` 更新・取得用
- `class Backlog` 取得専用
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
`class Backlog` はID探索のために作っています。更新は実装していません。
`class BacklogAPIClient` を使って更新をします。
## 認証

APIキーのアクセスを実装しています。OAUTHアクセスキー（BEARERトークン）は実装していません。
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

## サンプル


APIはバックログを開いてアドレスを見ながら使うと楽です。

課題コメントを開いたときのアドレスが次のときは、KEYがわかります。
```
https://example.backlog.com/view/MYPRJ-40#comment-8408
```
上記のアドレスから次のようなことが読み取れます。
```json
{
  "スペースKey":"example",
  "プロジェクトKey": "MYPRJ",
  "課題Key": "40",
  "コメントID": "8408"
}
```
上記の情報を使ってAPIにアクセスします。
```php
<?php
// API呼び出し
use Takuya\BacklogApiClient\BacklogAPIClient;
$space = 'example';
$key = 'YOUR_API_KEY';
$cli = new BacklogAPIClient($space, $key);

## プロジェクト取得 
$cli->getProject("MYPRJ");
## 課題取得 
$cli->getIssue("MYPRJ-40");

```

## api 一覧

APIの名前とメソッド名と実際のAPIの対応表を`api.html`に用意しています。


