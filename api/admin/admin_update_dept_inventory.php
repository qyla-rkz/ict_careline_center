<?php
// api/admin_update_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    jsonResponse('error', 'Akses ditolak. Fungsi Inventori Aset kini hanya untuk Super Admin.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $dept_name = $_POST['department_name'] ?? '';
    $assets_data = $_POST['assets_data'] ?? '{}'; // Expecting a JSON string

    try {
        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE department_inventory SET department_name=?, assets_data=? WHERE id=?");
            $stmt->execute([$dept_name, $assets_data, $id]);
            logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Inventori (Super Admin)', "Super Admin '{$_SESSION['full_name']}' mengemaskini inventori jabatan '$dept_name' (ID: $id).");
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO department_inventory (department_name, assets_data) VALUES (?, ?)");
            $stmt->execute([$dept_name, $assets_data]);
            $newId = $pdo->lastInsertId();
            logAudit($pdo, $_SESSION['user_id'], 'Tambah Inventori (Super Admin)', "Super Admin '{$_SESSION['full_name']}' menambah inventori bagi jabatan '$dept_name' (ID: $newId).");
        }
        jsonResponse('success', 'Inventori berjaya dikemaskini.');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>