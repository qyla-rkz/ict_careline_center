<?php
// api/superadmin/settings.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'super admin' && strtolower($_SESSION['role']) !== 'superadmin') {
    jsonResponse('error', 'Akses ditolak.');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        jsonResponse('success', 'Berjaya mengambil tetapan', ['settings' => $settings]);
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        jsonResponse('error', 'Data tidak sah.');
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?) 
                               ON DUPLICATE KEY UPDATE setting_value = ?");
        
        foreach ($data as $key => $value) {
            $stmt->execute([$key, $value, $value]);
        }

        // Audit Log
        $auditStmt = $pdo->prepare("INSERT INTO audit_logs (user_id, action, details) VALUES (?, ?, ?)");
        $auditStmt->execute([
            $_SESSION['user_id'],
            'UPDATE_SETTINGS',
            'Tetapan sistem dikemas kini'
        ]);

        $pdo->commit();
        jsonResponse('success', 'Tetapan berjaya disimpan.');
    } catch (PDOException $e) {
        $pdo->rollBack();
        jsonResponse('error', 'Ralat menyimpan tetapan: ' . $e->getMessage());
    }
}
?>
