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
$firstName = sanitizeInput($input['first_name'] ?? '');
$lastName = sanitizeInput($input['last_name'] ?? '');
$email = sanitizeInput($input['email'] ?? '');
$password = $input['password'] ?? '';

// 必須項目チェック
if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
    sendJSONResponse(false, 'すべての項目を入力してください。');
}

// メールアドレスの形式チェック
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJSONResponse(false, '正しいメールアドレスを入力してください。');
}

// パスワードの強度チェック
if (strlen($password) < 8) {
    sendJSONResponse(false, 'パスワードは8文字以上で入力してください。');
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
    sendJSONResponse(false, 'パスワードは英数字と大文字・小文字を含む必要があります。');
}

// データベース接続
$pdo = getDBConnection();
if (!$pdo) {
    sendJSONResponse(false, 'データベース接続に失敗しました。');
}

try {
    // メールアドレスの重複チェック
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        sendJSONResponse(false, 'このメールアドレスは既に登録されています。');
    }
    
    // パスワードのハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // ユーザー登録
    $stmt = $pdo->prepare("
        INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) 
        VALUES (?, ?, ?, ?, NOW(), NOW())
    ");
    
    $result = $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    
    if ($result) {
        sendJSONResponse(true, '登録が完了しました。ログインしてください。');
    } else {
        sendJSONResponse(false, '登録に失敗しました。もう一度お試しください。');
    }
    
} catch (PDOException $e) {
    error_log("ユーザー登録エラー: " . $e->getMessage());
    sendJSONResponse(false, 'データベースエラーが発生しました。');
} catch (Exception $e) {
    error_log("予期しないエラー: " . $e->getMessage());
    sendJSONResponse(false, '予期しないエラーが発生しました。');
}
?> 