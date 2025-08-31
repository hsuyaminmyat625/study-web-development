<?php
$host = 'localhost';
$port = '8889'; 
$dbname = 'mydb';
$username = 'root';
$password = 'root'; 

try {
    // PDOで接続
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 挿入先テーブル名（例: products）
    $table = 'products';
    // 挿入するデータ（任意のidと商品名）
    $insert_id = 1001; // 任意のID
    $insert_name = 'サンプル商品'; // 任意の商品名
    
    // INSERT文の実行
    $sql = "INSERT INTO `$table` (id, name) VALUES (:id, :name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $insert_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $insert_name);
    $stmt->execute();
    echo "<p>テーブル {$table} に新しいデータを挿入しました。（id={$insert_id}, name={$insert_name}）</p>";

    // 挿入後のデータ表示
    $stmt = $pdo->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) {
        echo 'データがありません。<br>';
    } else {
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
