<?php
require_once 'config.php';
session_start();
echo "Session: " . json_encode($_SESSION) . "<br>";
try {
    $stmt = $pdo->query("DESCRIBE users");
    $cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Users columns: " . json_encode($cols);
} catch (Exception $e) { echo $e->getMessage(); }
?>
