<?php
// api/admin_update_dept_inventory.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
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
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO department_inventory (department_name, assets_data) VALUES (?, ?)");
            $stmt->execute([$dept_name, $assets_data]);
        }
        jsonResponse('success', 'Inventory updated');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
