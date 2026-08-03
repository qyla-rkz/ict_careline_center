<?php
// api/admin_get_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

try {
    $stmt = $pdo->query("SELECT * FROM department_inventory ORDER BY department_name ASC");
    $data = $stmt->fetchAll();
    jsonResponse('success', 'Data fetched', $data);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>