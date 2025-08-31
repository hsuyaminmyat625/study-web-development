<?php
require_once 'config.php';

// セッション開始
startSession();

// ログイン状態をチェック
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    sendJSONResponse(false, '未認証です。');
}

// POSTリクエストのみ受け付け
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSONResponse(false, '不正なリクエストです。');
}

// JSONデータを取得
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    sendJSONResponse(false, 'データの取得に失敗しました。');
}

// 入力値の検証
$message = sanitizeInput($input['message'] ?? '');
$messageType = sanitizeInput($input['message_type'] ?? '');

// 必須項目チェック
if (empty($message) || empty($messageType)) {
    sendJSONResponse(false, 'メッセージとタイプを入力してください。');
}

// メッセージタイプの検証
if (!in_array($messageType, ['user', 'ai'])) {
    sendJSONResponse(false, '不正なメッセージタイプです。');
}

// ユーザーIDを取得
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    sendJSONResponse(false, 'ユーザーIDが取得できません。');
}

// データベース接続
$pdo = getDBConnection();
if (!$pdo) {
    sendJSONResponse(false, 'データベース接続に失敗しました。');
}

try {
    // チャット履歴を保存
    $stmt = $pdo->prepare("
        INSERT INTO chat_history (user_id, message, message_type, created_at) 
        VALUES (?, ?, ?, NOW())
    ");
    
    $result = $stmt->execute([$userId, $message, $messageType]);
    
    if ($result) {
        sendJSONResponse(true, 'チャット履歴を保存しました。', [
            'id' => $pdo->lastInsertId(),
            'message' => $message,
            'message_type' => $messageType,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    } else {
        sendJSONResponse(false, 'チャット履歴の保存に失敗しました。');
    }
    
} catch (PDOException $e) {
    error_log("チャット履歴保存エラー: " . $e->getMessage());
    sendJSONResponse(false, 'データベースエラーが発生しました。');
} catch (Exception $e) {
    error_log("予期しないエラー: " . $e->getMessage());
    sendJSONResponse(false, '予期しないエラーが発生しました。');
}
?> 