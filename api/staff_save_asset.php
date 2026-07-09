<?php
// api/staff_save_asset.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = $_POST['id'] ?? null; // If ID is present, we are editing
    $asset_type     = $_POST['asset_type'] ?? '';
    $serial_number  = $_POST['serial_number'] ?? '';
    $model_komputer = $_POST['model_komputer'] ?? '';
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

    if (empty($asset_type) || empty($serial_number)) {
        jsonResponse('error', 'Asset Type and Serial Number are required');
    }

    try {
        $pdo->beginTransaction();

        if ($id) {
            // Check ownership
            $checkStmt = $pdo->prepare("SELECT id FROM staff_assets WHERE id = ? AND user_id = ?");
            $checkStmt->execute([$id, $_SESSION['user_id']]);
            if (!$checkStmt->fetch()) {
                throw new Exception('Access denied or asset not found');
            }

            // Update
            $sql = "UPDATE staff_assets SET 
                    asset_type = ?, serial_number = ?, model_komputer = ?, model_monitor = ?, 
                    serial_monitor = ?, os = ?, processor = ?, ram = ?, hard_disk = ?, 
                    mouse = ?, keyboard = ?, ms_office = ?, antivirus = ?, ip_address = ?, 
                    printer = ?, perisian_lain = ? 
                    WHERE id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $asset_type, $serial_number, $model_komputer, $model_monitor, 
                $serial_monitor, $os, $processor, $ram, $hard_disk, 
                $mouse, $keyboard, $ms_office, $antivirus, $ip_address, 
                $printer, $perisian_lain, $id, $_SESSION['user_id']
            ]);
            $asset_id = $id;
        } else {
            // Insert
            $sql = "INSERT INTO staff_assets (
                        user_id, asset_type, serial_number, model_komputer, model_monitor, 
                        serial_monitor, os, processor, ram, hard_disk, 
                        mouse, keyboard, ms_office, antivirus, ip_address, 
                        printer, perisian_lain
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_SESSION['user_id'], $asset_type, $serial_number, $model_komputer, $model_monitor, 
                $serial_monitor, $os, $processor, $ram, $hard_disk, 
                $mouse, $keyboard, $ms_office, $antivirus, $ip_address, 
                $printer, $perisian_lain
            ]);
            $asset_id = $pdo->lastInsertId();
        }

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // If editing and new images were uploaded, remove previous image records first
            if ($id) {
                $oldImagesStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
                $oldImagesStmt->execute([$asset_id]);
                $oldImages = $oldImagesStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($oldImages as $oldImage) {
                    $oldPath = __DIR__ . '/../' . $oldImage['image_path'];
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $deleteStmt = $pdo->prepare("DELETE FROM asset_images WHERE asset_id = ?");
                $deleteStmt->execute([$asset_id]);
            }

            // Limit to 5
            $image_count = count($_FILES['images']['name']);
            if ($image_count > 5) $image_count = 5;

            for ($i = 0; $i < $image_count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                    $file_name = "asset_" . $asset_id . "_" . $i . "_" . time() . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file)) {
                        $img_stmt = $pdo->prepare("INSERT INTO asset_images (asset_id, image_path) VALUES (?, ?)");
                        $img_stmt->execute([$asset_id, 'uploads/' . $file_name]);
                    }
                }
            }
        }

        $pdo->commit();

        $auditAction = $id ? 'Kemaskini Aset' : 'Tambah Aset';
        $auditDetail = ($id ? "Aset dikemaskini" : "Aset baru ditambah") . ": $asset_type (S/N: $serial_number). ID Aset: $asset_id.";
        logAudit($pdo, $_SESSION['user_id'], $auditAction, $auditDetail);

        jsonResponse('success', 'Asset information saved successfully');

    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        jsonResponse('error', 'Error: ' . $e->getMessage());
    }
} else {
    jsonResponse('error', 'Invalid request method');
}
?>
