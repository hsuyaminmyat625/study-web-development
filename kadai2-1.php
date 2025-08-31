<?php
// 1. セッションを開始する
session_start();

// 2. セッションに変数をセットする
$_SESSION['username'] = 'Hsu Yamin Myat';

echo '<p>セッションに名前'.$_SESSION['username'].'をセットしました。</p>';

echo '<a href="kadai2-2.php">セッションを確認するページへ移動</a>';
?>