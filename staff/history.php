<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Laporan - eICT Desk</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <style>
        @media print {
            @page { size: A4 portrait; margin: 15mm 18mm; }
            body * { visibility: hidden !important; }
            #printableArea, #printableArea * { visibility: visible !important; }
            #printableArea { position: absolute; left: 0; top: 0; width: 100%; display: block !important; }
            .no-print { display: none !important; }
        }
        #printableArea { font-family: 'Times New Roman', Times, serif; color: #000; background: #fff; }
        #printableArea .pa9-title { text-align: right; font-size: 11pt; font-style: italic; margin-bottom: 8px; }
        #printableArea .pa9-heading { text-align: center; font-weight: bold; text-decoration: underline; font-size: 13pt; margin-bottom: 20px; }
        #printableArea .pa9-section-title { font-weight: bold; font-size: 10pt; margin-bottom: 8px; }
        #printableArea .pa9-row { display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8; }
        #printableArea .pa9-label { min-width: 160px; flex-shrink: 0; }
        #printableArea .pa9-colon { width: 10px; text-align: center; flex-shrink: 0; }
        #printableArea .pa9-value { flex: 1; border-bottom: 1px solid #000; padding-left: 4px; }
        #printableArea .pa9-box { border: 1px solid #000; padding: 12px; width: 240px; font-size: 9pt; display: flex; flex-direction: column; min-height: 160px; }
        #printableArea .pa9-sign-block { margin-top: 15px; }
        #printableArea .pa9-sign-line { border-bottom: 1px solid #000; height: 30px; width: 280px; margin-bottom: 3px; }
        #printableArea .pa9-sign-row { display: flex; font-size: 10pt; line-height: 1.8; }
        #printableArea .pa9-sign-label { width: 70px; flex-shrink: 0; }
        #printableArea .pa9-sign-value { flex: none; width: 350px; border-bottom: 1px solid #000; padding-left: 4px; }
        #printableArea .pa9-nota { font-size: 9pt; margin-top: 30px; font-style: italic; }
        #printableArea .pa9-bahagian2-label { min-width: 240px; flex-shrink: 0; }

        /* Disable card hover lift on history table */
        section .card:hover {
            transform: none !important;
            box-shadow: var(--shadow) !important;
            border-color: var(--border) !important;
        }
    </style>
    <script src="../assets/js/global.js?v=10"></script>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <img src="../assets/images/logo-mpm.png" alt="MPM Logo" class="logo-image">
                <h2>eICT Desk</h2>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="assets.php" class="nav-link">🖥️ Aset Saya</a>
                <a href="report_form.php" class="nav-link">📝 Hantar KEW.PA-9</a>
                <a href="history.php" class="nav-link active">📜 Laporan Saya</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0).php" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪 Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Staff Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Laporan Saya</h2>
                </div>
                <div id="current-date" style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date will be loaded here -->
                </div>
            </header>

            <section>
                <h1>Sejarah Penghantaran</h1>
                <p class="text-muted" style="margin-bottom: 2rem;">Menjejaki semua laporan KEW.PA-9 anda.</p>

                <!-- Filter Bar -->
                <div style="display: flex; gap: 1.25rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; background: rgba(0,0,0,0.01); padding: 1.25rem 1.5rem; border-radius: 16px; border: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <label for="filterYear" style="font-weight: 700; font-size: 0.9rem; color: var(--text-muted);">Tahun:</label>
                        <select id="filterYear" onchange="filterHistory()" style="padding: 0.6rem 1.25rem; border-radius: 12px; border: 1px solid var(--border); font-weight: 600; font-size: 0.9rem; background: var(--bg-card); color: var(--text-main); min-width: 130px; outline: none; transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                            <option value="">Semua Tahun</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <label for="filterMonth" style="font-weight: 700; font-size: 0.9rem; color: var(--text-muted);">Bulan:</label>
                        <select id="filterMonth" onchange="filterHistory()" style="padding: 0.6rem 1.25rem; border-radius: 12px; border: 1px solid var(--border); font-weight: 600; font-size: 0.9rem; background: var(--bg-card); color: var(--text-main); min-width: 160px; outline: none; transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                            <option value="">Semua Bulan</option>
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Mac</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Jun</option>
                            <option value="6">Julai</option>
                            <option value="7">Ogos</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Disember</option>
                        </select>
                    </div>
                    <div style="margin-left: auto; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.75rem; font-weight: 600; background: #fff; padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid var(--border);">
                        <span style="color: var(--text-muted); border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; margin-bottom: 0.25rem;">Petunjuk Proses/Keputusan:</span>
                        <span style="display:flex;align-items:center;gap:0.5rem;"><span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;"></span> Baru / Dalam Proses</span>
                        <span style="display:flex;align-items:center;gap:0.5rem;"><span style="width:10px;height:10px;border-radius:50%;background:#10b981;"></span> Selesai / Diluluskan</span>
                        <span style="display:flex;align-items:center;gap:0.5rem;"><span style="width:10px;height:10px;border-radius:50%;background:#ef4444;"></span> Ditolak / Tidak Diluluskan</span>
                        <span style="display:flex;align-items:center;gap:0.5rem;"><span style="width:10px;height:10px;border-radius:50%;background:#64748b;"></span> Syor Dilupuskan</span>
                    </div>
                </div>

                <div class="card table-card">
                    <div style="overflow-x: auto; min-height: 420px;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 2px solid var(--border);">
                                    <th style="padding: 1.25rem 1rem;">ID</th>
                                    <th style="padding: 1.25rem 1rem;">Jenis Aset</th>
                                    <th style="padding: 1.25rem 1rem;">Tarikh Dihantar</th>
                                    <th style="padding: 1.25rem 1rem;">Tarikh Siap</th>
                                    <th style="padding: 1.25rem 1rem;">Pematuhan ISO</th>
                                    <th style="padding: 1.25rem 1rem;">Proses</th>
                                    <th style="padding: 1.25rem 1rem;">Keputusan</th>
                                    <th style="padding: 1.25rem 1rem; text-align:center;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                <!-- Data loaded via JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div id="paginationControls" style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 1rem;">
                        <div id="paginationInfo" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;"></div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <button id="btnPrev" onclick="changePage(currentPage - 1)" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 10px; font-weight: 600; display:inline-flex; align-items:center; gap:0.35rem;">← Sebelum</button>
                            <div id="pageNumbers" style="display: flex; gap: 0.35rem;"></div>
                            <button id="btnNext" onclick="changePage(currentPage + 1)" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 10px; font-weight: 600; display:inline-flex; align-items:center; gap:0.35rem;">Seterus →</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content" style="max-width: 860px; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>Butiran Laporan KEW.PA-9</h2>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Bahagian I -->
                <div>
                    <h4 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Bahagian I: Maklumat Pengadu</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group"><label>Jenis Aset</label><input type="text" id="d_jenis" class="form-control" readonly></div>
                        <div class="form-group"><label>No. Siri Pendaftaran</label><input type="text" id="d_siri" class="form-control" readonly></div>
                        <div class="form-group"><label>Pengguna Terakhir</label><input type="text" id="d_pengguna" class="form-control" readonly></div>
                        <div class="form-group"><label>Tarikh Kerosakan</label><input type="text" id="d_tarikh_rosak" class="form-control" readonly></div>
                        <div class="form-group"><label>Nama Pelapor &amp; Jawatan</label><input type="text" id="d_nama_jawatan" class="form-control" readonly></div>
                        <div class="form-group"><label>Lokasi</label><input type="text" id="d_lokasi" class="form-control" readonly></div>
                    </div>
                    <div class="form-group"><label>Perihal Kerosakan</label><textarea id="d_perihal" class="form-control" rows="3" readonly></textarea></div>
                    <div class="form-group"><label>Tarikh Aduan</label><input type="text" id="d_created_at" class="form-control" readonly></div>
                </div>

                <!-- Bahagian II -->
                <div>
                    <h4 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Bahagian II: Penemuan Teknikal</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group"><label>Kos Penyelenggaraan Terdahulu (RM)</label><input type="text" id="d_kos_dahulu" class="form-control" readonly></div>
                        <div class="form-group"><label>Anggaran Kos Penyelenggaraan (RM)</label><input type="text" id="d_anggaran_kos" class="form-control" readonly></div>
                    </div>
                    <div class="form-group"><label>Syor Dan Ulasan</label><textarea id="d_syor" class="form-control" rows="3" readonly></textarea></div>
                    <div class="form-group"><label>Nama Pegawai Teknikal</label><input type="text" id="d_admin_nama" class="form-control" readonly></div>
                    <div class="form-group"><label>Jawatan Pegawai Teknikal</label><input type="text" id="d_admin_jawatan" class="form-control" readonly></div>
                    <div class="form-group"><label>Tarikh Siap (Admin ICT)</label><input type="text" id="d_admin_tarikh" class="form-control" readonly></div>
                </div>

                <!-- Proses Semasa (Web Only) -->
                <div style="background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(168,85,247,0.05)); border: 1px solid rgba(99,102,241,0.2); border-radius: 12px; padding: 1.25rem;">
                    <h4 style="color: #6366f1; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem;">
                        🔄 Proses Semasa <span style="font-size: 0.7rem; background: #6366f1; color: white; padding: 0.15rem 0.5rem; border-radius: 20px; font-weight: 600;">WEB SAHAJA</span>
                    </h4>
                    <div id="d_proses_semasa" style="font-size: 0.95rem; font-weight: 600; color: var(--text-main);">—</div>
                </div>

                <!-- Bahagian III -->
                <div>
                    <h4 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                        Bahagian III: Keputusan</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group"><label>Keputusan</label><input type="text" id="d_keputusan" class="form-control" readonly></div>
                        <div class="form-group"><label>Nama Ketua</label><input type="text" id="d_kep_nama" class="form-control" readonly></div>
                        <div class="form-group"><label>Tarikh Keputusan</label><input type="text" id="d_kep_tarikh" class="form-control" readonly></div>
                        <div class="form-group">
                            <label>Pematuhan ISO (&lt;14 hari)</label>
                            <div id="d_iso_badge" style="padding-top: 0.5rem;"></div>
                        </div>
                    </div>
                </div>

                <!-- Gambar Lampiran -->
                <div>
                    <h4 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">Gambar Lampiran</h4>
                    <div id="d_images"></div>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 1rem;">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary" style="flex: 1; padding: 0.75rem 1.5rem;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Printable KEW.PA-9 -->
    <div id="printableArea" style="display: none; padding: 10px;">
        <div class="pa9-title">KEW.PA-9</div>
        <div class="pa9-heading">BORANG ADUAN KEROSAKAN ASET ALIH</div>
        <div class="pa9-section-title">Bahagian I (Untuk diisi oleh Pengadu)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row"><div class="pa9-label">1. Jenis Aset</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_jenis"></div></div>
                <div class="pa9-row"><div class="pa9-label">2. No. Siri Pendaftaran</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_siri"></div></div>
                <div class="pa9-row"><div class="pa9-label">3. Pengguna Terakhir</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_pengguna"></div></div>
                <div class="pa9-row"><div class="pa9-label">4. Tarikh Kerosakan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_tarikh_rosak"></div></div>
                <div class="pa9-row"><div class="pa9-label">5. Perihal Kerosakan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_perihal"></div></div>
                <div class="pa9-row">
                    <div class="pa9-label">6. Nama Dan Jawatan</div>
                    <div class="pa9-colon">:</div>
                    <div style="flex:1; display:flex; flex-direction:column;">
                        <div class="pa9-value" id="pr_nama" style="min-height: 18px; margin-bottom: 5px;"></div>
                        <div class="pa9-value" id="pr_jawatan" style="min-height: 18px;"></div>
                    </div>
                </div>
                <div class="pa9-row"><div class="pa9-label">7. Tarikh</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_tarikh_aduan"></div></div>
            </div>
            <div class="pa9-box">
                <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">PENGESAHAN PENGADU</div>
                <div style="font-size: 8pt; text-align: center; margin-bottom: auto;">Adalah disahkan kerosakan aset di atas telah selesai dibaiki / diselenggara.</div>
                <div style="margin-top: auto; text-align: center;">
                    <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 2px;"></div>
                    <div style="font-size: 8pt;">(Tandatangan &amp; Cop)</div>
                    <div style="font-size: 8pt; margin-top: 5px; text-align: left;">Tarikh:</div>
                </div>
            </div>
        </div>
        <div class="pa9-section-title">Bahagian II (Untuk diisi oleh Pegawai Aset / Pegawai Teknikal)</div>
        <div style="margin-bottom: 8px;">
            <div class="pa9-row"><div class="pa9-bahagian2-label">1. Jumlah Kos Penyelenggaraan<br>&nbsp;&nbsp;&nbsp;Terdahulu</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_kos_dahulu"></div></div>
            <div class="pa9-row"><div class="pa9-bahagian2-label">2. Anggaran Kos Penyelenggaraan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_anggaran_kos"></div></div>
            <div class="pa9-row"><div class="pa9-bahagian2-label">3. Syor Dan Ulasan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_syor"></div></div>
        </div>
        <div style="margin-bottom: 20px;">
            <div class="pa9-row"><div class="pa9-bahagian2-label">4. Nama Dan Jawatan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_admin_nama"></div></div>
            <div class="pa9-row"><div class="pa9-bahagian2-label">5. Tarikh</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_admin_tarikh"></div></div>
        </div>
        <div class="pa9-section-title">Bahagian III (Keputusan Ketua Jabatan / Bahagian / Seksyen / Unit)</div>
        <div id="pr_keputusan_line" style="font-size: 10pt; margin-bottom: 25px;">Diluluskan/ Tidak Diluluskan/ Syor Dilupuskan*</div>
        <div class="pa9-sign-block">
            <div style="text-align: center; width: 250px;">
                <div style="border-bottom: 1px solid #000; height: 120px; margin-bottom: 3px;"></div>
                <div style="font-size: 10pt; margin-bottom: 12px;">Tandatangan</div>
            </div>
            <div class="pa9-sign-row"><div class="pa9-sign-label">Nama:</div><div class="pa9-sign-value" id="pr_kep_nama"></div></div>
            <div class="pa9-sign-row"><div class="pa9-sign-label">Jawatan:</div><div class="pa9-sign-value" id="pr_kep_jawatan"></div></div>
            <div class="pa9-sign-row"><div class="pa9-sign-label">Tarikh:</div><div class="pa9-sign-value" id="pr_kep_tarikh"></div></div>
        </div>
        <div class="pa9-nota">Nota: * Potong mana yang berkenaan</div>
    </div>

    <script>
        async function handleLogout() {
            try {
                await fetch("../api/logout.php");
            } catch (err) {}
            sessionStorage.clear();
            sessionStorage.clear();
            window.location.replace('../login.php');
        }

        let reportsData = [];
        let filteredData = [];
        let currentPage = 1;
        const PAGE_SIZE = 10;

        document.addEventListener('DOMContentLoaded', () => {
            const dateOpts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('current-date').textContent = new Date().toLocaleDateString('ms-MY', dateOpts);
            fetchHistory();
        });

        async function fetchHistory() {
            try {
                const response = await fetch("../api/staff_get_history.php");
                const result = await response.json();
                if (result.status === 'success') {
                    reportsData = result.data;

                    // Populate Year Dropdown dynamically
                    const years = [...new Set(reportsData.map(r => new Date(r.created_at).getFullYear()))].sort((a, b) => b - a);
                    const yearSelect = document.getElementById('filterYear');
                    yearSelect.innerHTML = '<option value="">Semua Tahun</option>';
                    years.forEach(yr => {
                        if (!isNaN(yr)) {
                            const opt = document.createElement('option');
                            opt.value = yr;
                            opt.textContent = yr;
                            yearSelect.appendChild(opt);
                        }
                    });

                    filteredData = reportsData;
                    currentPage = 1;
                    renderPage();
                }
            } catch (err) { console.error(err); }
        }

        function calcIsoDays(createdAt, completedAt) {
            if (!completedAt) return null;
            const start = new Date(createdAt);
            const end = new Date(completedAt);
            const diffMs = end - start;
            return Math.round(diffMs / (1000 * 60 * 60 * 24));
        }

        function isobadge(r) {
            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
            if (!isCompleted || !r.admin_tarikh) {
                return `<span style="color: var(--text-muted); font-size: 0.8rem;">—</span>`;
            }
            const days = calcIsoDays(r.created_at, r.admin_tarikh);
            if (days === null) return `<span style="color: var(--text-muted); font-size: 0.8rem;">—</span>`;
            const pass = days <= 14;
            return `<span style="
                display: inline-flex; align-items: center; gap: 0.4rem;
                padding: 0.4rem 0.85rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                background: ${pass ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)'};
                color: ${pass ? '#059669' : '#dc2626'};
                border: 1px solid ${pass ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)'};
            ">${pass ? '✅' : '⚠️'} ${days} hari</span>`;
        }

        function renderPage() {
            const totalItems = filteredData.length;
            const totalPages = Math.max(1, Math.ceil(totalItems / PAGE_SIZE));
            currentPage = Math.min(Math.max(1, currentPage), totalPages);

            const start = (currentPage - 1) * PAGE_SIZE;
            const pageData = filteredData.slice(start, start + PAGE_SIZE);

            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = pageData.map(r => {
                const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
                const tarikhSiap = (isCompleted && r.admin_tarikh)
                    ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })
                    : '<span style="color:var(--text-muted);font-size:0.85rem;">Belum Diproses</span>';
                return `
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: var(--primary);">#${r.id}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 600;">${r.jenis_aset}</td>
                    <td style="padding: 1.25rem 1rem; color: var(--text-muted);">${new Date(r.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                    <td style="padding: 1.25rem 1rem;">${tarikhSiap}</td>
                    <td style="padding: 1.25rem 1rem;">${isobadge(r)}</td>
                    <td style="padding: 1.25rem 1rem;">
                        ${r.proses_semasa
                            ? `<span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.75rem;border-radius:20px;font-size:0.75rem;font-weight:700;background:#f1f5f9;color:#475569;">${r.proses_semasa}</span>`
                            : `<span style="color:var(--text-muted);font-size:0.82rem;">—</span>`
                        }
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="font-weight: 700; font-size: 0.85rem; color: ${r.keputusan === 'Diluluskan' ? '#15803d' : r.keputusan === 'Tidak Diluluskan' ? '#b91c1c' : r.keputusan === 'Syor Dilupuskan' ? '#475569' : 'var(--text-muted)'};">
                            ${r.keputusan || 'Menunggu'}
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">
                        <button onclick='viewDetails(${JSON.stringify(r).replace(/'/g, "&apos;")})' class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-radius: 8px;">🔍 Lihat</button>
                    </td>
                </tr>`;
            }).join('') || '<tr><td colspan="8" style="padding: 3rem; text-align: center; color: var(--text-muted);">Tiada laporan dijumpai.</td></tr>';

            // Pagination info
            const from = totalItems === 0 ? 0 : start + 1;
            const to = Math.min(start + PAGE_SIZE, totalItems);
            document.getElementById('paginationInfo').textContent = `Menunjukkan ${from}–${to} daripada ${totalItems} laporan`;

            // Prev / Next buttons
            document.getElementById('btnPrev').disabled = currentPage <= 1;
            document.getElementById('btnNext').disabled = currentPage >= totalPages;

            // Page number buttons
            const pageNums = document.getElementById('pageNumbers');
            pageNums.innerHTML = '';
            // Show up to 5 page buttons around current
            let startP = Math.max(1, currentPage - 2);
            let endP   = Math.min(totalPages, startP + 4);
            if (endP - startP < 4) startP = Math.max(1, endP - 4);
            for (let p = startP; p <= endP; p++) {
                const btn = document.createElement('button');
                btn.textContent = p;
                btn.onclick = () => changePage(p);
                btn.style.cssText = `
                    width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border);
                    font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;
                    background: ${p === currentPage ? 'var(--primary)' : 'var(--bg-card)'};
                    color: ${p === currentPage ? '#fff' : 'var(--text-main)'};
                    box-shadow: ${p === currentPage ? '0 4px 12px var(--primary-light)' : 'none'};
                `;
                pageNums.appendChild(btn);
            }

            // Hide pagination bar if only one page
            document.getElementById('paginationControls').style.display = totalPages <= 1 ? 'none' : 'flex';
        }

        function changePage(page) {
            currentPage = page;
            renderPage();
            // Smooth scroll to top of table
            document.querySelector('.card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function filterHistory() {
            const selectedYear = document.getElementById('filterYear').value;
            const selectedMonth = document.getElementById('filterMonth').value;

            filteredData = reportsData.filter(r => {
                const date = new Date(r.created_at);
                const matchYear = !selectedYear || date.getFullYear().toString() === selectedYear;
                const matchMonth = !selectedMonth || date.getMonth().toString() === selectedMonth;
                return matchYear && matchMonth;
            });

            currentPage = 1;
            renderPage();
        }

        function resetFilters() {
            document.getElementById('filterYear').value = "";
            document.getElementById('filterMonth').value = "";
            filterHistory();
        }

        let currentReport = null;

        function viewDetails(r) {
            currentReport = r;
            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';

            // Bahagian I
            document.getElementById('d_jenis').value = r.jenis_aset || '-';
            document.getElementById('d_siri').value = r.nombor_siri || '-';
            document.getElementById('d_pengguna').value = r.pengguna_terakhir || '-';
            document.getElementById('d_tarikh_rosak').value = r.tarikh_kerosakan ? new Date(r.tarikh_kerosakan).toLocaleDateString('ms-MY') : '-';
            document.getElementById('d_nama_jawatan').value = (r.nama_pelapor || '-') + ' / ' + (r.jawatan_pelapor || '-');
            document.getElementById('d_lokasi').value = r.location || '-';
            document.getElementById('d_perihal').value = r.perihal_kerosakan || '-';
            document.getElementById('d_created_at').value = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '-';

            // Bahagian II
            const kos = parseFloat(r.kos_penyelenggaraan_dahulu) || 0;
            const anggaran = parseFloat(r.anggaran_kos) || 0;
            document.getElementById('d_kos_dahulu').value = kos > 0 ? 'RM ' + kos.toFixed(2) : '-';
            document.getElementById('d_anggaran_kos').value = anggaran > 0 ? 'RM ' + anggaran.toFixed(2) : '-';
            document.getElementById('d_syor').value = r.syor_ulasan || '-';
            document.getElementById('d_admin_nama').value = r.admin_name_jawatan || '-';
            document.getElementById('d_admin_jawatan').value = r.admin_jawatan || '-';
            document.getElementById('d_admin_tarikh').value = (isCompleted && r.admin_tarikh)
                ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' })
                : 'Belum Diproses';

            // Bahagian III
            document.getElementById('d_keputusan').value = r.keputusan || '-';
            document.getElementById('d_kep_nama').value = r.keputusan_nama || '-';
            document.getElementById('d_kep_tarikh').value = r.keputusan_tarikh ? new Date(r.keputusan_tarikh).toLocaleDateString('ms-MY') : '-';

            // Proses Semasa
            const prosesEl = document.getElementById('d_proses_semasa');
            if (r.proses_semasa) {
                const prosesColors = {
                    'Diterima': { bg: '#e0f2fe', color: '#0369a1' },
                    'Sedang Dibaikpulih': { bg: '#fef9c3', color: '#854d0e' },
                    'Tunggu Panel / Alat Ganti': { bg: '#ffedd5', color: '#9a3412' },
                    'Dihantar ke Panel Lantikan': { bg: '#ede9fe', color: '#6d28d9' },
                    'Siap - Sedia Diambil': { bg: '#dcfce7', color: '#166534' },
                };
                const pc = prosesColors[r.proses_semasa] || { bg: '#f1f5f9', color: '#475569' };
                prosesEl.innerHTML = `<span style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:20px;font-size:0.85rem;font-weight:700;background:${pc.bg};color:${pc.color};">${r.proses_semasa}</span>`;
            } else {
                prosesEl.innerHTML = '<span style="color:var(--text-muted);font-size:0.9rem;">⏳ Menunggu tindakan admin...</span>';
            }

            // ISO Badge
            const modalDays = (isCompleted && r.admin_tarikh) ? calcIsoDays(r.created_at, r.admin_tarikh) : null;
            const isoEl = document.getElementById('d_iso_badge');
            if (modalDays !== null) {
                const pass = modalDays <= 14;
                isoEl.innerHTML = `<span style="
                    display:inline-flex;align-items:center;gap:0.4rem;
                    padding:0.4rem 1rem;border-radius:20px;font-size:0.8rem;font-weight:700;
                    background:${pass ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)'};
                    color:${pass ? '#059669' : '#dc2626'};
                    border:1px solid ${pass ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)'};
                ">${pass ? '✅ Memenuhi ISO' : '⚠️ Melebihi ISO'} (${modalDays} hari)</span>`;
            } else {
                isoEl.innerHTML = '<span style="color:var(--text-muted);font-size:0.85rem;">—</span>';
            }

            // Gambar
            const imgEl = document.getElementById('d_images');
            if (r.images && r.images.length > 0) {
                imgEl.innerHTML = `<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                    ${r.images.map(img => `<div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--border);"><img src="../${img.image_path}" style="width:100%;height:100%;object-fit:cover;"></div>`).join('')}
                </div>`;
            } else {
                imgEl.innerHTML = '<p class="text-muted">Tiada gambar dilampirkan.</p>';
            }

            document.getElementById('detailModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        function printKEWPA9Staff() {
            const r = currentReport;
            if (!r) return;
            document.getElementById('pr_jenis').textContent = r.jenis_aset || '';
            document.getElementById('pr_siri').textContent = r.nombor_siri || '';
            document.getElementById('pr_pengguna').textContent = r.pengguna_terakhir || '';
            document.getElementById('pr_tarikh_rosak').textContent = r.tarikh_kerosakan ? new Date(r.tarikh_kerosakan).toLocaleDateString('ms-MY') : '';
            document.getElementById('pr_perihal').textContent = r.perihal_kerosakan || '';
            document.getElementById('pr_nama').textContent = r.nama_pelapor || '';
            document.getElementById('pr_jawatan').textContent = r.jawatan_pelapor || '';
            document.getElementById('pr_tarikh_aduan').textContent = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '';

            const kos = parseFloat(r.kos_penyelenggaraan_dahulu) || 0;
            const anggaran = parseFloat(r.anggaran_kos) || 0;
            document.getElementById('pr_kos_dahulu').textContent = 'RM ' + kos.toFixed(2);
            document.getElementById('pr_anggaran_kos').textContent = 'RM ' + anggaran.toFixed(2);
            document.getElementById('pr_syor').textContent = r.syor_ulasan || '-';

            const adminNama = r.admin_name_jawatan || '';
            const adminJawatan = r.admin_jawatan || '';
            document.getElementById('pr_admin_nama').textContent = adminJawatan ? adminNama + ' / ' + adminJawatan : adminNama;
            document.getElementById('pr_admin_tarikh').textContent = r.admin_tarikh ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY') : '';

            const kep = r.keputusan || '';
            document.getElementById('pr_keputusan_line').innerHTML = kep === 'Diluluskan'
                ? '<u><strong>Diluluskan</strong></u>/ Tidak Diluluskan/ Syor Dilupuskan*'
                : kep === 'Tidak Diluluskan'
                ? 'Diluluskan/ <u><strong>Tidak Diluluskan</strong></u>/ Syor Dilupuskan*'
                : kep === 'Syor Dilupuskan'
                ? 'Diluluskan/ Tidak Diluluskan/ <u><strong>Syor Dilupuskan</strong></u>*'
                : 'Diluluskan/ Tidak Diluluskan/ Syor Dilupuskan*';

            document.getElementById('pr_kep_nama').textContent = r.keputusan_nama || '';
            document.getElementById('pr_kep_jawatan').textContent = r.keputusan_nama || '';
            document.getElementById('pr_kep_tarikh').textContent = r.keputusan_tarikh || '';

            document.getElementById('printableArea').style.display = 'block';
            window.print();
            document.getElementById('printableArea').style.display = 'none';
        }
    </script>

</body>
</html>
