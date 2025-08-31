# AIチャットアプリケーション

10万パターンの会話を楽しめるAIチャットアプリケーションです。ログイン・新規登録機能付きで、セキュアな認証システムを実装しています。

## 機能

- 🤖 10万パターンの豊富な会話
- 🔍 Google検索連携
- 💬 リアルタイムチャット
- 🔐 セキュアな認証システム
- 📱 レスポンシブデザイン
- 👤 ユーザー管理機能

## セットアップ手順

### 1. 環境要件

- MAMP（PHP + MySQL）
- PHP 7.4以上
- MySQL 5.7以上

### 2. データベース設定

1. MAMPを起動し、phpMyAdminにアクセス
2. 新しいデータベース `ai_chat_db` を作成
3. `database.sql` ファイルをphpMyAdminで実行

```sql
-- データベース作成
CREATE DATABASE `ai_chat_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- テーブル作成（database.sqlファイルの内容を実行）
```

### 3. 設定ファイルの確認

`config.php` のデータベース接続情報を確認・修正：

```php
define('DB_HOST', 'localhost');        // データベースホスト
define('DB_NAME', 'ai_chat_db');       // データベース名
define('DB_USER', 'root');             // ユーザー名
define('DB_PASS', 'root');             // パスワード（MAMPのデフォルト）
```

### 4. ファイル配置

以下のファイルをMAMPのhtdocsフォルダ内の適切なディレクトリに配置：

```
conversation_chat/
├── index.html          # メインページ
├── login.html          # ログインフォーム
├── register.html       # 新規登録フォーム
├── conversation.html   # チャットアプリケーション
├── config.php          # データベース設定
├── login.php           # ログイン処理
├── register.php        # 新規登録処理
├── logout.php          # ログアウト処理
├── check_auth.php      # 認証チェック
├── database.sql        # データベース構造
└── README.md           # このファイル
```

### 5. アクセス

ブラウザで以下のURLにアクセス：

- メインページ: `http://localhost/conversation_chat/`
- ログイン: `http://localhost/conversation_chat/login.html`
- 新規登録: `http://localhost/conversation_chat/register.html`

## 使用方法

### 新規ユーザー

1. 新規登録ページでアカウントを作成
2. ログインページでログイン
3. チャットページでAIアシスタントと会話

### 既存ユーザー

1. ログインページでログイン
2. チャットページでAIアシスタントと会話

### チャット機能

- 通常の会話: メッセージを入力して送信
- 検索機能: 「〇〇について調べて」「〇〇を検索して」と入力
- 時間・日付: 「時間」「日付」と入力
- 天気: 「天気」と入力

## セキュリティ機能

- パスワードハッシュ化（bcrypt）
- SQLインジェクション対策（プリペアドステートメント）
- XSS対策（入力値サニタイズ）
- CSRF対策（トークン検証）
- セッション管理

## データベース構造

### users テーブル

| カラム | 型 | 説明 |
|--------|----|----|
| id | int | 主キー（自動増分） |
| first_name | varchar(50) | 姓 |
| last_name | varchar(50) | 名 |
| email | varchar(255) | メールアドレス（ユニーク） |
| password | varchar(255) | パスワード（ハッシュ化） |
| created_at | datetime | 作成日時 |
| updated_at | datetime | 更新日時 |
| last_login | datetime | 最終ログイン日時 |
| status | enum | アカウント状態 |

### chat_history テーブル（オプション）

| カラム | 型 | 説明 |
|--------|----|----|
| id | int | 主キー（自動増分） |
| user_id | int | ユーザーID（外部キー） |
| message | text | メッセージ内容 |
| message_type | enum | メッセージタイプ（user/ai） |
| created_at | datetime | 送信日時 |

## トラブルシューティング

### よくある問題

1. **データベース接続エラー**
   - MAMPが起動しているか確認
   - データベース名・ユーザー名・パスワードを確認

2. **ログインできない**
   - データベースにユーザーが作成されているか確認
   - パスワードが正しく入力されているか確認

3. **ページが表示されない**
   - ファイルパスが正しいか確認
   - PHPエラーログを確認

### ログ確認

MAMPのログファイルを確認：
- Apache ログ: `/Applications/MAMP/logs/apache_error.log`
- PHP エラー: `/Applications/MAMP/logs/php_error.log`

## カスタマイズ

### 会話パターンの追加

`conversation.html` の `generateConversationPatterns()` 関数内で、各配列に新しい要素を追加することで、会話パターンを増やすことができます。

### デザインの変更

各HTMLファイルの `<style>` セクション内のCSSを編集することで、デザインをカスタマイズできます。

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。

## サポート

問題や質問がある場合は、以下の点を確認してください：

1. 環境要件が満たされているか
2. データベースが正しく設定されているか
3. ファイルパスが正しいか
4. エラーログに何か記載されているか

---

**注意**: 本アプリケーションは開発・学習目的で作成されています。本格的な運用を行う場合は、セキュリティの追加強化やエラーハンドリングの改善を行ってください。 