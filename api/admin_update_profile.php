<?php
// api/admin_update_profile.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['full_name'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $office  = trim($_POST['office'] ?? '');
    $jawatan = trim($_POST['jawatan'] ?? '');
    $department = trim($_POST['department'] ?? '');

    if (empty($name)) {
        jsonResponse('error', 'Nama tidak boleh kosong');
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE users SET name = ?, phone = ?, office = ?, jawatan = ?, department = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $office, $jawatan, $department, $_SESSION['user_id']]);

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath    = $_FILES['profile_picture']['tmp_name'];
            $fileName       = $_FILES['profile_picture']['name'];
            $fileSize       = $_FILES['profile_picture']['size'];
            $fileNameCmps   = explode(".", $fileName);
            $fileExtension  = strtolower(end($fileNameCmps));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                $pdo->rollBack();
                jsonResponse('error', 'Format gambar profil tidak sah. Sila muat naik fail JPG, JPEG, PNG atau GIF sahaja');
            }

            if ($fileSize > 5 * 1024 * 1024) {
                $pdo->rollBack();
                jsonResponse('error', 'Saiz gambar profil tidak boleh melebihi 5MB');
            }

            // Retrieve old image path
            $stmt = $pdo->prepare("SELECT profile_picture, staff_id FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $oldUser = $stmt->fetch();
            $oldPic  = $oldUser['profile_picture'] ?? '';
            $staff_id = $oldUser['staff_id'] ?? uniqid();

            $uploadFileDir = '../uploads/profile_pictures/';
            if (!file_exists($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            $newFileName = 'profile_' . preg_replace('/[^A-Za-z0-9_\-]/', '', $staff_id) . '_' . uniqid() . '.' . $fileExtension;
            $dest_path   = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $db_profile_pic_path = 'uploads/profile_pictures/' . $newFileName;

                $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
                $stmt->execute([$db_profile_pic_path, $_SESSION['user_id']]);

                if (!empty($oldPic)) {
                    $oldFilePath = '../' . $oldPic;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            } else {
                $pdo->rollBack();
                jsonResponse('error', 'Ralat semasa memuat naik gambar profil.');
            }
        }

        // Log activity
        $logStmt = $pdo->prepare("INSERT INTO activity_logs (user_id, activity_type, description) VALUES (?, 'Profile Updated', 'Admin changed profile information')");
        $logStmt->execute([$_SESSION['user_id']]);

        $pdo->commit();
        jsonResponse('success', 'Profil berjaya dikemaskini');
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        jsonResponse('error', $e->getMessage());
    }
}
?>
