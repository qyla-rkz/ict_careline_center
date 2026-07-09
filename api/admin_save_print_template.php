<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$name = $_POST['name'] ?? 'kewpa9';
$template_html = $_POST['template_html'] ?? '';

if (empty($template_html)) {
    echo json_encode(['status' => 'error', 'message' => 'Sila masukkan format cetakan.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE print_templates SET template_html = :html WHERE name = :name");
    $stmt->execute([
        ':html' => $template_html,
        ':name' => $name
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Format cetakan berjaya disimpan.']);
    } else {
        // If row count is 0, it might mean the html is exactly the same, or the name doesn't exist.
        // Let's check if it exists
        $check = $pdo->prepare("SELECT id FROM print_templates WHERE name = :name");
        $check->execute([':name' => $name]);
        if ($check->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Tiada perubahan pada format cetakan.']);
        } else {
            // Insert new template if doesn't exist
            $insert = $pdo->prepare("INSERT INTO print_templates (name, template_html) VALUES (:name, :html)");
            $insert->execute([
                ':name' => $name,
                ':html' => $template_html
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Format cetakan berjaya dicipta dan disimpan.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ralat pangkalan data: ' . $e->getMessage()]);
}
?>
