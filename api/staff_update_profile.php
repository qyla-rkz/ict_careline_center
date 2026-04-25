<?php
// api/staff_update_profile.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $office = trim($_POST['office'] ?? '');
    $jawatan = trim($_POST['jawatan'] ?? '');

    if (empty($name)) {
        jsonResponse('error', 'Name cannot be empty');
    }

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, phone = ?, office = ?, jawatan = ? WHERE id = ?");
        if ($stmt->execute([$name, $phone, $office, $jawatan, $_SESSION['user_id']])) {
            // Log activity
            $logStmt = $pdo->prepare("INSERT INTO activity_logs (user_id, activity_type, description) VALUES (?, 'Profile Updated', 'Changed profile information')");
            $logStmt->execute([$_SESSION['user_id']]);
            
            jsonResponse('success', 'Profile updated successfully');
        } else {
            jsonResponse('error', 'Failed to update profile');
        }
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
