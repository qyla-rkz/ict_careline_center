<?php
// api/reset_print_template.php
// Run this once to update the database template to the full KEW.PA-9 format
require_once 'config.php';

$fullTemplate = <<<'HTML'
<div style="font-family: 'Times New Roman', Times, serif; color: #000; background: #fff; padding: 10px;">

    <div style="text-align: right; font-size: 11pt; font-style: italic; margin-bottom: 8px;">KEW.PA-9</div>
    <div style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 13pt; margin-bottom: 20px;">BORANG ADUAN KEROSAKAN ASET ALIH</div>

    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 8px;">Bahagian I (Untuk diisi oleh Pengadu)</div>
    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
        <div style="flex: 1;">
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">1. Jenis Aset</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{jenis_aset}}</div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">2. No. Siri Pendaftaran</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{no_siri}}</div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">3. Pengguna Terakhir</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{pengguna_terakhir}}</div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">4. Tarikh Kerosakan</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{tarikh_kerosakan}}</div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">5. Perihal Kerosakan</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{perihal_kerosakan}}</div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">6. Nama Dan Jawatan</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; display: flex; flex-direction: column;">
                    <div style="border-bottom: 1px solid #000; padding-left: 4px; min-height: 1.8em;">{{pengadu_nama}}</div>
                    <div style="border-bottom: 1px solid #000; padding-left: 4px; min-height: 1.8em;">{{pengadu_jawatan}}</div>
                </div>
            </div>
            <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
                <div style="min-width: 160px; flex-shrink: 0;">7. Tarikh</div>
                <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
                <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{tarikh_aduan}}</div>
            </div>
        </div>
        <div style="border: 1px solid #000; padding: 12px; width: 240px; font-size: 9pt; display: flex; flex-direction: column; min-height: 160px;">
            <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">PENGESAHAN PENGADU</div>
            <div style="font-size: 8pt; text-align: center; margin-bottom: auto;">Adalah disahkan kerosakan aset di atas telah selesai dibaiki / diselenggara.</div>
            <div style="margin-top: auto; text-align: center;">
                <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 2px;"></div>
                <div style="font-size: 8pt;">(Tandatangan &amp; Cop)</div>
                <div style="font-size: 8pt; margin-top: 5px; text-align: left;">Tarikh:</div>
            </div>
        </div>
    </div>

    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 8px;">Bahagian II (Untuk diisi oleh Pegawai Aset / Pegawai Teknikal)</div>
    <div style="margin-bottom: 8px;">
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8; align-items: flex-start;">
            <div style="min-width: 240px; flex-shrink: 0;">1. Jumlah Kos Penyelenggaraan<br>&nbsp;&nbsp;&nbsp;Terdahulu</div>
            <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{kos_dahulu}}</div>
        </div>
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
            <div style="min-width: 240px; flex-shrink: 0;">2. Anggaran Kos Penyelenggaraan</div>
            <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{anggaran_kos}}</div>
        </div>
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
            <div style="min-width: 240px; flex-shrink: 0;">3. Syor Dan Ulasan</div>
            <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{syor_ulasan}}</div>
        </div>
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
            <div style="min-width: 240px; flex-shrink: 0;"></div>
            <div style="width: 10px; flex-shrink: 0;"></div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">&nbsp;</div>
        </div>
    </div>
    <div style="margin-bottom: 20px;">
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
            <div style="min-width: 240px; flex-shrink: 0;">4. Nama Dan Jawatan</div>
            <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{admin_nama}}</div>
        </div>
        <div style="display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;">
            <div style="min-width: 240px; flex-shrink: 0;">5. Tarikh</div>
            <div style="width: 10px; text-align: center; flex-shrink: 0;">:</div>
            <div style="flex: 1; border-bottom: 1px solid #000; padding-left: 4px;">{{admin_tarikh}}</div>
        </div>
    </div>

    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 8px;">Bahagian III (Keputusan Ketua Jabatan / Bahagian / Seksyen / Unit dari ICT)</div>
    <div style="font-size: 10pt; margin-bottom: 25px; font-weight: bold;">{{keputusan_line}}</div>

    <div style="margin-top: 15px;">
        <div style="text-align: center; width: 250px; display: inline-block;">
            <div style="border-bottom: 1px solid #000; height: 120px; margin-bottom: 3px;"></div>
            <div style="font-size: 10pt; margin-bottom: 12px;">Tandatangan</div>
        </div>
        <div style="display: flex; font-size: 10pt; line-height: 1.8;">
            <div style="width: 70px; flex-shrink: 0;">Nama:</div>
            <div style="width: 350px; border-bottom: 1px solid #000; padding-left: 4px;">{{kep_nama}}</div>
        </div>
        <div style="display: flex; font-size: 10pt; line-height: 1.8;">
            <div style="width: 70px; flex-shrink: 0;">Jawatan:</div>
            <div style="width: 350px; border-bottom: 1px solid #000; padding-left: 4px;">{{kep_jawatan}}</div>
        </div>
        <div style="display: flex; font-size: 10pt; line-height: 1.8;">
            <div style="width: 70px; flex-shrink: 0;">Tarikh:</div>
            <div style="width: 350px; border-bottom: 1px solid #000; padding-left: 4px;">{{kep_tarikh}}</div>
        </div>
    </div>

    <div style="font-size: 9pt; margin-top: 30px; font-style: italic;">Nota: * Potong mana yang berkenaan</div>
</div>
HTML;

try {
    $stmt = $pdo->prepare("UPDATE print_templates SET template_html = :html WHERE name = 'kewpa9'");
    $stmt->execute([':html' => $fullTemplate]);
    echo "Template updated successfully with full KEW.PA-9 format.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
