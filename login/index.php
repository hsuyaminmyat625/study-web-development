<?php 
session_start(); // ログインチェック 
if (empty($_SESSION['login'])) { 
    echo "このページにアクセスするには<a href='login.php'>ログイン</a>が必要です。"; 
    exit; 
    } 
?> 
<!DOCTYPE html> 
<html lang="ja"> 
    <head> 
        <meta charset="UTF-8"> 
    </head> 
    <body> 
        <h1>ログイン済み</h1> 
        <h4>ログインに成功しました</h4> 
        <p><a href="login.php">ログアウト</a></p>
    </body>
</html>