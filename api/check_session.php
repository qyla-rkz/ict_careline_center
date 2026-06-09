<?php
// api/check_session.php
// Validates the PHP server-side session and returns user data
// Used by global.js to sync sessionStorage with real server session
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    echo json_encode([
        'status' => 'success',
        'data' => [
            'id'        => $_SESSION['user_id'],
            'full_name' => $_SESSION['full_name'] ?? '',
            'role'      => $_SESSION['role'],
            'jawatan'   => $_SESSION['jawatan'] ?? '',
            'username'  => $_SESSION['username'] ?? ''
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No active session']);
}
?>
