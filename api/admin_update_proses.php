<?php
// api/admin_update_proses.php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['Admin', 'Super Admin'])) {
    jsonResponse('error', 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $proses_semasa = $_POST['proses_semasa'] ?? '';

    if (!$id) {
        jsonResponse('error', 'ID laporan tidak sah');
    }

    try {
        $stmt = $pdo->prepare("UPDATE reports SET proses_semasa = ? WHERE id = ?");
        if ($stmt->execute([$proses_semasa ?: null, $id])) {
            logAudit($pdo, $_SESSION['user_id'], 'Kemaskini Proses', "Admin '{$_SESSION['full_name']}' kemaskini proses laporan ID $id kepada: '$proses_semasa'.");
            jsonResponse('success', 'Proses semasa berjaya dikemaskini');
        } else {
            jsonResponse('error', 'Gagal kemaskini proses');
        }
    } catch (PDOException $e) {
        jsonResponse('error', $e->getMessage());
    }
}
?>