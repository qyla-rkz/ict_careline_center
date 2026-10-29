<?php
// api/admin/admin_get_disposed_assets.php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    jsonResponse('error', 'Akses ditolak. Pengurusan Aset Lupus hanya untuk Super Admin.');
}

try {
    // 0. Auto-sync mana-mana laporan KEW.PA-9 yang berkeputusan 'Syor Dilupuskan' ke dalam disposed_assets jika belum ada
    $syorReports = $pdo->query("SELECT r.*, u.department as staff_dept, u.jawatan as staff_jawatan_u 
                                FROM reports r 
                                LEFT JOIN users u ON r.user_id = u.id 
                                WHERE r.keputusan = 'Syor Dilupuskan'")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($syorReports as $sr) {
        $check = $pdo->prepare("SELECT id FROM disposed_assets WHERE report_id = ?");
        $check->execute([$sr['id']]);
        $existingDisposal = $check->fetch(PDO::FETCH_ASSOC);

        if (!$existingDisposal) {
            // Cari rekod aset dalam staff_assets
            $sa = null;
            if (!empty($sr['nombor_siri'])) {
                $aStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE serial_number = ? LIMIT 1");
                $aStmt->execute([trim($sr['nombor_siri'])]);
                $sa = $aStmt->fetch(PDO::FETCH_ASSOC);
            }
            if (!$sa && !empty($sr['asset_id'])) {
                $aStmt = $pdo->prepare("SELECT * FROM staff_assets WHERE id = ? LIMIT 1");
                $aStmt->execute([$sr['asset_id']]);
                $sa = $aStmt->fetch(PDO::FETCH_ASSOC);
            }

            $assetId = $sa['id'] ?? ($sr['asset_id'] ?: null);
            $sn = !empty($sr['nombor_siri']) ? trim($sr['nombor_siri']) : ($sa['serial_number'] ?? 'TIADA');
            $noPendaftaran = (!empty($sa['no_siri_pendaftaran'])) ? $sa['no_siri_pendaftaran'] : $sn;
            $assetType = !empty($sr['jenis_aset']) ? $sr['jenis_aset'] : ($sa['asset_type'] ?? 'Desktop PC');
            $model = (!empty($sa['model_komputer'])) ? $sa['model_komputer'] : (!empty($sr['jenis_aset']) ? $sr['jenis_aset'] : 'Komputer');
            $pegawai = !empty($sr['nama_pelapor']) ? $sr['nama_pelapor'] : (!empty($sr['pengguna_terakhir']) ? $sr['pengguna_terakhir'] : ($sa['nama_pegawai'] ?? 'Staf'));
            $jawatan = !empty($sr['jawatan_pelapor']) ? $sr['jawatan_pelapor'] : ($sa['jawatan'] ?? ($sr['staff_jawatan_u'] ?? ''));
            $dept = (!empty($sa['jabatan_unit'])) ? $sa['jabatan_unit'] : (!empty($sr['location']) ? $sr['location'] : ($sr['staff_dept'] ?? 'Unit Teknologi Maklumat'));
            $tLupus = (!empty($sr['keputusan_tarikh']) && $sr['keputusan_tarikh'] !== '0000-00-00') ? $sr['keputusan_tarikh'] : (!empty($sr['created_at']) ? substr($sr['created_at'], 0, 10) : date('Y-m-d'));
            $sebab = !empty($sr['syor_ulasan']) ? $sr['syor_ulasan'] : (!empty($sr['perihal_kerosakan']) ? 'Aduan KEW.PA-9: ' . $sr['perihal_kerosakan'] : 'Disyorkan lupus melalui kelulusan KEW.PA-9');
            $pelulus = !empty($sr['keputusan_nama']) ? $sr['keputusan_nama'] : 'Super Admin';
            $rujukan = 'KEW.PA-9 #' . str_pad($sr['id'], 2, '0', STR_PAD_LEFT);

            $ins = $pdo->prepare("INSERT INTO disposed_assets 
                (asset_id, report_id, no_siri_pendaftaran, serial_number, asset_type, model_komputer,
                 nama_pegawai, jawatan, jabatan_unit, tarikh_lupus, kaedah_pelupusan,
                 sebab_lupus, no_rujukan_kelulusan, pegawai_pelulus, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '-', ?, ?, ?, 'Syor Dilupuskan')");
            $ins->execute([
                $assetId, $sr['id'], $noPendaftaran, $sn, $assetType, $model,
                $pegawai, $jawatan, $dept, $tLupus, $sebab, $rujukan, $pelulus
            ]);

            // Kemaskini status aset staf kepada 'Dilupuskan'
            if ($assetId) {
                $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE id = ?")->execute([$assetId]);
            } elseif (!empty($sn) && $sn !== 'TIADA') {
                $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE serial_number = ?")->execute([$sn]);
            }
        }
    }

    // 1. Dapatkan semua rekod aset lupus (termasuk spesifikasi daripada staff_assets)
    $stmt = $pdo->query("SELECT da.*,
                                sa.id as sa_id,
                                sa.asset_type as sa_asset_type,
                                sa.model_komputer as sa_model_komputer,
                                sa.serial_number as sa_serial_number,
                                sa.no_siri_pendaftaran as sa_no_siri_pendaftaran,
                                sa.model_monitor as sa_model_monitor,
                                sa.serial_monitor as sa_serial_monitor,
                                sa.os as sa_os,
                                sa.processor as sa_processor,
                                sa.ram as sa_ram,
                                sa.hard_disk as sa_hard_disk,
                                sa.mouse as sa_mouse,
                                sa.keyboard as sa_keyboard,
                                sa.ms_office as sa_ms_office,
                                sa.antivirus as sa_antivirus,
                                sa.ip_address as sa_ip_address,
                                sa.printer as sa_printer,
                                sa.perisian_lain as sa_perisian_lain,
                                sa.maklumat_ict as sa_maklumat_ict,
                                sa.nama_pegawai as sa_nama_pegawai,
                                sa.jawatan as sa_jawatan,
                                sa.jabatan_unit as sa_jabatan_unit
                         FROM disposed_assets da
                         LEFT JOIN staff_assets sa ON (da.asset_id IS NOT NULL AND da.asset_id = sa.id) 
                                                   OR (da.asset_id IS NULL AND da.serial_number = sa.serial_number)
                         ORDER BY da.tarikh_lupus DESC, da.id DESC");
    $disposedAssets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dapatkan data sokongan: gambar aset fizikal, laporan KEW.PA-9 penuh dan gambar aduan
    foreach ($disposedAssets as &$da) {
        $assetId = $da['asset_id'] ?: ($da['sa_id'] ?? null);
        if (!$da['asset_id'] && $assetId) {
            $da['asset_id'] = $assetId;
            try {
                $pdo->prepare("UPDATE disposed_assets SET asset_id = ? WHERE id = ?")->execute([$assetId, $da['id']]);
            } catch (Exception $e) {}
        }

        // Lengkapkan medan spec daripada staff_assets jika di disposed_assets kosong
        $da['model_komputer'] = (!empty($da['model_komputer']) && $da['model_komputer'] !== '-') ? $da['model_komputer'] : ($da['sa_model_komputer'] ?? '-');
        $da['serial_number'] = (!empty($da['serial_number']) && $da['serial_number'] !== '-') ? $da['serial_number'] : ($da['sa_serial_number'] ?? '-');
        $da['no_siri_pendaftaran'] = (!empty($da['no_siri_pendaftaran']) && $da['no_siri_pendaftaran'] !== '-') ? $da['no_siri_pendaftaran'] : ($da['sa_no_siri_pendaftaran'] ?? ($da['serial_number'] ?? '-'));
        $da['asset_type'] = (!empty($da['asset_type']) && $da['asset_type'] !== '-') ? $da['asset_type'] : ($da['sa_asset_type'] ?? 'Desktop PC');
        $da['nama_pegawai'] = (!empty($da['nama_pegawai']) && $da['nama_pegawai'] !== '-') ? $da['nama_pegawai'] : ($da['sa_nama_pegawai'] ?? '-');
        $da['jawatan'] = (!empty($da['jawatan']) && $da['jawatan'] !== '-') ? $da['jawatan'] : ($da['sa_jawatan'] ?? '-');
        $da['jabatan_unit'] = (!empty($da['jabatan_unit']) && $da['jabatan_unit'] !== '-') ? $da['jabatan_unit'] : ($da['sa_jabatan_unit'] ?? '-');

        // Spesifikasi terperinci
        $da['model_monitor'] = $da['sa_model_monitor'] ?? '';
        $da['serial_monitor'] = $da['sa_serial_monitor'] ?? '';
        $da['os'] = $da['sa_os'] ?? '';
        $da['processor'] = $da['sa_processor'] ?? '';
        $da['ram'] = $da['sa_ram'] ?? '';
        $da['hard_disk'] = $da['sa_hard_disk'] ?? '';
        $da['mouse'] = $da['sa_mouse'] ?? '';
        $da['keyboard'] = $da['sa_keyboard'] ?? '';
        $da['ms_office'] = $da['sa_ms_office'] ?? '';
        $da['antivirus'] = $da['sa_antivirus'] ?? '';
        $da['ip_address'] = $da['sa_ip_address'] ?? '';
        $da['printer'] = $da['sa_printer'] ?? '';
        $da['perisian_lain'] = $da['sa_perisian_lain'] ?? '';
        $da['maklumat_ict'] = $da['sa_maklumat_ict'] ?? '';

        // Gambar aset fizikal (dari asset_images)
        $da['asset_images'] = [];
        if ($assetId) {
            $imgStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
            $imgStmt->execute([$assetId]);
            $da['asset_images'] = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Laporan KEW.PA-9 Penuh
        $da['kewpa9_report'] = null;
        $repRow = null;

        if (!empty($da['report_id'])) {
            $repStmt = $pdo->prepare("SELECT r.*, 
                                             u.name as reporter_user_name, 
                                             u.email as reporter_user_email, 
                                             u.phone as reporter_user_phone, 
                                             u.department as reporter_user_dept,
                                             u.jawatan as reporter_user_jawatan
                                      FROM reports r 
                                      LEFT JOIN users u ON r.user_id = u.id 
                                      WHERE r.id = ? LIMIT 1");
            $repStmt->execute([$da['report_id']]);
            $repRow = $repStmt->fetch(PDO::FETCH_ASSOC);
        }

        // Jika tiada report_id tapi ada no siri sepadan
        if (!$repRow && !empty($da['serial_number']) && $da['serial_number'] !== 'TIADA') {
            $repStmt = $pdo->prepare("SELECT r.*, 
                                             u.name as reporter_user_name, 
                                             u.email as reporter_user_email, 
                                             u.phone as reporter_user_phone, 
                                             u.department as reporter_user_dept,
                                             u.jawatan as reporter_user_jawatan
                                      FROM reports r 
                                      LEFT JOIN users u ON r.user_id = u.id 
                                      WHERE (r.nombor_siri = ? OR (r.asset_id IS NOT NULL AND r.asset_id = ?))
                                      ORDER BY (r.keputusan = 'Syor Dilupuskan') DESC, r.id DESC LIMIT 1");
            $repStmt->execute([$da['serial_number'], $assetId ?: 0]);
            $repRow = $repStmt->fetch(PDO::FETCH_ASSOC);
            if ($repRow) {
                $da['report_id'] = $repRow['id'];
            }
        }

        if ($repRow) {
            // Gambar bukti kerosakan aduan KEW.PA-9
            $rImgStmt = $pdo->prepare("SELECT image_path FROM report_images WHERE report_id = ?");
            $rImgStmt->execute([$repRow['id']]);
            $repRow['images'] = $rImgStmt->fetchAll(PDO::FETCH_ASSOC);

            // Parsing lampiran_spec jika string JSON
            if (!empty($repRow['lampiran_spec'])) {
                if (is_string($repRow['lampiran_spec'])) {
                    $dec = json_decode($repRow['lampiran_spec'], true);
                    if ($dec && is_array($dec)) {
                        $repRow['lampiran_spec'] = $dec;
                    }
                }
            }

            // Jika ada nilai spec dalam lampiran_spec laporan, guna sebagai fallback jika spec aset kosong
            if (!empty($repRow['lampiran_spec']) && is_array($repRow['lampiran_spec'])) {
                $ls = $repRow['lampiran_spec'];
                if (empty($da['model_monitor']) && !empty($ls['model_monitor'])) $da['model_monitor'] = $ls['model_monitor'];
                if (empty($da['serial_monitor']) && !empty($ls['serial_monitor'])) $da['serial_monitor'] = $ls['serial_monitor'];
                if (empty($da['os']) && !empty($ls['os'])) $da['os'] = $ls['os'];
                if (empty($da['processor']) && !empty($ls['processor'])) $da['processor'] = $ls['processor'];
                if (empty($da['ram']) && !empty($ls['ram'])) $da['ram'] = $ls['ram'];
                if (empty($da['hard_disk']) && !empty($ls['hard_disk'])) $da['hard_disk'] = $ls['hard_disk'];
                if (empty($da['ip_address']) && !empty($ls['ip_address'])) $da['ip_address'] = $ls['ip_address'];
                if (empty($da['printer']) && !empty($ls['printer'])) $da['printer'] = $ls['printer'];
                if (empty($da['mouse']) && !empty($ls['mouse'])) $da['mouse'] = $ls['mouse'];
                if (empty($da['keyboard']) && !empty($ls['keyboard'])) $da['keyboard'] = $ls['keyboard'];
                if (empty($da['ms_office']) && !empty($ls['ms_office'])) $da['ms_office'] = $ls['ms_office'];
                if (empty($da['antivirus']) && !empty($ls['antivirus'])) $da['antivirus'] = $ls['antivirus'];
                if (empty($da['perisian_lain']) && !empty($ls['perisian_lain'])) $da['perisian_lain'] = $ls['perisian_lain'];
            }

            $da['kewpa9_report'] = $repRow;
        }
    }
    unset($da);

    // 2. Dapatkan laporan yang mempunyai keputusan 'Syor Dilupuskan' tetapi belum didaftarkan dalam disposed_assets
    $existingReportIds = array_filter(array_column($disposedAssets, 'report_id'));
    $existingSerialNumbers = array_filter(array_map('trim', array_column($disposedAssets, 'serial_number')));

    $repSql = "SELECT r.id, r.user_id, r.asset_id, r.jenis_aset, r.nombor_siri, 
                      r.pengguna_terakhir, r.nama_pelapor, r.jawatan_pelapor, r.location,
                      r.tarikh_kerosakan, r.perihal_kerosakan, r.syor_ulasan,
                      r.keputusan, r.keputusan_nama, r.keputusan_tarikh, r.created_at,
                      u.name as staff_name, u.department as staff_department, u.jawatan as staff_jawatan
               FROM reports r
               LEFT JOIN users u ON r.user_id = u.id
               WHERE r.keputusan = 'Syor Dilupuskan'
               ORDER BY r.keputusan_tarikh DESC, r.id DESC";
    $repStmt = $pdo->query($repSql);
    $allSyorReports = $repStmt->fetchAll(PDO::FETCH_ASSOC);

    $pendingReports = [];
    foreach ($allSyorReports as $r) {
        $alreadyLogged = false;
        if (!empty($r['id']) && in_array($r['id'], $existingReportIds)) {
            $alreadyLogged = true;
        } elseif (!empty($r['nombor_siri']) && in_array(trim($r['nombor_siri']), $existingSerialNumbers)) {
            $alreadyLogged = true;
        }

        if (!$alreadyLogged) {
            $pendingReports[] = $r;
        }
    }

    // 3. Ringkasan Statistik
    $totalDisposed = count($disposedAssets);
    $totalPendingSyor = count($pendingReports);
    
    // Kaedah breakdown
    $methods = [];
    foreach ($disposedAssets as $da) {
        $k = $da['kaedah_pelupusan'] ?: 'Lain-lain';
        $methods[$k] = ($methods[$k] ?? 0) + 1;
    }

    jsonResponse('success', 'Data aset lupus berjaya dimuat.', [
        'disposed_assets' => $disposedAssets,
        'pending_reports' => $pendingReports,
        'stats' => [
            'total_disposed' => $totalDisposed,
            'total_pending_syor' => $totalPendingSyor,
            'methods' => $methods
        ]
    ]);
} catch (PDOException $e) {
    jsonResponse('error', 'DB Error: ' . $e->getMessage());
}
?>
