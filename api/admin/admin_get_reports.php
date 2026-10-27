<?php
// api/admin_get_reports.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

$userRole = strtolower($_SESSION['role'] ?? '');
if (!isset($_SESSION['user_id']) || !in_array($userRole, ['admin', 'super admin', 'superadmin'])) {
    jsonResponse('error', 'Unauthorized');
}

$name = isset($_GET['name']) ? $_GET['name'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

try {
    // Pastikan kolum proses_semasa, asset_id, lampiran_spec wujud
    try {
        $check = $pdo->query("SHOW COLUMNS FROM reports LIKE 'proses_semasa'")->fetch();
        if (!$check) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN proses_semasa VARCHAR(100) DEFAULT NULL");
        }
    } catch (Exception $colEx) {}

    try {
        $checkAssetId = $pdo->query("SHOW COLUMNS FROM reports LIKE 'asset_id'")->fetch();
        if (!$checkAssetId) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN asset_id INT(11) DEFAULT NULL");
        }
    } catch (Exception $colEx) {}

    try {
        $checkSpec = $pdo->query("SHOW COLUMNS FROM reports LIKE 'lampiran_spec'")->fetch();
        if (!$checkSpec) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN lampiran_spec LONGTEXT DEFAULT NULL");
        }
    } catch (Exception $colEx) {}

    try {
        $checkUpdated = $pdo->query("SHOW COLUMNS FROM reports LIKE 'updated_at'")->fetch();
        if (!$checkUpdated) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        }
    } catch (Exception $colEx) {}

    $sql = "SELECT r.*, u.name AS full_name, u.department 
            FROM reports r 
            JOIN users u ON r.user_id = u.id 
            WHERE 1=1";
    $params = [];

    if ($name !== '') {
        $sql .= " AND (u.name LIKE :name OR r.nama_pelapor LIKE :name)";
        $params['name'] = "%$name%";
    }

    if ($user_id !== '') {
        $sql .= " AND u.id = :user_id";
        $params['user_id'] = $user_id;
    }

    if ($date !== '') {
        $sql .= " AND DATE(r.created_at) = :date";
        $params['date'] = $date;
    }

    $sql .= " ORDER BY r.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reports = $stmt->fetchAll();

    // Attach images and ensure lampiran_spec for each report
    foreach ($reports as &$r) {
        $imgStmt = $pdo->prepare("SELECT image_path FROM report_images WHERE report_id = ?");
        $imgStmt->execute([$r['id']]);
        $r['images'] = $imgStmt->fetchAll();

        // Fallback: Jika lampiran_spec kosong tetapi ada asset_id atau nombor_siri, dapatkan dari jadual staff_assets
        if (empty($r['lampiran_spec'])) {
            try {
                $assetRow = null;
                if (!empty($r['asset_id'])) {
                    $aStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE id = ? LIMIT 1");
                    $aStmt->execute([$r['asset_id']]);
                    $assetRow = $aStmt->fetch(PDO::FETCH_ASSOC);
                }
                if (!$assetRow && !empty($r['nombor_siri'])) {
                    $aStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE no_siri_pendaftaran = ? OR serial_number = ? LIMIT 1");
                    $aStmt->execute([$r['nombor_siri'], $r['nombor_siri']]);
                    $assetRow = $aStmt->fetch(PDO::FETCH_ASSOC);
                }
                if ($assetRow) {
                    $r['lampiran_spec'] = [
                        'asset_id' => $assetRow['id'],
                        'asset_type' => $assetRow['asset_type'] ?? '',
                        'model_komputer' => $assetRow['model_komputer'] ?? '',
                        'no_siri_pendaftaran' => $assetRow['no_siri_pendaftaran'] ?? '',
                        'serial_number' => $assetRow['serial_number'] ?? '',
                        'model_monitor' => $assetRow['model_monitor'] ?? '',
                        'serial_monitor' => $assetRow['serial_monitor'] ?? '',
                        'os' => $assetRow['os'] ?? '',
                        'processor' => $assetRow['processor'] ?? '',
                        'ram' => $assetRow['ram'] ?? '',
                        'hard_disk' => $assetRow['hard_disk'] ?? '',
                        'ip_address' => $assetRow['ip_address'] ?? '',
                        'printer' => $assetRow['printer'] ?? '',
                        'mouse' => $assetRow['mouse'] ?? '',
                        'keyboard' => $assetRow['keyboard'] ?? '',
                        'ms_office' => $assetRow['ms_office'] ?? '',
                        'antivirus' => $assetRow['antivirus'] ?? '',
                        'perisian_lain' => $assetRow['perisian_lain'] ?? '',
                        'maklumat_ict' => $assetRow['maklumat_ict'] ?? '',
                        'nama_pegawai' => $assetRow['nama_pegawai'] ?? '',
                        'jawatan' => $assetRow['jawatan'] ?? '',
                        'jabatan_unit' => $assetRow['jabatan_unit'] ?? ''
                    ];
                }
            } catch (Exception $fallbackEx) {}
        } elseif (is_string($r['lampiran_spec'])) {
            $decoded = json_decode($r['lampiran_spec'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $r['lampiran_spec'] = $decoded;
            }
        }
    }

    jsonResponse('success', 'Reports fetched', $reports);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>