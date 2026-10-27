<?php
// api/admin_delete_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    jsonResponse('error', 'Akses ditolak. Fungsi Inventori Aset kini hanya untuk Super Admin.');
}

$id = $_GET['id'] ?? '';

if ($id) {
    try {
        // Ambil nama jabatan dahulu untuk log audit
        $nameStmt = $pdo->prepare("SELECT department_name FROM department_inventory WHERE id = ?");
        $nameStmt->execute([$id]);
        $deptName = $nameStmt->fetchColumn() ?: "ID $id";

        $stmt = $pdo->prepare("DELETE FROM department_inventory WHERE id = ?");
        $stmt->execute([$id]);

        logAudit($pdo, $_SESSION['user_id'], 'Padam Inventori (Super Admin)', "Super Admin '{$_SESSION['full_name']}' memadam inventori jabatan '$deptName' (ID: $id).");

        jsonResponse('success', 'Inventori jabatan berjaya dipadam.');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>