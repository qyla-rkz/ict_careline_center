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

        jsonResponse('success', 'Login successful', [
            'id'        => $user['id'],
            'username'  => $user['staff_id'] ?? $user['name'],
            'role'      => $user['role'],
            'full_name' => $user['name'],
            'jawatan'   => $user['jawatan'] ?? ''
        ]);
    } else {
        jsonResponse('error', 'Invalid Staff ID or password');
    }
} catch (PDOException $e) {
    jsonResponse('error', 'Database error: ' . $e->getMessage());
}
?>
