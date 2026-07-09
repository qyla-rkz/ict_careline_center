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

// Profile picture upload handling
if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
    jsonResponse('error', 'Sila muat naik gambar profil formal anda');
}

$fileTmpPath = $_FILES['profile_picture']['tmp_name'];
$fileName = $_FILES['profile_picture']['name'];
$fileSize = $_FILES['profile_picture']['size'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($fileExtension, $allowedExtensions)) {
    jsonResponse('error', 'Format gambar profil tidak sah. Sila muat naik fail JPG, JPEG, PNG atau GIF sahaja');
}

if ($fileSize > 5 * 1024 * 1024) {
    jsonResponse('error', 'Saiz gambar profil tidak boleh melebihi 5MB');
}

$uploadFileDir = '../uploads/profile_pictures/';
if (!file_exists($uploadFileDir)) {
    mkdir($uploadFileDir, 0777, true);
}

$newFileName = 'profile_' . preg_replace('/[^A-Za-z0-9_\-]/', '', $staff_id) . '_' . uniqid() . '.' . $fileExtension;
$dest_path = $uploadFileDir . $newFileName;

if (!move_uploaded_file($fileTmpPath, $dest_path)) {
    jsonResponse('error', 'Ralat semasa memuat naik gambar profil. Sila cuba lagi.');
}

$db_profile_pic_path = 'uploads/profile_pictures/' . $newFileName;

try {
    // Check if staff_id already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE staff_id = ?");
    $stmt->execute([$staff_id]);
    if ($stmt->fetch()) {
        // Remove uploaded profile pic since registration failed
        if (file_exists($dest_path)) {
            unlink($dest_path);
        }
        jsonResponse('error', 'Staff ID already exists');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, staff_id, phone, office, department, jawatan, password, role, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Staff', ?)");
    if ($stmt->execute([$name, $email, $staff_id, $phone, $office, $department, $jawatan, $hashed_password, $db_profile_pic_path])) {
        $newUserId = $pdo->lastInsertId();
        logAudit($pdo, $newUserId, 'Pendaftaran Akaun', "Akaun baru didaftarkan: '$name' (ID Staf: $staff_id, Jabatan: $department).");
        jsonResponse('success', 'Registration successful');
    } else {
        // Remove uploaded file on failure
        if (file_exists($dest_path)) {
            unlink($dest_path);
        }
        jsonResponse('error', 'Registration failed');
    }
} catch (PDOException $e) {
    // Remove uploaded file on failure
    if (file_exists($dest_path)) {
        unlink($dest_path);
    }
    jsonResponse('error', 'Database error: ' . $e->getMessage());
}
?>
