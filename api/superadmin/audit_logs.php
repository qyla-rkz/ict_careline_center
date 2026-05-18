<?php
// api/superadmin/audit_logs.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'super admin' && strtolower($_SESSION['role']) !== 'superadmin') {
    jsonResponse('error', 'Akses ditolak.');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT a.id, a.action, a.details, a.ip_address, a.created_at, u.name as user_name, u.staff_id 
                             FROM audit_logs a 
                             LEFT JOIN users u ON a.user_id = u.id 
                             ORDER BY a.created_at DESC LIMIT 100");
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        jsonResponse('success', 'Berjaya mengambil log', ['logs' => $logs]);
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}
?>
