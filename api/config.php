<?php
// api/config.php

// Simple .env parser function
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || strpos($trimmed, '#') === 0) continue; // Skip empty and comments
        if (strpos($trimmed, '=') === false) continue;
        list($name, $value) = explode('=', $trimmed, 2);
        $name = trim($name);
        $value = trim($value);
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
            (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

// Load .env file from the root directory
loadEnv(__DIR__ . '/../.env');

$db_host = $_ENV['DB_HOST'] ?? (getenv('DB_HOST') ?: 'localhost');
$db_port = $_ENV['DB_PORT'] ?? (getenv('DB_PORT') ?: '3306');
$db_name = $_ENV['DB_NAME'] ?? (getenv('DB_NAME') ?: 'ict_careline');
$db_user = $_ENV['DB_USER'] ?? (getenv('DB_USER') ?: 'root');
$db_pass = $_ENV['DB_PASS'] ?? (getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

try {
    $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    error_log("Database connection error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed. Please contact administrator.']);
    exit;
}

function sanitizeOutput($data) {
    if (is_string($data)) {
        $trimmed = trim($data);
        if ($trimmed !== '' && ($trimmed[0] === '{' || $trimmed[0] === '[')) {
            $testJson = json_decode($data);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        }
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
            $stmt = $pdo->prepare("INSERT INTO audit_logs (user_id, action, details) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $action, $details]);
        } catch (Exception $e) {
            // Fail silently — jangan ganggu response utama
        }
    }
}
?>
