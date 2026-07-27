<?php
// api/admin_update_asset.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    
    if (!$id) {
        jsonResponse('error', 'ID Aset diperlukan.');
    }

    $model_komputer = $_POST['model_komputer'] ?? '';
    $serial_number = $_POST['serial_number'] ?? '';
    $model_monitor = $_POST['model_monitor'] ?? '';
    $serial_monitor = $_POST['serial_monitor'] ?? '';
    $os = $_POST['os'] ?? '';
    $processor = $_POST['processor'] ?? '';
    $ram = $_POST['ram'] ?? '';
    $hard_disk = $_POST['hard_disk'] ?? '';
    $mouse = $_POST['mouse'] ?? '';
    $keyboard = $_POST['keyboard'] ?? '';
    $ms_office = $_POST['ms_office'] ?? '';
    $antivirus = $_POST['antivirus'] ?? '';
    $ip_address = $_POST['ip_address'] ?? '';
    $printer = $_POST['printer'] ?? '';
    $perisian_lain = $_POST['perisian_lain'] ?? '';

    try {
        $sql = "UPDATE staff_assets SET 
                serial_number = ?, model_komputer = ?, model_monitor = ?, 
                serial_monitor = ?, os = ?, processor = ?, ram = ?, hard_disk = ?, 
                mouse = ?, keyboard = ?, ms_office = ?, antivirus = ?, ip_address = ?, 
                printer = ?, perisian_lain = ? 
                WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $serial_number, $model_komputer, $model_monitor, 
            $serial_monitor, $os, $processor, $ram, $hard_disk, 
            $mouse, $keyboard, $ms_office, $antivirus, $ip_address, 
            $printer, $perisian_lain, $id
        ]);

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Remove previous image records first
            $oldImagesStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
            $oldImagesStmt->execute([$id]);
            $oldImages = $oldImagesStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($oldImages as $oldImage) {
                $oldPath = __DIR__ . '/../' . $oldImage['image_path'];
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $deleteStmt = $pdo->prepare("DELETE FROM asset_images WHERE asset_id = ?");
            $deleteStmt->execute([$id]);

            // Limit to 3
            $image_count = count($_FILES['images']['name']);
            if ($image_count > 3) $image_count = 3;

            for ($i = 0; $i < $image_count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                    $file_name = "asset_" . $id . "_" . $i . "_" . time() . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file)) {
                        $img_stmt = $pdo->prepare("INSERT INTO asset_images (asset_id, image_path) VALUES (?, ?)");
                        $img_stmt->execute([$id, 'uploads/' . $file_name]);
                    }
                }
            }
        }

        logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Aset (Admin)', "Admin '{$_SESSION['full_name']}' kemaskini aset ID $id (S/N: $serial_number).");
        
        jsonResponse('success', 'Asset dikemaskini dengan berjaya');
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
} else {
    jsonResponse('error', 'Kaedah tidak sah');
}
?>
