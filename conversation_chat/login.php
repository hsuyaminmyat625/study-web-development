<?php
require_once 'config.php';

// セッション開始
startSession();

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
$email = sanitizeInput($input['email'] ?? '');
$password = $input['password'] ?? '';

// 必須項目チェック
if (empty($email) || empty($password)) {
    sendJSONResponse(false, 'メールアドレスとパスワードを入力してください。');
}

// メールアドレスの形式チェック
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJSONResponse(false, '正しいメールアドレスを入力してください。');
}

// データベース接続
$pdo = getDBConnection();
if (!$pdo) {
    sendJSONResponse(false, 'データベース接続に失敗しました。');
}

try {
    // ユーザー認証
    $stmt = $pdo->prepare("
        SELECT id, first_name, last_name, email, password 
        FROM users 
        WHERE email = ?
    ");
    $stmt->execute([$email]);
    
    $user = $stmt->fetch();
    
    if (!$user) {
        sendJSONResponse(false, 'メールアドレスまたはパスワードが正しくありません。');
    }
    
    // パスワード検証
    if (!password_verify($password, $user['password'])) {
        sendJSONResponse(false, 'メールアドレスまたはパスワードが正しくありません。');
    }
    
    // ログイン成功
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['logged_in'] = true;
    
    // 最終ログイン時刻を更新
    $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
    $stmt->execute([$user['id']]);
    
    sendJSONResponse(true, 'ログインに成功しました。', [
        'user_id' => $user['id'],
        'user_name' => $user['first_name'] . ' ' . $user['last_name'],
        'user_email' => $user['email']
    ]);
    
} catch (PDOException $e) {
    error_log("ログインエラー: " . $e->getMessage());
    sendJSONResponse(false, 'データベースエラーが発生しました。');
} catch (Exception $e) {
    error_log("予期しないエラー: " . $e->getMessage());
    sendJSONResponse(false, '予期しないエラーが発生しました。');
}
?> 