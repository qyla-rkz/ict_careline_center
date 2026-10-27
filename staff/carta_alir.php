<?php
// staff/carta_alir.php
$pageTitle = 'Carta Alir KEW.PA-9 - eICT Desk';
$includeMermaid = true;
include 'includes/header.php';
?>

<style>
    @media (max-width: 768px) {
        .panduan-grid-2x2 {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<div class="wide-content active">
    <div class="view active" id="view-carta">
        <a href="dashboard.php" class="back-btn">‹ Kembali</a>
        <div class="view-subheading">KEW.PA-9</div>
        <div class="view-heading">Carta Alir Proses Aduan &amp; Penyelenggaraan Aset</div>

        <div class="view-scroll">
            <!-- PANDUAN ALIRAN KERJA (Diletakkan di atas carta alir dengan susun atur 2x2) -->
            <div style="background:rgba(255,255,255,.9);border:1px solid rgba(37,99,235,.22);border-radius:18px;padding:1.6rem;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                <h4 style="color:#2563eb;font-size:1.15rem;font-weight:800;margin-bottom:1.1rem;display:flex;align-items:center;gap:.6rem;">
                    ℹ️ Panduan Aliran Kerja Laporan Kerosakan
                </h4>
                <div class="panduan-grid-2x2" style="display:grid;grid-template-columns:repeat(2, 1fr);gap:1.2rem;font-size:0.95rem;color:#24324b;">
                    <div style="background:#f8fafc;padding:1.15rem 1.25rem;border-radius:12px;border-left:4px solid #2563eb;box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <strong style="display:block;margin-bottom:.4rem;color:#1e40af;font-size:1.05rem;font-weight:700;">1. Hantar Laporan</strong>
                        <span style="font-size:0.92rem;line-height:1.55;display:block;color:#334155;">Staf mengisi borang KEW.PA-9 dengan nombor siri aset dan perihal kerosakan.</span>
                    </div>
                    <div style="background:#f8fafc;padding:1.15rem 1.25rem;border-radius:12px;border-left:4px solid #f59e0b;box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <strong style="display:block;margin-bottom:.4rem;color:#b45309;font-size:1.05rem;font-weight:700;">2. Semakan Teknikal</strong>
                        <span style="font-size:0.92rem;line-height:1.55;display:block;color:#334155;">Pegawai ICT menerima laporan, memeriksa perkakasan dan mengenal pasti kerosakan.</span>
                    </div>
                    <div style="background:#f8fafc;padding:1.15rem 1.25rem;border-radius:12px;border-left:4px solid #8b5cf6;box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <strong style="display:block;margin-bottom:.4rem;color:#6d28d9;font-size:1.05rem;font-weight:700;">3. Tindakan Baik Pulih</strong>
                        <span style="font-size:0.92rem;line-height:1.55;display:block;color:#334155;">Pembaikan dalaman atau penghantaran aset kepada panel pembekal yang dilantik.</span>
                    </div>
                    <div style="background:#f8fafc;padding:1.15rem 1.25rem;border-radius:12px;border-left:4px solid #10b981;box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <strong style="display:block;margin-bottom:.4rem;color:#047857;font-size:1.05rem;font-weight:700;">4. Kelulusan &amp; Siap</strong>
                        <span style="font-size:0.92rem;line-height:1.55;display:block;color:#334155;">Keputusan diperakukan oleh Ketua Jabatan dan aset sedia untuk diserahkan semula.</span>
                    </div>
                </div>
            </div>

            <!-- CARTA ALIR MERMAID -->
            <div class="flow-card" style="padding:1.5rem;margin-bottom:1.5rem;">
                <div id="portalMermaidFull"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        renderFullCarta();
    });

    function renderFullCarta() {
        const el = document.getElementById('portalMermaidFull');
        if (!el || typeof mermaid === 'undefined') return;

        const graph = `flowchart TD
    classDef default fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-weight:600;
    classDef diamond fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-weight:600;
    A([Mula]) --> B[Isi Maklumat Laporan]
    B --> C[Hantar Laporan]
    C --> D[Semak Laporan]
    D --> E[Ambil Aset Rosak]
    E --> F[Kenal Pasti Masalah]
    F --> G{Boleh Dibaikpulih?}
    G -- Ya --> I[Ganti Komponen]
    G -- Tidak --> H[Hantar ke Panel]
    H --> J[Pembaikian Selesai]
    I --> J
    J --> K{Berjaya Dibaiki?}
    K -- Ya --> M[Kembalikan Aset]
    K -- Tidak --> L[Lupuskan Aset]
    L --> N[Kemaskini Keputusan]
    M --> N
    N --> O[Jana Laporan]
    O --> P[Tandatangan]
    P --> Q([Tamat])
    class G,K diamond;`;

        mermaid.initialize({
            startOnLoad: false,
            theme: 'base',
            themeVariables: {
                primaryColor: '#dbeafe',
                primaryTextColor: '#1e40af',
                primaryBorderColor: '#3b82f6',
                lineColor: '#3b82f6',
                fontSize: '13px'
            }
        });

        mermaid.render('fullCartaSvg', graph).then(({ svg }) => {
            el.innerHTML = svg;
        }).catch(err => {
            console.warn('Mermaid render error:', err);
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
