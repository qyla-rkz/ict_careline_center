<?php
// api/admin/admin_get_staff_list.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

try {
    $stmt = $pdo->query("SELECT id, name, staff_id, department, jawatan FROM users WHERE status = 'Active' OR status IS NULL ORDER BY name ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse('success', 'Staff list fetched', $users);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
