<?php
// api/setup_print_templates.php
require_once 'config.php';

try {
    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS print_templates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        template_html LONGTEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // Check if default template 'kewpa9' exists
    $stmt = $pdo->prepare("SELECT id FROM print_templates WHERE name = 'kewpa9'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $defaultHtml = <<<HTML
<div style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.5;">
    <div style="text-align: right; font-weight: bold; margin-bottom: 20px;">KEW.PA-9</div>
    <div style="text-align: center; font-weight: bold; font-size: 16px; text-decoration: underline; margin-bottom: 20px;">
        BORANG ADUAN KEROSAKAN ASET ALIH KERAJAAN
    </div>
    
    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 14px; font-weight: bold;">Bahagian I (Untuk diisi oleh Pengadu)</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="padding: 5px; width: 5%;">1.</td>
                <td style="padding: 5px; width: 35%;">Jenis Aset</td>
                <td style="padding: 5px; width: 5%;">:</td>
                <td style="padding: 5px; width: 55%; font-weight: bold;">{{jenis_aset}}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">2.</td>
                <td style="padding: 5px;">Keterangan Aset</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px; font-weight: bold;">{{perihal_aset}}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">3.</td>
                <td style="padding: 5px;">Nombor Siri Pendaftaran</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px; font-weight: bold;">{{no_siri}}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">4.</td>
                <td style="padding: 5px;">Pengguna Terakhir</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px; font-weight: bold;">{{pengguna_terakhir}}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">5.</td>
                <td style="padding: 5px;">Tarikh Kerosakan</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px; font-weight: bold;">{{tarikh_kerosakan}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; vertical-align: top;">6.</td>
                <td style="padding: 5px; vertical-align: top;">Perihal Kerosakan</td>
                <td style="padding: 5px; vertical-align: top;">:</td>
                <td style="padding: 5px; font-weight: bold; min-height: 60px;">{{perihal_kerosakan}}</td>
            </tr>
        </table>

        <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
            <div style="width: 300px; text-align: center;">
                <div style="border-bottom: 1px solid #000; min-height: 30px; margin-bottom: 5px;">{{pengadu_nama}}</div>
                <div>(Tandatangan Pengadu)</div>
                <div style="margin-top: 10px;">Nama: <span style="font-weight: bold;">{{pengadu_nama}}</span></div>
                <div style="margin-top: 5px;">Jawatan: <span style="font-weight: bold;">{{pengadu_jawatan}}</span></div>
                <div style="margin-top: 5px;">Tarikh: <span style="font-weight: bold;">{{tarikh_aduan}}</span></div>
            </div>
        </div>
    </div>
    
    <div style="font-style: italic; font-size: 12px; margin-top: 50px;">
        Nota: Cetakan ini dijana secara automatik oleh sistem.
    </div>
</div>
HTML;
        $insert = $pdo->prepare("INSERT INTO print_templates (name, template_html) VALUES ('kewpa9', ?)");
        $insert->execute([$defaultHtml]);
        echo "Successfully created table and seeded default template.\n";
    } else {
        echo "Table exists and template already seeded.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
