<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
</head>   
<body>
<form method = 'post' action='login.php'>
    <p>
        <label for="username">ユーザー名:</label>
        <input type='text' name='username'>
    </p>
    <p>
        <label for="password">パスワード:</label>
        <input type='password' name='password'>
    </p>
    <input type='submit' value='送信する'>
 
</form>
</body>
 
<?php
session_start();
 
 
if((empty($_POST['username'])) || (empty($_POST['password']))) {
    echo 'ユーザー名、パスワードを入力してください。';
    exit;
}
 
 
try {
    // DB接続
    $db = new PDO('mysql:dbname=mydb;host=localhost;port=8888;charset=utf8', 'root', 'root');
 
    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        echo "ログインに失敗しました";
        exit;
    }
    if(password_verify($_POST['password'],$user['password'])){
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        header("Location: index.php");
    }else{
        echo 'ログインに失敗しました。';
    }
} catch (PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}
 
?>