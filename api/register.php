<?php
// api/register.php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Invalid request method');
}

$name       = trim($_POST['full_name'] ?? '');
$staff_id   = trim($_POST['username'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$office     = trim($_POST['office'] ?? '');
$department = trim($_POST['department'] ?? '');
$jawatan    = trim($_POST['jawatan'] ?? '');
$password   = $_POST['password'] ?? '';

if (empty($name) || empty($staff_id) || empty($password) || empty($department) || empty($jawatan)) {
    jsonResponse('error', 'All required fields must be filled');
}

try {
    // Check if staff_id already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE staff_id = ?");
    $stmt->execute([$staff_id]);
    if ($stmt->fetch()) {
        jsonResponse('error', 'Staff ID already exists');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, staff_id, phone, office, department, jawatan, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Staff')");
    if ($stmt->execute([$name, $email, $staff_id, $phone, $office, $department, $jawatan, $hashed_password])) {
        jsonResponse('success', 'Registration successful');
    } else {
        jsonResponse('error', 'Registration failed');
    }
} catch (PDOException $e) {
    jsonResponse('error', 'Database error: ' . $e->getMessage());
}
?>
