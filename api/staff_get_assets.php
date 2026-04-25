<?php
// api/staff_get_assets.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM staff_assets WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
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
