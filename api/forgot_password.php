<?php
// api/forgot_password.php
header('Content-Type: application/json');
require_once 'config.php';

// Load SMTP config (try Database system_settings first, then fallback to .env)
$settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings");
    if ($stmt) {
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
} catch (PDOException $e) {
    // Fail silently if table doesn't exist yet
}

$smtp_host = !empty($settings['smtp_host']) ? $settings['smtp_host'] : (getenv('SMTP_HOST') ?: 'smtp.gmail.com');
$smtp_user = !empty($settings['smtp_username']) ? $settings['smtp_username'] : (getenv('SMTP_USER') ?: '');
$smtp_pass = !empty($settings['smtp_password']) ? $settings['smtp_password'] : (getenv('SMTP_PASS') ?: '');
$smtp_port = !empty($settings['smtp_port']) ? $settings['smtp_port'] : (getenv('SMTP_PORT') ?: 587);
$app_url   = getenv('APP_URL') ?: 'http://localhost/ict_careline_center';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Kaedah permintaan tidak sah');
}

$email = trim($_POST['email'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse('error', 'Sila masukkan alamat emel yang sah');
}

try {
    // Check if email exists in users table
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Always respond success to prevent email enumeration
    if (!$user) {
        jsonResponse('success', 'Jika emel anda berdaftar, pautan tetapan semula telah dihantar.');
    }

    // Delete any old unused tokens for this email
    $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

    // Generate secure token
    $token = bin2hex(random_bytes(32)); // 64 char hex
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expires]);

    // Build reset link
    $reset_link = $app_url . '/reset_password.php?token=' . $token;

    // ─── Send Email via PHPMailer ───
    require_once __DIR__ . '/../phpmailer/PHPMailer.php';
    require_once __DIR__ . '/../phpmailer/SMTP.php';
    require_once __DIR__ . '/../phpmailer/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_user;
    $mail->Password   = $smtp_pass;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int)$smtp_port;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($smtp_user, 'eICT Desk');
    $mail->addAddress($email, $user['name']);
    $mail->Subject = 'Tetapan Semula Kata Laluan - eICT Desk';
    $mail->isHTML(true);
    $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head><meta charset="UTF-8"></head>
    <body style="font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 20px;">
        <div style="max-width: 500px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
            <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); padding: 2rem; text-align: center;">
                <div style="font-size: 2.5rem;">🔐</div>
                <h1 style="color: #fff; margin: 0.5rem 0 0; font-size: 1.4rem;">eICT Desk</h1>
            </div>
            <div style="padding: 2rem;">
                <p style="color: #374151; font-size: 1rem;">Salam, <strong>' . htmlspecialchars($user['name']) . '</strong>,</p>
                <p style="color: #6b7280; font-size: 0.9rem; line-height: 1.6;">
                    Kami menerima permintaan untuk menetapkan semula kata laluan akaun anda.<br>
                    Klik butang di bawah untuk menetapkan kata laluan baru.
                </p>
                <div style="text-align: center; margin: 2rem 0;">
                    <a href="' . $reset_link . '" 
                       style="display: inline-block; padding: 0.9rem 2rem; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1rem;">
                        Tetapkan Semula Kata Laluan
                    </a>
                </div>
                <p style="color: #9ca3af; font-size: 0.8rem; text-align: center;">
                    ⏱️ Pautan ini akan tamat tempoh dalam <strong>1 jam</strong>.<br>
                    Jika anda tidak membuat permintaan ini, abaikan emel ini.
                </p>
                <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1.5rem 0;">
                <p style="color: #d1d5db; font-size: 0.75rem; text-align: center;">
                    © 2026 Unit Teknologi Maklumat, Majlis Perbandaran Muar
                </p>
            </div>
        </div>
    </body>
    </html>';

    $mail->AltBody = "Klik pautan berikut untuk tetapan semula kata laluan:\n$reset_link\n\nPautan tamat tempoh dalam 1 jam.";

    $mail->send();

    jsonResponse('success', 'Pautan tetapan semula telah dihantar ke emel anda. Sila semak peti masuk anda.');

} catch (\PHPMailer\PHPMailer\Exception $e) {
    error_log('Mailer Error: ' . $e->getMessage());
    jsonResponse('error', 'Gagal menghantar emel. Sila hubungi admin ICT.');
} catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    jsonResponse('error', 'Ralat pangkalan data. Sila cuba lagi.');
}
?>
