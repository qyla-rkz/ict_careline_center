<?php
// api/logout.php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    logAudit($pdo, $_SESSION['user_id'], 'Log Keluar', "Pengguna '{$_SESSION['full_name']}' ({$_SESSION['username']}) telah log keluar.");
}

session_unset();
session_destroy();
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
?>
