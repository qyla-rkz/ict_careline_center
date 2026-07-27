<?php
require_once 'config.php';
try {
    $pdo->exec("ALTER TABLE reports ADD COLUMN IF NOT EXISTS proses_semasa VARCHAR(100) DEFAULT NULL");
    echo json_encode(['status' => 'success', 'message' => 'Column proses_semasa added successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
