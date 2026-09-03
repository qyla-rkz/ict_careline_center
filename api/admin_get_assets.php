<?php
// api/admin_get_assets.php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized - Role: ' . ($_SESSION['role'] ?? 'TIADA'));
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

        // Fetch how many times this staff has reported this asset
        try {
            // Reports table doesn't have an asset_id foreign key; match by serial number and user
            $countStmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM reports WHERE nombor_siri = ? AND user_id = ?");
            $countStmt->execute([$asset['serial_number'] ?? '', $asset['user_id'] ?? null]);
            $cntRow = $countStmt->fetch();
            $asset['report_count'] = isset($cntRow['cnt']) ? (int)$cntRow['cnt'] : 0;

            // Also include total reports by this user (all assets)
            $totalStmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM reports WHERE user_id = ?");
            $totalStmt->execute([$asset['user_id'] ?? null]);
            $totalRow = $totalStmt->fetch();
            $asset['total_report_count'] = isset($totalRow['cnt']) ? (int)$totalRow['cnt'] : 0;
        } catch (PDOException $e) {
            $asset['report_count'] = 0;
            $asset['total_report_count'] = 0;
        }
    }

    jsonResponse('success', 'Assets fetched', $assets);
} catch (PDOException $e) {
    jsonResponse('error', 'DB Error: ' . $e->getMessage());
}
?>
