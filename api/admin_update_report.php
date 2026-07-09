<?php
// api/admin_update_report.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kos_dahulu = $_POST['kos_penyelenggaraan_dahulu'] ?? 0;
    $anggaran_kos = $_POST['anggaran_kos'] ?? 0;
    $syor_ulasan = $_POST['syor_ulasan'] ?? '';
    $keputusan = $_POST['keputusan'] ?? '';
    $kep_nama = $_POST['keputusan_nama'] ?? '';
    $kep_tarikh = $_POST['keputusan_tarikh'] ?? '';
    
    $admin_nama = $_POST['pegawai_teknikal_nama'] ?? $_SESSION['full_name'];
    $admin_jawatan = $_POST['pegawai_teknikal_jawatan'] ?? '';
    $status = ($keputusan === 'Tidak Diluluskan') ? 'Rejected' : 'Resolved';

    try {
        $stmt = $pdo->prepare("UPDATE reports SET 
            kos_penyelenggaraan_dahulu = ?, 
            anggaran_kos = ?, 
            syor_ulasan = ?, 
            keputusan = ?, 
            keputusan_nama = ?, 
            keputusan_tarikh = ?, 
            status = ?,
            admin_name_jawatan = ?,
            admin_jawatan = ?,
            admin_tarikh = CURDATE()
            WHERE id = ?");
            
        if ($stmt->execute([
            $kos_dahulu, $anggaran_kos, $syor_ulasan, $keputusan, 
            $kep_nama, $kep_tarikh, $status, $admin_nama, $admin_jawatan, $id
        ])) {
            logAudit($pdo, $_SESSION['user_id'], 'Proses Laporan', "Admin '{$_SESSION['full_name']}' telah memproses Laporan ID $id. Keputusan: '$keputusan' ($status).");
            jsonResponse('success', 'Report updated successfully');
        } else {
            jsonResponse('error', 'Failed to update report');
        }
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>
