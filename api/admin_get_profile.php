<?php
// api/admin_get_profile.php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user) {
        jsonResponse('success', 'Profile fetched', [
            'id'              => $user['id'] ?? 0,
            'username'        => $user['staff_id'] ?? $user['username'] ?? '',
            'full_name'       => $user['name'] ?? $user['full_name'] ?? '',
            'phone'           => $user['phone'] ?? '',
            'office'          => $user['office'] ?? '',
            'department'      => $user['department'] ?? '',
            'jawatan'         => $user['jawatan'] ?? '',
            'role'            => $user['role'] ?? 'Admin',
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
