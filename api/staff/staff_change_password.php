<?php
// api/staff_change_password.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        jsonResponse('error', 'All fields are required');
    }

    if (strlen($new_password) < 6) {
        jsonResponse('error', 'Kata laluan baru mesti sekurang-kurangnya 6 aksara');
    }

    if ($new_password !== $confirm_password) {
        jsonResponse('error', 'New passwords do not match');
    }

    try {
        // Fetch current password hash
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['password'])) {
            jsonResponse('error', 'Incorrect current password');
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        if ($stmt->execute([$hashed_password, $_SESSION['user_id']])) {
            // Log activity
            $logStmt = $pdo->prepare("INSERT INTO activity_logs (user_id, activity_type, description) VALUES (?, 'Security Update', 'Changed account password')");
            $logStmt->execute([$_SESSION['user_id']]);
            
            jsonResponse('success', 'Password updated successfully');
        } else {
            jsonResponse('error', 'Failed to update password');
        }
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
