<?php
// api/login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Invalid request method');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$selected_role = $_POST['role'] ?? 'Staff';

if (empty($username) || empty($password)) {
    jsonResponse('error', 'Staff ID and password are required');
}

try {
    // Search by staff_id or username just in case
    $stmt = $pdo->prepare("SELECT * FROM users WHERE staff_id = ? OR name = ? LIMIT 1");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Semak peranan (role) yang dipilih sepadan dengan pangkalan data
        $selected_role_lower = strtolower($selected_role);
        $db_role_lower = strtolower($user['role']);
        
        if ($selected_role_lower === 'admin') {
            if ($db_role_lower !== 'admin' && $db_role_lower !== 'super admin') {
                jsonResponse('error', 'ID Staf ini didaftarkan sebagai Staf biasa. Sila pilih peranan Staf.');
            }
        } else { // default to Staff checking
            if ($db_role_lower === 'admin' || $db_role_lower === 'super admin') {
                jsonResponse('error', 'ID Staf ini didaftarkan sebagai Admin. Sila pilih peranan Admin.');
            }
        }

        // Semak Mod Penyelenggaraan (Maintenance Mode)
        try {
            $settingsStmt = $pdo->query("SELECT setting_value FROM system_settings WHERE setting_key = 'maintenance_mode' LIMIT 1");
            if ($settingsStmt) {
                $maintenance = $settingsStmt->fetchColumn();
                if ($maintenance === '1' && !in_array(strtolower($user['role']), ['super admin', 'superadmin', 'admin'])) {
                    jsonResponse('error', 'Sistem sedang dalam penyelenggaraan (Maintenance Mode). Hanya pentadbir sahaja dibenarkan log masuk pada masa ini.');
                }
            }
        } catch (PDOException $e) {
            // Fail silently if table or setting doesn't exist
        }

        // Clear old session
        session_unset();
        
        // Set new session
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['username']   = $user['staff_id'] ?? $user['name'];
        $_SESSION['full_name']  = $user['name'];
        $_SESSION['role']       = $user['role'];
        $_SESSION['jawatan']    = $user['jawatan'] ?? '';
        $_SESSION['department'] = $user['department'] ?? '';
        
        // Force session to save
        session_write_close();
        session_start();

        logAudit($pdo, $user['id'], 'Log Masuk', "Pengguna '{$user['name']}' ({$user['staff_id']}) berjaya log masuk sebagai {$user['role']}.");

        jsonResponse('success', 'Login successful', [
            'id'        => $user['id'],
            'username'  => $user['staff_id'] ?? $user['name'],
            'role'      => $user['role'],
            'full_name' => $user['name'],
            'jawatan'   => $user['jawatan'] ?? ''
        ]);
    } else {
        logAudit($pdo, null, 'Log Masuk Gagal', "Cubaan log masuk gagal untuk ID: '$username'.");
        jsonResponse('error', 'Invalid Staff ID or password');
    }
} catch (PDOException $e) {
    jsonResponse('error', 'Database error: ' . $e->getMessage());
}
?>
