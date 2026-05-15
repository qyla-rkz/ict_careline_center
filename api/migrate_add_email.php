<?php
// api/migrate_add_email.php
// Run once to add email column to users table
require_once 'config.php';

try {
    // Check if email column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'email'");
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'info', 'message' => 'Column email already exists']);
        exit;
    }

    $pdo->exec("ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL AFTER name");
    echo json_encode(['status' => 'success', 'message' => 'Column email added successfully to users table']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
