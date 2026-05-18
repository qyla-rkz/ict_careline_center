<?php
// api/superadmin/system_stats.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'super admin' && strtolower($_SESSION['role']) !== 'superadmin') {
    jsonResponse('error', 'Akses ditolak.');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stats = [];
        
        // Total Users
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $stats['total_users'] = $stmt->fetchColumn();
        
        // Total Assets
        $stmt = $pdo->query("SELECT COUNT(*) FROM staff_assets");
        $stats['total_assets'] = $stmt->fetchColumn();
        
        // Total Reports
        $stmt = $pdo->query("SELECT COUNT(*) FROM reports");
        $stats['total_reports'] = $stmt->fetchColumn();
        
        // Recent Audit Logs
        $stmt = $pdo->query("SELECT a.action, a.created_at, u.name 
                             FROM audit_logs a 
                             LEFT JOIN users u ON a.user_id = u.id 
                             ORDER BY a.created_at DESC LIMIT 5");
        $stats['recent_logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        jsonResponse('success', 'Berjaya mengambil statistik', $stats);
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}
?>
