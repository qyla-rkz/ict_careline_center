<?php
// api/admin_get_reports.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

$name = isset($_GET['name']) ? $_GET['name'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

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

    if ($date !== '') {
        $sql .= " AND DATE(r.created_at) = :date";
        $params['date'] = $date;
    }

    $sql .= " ORDER BY r.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reports = $stmt->fetchAll();
    jsonResponse('success', 'Reports fetched', $reports);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>