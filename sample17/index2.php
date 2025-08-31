<?php
session_start();

// ログインしていなければログインページにリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン済み</title>
    <link rel="stylesheet" href="sample17.css">
</head>
<body>
    <h1>ログイン済み</h1>
    <p>ログインに成功しました。</p>
    <a href="logout.php">ログアウト</a>
</body>
</html>
