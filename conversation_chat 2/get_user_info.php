<?php
require_once 'config.php';

// セッション開始
startSession();

// ログイン状態をチェック
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    sendJSONResponse(false, '未認証です。');
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
    // ユーザー情報を取得
    $stmt = $pdo->prepare("
        SELECT id, first_name, last_name, email, created_at, last_login, status 
        FROM users 
        WHERE id = ? AND status = 'active'
    ");
    $stmt->execute([$userId]);
    
    $user = $stmt->fetch();
    
    if (!$user) {
        sendJSONResponse(false, 'ユーザーが見つかりません。');
    }
    
    // ユーザー情報を返す
    sendJSONResponse(true, 'ユーザー情報を取得しました。', [
        'id' => $user['id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'full_name' => $user['first_name'] . ' ' . $user['last_name'],
        'email' => $user['email'],
        'created_at' => $user['created_at'],
        'last_login' => $user['last_login'],
        'status' => $user['status']
    ]);
    
} catch (PDOException $e) {
    error_log("ユーザー情報取得エラー: " . $e->getMessage());
    sendJSONResponse(false, 'データベースエラーが発生しました。');
} catch (Exception $e) {
    error_log("予期しないエラー: " . $e->getMessage());
    sendJSONResponse(false, '予期しないエラーが発生しました。');
}
?> 