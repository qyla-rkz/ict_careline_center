<?php
// api/admin_update_report.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Unauthorized');
}

$userRole = strtolower($_SESSION['role'] ?? '');
$isSuper = in_array($userRole, ['super admin', 'superadmin']);
$isAdmin = ($userRole === 'admin');

if (!$isSuper && !$isAdmin) {
    jsonResponse('error', 'Unauthorized. Akses tidak dibenarkan.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        jsonResponse('error', 'ID laporan tidak sah.');
    }

    try {
        $checkUpdated = $pdo->query("SHOW COLUMNS FROM reports LIKE 'updated_at'")->fetch();
        if (!$checkUpdated) {
            $pdo->exec("ALTER TABLE reports ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        }
    } catch (Exception $colEx) {}

    try {
        // Ambil maklumat laporan semasa
        $stmtReport = $pdo->prepare("SELECT * FROM reports WHERE id = ?");
        $stmtReport->execute([$id]);
        $existingReport = $stmtReport->fetch(PDO::FETCH_ASSOC);

        if (!$existingReport) {
            jsonResponse('error', 'Laporan tidak ditemui.');
        }

        // ==========================================
        // KES 1: ADMIN (Hanya Bahagian II & Proses Semasa)
        // Bahagian III khas untuk Super Admin sahaja!
        // ==========================================
        if ($isAdmin && !$isSuper) {
            $kos_dahulu = isset($_POST['kos_penyelenggaraan_dahulu']) && $_POST['kos_penyelenggaraan_dahulu'] !== '' 
                ? floatval($_POST['kos_penyelenggaraan_dahulu']) 
                : ($existingReport['kos_penyelenggaraan_dahulu'] ?? 0.00);

            $anggaran_kos = isset($_POST['anggaran_kos']) && $_POST['anggaran_kos'] !== '' 
                ? floatval($_POST['anggaran_kos']) 
                : ($existingReport['anggaran_kos'] ?? 0.00);

            $syor_ulasan = isset($_POST['syor_ulasan']) 
                ? trim($_POST['syor_ulasan']) 
                : ($existingReport['syor_ulasan'] ?? '');

            $admin_nama = isset($_POST['pegawai_teknikal_nama']) 
                ? trim($_POST['pegawai_teknikal_nama']) 
                : ($existingReport['admin_name_jawatan'] ?? $_SESSION['full_name'] ?? '');

            $admin_jawatan = isset($_POST['pegawai_teknikal_jawatan']) 
                ? trim($_POST['pegawai_teknikal_jawatan']) 
                : ($existingReport['admin_jawatan'] ?? '');

            $proses_semasa = isset($_POST['proses_semasa']) ? trim($_POST['proses_semasa']) : $existingReport['proses_semasa'];

            // Jika status masih Pending, tukar kepada In Progress
            $newStatus = ($existingReport['status'] === 'Pending') ? 'In Progress' : $existingReport['status'];
            $admin_tarikh = !empty($existingReport['admin_tarikh']) ? $existingReport['admin_tarikh'] : date('Y-m-d');

            $stmt = $pdo->prepare("UPDATE reports SET 
                kos_penyelenggaraan_dahulu = ?, 
                anggaran_kos = ?, 
                syor_ulasan = ?, 
                admin_name_jawatan = ?, 
                admin_jawatan = ?, 
                admin_tarikh = ?, 
                proses_semasa = ?, 
                status = ?,
                updated_at = NOW() 
                WHERE id = ?");

            $stmt->execute([
                $kos_dahulu,
                $anggaran_kos,
                $syor_ulasan,
                $admin_nama,
                $admin_jawatan,
                $admin_tarikh,
                $proses_semasa ?: null,
                $newStatus,
                $id
            ]);

            logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Bahagian II (Admin)', "Admin '{$_SESSION['full_name']}' telah mengemaskini Penemuan Teknikal (Bahagian II) untuk Laporan ID $id.");

            jsonResponse('success', 'Penemuan teknikal (Bahagian II) berjaya disimpan.');
        }

        // ==========================================
        // KES 2: SUPER ADMIN (Bahagian III Keputusan)
        // Hanya Super Admin boleh buat keputusan Bahagian III
        // ==========================================
        if ($isSuper) {
            $keputusan = trim($_POST['keputusan'] ?? '');
            $kep_nama = trim($_POST['keputusan_nama'] ?? '');
            $kep_tarikh = trim($_POST['keputusan_tarikh'] ?? '');

            if ($keputusan === '' || $kep_nama === '' || $kep_tarikh === '') {
                jsonResponse('error', 'Sila lengkapkan semua ruangan Bahagian III (Keputusan).');
            }

            $status = ($keputusan === 'Tidak Diluluskan') ? 'Rejected' : 'Resolved';

            // Super Admin boleh juga mengemaskini maklumat teknikal jika dihantar
            $kos_dahulu = isset($_POST['kos_penyelenggaraan_dahulu']) && $_POST['kos_penyelenggaraan_dahulu'] !== '' 
                ? floatval($_POST['kos_penyelenggaraan_dahulu']) 
                : ($existingReport['kos_penyelenggaraan_dahulu'] ?? 0.00);

            $anggaran_kos = isset($_POST['anggaran_kos']) && $_POST['anggaran_kos'] !== '' 
                ? floatval($_POST['anggaran_kos']) 
                : ($existingReport['anggaran_kos'] ?? 0.00);

            $syor_ulasan = isset($_POST['syor_ulasan']) 
                ? trim($_POST['syor_ulasan']) 
                : ($existingReport['syor_ulasan'] ?? '');

            $admin_nama = isset($_POST['pegawai_teknikal_nama']) 
                ? trim($_POST['pegawai_teknikal_nama']) 
                : ($existingReport['admin_name_jawatan'] ?? '');

            $admin_jawatan = isset($_POST['pegawai_teknikal_jawatan']) 
                ? trim($_POST['pegawai_teknikal_jawatan']) 
                : ($existingReport['admin_jawatan'] ?? '');

            $stmt = $pdo->prepare("UPDATE reports SET 
                kos_penyelenggaraan_dahulu = ?, 
                anggaran_kos = ?, 
                syor_ulasan = ?, 
                admin_name_jawatan = ?, 
                admin_jawatan = ?, 
                keputusan = ?, 
                keputusan_nama = ?, 
                keputusan_tarikh = ?, 
                status = ?,
                updated_at = NOW() 
                WHERE id = ?");

            $stmt->execute([
                $kos_dahulu,
                $anggaran_kos,
                $syor_ulasan,
                $admin_nama,
                $admin_jawatan,
                $keputusan,
                $kep_nama,
                $kep_tarikh,
                $status,
                $id
            ]);

            // ==========================================
            // KEMASKINI ASET LUPUS AUTOMATIK UNTUK 'Syor Dilupuskan'
            // ==========================================
            if ($keputusan === 'Syor Dilupuskan') {
                $chkDisposal = $pdo->prepare("SELECT id FROM disposed_assets WHERE report_id = ?");
                $chkDisposal->execute([$id]);
                $existingDisposal = $chkDisposal->fetch(PDO::FETCH_ASSOC);

                // Cari rekod padanan dalam staff_assets
                $sa = null;
                $sn = !empty($existingReport['nombor_siri']) ? trim($existingReport['nombor_siri']) : '';
                if (!empty($sn)) {
                    $saStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE serial_number = ? LIMIT 1");
                    $saStmt->execute([$sn]);
                    $sa = $saStmt->fetch(PDO::FETCH_ASSOC);
                }
                if (!$sa && !empty($existingReport['asset_id'])) {
                    $saStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE id = ? LIMIT 1");
                    $saStmt->execute([$existingReport['asset_id']]);
                    $sa = $saStmt->fetch(PDO::FETCH_ASSOC);
                }

                $assetId = $sa['id'] ?? ($existingReport['asset_id'] ?: null);
                $serialNum = $sn ?: ($sa['serial_number'] ?? 'TIADA');
                $noPendaftaran = (!empty($sa['no_siri_pendaftaran'])) ? $sa['no_siri_pendaftaran'] : $serialNum;
                $assetType = !empty($existingReport['jenis_aset']) ? $existingReport['jenis_aset'] : ($sa['asset_type'] ?? 'Desktop PC');
                $model = (!empty($sa['model_komputer'])) ? $sa['model_komputer'] : (!empty($existingReport['jenis_aset']) ? $existingReport['jenis_aset'] : 'Komputer');
                $pegawai = !empty($existingReport['nama_pelapor']) ? $existingReport['nama_pelapor'] : (!empty($existingReport['pengguna_terakhir']) ? $existingReport['pengguna_terakhir'] : ($sa['nama_pegawai'] ?? 'Staf'));
                $jawatan = !empty($existingReport['jawatan_pelapor']) ? $existingReport['jawatan_pelapor'] : ($sa['jawatan'] ?? '');
                $dept = (!empty($sa['jabatan_unit'])) ? $sa['jabatan_unit'] : (!empty($existingReport['location']) ? $existingReport['location'] : 'Majlis Perbandaran Manjung');
                $tLupus = (!empty($kep_tarikh) && $kep_tarikh !== '0000-00-00') ? $kep_tarikh : date('Y-m-d');
                $sebab = !empty($syor_ulasan) ? $syor_ulasan : (!empty($existingReport['perihal_kerosakan']) ? 'Aduan KEW.PA-9: ' . $existingReport['perihal_kerosakan'] : 'Disyorkan lupus melalui kelulusan KEW.PA-9');
                $pelulus = !empty($kep_nama) ? $kep_nama : ($_SESSION['full_name'] ?? 'Super Admin');
                $rujukan = 'KEW.PA-9 #' . str_pad($id, 2, '0', STR_PAD_LEFT);

                if (!$existingDisposal) {
                    $ins = $pdo->prepare("INSERT INTO disposed_assets 
                        (asset_id, report_id, no_siri_pendaftaran, serial_number, asset_type, model_komputer,
                         nama_pegawai, jawatan, jabatan_unit, tarikh_lupus, kaedah_pelupusan,
                         sebab_lupus, no_rujukan_kelulusan, pegawai_pelulus, status)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '-', ?, ?, ?, 'Syor Dilupuskan')");
                    $ins->execute([
                        $assetId, $id, $noPendaftaran, $serialNum, $assetType, $model,
                        $pegawai, $jawatan, $dept, $tLupus, $sebab, $rujukan, $pelulus
                    ]);
                } else {
                    $upd = $pdo->prepare("UPDATE disposed_assets SET 
                        tarikh_lupus = ?, sebab_lupus = ?, pegawai_pelulus = ?, no_rujukan_kelulusan = ?
                        WHERE id = ?");
                    $upd->execute([$tLupus, $sebab, $pelulus, $rujukan, $existingDisposal['id']]);
                }

                // Kemaskini status aset staf kepada 'Dilupuskan'
                if ($assetId) {
                    $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE id = ?")->execute([$assetId]);
                } elseif (!empty($serialNum) && $serialNum !== 'TIADA') {
                    $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE serial_number = ?")->execute([$serialNum]);
                }
            } else {
                // Jika keputusan bukan lagi 'Syor Dilupuskan', padam rekod auto dan kembalikan status aset jika ada
                $pdo->prepare("DELETE FROM disposed_assets WHERE report_id = ?")->execute([$id]);
                if (!empty($existingReport['nombor_siri'])) {
                    $pdo->prepare("UPDATE staff_assets SET status = 'Aktif' WHERE serial_number = ? AND status = 'Dilupuskan'")->execute([trim($existingReport['nombor_siri'])]);
                }
            }

            logAudit($pdo, $_SESSION['user_id'], 'Keputusan KEW.PA-9 (Super Admin)', "Super Admin '{$_SESSION['full_name']}' telah membuat keputusan Bahagian III untuk Laporan ID $id: '$keputusan' ($status).");

            jsonResponse('success', 'Keputusan KEW.PA-9 (Bahagian III) berjaya disimpan.');
        }
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}
?>