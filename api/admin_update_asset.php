<?php
// api/admin_update_asset.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $user_id = $_POST['user_id'] ?? null;
    $type = $_POST['asset_type'] ?? '';
    $serial = $_POST['serial_number'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';

    try {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE staff_assets SET user_id=?, asset_type=?, serial_number=?, brand=?, model=? WHERE id=?");
            $stmt->execute([$user_id, $type, $serial, $brand, $model, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO staff_assets (user_id, asset_type, serial_number, brand, model) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $type, $serial, $brand, $model]);
        }
        jsonResponse('success', 'Asset saved');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
