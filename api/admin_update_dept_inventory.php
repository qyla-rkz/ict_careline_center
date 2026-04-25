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
    $pc = $_POST['pc_count'] ?? 0;
    $laptop = $_POST['laptop_count'] ?? 0;
    $printer = $_POST['printer_count'] ?? 0;
    $monitor = $_POST['monitor_count'] ?? 0;
    $wifi = $_POST['wifi_count'] ?? 0;

    try {
        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE department_inventory SET department_name=?, pc_count=?, laptop_count=?, printer_count=?, monitor_count=?, wifi_count=? WHERE id=?");
            $stmt->execute([$dept_name, $pc, $laptop, $printer, $monitor, $wifi, $id]);
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO department_inventory (department_name, pc_count, laptop_count, printer_count, monitor_count, wifi_count) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$dept_name, $pc, $laptop, $printer, $monitor, $wifi]);
        }
        jsonResponse('success', 'Inventory updated');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
