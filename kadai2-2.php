<?php
session_start();

echo '<p>セッションが確認できました。</p>';
echo '<p>セッションから名前:'.$_SESSION['username'].'を取得しました。</p>';

echo '<a href="kadai2-1.php">もう一度セッションをセットする</a>';
?>