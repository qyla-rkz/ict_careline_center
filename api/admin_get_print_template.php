<?php
require_once 'config.php';

header('Content-Type: application/json');

$name = $_GET['name'] ?? 'kewpa9';

try {
    $stmt = $pdo->prepare("SELECT template_html FROM print_templates WHERE name = :name");
    $stmt->execute([':name' => $name]);
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        // Return raw HTML, don't sanitize HTML tags here because it's a template
        echo json_encode([
            'status' => 'success',
            'data' => [
                'template_html' => $row['template_html']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Templat tidak dijumpai.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ralat pangkalan data: ' . $e->getMessage()]);
}
?>
