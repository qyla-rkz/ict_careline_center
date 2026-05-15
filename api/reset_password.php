<?php
// api/reset_password.php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Kaedah permintaan tidak sah');
}

$token    = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if (empty($token) || empty($password) || empty($confirm)) {
    jsonResponse('error', 'Semua medan diperlukan');
}

if (strlen($password) < 6) {
    jsonResponse('error', 'Kata laluan mestilah sekurang-kurangnya 6 aksara');
}

if ($password !== $confirm) {
    jsonResponse('error', 'Kata laluan tidak sepadan');
}

try {
    // Validate token
    $stmt = $pdo->prepare("
        SELECT * FROM password_resets 
        WHERE token = ? AND used = 0 AND expires_at > NOW()
        LIMIT 1
    ");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if (!$reset) {
        jsonResponse('error', 'Pautan tetapan semula tidak sah atau telah tamat tempoh.');
    }

    // Update user password
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hashed, $reset['email']]);

    if ($stmt->rowCount() === 0) {
        jsonResponse('error', 'Pengguna tidak dijumpai');
    }

    // Mark token as used
    $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = ?")->execute([$token]);

    jsonResponse('success', 'Kata laluan berjaya ditetapkan semula. Sila log masuk.');

} catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    jsonResponse('error', 'Ralat pangkalan data. Sila cuba lagi.');
}
?>
