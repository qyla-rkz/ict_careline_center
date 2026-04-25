<?php
require_once 'config.php';
$s = $pdo->query("DESCRIBE users");
echo json_encode($s->fetchAll(PDO::FETCH_COLUMN));
?>
