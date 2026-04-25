<?php
// api/staff_submit_report.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asset_id = !empty($_POST['asset_id']) ? $_POST['asset_id'] : null;
    $nama_aset = $_POST['nama_aset'] ?? '';
    $jenis_aset = $_POST['jenis_aset'] ?? '';
    $nombor_siri = $_POST['nombor_siri'] ?? '';
    $tarikh_kerosakan = $_POST['tarikh_kerosakan'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    $perihal = $_POST['perihal_kerosakan'] ?? '';
    
    // Auto-fill/Override from POST
    $pengguna = !empty($_POST['pengguna_terakhir']) ? $_POST['pengguna_terakhir'] : $_SESSION['full_name'];
    $jawatan = $_SESSION['jawatan'] ?? $_SESSION['role']; 

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO reports (user_id, jenis_aset, nombor_siri, pengguna_terakhir, tarikh_kerosakan, perihal_kerosakan, nama_pelapor, jawatan_pelapor, location, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        
        $stmt->execute([
            $_SESSION['user_id'], 
            $jenis_aset, 
            $nombor_siri, 
            $pengguna, 
            $tarikh_kerosakan, 
            $perihal,
            $_SESSION['full_name'], // nama_pelapor
            $jawatan,               // jawatan_pelapor
            $lokasi                 // location
        ]);

        $report_id = $pdo->lastInsertId();

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $file_ext = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                    $file_name = "report_" . $report_id . "_" . $key . "_" . time() . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $img_stmt = $pdo->prepare("INSERT INTO report_images (report_id, image_path) VALUES (?, ?)");
                        $img_stmt->execute([$report_id, 'uploads/' . $file_name]);
                    }
                }
            }
        }

        // Log Activity
        $logStmt = $pdo->prepare("INSERT INTO activity_logs (user_id, activity_type, description) VALUES (?, 'Report Submitted', ?)");
        $logStmt->execute([$_SESSION['user_id'], "Submitted KEW.PA-9 for $jenis_aset ($nombor_siri)"]);

        $pdo->commit();
        jsonResponse('success', 'Report submitted successfully');

    } catch (Exception $e) {
        $pdo->rollBack();
        jsonResponse('error', 'Database error: ' . $e->getMessage());
    }
} else {
    jsonResponse('error', 'Invalid request method');
}
?>
