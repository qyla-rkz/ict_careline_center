<?php
// api/admin_delete_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

$id = $_GET['id'] ?? '';

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM department_inventory WHERE id = ?");
        $stmt->execute([$id]);
        jsonResponse('success', 'Department deleted');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
