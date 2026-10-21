<?php
// api/admin_get_assets.php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized - Role: ' . ($_SESSION['role'] ?? 'TIADA'));
}

try {
    $stmt = $pdo->query("SELECT sa.*, 
                                COALESCE(u.name, sa.nama_pegawai, 'Staf') as name, 
                                COALESCE(u.department, sa.jabatan_unit, '-') as department, 
                                COALESCE(u.jawatan, sa.jawatan, '-') as jawatan
                         FROM staff_assets sa
                         LEFT JOIN users u ON sa.user_id = u.id
                         ORDER BY sa.created_at DESC");
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch images mapped by asset_id
    $imgStmt = $pdo->query("SELECT asset_id, image_path FROM asset_images");
    $allImages = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
    $imagesByAsset = [];
    foreach ($allImages as $img) {
        $imagesByAsset[$img['asset_id']][] = $img;
    }

    // Fetch report counts mapped by user_id
    $repStmt = $pdo->query("SELECT user_id, COUNT(*) as cnt FROM reports WHERE user_id IS NOT NULL GROUP BY user_id");
    $reportCounts = $repStmt->fetchAll(PDO::FETCH_KEY_PAIR);

    foreach ($assets as &$asset) {
        $asset['images'] = $imagesByAsset[$asset['id']] ?? [];
        $asset['total_report_count'] = isset($asset['user_id']) ? (int)($reportCounts[$asset['user_id']] ?? 0) : 0;
    }

    jsonResponse('success', 'Assets fetched', $assets);
} catch (PDOException $e) {
    jsonResponse('error', 'DB Error: ' . $e->getMessage());
}
?>
