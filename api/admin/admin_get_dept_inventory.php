<?php
// api/admin_get_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    jsonResponse('error', 'Akses ditolak. Fungsi Inventori Aset kini hanya untuk Super Admin.');
}

try {
    $stmt = $pdo->query("SELECT * FROM department_inventory ORDER BY department_name ASC");
    $data = $stmt->fetchAll();
    jsonResponse('success', 'Data fetched', $data);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>