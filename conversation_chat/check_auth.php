<?php
require_once 'config.php';

// セッション開始
startSession();

// ログイン状態をチェック
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// ユーザー情報を取得
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'name' => $_SESSION['user_name'] ?? null,
        'email' => $_SESSION['user_email'] ?? null
    ];
}

// API用の認証チェック
if (isset($_GET['api']) && $_GET['api'] === 'check') {
    if (isLoggedIn()) {
        $user = getCurrentUser();
        sendJSONResponse(true, '認証済み', $user);
    } else {
        sendJSONResponse(false, '未認証');
    }
}
?> 