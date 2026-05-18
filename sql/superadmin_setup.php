<?php
// sql/superadmin_setup.php
require_once __DIR__ . '/../api/config.php';

try {
    // 1. Add status column to users if it doesn't exist
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS status ENUM('active', 'suspended') DEFAULT 'active' AFTER role");

    // 2. Create audit_logs table
    $pdo->exec("CREATE TABLE IF NOT EXISTS audit_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action VARCHAR(100) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // 3. Create system_settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS system_settings (
        setting_key VARCHAR(50) PRIMARY KEY,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Insert default settings if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM system_settings");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO system_settings (setting_key, setting_value) VALUES 
            ('maintenance_mode', '0'),
            ('smtp_host', 'smtp.gmail.com'),
            ('smtp_port', '587'),
            ('smtp_username', ''),
            ('smtp_password', '')
        ");
    }

    echo "Database setup for Super Admin completed successfully.\n";
} catch (PDOException $e) {
    echo "Error setting up database: " . $e->getMessage() . "\n";
}
?>
