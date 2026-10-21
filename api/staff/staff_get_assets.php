<?php
// api/staff_get_assets.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id'])) {
    jsonResponse('error', 'Not logged in');
}

try {
    $userId = $_SESSION['user_id'];
    $fullName = trim($_SESSION['full_name'] ?? '');

    // Auto-link any asset where user_id is NULL or 0, but nama_pegawai matches current user's name
    if (!empty($fullName)) {
        try {
            $linkStmt = $pdo->prepare("UPDATE staff_assets SET user_id = ? WHERE (user_id IS NULL OR user_id = 0) AND LOWER(TRIM(nama_pegawai)) = LOWER(?)");
            $linkStmt->execute([$userId, $fullName]);
        } catch (Exception $e) {
            // Silently continue
        }
    }

    $stmt = $pdo->prepare("SELECT sa.*, 
                                  COALESCE(u.name, sa.nama_pegawai) as display_name,
                                  COALESCE(u.department, sa.jabatan_unit) as display_dept,
                                  COALESCE(u.jawatan, sa.jawatan) as display_jawatan
                           FROM staff_assets sa
                           LEFT JOIN users u ON sa.user_id = u.id
                           WHERE sa.user_id = ? 
                              OR (sa.user_id IS NULL AND LOWER(TRIM(sa.nama_pegawai)) = LOWER(?))
                           ORDER BY sa.created_at DESC, sa.id DESC");
    $stmt->execute([$userId, $fullName]);
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch images for each asset
    foreach ($assets as &$asset) {
        $imgStmt = $pdo->prepare("SELECT image_path FROM asset_images WHERE asset_id = ?");
        $imgStmt->execute([$asset['id']]);
        $asset['images'] = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    jsonResponse('success', 'Assets fetched', $assets);
} catch (PDOException $e) {
    jsonResponse('error', $e->getMessage());
}
?>
