<?php
session_start();

// セッションの内容を全て削除
$_SESSION = [];

// セッションを完全に破棄
session_destroy();

// ログイン画面にリダイレクト
header("Location: login.php");
exit;
