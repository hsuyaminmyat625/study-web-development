<?php
$dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password);
    $sql = "UPDATE items SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => '編集したデータ', ':id' => 1000]);
    echo "データを更新しました";
} catch (PDOException $e) {
    echo "接続またはクエリに失敗しました: " . $e->getMessage();
}
?>