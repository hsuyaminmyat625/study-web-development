-- AIチャットアプリケーション用データベース
-- phpMyAdminで実行してください

-- データベース作成
CREATE DATABASE IF NOT EXISTS `ai_chat_db` 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `ai_chat_db`;

-- ユーザーテーブル
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL COMMENT '姓',
  `last_name` varchar(50) NOT NULL COMMENT '名',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワード（ハッシュ化）',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
  `last_login` datetime NULL COMMENT '最終ログイン日時',
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active' COMMENT 'アカウント状態',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザー情報';

-- チャット履歴テーブル（オプション）
CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `message` text NOT NULL COMMENT 'メッセージ内容',
  `message_type` enum('user','ai') NOT NULL COMMENT 'メッセージタイプ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '送信日時',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `fk_chat_history_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='チャット履歴';

-- サンプルユーザー（テスト用）
-- パスワード: Test123!
INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `status`) VALUES
('テスト', 'ユーザー', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active');

-- インデックス作成（パフォーマンス向上）
CREATE INDEX `idx_users_email_status` ON `users` (`email`, `status`);
CREATE INDEX `idx_chat_history_user_created` ON `chat_history` (`user_id`, `created_at`); 