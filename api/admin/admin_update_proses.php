<?php
// api/admin_update_proses.php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? $_POST['report_id'] ?? 0);
    $proses_semasa = $_POST['proses_semasa'] ?? '';

    if (!$id) {
        jsonResponse('error', 'ID laporan tidak sah');
    }

    try {
        // Pastikan kolum proses_semasa wujud dalam jadual reports
        try {
            $check = $pdo->query("SHOW COLUMNS FROM reports LIKE 'proses_semasa'")->fetch();
            if (!$check) {
                $pdo->exec("ALTER TABLE reports ADD COLUMN proses_semasa VARCHAR(100) DEFAULT NULL");
            }
        } catch (Exception $colEx) {
            // Abaikan jika tidak dapat semak secara langsung
        }

        $stmt = $pdo->prepare("UPDATE reports SET proses_semasa = ? WHERE id = ?");
        if ($stmt->execute([$proses_semasa ?: null, $id])) {
            logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Proses', "Admin '{$_SESSION['full_name']}' kemaskini proses laporan ID $id kepada: '$proses_semasa'.");
            jsonResponse('success', 'Proses semasa berjaya dikemaskini');
        } else {
            jsonResponse('error', 'Gagal kemaskini proses');
        }
    } catch (PDOException $e) {
        // Sekiranya masih berlaku ralat 1054 / 42S22 (Unknown column)
        if ($e->getCode() === '42S22' || strpos($e->getMessage(), '1054') !== false) {
            try {
                $pdo->exec("ALTER TABLE reports ADD COLUMN proses_semasa VARCHAR(100) DEFAULT NULL");
                $stmt = $pdo->prepare("UPDATE reports SET proses_semasa = ? WHERE id = ?");
                if ($stmt->execute([$proses_semasa ?: null, $id])) {
                    logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Proses', "Admin '{$_SESSION['full_name']}' kemaskini proses laporan ID $id kepada: '$proses_semasa'.");
                    jsonResponse('success', 'Proses semasa berjaya dikemaskini');
                }
            } catch (Exception $retryEx) {
                jsonResponse('error', $retryEx->getMessage());
            }
        }
        jsonResponse('error', $e->getMessage());
    }
}
?>