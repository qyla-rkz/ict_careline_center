<?php
// api/config.php

// Simple .env parser function
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env file from the root directory
loadEnv(__DIR__ . '/../.env');

$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    // Log actual error to file here in production instead of showing it
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed. Please contact administrator.']);
    exit;
}

function sanitizeOutput($data) {
    if (is_string($data)) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    if (is_array($data)) {
        $clean = [];
        foreach ($data as $key => $value) {
            $clean[$key] = sanitizeOutput($value);
        }
        return $clean;
    }
    return $data;
}

if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => sanitizeOutput($data)
        ]);
        exit;
    }
}

if (!function_exists('logAudit')) {
    function logAudit($pdo, $user_id, $action, $details = null) {
        try {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
            $stmt = $pdo->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $action, $details, $ip]);
        } catch (Exception $e) {
            // Fail silently — jangan ganggu response utama
        }
    }
}
?>
