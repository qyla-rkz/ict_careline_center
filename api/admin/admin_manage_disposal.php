<?php
// api/admin/admin_manage_disposal.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    jsonResponse('error', 'Akses ditolak. Pengurusan Aset Lupus hanya untuk Super Admin.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Kaedah permintaan tidak sah.');
}

$action = $_POST['action'] ?? '';

try {
    // ----------------------------------------------------
    // PADAM REKOD PELUPUSAN
    // ----------------------------------------------------
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $revert = !empty($_POST['revert_status']) && $_POST['revert_status'] === 'yes';

        if (!$id) {
            jsonResponse('error', 'ID Rekod Pelupusan diperlukan.');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT * FROM disposed_assets WHERE id = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            $pdo->rollBack();
            jsonResponse('error', 'Rekod pelupusan tidak dijumpai.');
        }

        // Jika diminta kembalikan status aset staf kepada Aktif
        if ($revert && !empty($record['asset_id'])) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Aktif' WHERE id = ?")->execute([$record['asset_id']]);
        } elseif ($revert && !empty($record['serial_number'])) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Aktif' WHERE serial_number = ?")->execute([$record['serial_number']]);
        }

        $delStmt = $pdo->prepare("DELETE FROM disposed_assets WHERE id = ?");
        $delStmt->execute([$id]);

        $auditDesc = "Super Admin '{$_SESSION['full_name']}' memadam rekod pelupusan ID: $id (S/N: {$record['serial_number']}).";
        if ($revert) $auditDesc .= " Status aset telah dikembalikan kepada Aktif.";
        logAudit($pdo, $_SESSION['user_id'], 'Padam Rekod Lupus (Super Admin)', $auditDesc);

        $pdo->commit();
        jsonResponse('success', 'Rekod pelupusan berjaya dipadam.');
    }

    // ----------------------------------------------------
    // PULIHKAN ASET (RESTORE KE AKTIF)
    // ----------------------------------------------------
    if ($action === 'restore') {
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            jsonResponse('error', 'ID Rekod Pelupusan diperlukan.');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT * FROM disposed_assets WHERE id = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            $pdo->rollBack();
            jsonResponse('error', 'Rekod pelupusan tidak dijumpai.');
        }

        if (!empty($record['asset_id'])) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Aktif' WHERE id = ?")->execute([$record['asset_id']]);
        } elseif (!empty($record['serial_number'])) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Aktif' WHERE serial_number = ?")->execute([$record['serial_number']]);
        }

        $pdo->prepare("DELETE FROM disposed_assets WHERE id = ?")->execute([$id]);

        logAudit($pdo, $_SESSION['user_id'], 'Pulihkan Aset Lupus (Super Admin)', 
            "Super Admin '{$_SESSION['full_name']}' memulihkan aset ID {$record['asset_id']} (S/N: {$record['serial_number']}) kembali ke status Aktif.");

        $pdo->commit();
        jsonResponse('success', 'Aset berjaya dipulihkan kembali ke senarai Aset Staf Aktif.');
    }

    // ----------------------------------------------------
    // SIMPAN / KEMASKINI REKOD PELUPUSAN
    // ----------------------------------------------------
    $id                   = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $asset_id             = !empty($_POST['asset_id']) ? (int)$_POST['asset_id'] : null;
    $report_id            = !empty($_POST['report_id']) ? (int)$_POST['report_id'] : null;
    $serial_number        = trim($_POST['serial_number'] ?? '');
    $no_siri_pendaftaran  = trim($_POST['no_siri_pendaftaran'] ?? '');
    $asset_type           = trim($_POST['asset_type'] ?? 'Desktop PC');
    $model_komputer       = trim($_POST['model_komputer'] ?? '');
    $nama_pegawai         = trim($_POST['nama_pegawai'] ?? '');
    $jawatan              = trim($_POST['jawatan'] ?? '');
    $jabatan_unit         = trim($_POST['jabatan_unit'] ?? '');
    $tarikh_perolehan     = !empty($_POST['tarikh_perolehan']) ? $_POST['tarikh_perolehan'] : null;
    $harga_perolehan_asal = !empty($_POST['harga_perolehan_asal']) ? (float)$_POST['harga_perolehan_asal'] : 0.00;
    $tarikh_lupus         = !empty($_POST['tarikh_lupus']) ? $_POST['tarikh_lupus'] : date('Y-m-d');
    $kaedah_pelupusan     = trim($_POST['kaedah_pelupusan'] ?? '-') ?: '-';
    $sebab_lupus          = trim($_POST['sebab_lupus'] ?? '');
    $no_rujukan_kelulusan = trim($_POST['no_rujukan_kelulusan'] ?? '');
    $pegawai_pelulus      = trim($_POST['pegawai_pelulus'] ?? ($_SESSION['full_name'] ?? 'Super Admin'));
    $catatan              = trim($_POST['catatan'] ?? '');
    $status               = trim($_POST['status'] ?? 'Selesai Dilupuskan');

    if (empty($serial_number) || empty($model_komputer)) {
        jsonResponse('error', 'No. Siri dan Model Aset adalah wajib diisi.');
    }

    if (empty($sebab_lupus)) {
        jsonResponse('error', 'Sebab / Justifikasi Pelupusan adalah wajib diisi.');
    }

    if (empty($no_siri_pendaftaran)) {
        $no_siri_pendaftaran = $serial_number;
    }

    $pdo->beginTransaction();

    // Jika asset_id tidak diberikan tapi ada serial_number, cuba cari dalam staff_assets
    if (empty($asset_id) && !empty($serial_number)) {
        $findStmt = $pdo->prepare("SELECT id FROM staff_assets WHERE serial_number = ? LIMIT 1");
        $findStmt->execute([$serial_number]);
        if ($row = $findStmt->fetch(PDO::FETCH_ASSOC)) {
            $asset_id = (int)$row['id'];
        }
    }

    if ($id) {
        // UPDATE REKOD SEDIA ADA
        $sql = "UPDATE disposed_assets SET
                    asset_id = ?, report_id = ?, no_siri_pendaftaran = ?, serial_number = ?,
                    asset_type = ?, model_komputer = ?, nama_pegawai = ?, jawatan = ?,
                    jabatan_unit = ?, tarikh_perolehan = ?, harga_perolehan_asal = ?,
                    tarikh_lupus = ?, kaedah_pelupusan = ?, sebab_lupus = ?,
                    no_rujukan_kelulusan = ?, pegawai_pelulus = ?, catatan = ?, status = ?
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $asset_id, $report_id, $no_siri_pendaftaran, $serial_number,
            $asset_type, $model_komputer, $nama_pegawai, $jawatan,
            $jabatan_unit, $tarikh_perolehan, $harga_perolehan_asal,
            $tarikh_lupus, $kaedah_pelupusan, $sebab_lupus,
            $no_rujukan_kelulusan, $pegawai_pelulus, $catatan, $status,
            $id
        ]);

        $auditDesc = "Super Admin '{$_SESSION['full_name']}' kemaskini maklumat pelupusan aset ID $id (S/N: $serial_number).";
        logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Aset Lupus (Super Admin)', $auditDesc);

        $pdo->commit();
        jsonResponse('success', 'Maklumat pelupusan aset berjaya dikemaskini.');
    } else {
        // INSERT REKOD BAHARU
        $sql = "INSERT INTO disposed_assets (
                    asset_id, report_id, no_siri_pendaftaran, serial_number,
                    asset_type, model_komputer, nama_pegawai, jawatan,
                    jabatan_unit, tarikh_perolehan, harga_perolehan_asal,
                    tarikh_lupus, kaedah_pelupusan, sebab_lupus,
                    no_rujukan_kelulusan, pegawai_pelulus, catatan, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $asset_id, $report_id, $no_siri_pendaftaran, $serial_number,
            $asset_type, $model_komputer, $nama_pegawai, $jawatan,
            $jabatan_unit, $tarikh_perolehan, $harga_perolehan_asal,
            $tarikh_lupus, $kaedah_pelupusan, $sebab_lupus,
            $no_rujukan_kelulusan, $pegawai_pelulus, $catatan, $status
        ]);
        $newDisposalId = $pdo->lastInsertId();

        // Kemaskini status dalam staff_assets kepada 'Dilupuskan'
        if ($asset_id) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE id = ?")->execute([$asset_id]);
        } elseif ($serial_number) {
            $pdo->prepare("UPDATE staff_assets SET status = 'Dilupuskan' WHERE serial_number = ?")->execute([$serial_number]);
        }

        $auditDesc = "Super Admin '{$_SESSION['full_name']}' melupuskan aset baharu (S/N: $serial_number, Kaedah: $kaedah_pelupusan). ID Pelupusan: $newDisposalId.";
        logAudit($pdo, $_SESSION['user_id'], 'Lupus Aset (Super Admin)', $auditDesc);

        $pdo->commit();
        jsonResponse('success', 'Aset berjaya didaftarkan ke dalam senarai Aset Lupus.');
    }

} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    jsonResponse('error', 'Ralat Pangkalan Data: ' . $e->getMessage());
}
?>
