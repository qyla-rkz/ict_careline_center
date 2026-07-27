<?php
// api/staff_get_profile.php
session_start();
require_once 'config.php';

// Debug: Log session status to a file (temporary)
// file_put_contents('session_debug.txt', "Session ID: " . session_id() . " | User ID: " . ($_SESSION['user_id'] ?? 'NONE') . "\n", FILE_APPEND);

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    // Select everything so we don't fail if a specific column is missing, then map safely
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user) {
        // Map fields safely with defaults to avoid JS "undefined"
        jsonResponse('success', 'Profile fetched', [
            'id'              => $user['id'] ?? 0,
            'username'        => $user['staff_id'] ?? $user['username'] ?? '',
            'full_name'       => $user['name'] ?? $user['full_name'] ?? '',
            'phone'           => $user['phone'] ?? '',
            'office'          => $user['office'] ?? '',
            'department'      => $user['department'] ?? '',
            'jawatan'         => $user['jawatan'] ?? '',
            'role'            => $user['role'] ?? 'Staff',
            'profile_picture' => $user['profile_picture'] ?? '',
            'updated_at'      => $user['updated_at'] ?? ''
        ]);
    } else {
        jsonResponse('error', 'User record not found in database');
    }
} catch (PDOException $e) {
    jsonResponse('error', 'Database error: ' . $e->getMessage());
}
?>
