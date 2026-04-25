<?php
// api/staff_get_history.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM reports WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $history = $stmt->fetchAll();

    // Fetch images for each report
    foreach ($history as &$r) {
        $imgStmt = $pdo->prepare("SELECT image_path FROM report_images WHERE report_id = ?");
        $imgStmt->execute([$r['id']]);
        $r['images'] = $imgStmt->fetchAll();
    }

    jsonResponse('success', 'History fetched', $history);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
