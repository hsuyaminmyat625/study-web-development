<?php
$dsn = 'mysql:host=localhost;port=8889;dbname=mydb;charset=utf8';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if (empty($tables)) {
        echo 'mydbにテーブルがありません。';
        exit;
    }
    foreach ($tables as $table) {
        echo "<h2>テーブル: {$table}</h2>";
        $stmt = $pdo->query("SELECT * FROM `{$table}`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            echo 'データがありません。<br>';
            continue;
        }
        echo '<table border="1"><tr>';
        foreach (array_keys($rows[0]) as $col) {
            echo "<th>{$col}</th>";
        }
        echo '</tr>';
        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($row as $val) {
                echo '<td>' . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . '</td>';
            }
            echo '</tr>';
        }
        echo '</table><br>';
    }
} catch (PDOException $e) {
    echo 'DB接続エラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
?>
