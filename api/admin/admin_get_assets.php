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
    $stmt = $pdo->query("SELECT sa.*, u.name, u.department, u.jawatan
                         FROM staff_assets sa
                         LEFT JOIN users u ON sa.user_id = u.id
                         ORDER BY sa.created_at DESC");
    $assets = $stmt->fetchAll();

    // Keep the list response lightweight; images are not needed to render the table.
    foreach ($assets as &$asset) {
        $asset['images'] = [];
        $asset['report_count'] = 0;
        $asset['total_report_count'] = 0;
    }

    jsonResponse('success', 'Assets fetched', $assets);
} catch (PDOException $e) {
    jsonResponse('error', 'DB Error: ' . $e->getMessage());
}
?>
