<?php
// api/staff_get_activity.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    // Get last 5 activities
    $stmt = $pdo->prepare("SELECT activity_type, description, created_at FROM activity_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$_SESSION['user_id']]);
    $activities = $stmt->fetchAll();
    
    // If no explicit logs yet, fallback to recent reports as "pseudo-activity"
    if (empty($activities)) {
        $stmt = $pdo->prepare("SELECT 'Report Submitted' as activity_type, CONCAT(jenis_aset, ' (', status, ')') as description, created_at FROM reports WHERE user_id = ? ORDER BY created_at DESC LIMIT 3");
        $stmt->execute([$_SESSION['user_id']]);
        $activities = $stmt->fetchAll();
    }
    
    jsonResponse('success', 'Activities fetched', $activities);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
