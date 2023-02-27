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
spaceId はURLを入れます。
```php
$space='http://xxx-your-space.backlog.xxx'
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
自動補完の例
<div>
<img width="100%" alt="image" src="https://user-images.githubusercontent.com/55338/215521858-31d7fd22-ddd5-484f-b55f-af12503eb82a.png">
</div>

## サンプル


APIはバックログを開いてアドレスを見ながら使います。

課題コメントを開いたときのアドレスは次のようになっています。
```
https://example.backlog.com/view/MYPRJ-40#comment-8408
```
アドレスから次の情報が読み取れます。
```json
{
  "スペースKey":"example",
  "プロジェクトKey": "MYPRJ",
  "課題Key": "40",
  "コメントID": "8408"
}
```

|         URL(path)          |   値   |   Apiでの引数表記    |    呼び方     |
|:--------------------------:|:-----:|:--------------:|:----------:|
| /**MYPRJ**-40#comment-8408 | MYPRJ | ProjectIdOrKey | ProjectKey |
| /MYPRJ-**40**#comment-8408 |  40   |  IssueIdOrKey  |  IssueKey  |
| /MYPRJ-40#comment-**8408** | 8409  |   CommentId    | CommentId  |

APIドキュメントに`ProjectIdOrKey`と書かれた場合は、 ProjectId Or ProjectKey を意味しています。`ProjectKey`と`ProjectId`とは１対１対応のようです。
上記の情報を使ってAPIにアクセスします。

たとえば、以下のように使います。
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


基本的に、`Key`より`ID`アクセスが楽ちんです。

なぜなら、リクエスト引数へIDsを指定で検索するAPIが殆どだからです。たとえばパラメータ`projectIds[]`や`IssueIds[]`などです。

このためにID と Key を相互に変換するメソッドを作成してあります。
```php
<?php
use Takuya\BacklogApiClient\Backlog;
$cli = new Backlog($space, $key);
$project_id = $cli->projectIdByKeyName("MYPRJ");
```



## api 一覧

APIの名前とメソッド名と実際のAPIの対応表を`api.html`に用意しています。

## 日付と時刻

BacklogのAPIは `created` / `updated` で日付が返されます。すべてUTCのようです。

## インストール via github
```sh
composer config repositories.'php-nulab-backlog-api-client' \
vcs https://github.com/takuya/php-nulab-backlog-api-client  
composer require takuya/php-nulab-backlog-api-client:master
composer install
```
## インストール via packagist with composer 
```sh
composer require takuya/php-nulab-backlog-api-client
```
## Development
インストールしてテストして開発。
```sh
## clone
git clone git@github.com:takuya/php-nulab-backlog-api-client.git
cd php-nulab-backlog-api-client
composer install
## generate api from backlog WebSite.
composer run-script gen_api_methods
## Test api methods.
export backlog_api_key='YOUR_API_KEY'
export backlog_space='xxxspace'
composer run-script test
## test some test case
php vendor/bin/phpunit --filter get_space
```
