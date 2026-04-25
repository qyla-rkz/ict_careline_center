<?php
// api/admin_get_reports.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

try {
    $stmt = $pdo->query("SELECT r.*, u.name AS full_name, u.department 
                         FROM reports r 
                         JOIN users u ON r.user_id = u.id 
                         ORDER BY r.created_at DESC");
    $reports = $stmt->fetchAll();
    jsonResponse('success', 'Reports fetched', $reports);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
