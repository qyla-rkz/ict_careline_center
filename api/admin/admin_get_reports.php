<?php
// api/admin_get_reports.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

$name = isset($_GET['name']) ? $_GET['name'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

try {
    $sql = "SELECT r.*, u.name AS full_name, u.department 
            FROM reports r 
            JOIN users u ON r.user_id = u.id 
            WHERE 1=1";
    $params = [];

    if ($name !== '') {
        $sql .= " AND (u.name LIKE :name OR r.nama_pelapor LIKE :name)";
        $params['name'] = "%$name%";
    }

    if ($user_id !== '') {
        $sql .= " AND u.id = :user_id";
        $params['user_id'] = $user_id;
    }

    if ($date !== '') {
        $sql .= " AND DATE(r.created_at) = :date";
        $params['date'] = $date;
    }

    $sql .= " ORDER BY r.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reports = $stmt->fetchAll();

    // Attach images for each report
    foreach ($reports as &$r) {
        $imgStmt = $pdo->prepare("SELECT image_path FROM report_images WHERE report_id = ?");
        $imgStmt->execute([$r['id']]);
        $r['images'] = $imgStmt->fetchAll();
    }

    jsonResponse('success', 'Reports fetched', $reports);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>