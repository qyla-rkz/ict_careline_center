<?php
// api/admin_get_assets.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

try {
    $stmt = $pdo->query("SELECT sa.*, u.name, u.department, u.jawatan
                         FROM staff_assets sa 
                         LEFT JOIN users u ON sa.user_id = u.id 
                         ORDER BY sa.created_at DESC");
    $assets = $stmt->fetchAll();

    // Fetch images for each asset
    foreach ($assets as &$asset) {
        $imgStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
        $imgStmt->execute([$asset['id']]);
        $asset['images'] = $imgStmt->fetchAll();
    }

    jsonResponse('success', 'Assets fetched', $assets);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
