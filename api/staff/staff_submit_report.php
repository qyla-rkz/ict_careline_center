<?php
// api/staff_submit_report.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan kolum asset_id dan lampiran_spec wujud dalam reports
    try {
        $checkCol = $pdo->query("SHOW COLUMNS FROM reports LIKE 'asset_id'")->fetch();
        if (!$checkCol) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN asset_id INT(11) DEFAULT NULL");
        }
    } catch (Exception $e) {}

    try {
        $checkSpecCol = $pdo->query("SHOW COLUMNS FROM reports LIKE 'lampiran_spec'")->fetch();
        if (!$checkSpecCol) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN lampiran_spec LONGTEXT DEFAULT NULL");
        }
    } catch (Exception $e) {}

    $asset_id = !empty($_POST['asset_id']) ? intval($_POST['asset_id']) : null;
    $lampiran_spec = !empty($_POST['lampiran_spec']) ? trim($_POST['lampiran_spec']) : null;
    $confirm_spec = !empty($_POST['confirm_spec']) ? trim($_POST['confirm_spec']) : '';

    $nama_aset = $_POST['nama_aset'] ?? '';
    $jenis_aset = $_POST['jenis_aset'] ?? '';
    $nombor_siri = $_POST['nombor_siri'] ?? '';
    $tarikh_kerosakan = $_POST['tarikh_kerosakan'] ?? '';
    $lokasi = $_POST['lokasi'] ?? $_POST['location'] ?? '';
    $perihal = $_POST['perihal_kerosakan'] ?? '';
    
    // Pengesahan Wajib Lampiran Spesifikasi Aset
    if (empty($lampiran_spec) || ($confirm_spec !== '1' && $confirm_spec !== 'true' && $confirm_spec !== 'on')) {
        jsonResponse('error', 'Spesifikasi aset wajib dilampirkan dan kotak pengesahan mesti ditanda sebelum menghantar borang KEW.PA-9.');
    }

    // Auto-fill/Override from POST
    $pengguna = !empty($_POST['pengguna_terakhir']) ? $_POST['pengguna_terakhir'] : ($_SESSION['full_name'] ?? '');
    $nama_pelapor = !empty($_POST['nama_pelapor']) ? trim($_POST['nama_pelapor']) : ($_SESSION['full_name'] ?? '');
    $jawatan = !empty($_POST['jawatan_pelapor']) ? trim($_POST['jawatan_pelapor']) : ($_SESSION['jawatan'] ?? $_SESSION['role'] ?? ''); 

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO reports (user_id, asset_id, lampiran_spec, jenis_aset, nombor_siri, pengguna_terakhir, tarikh_kerosakan, perihal_kerosakan, nama_pelapor, jawatan_pelapor, location, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        
        $stmt->execute([
            $_SESSION['user_id'], 
            $asset_id,
            $lampiran_spec,
            $jenis_aset, 
            $nombor_siri, 
            $pengguna, 
            $tarikh_kerosakan, 
            $perihal,
            $nama_pelapor,
            $jawatan,
            $lokasi
        ]);

        $report_id = $pdo->lastInsertId();

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = __DIR__ . '/../../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $image_count = 0;
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($image_count >= 3) break;
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $file_ext = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($file_ext, $allowedExtensions, true) || @getimagesize($tmp_name) === false) {
                        continue;
                    }
                    $file_name = "report_" . $report_id . "_" . $key . "_" . time() . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $img_stmt = $pdo->prepare("INSERT INTO report_images (report_id, image_path) VALUES (?, ?)");
                        $img_stmt->execute([$report_id, 'uploads/' . $file_name]);
                        $image_count++;
                    }
                }
            }
        }

        // Log Activity ke audit_logs
        logAudit($pdo, $_SESSION['user_id'], 'Hantar Laporan', "Laporan KEW.PA-9 baru dihantar untuk aset '$jenis_aset' (S/N: $nombor_siri). ID Laporan: $report_id.");

        $pdo->commit();
        echo json_encode([
            'status' => 'success',
            'message' => 'Report submitted successfully',
            'report_id' => (int)$report_id,
            'data' => [
                'report_id' => (int)$report_id
            ]
        ]);
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        jsonResponse('error', 'Database error: ' . $e->getMessage());
    }
} else {
    jsonResponse('error', 'Invalid request method');
}
?>
