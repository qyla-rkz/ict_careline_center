<?php
// api/admin/admin_update_asset.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    // Handle Delete Action
    if ($action === 'delete') {
        if (!$id) {
            jsonResponse('error', 'ID Aset diperlukan untuk pemadaman.');
        }

        try {
            $pdo->beginTransaction();

            // Delete associated images
            $imgStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
            $imgStmt->execute([$id]);
            $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($images as $img) {
                $oldPath = __DIR__ . '/../../' . ltrim($img['image_path'], '/\\');
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $pdo->prepare("DELETE FROM asset_images WHERE asset_id = ?")->execute([$id]);
            $pdo->prepare("DELETE FROM staff_assets WHERE id = ?")->execute([$id]);

            logAudit($pdo, $_SESSION['user_id'], 'Padam Aset (Admin)', "Admin '{$_SESSION['full_name']}' memadam rekod aset ID: $id.");

            $pdo->commit();
            jsonResponse('success', 'Rekod aset berjaya dipadam.');
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            jsonResponse('error', 'Gagal memadam aset: ' . $e->getMessage());
        }
    }

    // Save (Create or Update)
    $user_id        = !empty($_POST['user_id']) ? (int)$_POST['user_id'] : null;
    $asset_type     = $_POST['asset_type'] ?? 'Desktop PC';
    $model_komputer = $_POST['model_komputer'] ?? '';
    $serial_number  = $_POST['serial_number'] ?? '';
    $model_monitor  = $_POST['model_monitor'] ?? '';
    $serial_monitor = $_POST['serial_monitor'] ?? '';
    $os             = $_POST['os'] ?? '';
    $processor      = $_POST['processor'] ?? '';
    $ram            = $_POST['ram'] ?? '';
    $hard_disk      = $_POST['hard_disk'] ?? '';
    $mouse          = $_POST['mouse'] ?? '';
    $keyboard       = $_POST['keyboard'] ?? '';
    $ms_office      = $_POST['ms_office'] ?? '';
    $antivirus      = $_POST['antivirus'] ?? '';
    $ip_address     = $_POST['ip_address'] ?? '';
    $printer        = $_POST['printer'] ?? '';
    $perisian_lain  = $_POST['perisian_lain'] ?? '';
    
    // User details for Bahagian A
    $nama_pegawai   = trim($_POST['nama_pegawai'] ?? '');
    $jawatan        = trim($_POST['jawatan'] ?? '');
    $jabatan_unit   = trim($_POST['jabatan_unit'] ?? '');

    // If user_id is provided, try to fill empty name/dept/jawatan from users table
    if ($user_id && (empty($nama_pegawai) || empty($jawatan) || empty($jabatan_unit))) {
        $uStmt = $pdo->prepare("SELECT name, jawatan, department FROM users WHERE id = ?");
        $uStmt->execute([$user_id]);
        if ($u = $uStmt->fetch(PDO::FETCH_ASSOC)) {
            if (empty($nama_pegawai)) $nama_pegawai = $u['name'] ?? '';
            if (empty($jawatan)) $jawatan = $u['jawatan'] ?? '';
            if (empty($jabatan_unit)) $jabatan_unit = $u['department'] ?? '';
        }
    }

    // If user_id is not provided, try to find user by nama_pegawai to link asset
    if (empty($user_id) && !empty($nama_pegawai)) {
        $uFind = $pdo->prepare("SELECT id, jawatan, department FROM users WHERE LOWER(TRIM(name)) = LOWER(?) LIMIT 1");
        $uFind->execute([$nama_pegawai]);
        if ($u = $uFind->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $u['id'];
            if (empty($jawatan)) $jawatan = $u['jawatan'] ?? '';
            if (empty($jabatan_unit)) $jabatan_unit = $u['department'] ?? '';
        }
    }

    if (empty($serial_number) || empty($model_komputer)) {
        jsonResponse('error', 'Model Komputer dan No. Siri CPU adalah wajib diisi.');
    }

    try {
        $pdo->beginTransaction();

        if (!empty($id)) {
            // UPDATE
            $sql = "UPDATE staff_assets SET 
                    user_id = ?, asset_type = ?, serial_number = ?, model_komputer = ?, 
                    model_monitor = ?, serial_monitor = ?, os = ?, processor = ?, 
                    ram = ?, hard_disk = ?, mouse = ?, keyboard = ?, ms_office = ?, 
                    antivirus = ?, ip_address = ?, printer = ?, perisian_lain = ?, 
                    no_siri_pendaftaran = ?, nama_pegawai = ?, jawatan = ?, jabatan_unit = ?
                    WHERE id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $user_id, $asset_type, $serial_number, $model_komputer, 
                $model_monitor, $serial_monitor, $os, $processor, 
                $ram, $hard_disk, $mouse, $keyboard, $ms_office, 
                $antivirus, $ip_address, $printer, $perisian_lain, 
                $serial_number, $nama_pegawai, $jawatan, $jabatan_unit,
                $id
            ]);
            $target_asset_id = $id;
            $auditAction = 'Kemaskini Aset (Admin)';
            $auditDesc = "Admin '{$_SESSION['full_name']}' kemaskini aset ID $id ($nama_pegawai, S/N: $serial_number).";
        } else {
            // INSERT
            $sql = "INSERT INTO staff_assets (
                        user_id, asset_type, serial_number, model_komputer, model_monitor, 
                        serial_monitor, os, processor, ram, hard_disk, 
                        mouse, keyboard, ms_office, antivirus, ip_address, 
                        printer, perisian_lain, no_siri_pendaftaran, nama_pegawai,
                        jawatan, jabatan_unit
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $user_id, $asset_type, $serial_number, $model_komputer, $model_monitor, 
                $serial_monitor, $os, $processor, $ram, $hard_disk, 
                $mouse, $keyboard, $ms_office, $antivirus, $ip_address, 
                $printer, $perisian_lain, $serial_number, $nama_pegawai,
                $jawatan, $jabatan_unit
            ]);
            $target_asset_id = $pdo->lastInsertId();
            $auditAction = 'Tambah Aset (Admin)';
            $auditDesc = "Admin '{$_SESSION['full_name']}' tambah aset baharu ID $target_asset_id ($nama_pegawai, S/N: $serial_number).";
        }

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = __DIR__ . '/../../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Remove previous images if updating
            if (!empty($id)) {
                $oldImagesStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
                $oldImagesStmt->execute([$target_asset_id]);
                $oldImages = $oldImagesStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($oldImages as $oldImage) {
                    $oldPath = __DIR__ . '/../../' . ltrim($oldImage['image_path'], '/\\');
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $deleteStmt = $pdo->prepare("DELETE FROM asset_images WHERE asset_id = ?");
                $deleteStmt->execute([$target_asset_id]);
            }

            // Limit up to 3
            $image_count = count($_FILES['images']['name']);
            if ($image_count > 3) $image_count = 3;

            for ($i = 0; $i < $image_count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($file_ext, $allowedExtensions, true) || @getimagesize($_FILES['images']['tmp_name'][$i]) === false) {
                        continue;
                    }
                    $file_name = "asset_" . $target_asset_id . "_" . $i . "_" . time() . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file)) {
                        $img_stmt = $pdo->prepare("INSERT INTO asset_images (asset_id, image_path) VALUES (?, ?)");
                        $img_stmt->execute([$target_asset_id, 'uploads/' . $file_name]);
                    }
                }
            }
        }

        logAudit($pdo, $_SESSION['user_id'], $auditAction, $auditDesc);

        $pdo->commit();
        jsonResponse('success', !empty($id) ? 'Maklumat aset berjaya dikemaskini.' : 'Aset staf baharu berjaya didaftarkan.');
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
} else {
    jsonResponse('error', 'Kaedah permintaan tidak sah.');
}
?>
