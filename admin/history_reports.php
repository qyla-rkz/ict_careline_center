<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Laporan - ICT Careline Center</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/global.js?v=10"></script>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm 18mm;
            }

            body * {
                visibility: hidden !important;
            }

            #printableArea,
            #printableArea * {
                visibility: visible !important;
            }

            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
            }

            .no-print {
                display: none !important;
            }
        }

        #printableArea {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
        }

        #printableArea .pa9-title {
            text-align: right;
            font-size: 11pt;
            font-style: italic;
            margin-bottom: 8px;
        }

        #printableArea .pa9-heading {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13pt;
            margin-bottom: 20px;
        }

        #printableArea .pa9-section-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
        }

        #printableArea .pa9-row {
            display: flex;
            margin-bottom: 4px;
            font-size: 10pt;
            line-height: 1.8;
        }

        #printableArea .pa9-label {
            min-width: 160px;
            flex-shrink: 0;
        }

        #printableArea .pa9-colon {
            width: 10px;
            text-align: center;
            flex-shrink: 0;
        }

        #printableArea .pa9-value {
            flex: 1;
            border-bottom: 1px solid #000;
            padding-left: 4px;
        }

        #printableArea .pa9-box {
            border: 1px solid #000;
            padding: 12px;
            width: 240px;
            font-size: 9pt;
            display: flex;
            flex-direction: column;
            min-height: 160px;
        }

        #printableArea .pa9-sign-block {
            margin-top: 15px;
        }

        #printableArea .pa9-sign-line {
            border-bottom: 1px solid #000;
            height: 30px;
            width: 280px;
            margin-bottom: 3px;
        }

        #printableArea .pa9-sign-row {
            display: flex;
            font-size: 10pt;
            line-height: 1.8;
        }

        #printableArea .pa9-sign-label {
            width: 70px;
            flex-shrink: 0;
        }

        #printableArea .pa9-sign-value {
            flex: none;
            width: 350px;
            border-bottom: 1px solid #000;
            padding-left: 4px;
        }

        #printableArea .pa9-nota {
            font-size: 9pt;
            margin-top: 30px;
            font-style: italic;
        }

        #printableArea .pa9-bahagian2-label {
            width: 240px;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <img src="../assets/images/logo-mpm.png" alt="MPM Logo" class="logo-image">
                <h2>ICT Careline Center</h2>
            </div>
            <div class="user-profile"
                style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Selamat kembali,</p>
                <p id="sidebarAdminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="report_management.php" class="nav-link">📝 Pengurusan Laporan</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link">👥 Aset Staf</a>
                <a href="history_reports.php" class="nav-link active">📜 Sejarah Laporan</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0).php" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪
                    Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Sejarah Laporan</h2>
                </div>
                <div id="current-date"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date loaded via JS -->
                </div>
            </header>

            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-end; padding: 0.5rem;">
                    <div class="form-group" style="margin-bottom: 0; flex: 1;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Cari
                            Nama Pelapor</label>
                        <input type="text" id="filterName" class="form-control" placeholder="Masukkan nama..."
                            onkeyup="if(event.key === 'Enter') applyFilters()">
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Tahun</label>
                        <select id="filterYear" class="form-control" onchange="applyFilters()">
                            <option value="">Semua Tahun</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Bulan</label>
                        <select id="filterMonth" class="form-control" onchange="applyFilters()">
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
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="applyFilters()" class="btn btn-primary" style="padding: 0.6rem 1.25rem;">🔍
                            Cari</button>
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="table-container">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left;">
                                <th style="padding: 1rem;">ID</th>
                                <th style="padding: 1rem;">Pengadu</th>
                                <th style="padding: 1rem;">Keputusan</th>
                                <th style="padding: 1rem;">Diproses Oleh</th>
                                <th style="padding: 1rem; white-space: nowrap;">Tarikh Aduan</th>
                                <th style="padding: 1rem; white-space: nowrap;">Tarikh Siap</th>
                                <th style="padding: 1rem; white-space: nowrap;">Pematuhan ISO</th>
                                <th style="padding: 1rem; text-align: center; white-space: nowrap;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Loaded via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">Menunjukkan 0 hingga 0 daripada 0 entri</div>
                    <div class="pagination-controls">
                        <button onclick="prevPage()" id="prevBtn" class="pagination-btn" disabled>Sebelumnya</button>
                        <button onclick="nextPage()" id="nextBtn" class="pagination-btn">Seterusnya</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content" style="max-width: 860px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>Butiran Laporan KEW.PA-9</h2>
                <button onclick="closeModal()"
                    style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>

            <form id="processForm">
                <input type="hidden" id="p_id" name="id">
                <input type="hidden" id="p_reporter" name="reporter">
                <input type="hidden" id="p_created_at" name="created_at">

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Bahagian I -->
                    <div>
                        <h4
                            style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                            Bahagian I: Maklumat Pengadu</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group"><label>Jenis Aset</label><input type="text" id="v_jenis"
                                    class="form-control" readonly></div>
                            <div class="form-group"><label>No. Siri Pendaftaran</label><input type="text" id="v_siri"
                                    class="form-control" readonly></div>
                            <div class="form-group"><label>Pengguna Terakhir</label><input type="text" id="v_pengguna"
                                    class="form-control" readonly></div>
                            <div class="form-group"><label>Tarikh Kerosakan</label><input type="text"
                                    id="v_tarikh_rosak" class="form-control" readonly></div>
                            <div class="form-group"><label>Nama Pelapor & Jawatan</label><input type="text"
                                    id="v_nama_jawatan" class="form-control" readonly></div>
                            <div class="form-group"><label>Lokasi</label><input type="text" id="v_lokasi"
                                    class="form-control" readonly></div>
                        </div>
                        <div class="form-group"><label>Perihal Kerosakan</label><textarea id="v_perihal"
                                class="form-control" rows="3" readonly></textarea></div>
                    </div>

                    <!-- Bahagian II -->
                    <div>
                        <h4
                            style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                            Bahagian II: Penemuan Teknikal</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group"><label>Kos Penyelenggaraan Terdahulu (RM)</label><input
                                    type="number" step="0.01" name="kos_penyelenggaraan_dahulu" id="v_kos_dahulu"
                                    class="form-control" readonly></div>
                            <div class="form-group"><label>Anggaran Kos Penyelenggaraan (RM)</label><input type="number"
                                    step="0.01" name="anggaran_kos" id="v_anggaran_kos" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group"><label>Syor Dan Ulasan</label><textarea name="syor_ulasan" id="v_syor"
                                class="form-control" rows="3" readonly></textarea></div>
                        <div class="form-group"><label>Nama Pegawai Teknikal</label><input type="text"
                                name="pegawai_teknikal_nama" id="v_admin_nama" class="form-control" readonly></div>
                        <div class="form-group"><label>Jawatan Pegawai Teknikal</label><input type="text"
                                name="pegawai_teknikal_jawatan" id="v_admin_jawatan" class="form-control" readonly>
                        </div>
                        <div class="form-group"><label>Tarikh Siap (Admin ICT)</label><input type="text"
                                id="v_admin_tarikh" class="form-control" readonly></div>
                    </div>

                    <!-- Bahagian III -->
                    <div>
                        <h4
                            style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                            Bahagian III: Keputusan</h4>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div class="form-group">
                                <label>Keputusan</label>
                                <input type="text" id="v_keputusan" class="form-control" readonly>
                            </div>
                            <div class="form-group"><label>Nama Ketua</label><input type="text" name="keputusan_nama"
                                    id="v_kep_nama" class="form-control" readonly></div>
                            <div class="form-group"><label>Tarikh Keputusan</label><input type="date"
                                    name="keputusan_tarikh" id="v_kep_tarikh" class="form-control" readonly></div>
                            <div class="form-group">
                                <label>Pematuhan ISO (&lt;14 hari)</label>
                                <div id="v_iso_badge" style="padding-top: 0.5rem;"></div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <button type="button" onclick="printKEWPA9()" class="btn btn-secondary" style="flex: 1;">🖨️
                            Cetak KEW.PA-9</button>
                        <button type="button" onclick="closeModal()" class="btn btn-secondary"
                            style="flex: 0 0 auto; padding: 0.75rem 1.5rem;">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="printableArea" style="display: none; padding: 10px;">
        <div class="pa9-title">KEW.PA-9</div>
        <div class="pa9-heading">BORANG ADUAN KEROSAKAN ASET ALIH</div>

        <div class="pa9-section-title">Bahagian I (Untuk diisi oleh Pengadu)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row">
                    <div class="pa9-label">1. Jenis Aset</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_jenis"></div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">2. No. Siri Pendaftaran</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_siri"></div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">3. Pengguna Terakhir</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_pengguna"></div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">4. Tarikh Kerosakan</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_tarikh_rosak"></div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">5. Perihal Kerosakan</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_perihal"></div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">6. Nama Dan Jawatan</div>
                    <div class="pa9-colon">:</div>
                    <div style="flex:1; display:flex; flex-direction:column;">
                        <div class="pa9-value" id="pr_nama" style="min-height: 18px; margin-bottom: 5px;"></div>
                        <div class="pa9-value" id="pr_jawatan" style="min-height: 18px;"></div>
                    </div>
                </div>
                <div class="pa9-row">
                    <div class="pa9-label">7. Tarikh</div>
                    <div class="pa9-colon">:</div>
                    <div class="pa9-value" id="pr_tarikh_aduan"></div>
                </div>
            </div>
            <div class="pa9-box">
                <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">PENGESAHAN PENGADU</div>
                <div style="font-size: 8pt; text-align: center; margin-bottom: auto;">Adalah disahkan kerosakan aset di
                    atas telah selesai dibaiki / diselenggara.</div>
                <div style="margin-top: auto; text-align: center;">
                    <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 2px;"></div>
                    <div style="font-size: 8pt;">(Tandatangan &amp; Cop)</div>
                    <div style="font-size: 8pt; margin-top: 5px; text-align: left;">Tarikh:</div>
                </div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian II (Untuk diisi oleh Pegawai Aset / Pegawai Teknikal)</div>
        <div style="margin-bottom: 8px;">
            <div class="pa9-row" style="align-items: flex-start;">
                <div class="pa9-bahagian2-label">1. Jumlah Kos Penyelenggaraan<br>&nbsp;&nbsp;&nbsp;Terdahulu</div>
                <div class="pa9-colon">:</div>
                <div class="pa9-value" id="pr_kos_dahulu"></div>
            </div>
            <div class="pa9-row">
                <div class="pa9-bahagian2-label">2. Anggaran Kos Penyelenggaraan</div>
                <div class="pa9-colon">:</div>
                <div class="pa9-value" id="pr_anggaran_kos"></div>
            </div>
            <div class="pa9-row">
                <div class="pa9-bahagian2-label">3. Syor Dan Ulasan</div>
                <div class="pa9-colon">:</div>
                <div class="pa9-value" id="pr_syor"></div>
            </div>
            <div class="pa9-row">
                <div class="pa9-bahagian2-label"></div>
                <div class="pa9-colon"></div>
                <div class="pa9-value">&nbsp;</div>
            </div>
        </div>
        <div style="margin-bottom: 20px;">
            <div class="pa9-row">
                <div class="pa9-bahagian2-label">4. Nama Dan Jawatan</div>
                <div class="pa9-colon">:</div>
                <div class="pa9-value" id="pr_admin_nama"></div>
            </div>
            <div class="pa9-row">
                <div class="pa9-bahagian2-label">5. Tarikh</div>
                <div class="pa9-colon">:</div>
                <div class="pa9-value" id="pr_admin_tarikh"></div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian III (Keputusan Ketua Jabatan / Bahagian / Seksyen / Unit)</div>
        <div id="pr_keputusan_line" style="font-size: 10pt; margin-bottom: 25px;">Diluluskan/ Tidak
            Diluluskan/ Syor Dilupuskan*</div>

        <div class="pa9-sign-block">
            <div style="text-align: center; width: 250px;">
                <div style="border-bottom: 1px solid #000; height: 120px; margin-bottom: 3px;"></div>
                <div style="font-size: 10pt; margin-bottom: 12px;">Tandatangan</div>
            </div>
            <div class="pa9-sign-row">
                <div class="pa9-sign-label">Nama:</div>
                <div class="pa9-sign-value" id="pr_kep_nama"></div>
            </div>
            <div class="pa9-sign-row">
                <div class="pa9-sign-label">Jawatan:</div>
                <div class="pa9-sign-value" id="pr_kep_jawatan"></div>
            </div>
            <div class="pa9-sign-row">
                <div class="pa9-sign-label">Tarikh:</div>
                <div class="pa9-sign-value" id="pr_kep_tarikh"></div>
            </div>
        </div>

        <div class="pa9-nota">Nota: * Potong mana yang berkenaan</div>
    </div>


    <script>
        let currentReport = null;

        async function handleLogout() {
            try {
                await fetch("../api/logout"));
            } catch (err) { }
            sessionStorage.clear();
            sessionStorage.clear();
            window.location.replace('../login.php');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('current-date').textContent = new Date().toLocaleDateString('ms-MY', opts);

            const user = JSON.parse(sessionStorage.getItem('user'));
            if (user && user.full_name) {
                document.getElementById('sidebarAdminName').textContent = user.full_name;
            }

            fetchHistory();
        });

        let currentPage = 1;
        const itemsPerPage = 10;
        let allHistory = [];
        let filteredHistory = [];

        async function fetchHistory() {
            const url = `../api/admin_get_reports.php`;

            try {
                const response = await fetch(url);
                const result = await response.json();
                if (result.status === 'success') {
                    allHistory = result.data.filter(r => r.status === 'Resolved' || r.status === 'Rejected');
                    
                    // Populate Year Dropdown dynamically
                    const yearSelect = document.getElementById('filterYear');
                    if (yearSelect.options.length <= 1) {
                        const years = [...new Set(allHistory.map(r => new Date(r.created_at).getFullYear()))].sort((a, b) => b - a);
                        years.forEach(yr => {
                            if (!isNaN(yr)) {
                                const opt = document.createElement('option');
                                opt.value = yr;
                                opt.textContent = yr;
                                yearSelect.appendChild(opt);
                            }
                        });
                    }

                    applyFilters();
                }
            } catch (err) { console.error(err); }
        }

        function applyFilters() {
            const name = document.getElementById('filterName').value.toLowerCase();
            const y = document.getElementById('filterYear').value;
            const m = document.getElementById('filterMonth').value;

            filteredHistory = allHistory.filter(r => {
                const date = new Date(r.created_at);
                const yearMatch = !y || date.getFullYear().toString() === y;
                const monthMatch = !m || date.getMonth().toString() === m;
                
                const nameMatch = !name || 
                    (r.nama_pelapor && r.nama_pelapor.toLowerCase().includes(name)) ||
                    (r.full_name && r.full_name.toLowerCase().includes(name));

                return yearMatch && monthMatch && nameMatch;
            });

            currentPage = 1;
            renderHistory();
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

        function renderHistory() {
            const tbody = document.getElementById('historyTableBody');
            if (!filteredHistory.length) {
                tbody.innerHTML = '<tr><td colspan="8" style="padding:2rem;text-align:center;color:var(--text-muted)">Tiada rekod ditemui.</td></tr>';
                updatePagination(0);
                return;
            }

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = filteredHistory.slice(start, end);

            tbody.innerHTML = pageItems.map(r => {
                const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
                const tarikhSiap = (isCompleted && r.admin_tarikh)
                    ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })
                    : '<span style="color:var(--text-muted);font-size:0.85rem;">Belum Diproses</span>';

                return `
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1rem; font-weight: 600; color: var(--primary);">#${r.id}</td>
                    <td style="padding: 1rem;">${r.nama_pelapor || r.full_name}</td>
                    <td style="padding: 1rem;"><span class="badge badge-${r.keputusan === 'Diluluskan' ? 'resolved' : r.keputusan === 'Syor Dilupuskan' ? 'disposed' : 'rejected'}" style="white-space: nowrap;">${r.keputusan || 'N/A'}</span></td>
                    <td style="padding: 1rem;">${r.keputusan_nama || r.admin_name_jawatan || 'System'}</td>
                    <td style="padding: 1rem; white-space: nowrap;">${new Date(r.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                    <td style="padding: 1rem; white-space: nowrap;">${tarikhSiap}</td>
                    <td style="padding: 1rem; white-space: nowrap;">${isobadge(r)}</td>
                    <td style="padding: 1rem; text-align: center; white-space: nowrap;">
                        <button onclick='showReportDetails(${JSON.stringify(r).replace(/'/g, "&#39;")})' class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">Lihat / Cetak</button>
                    </td>
                </tr>
            `;
            }).join('');

            updatePagination(filteredHistory.length);
        }

        function updatePagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('paginationInfo').textContent = totalItems > 0
                ? `Menunjukkan ${start} hingga ${end} daripada ${totalItems} entri`
                : `Menunjukkan 0 hingga 0 daripada 0 entri`;

            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
        }

        function nextPage() {
            currentPage++;
            renderHistory();
            document.querySelector('.table-container').scrollTop = 0;
        }

        function prevPage() {
            currentPage--;
            renderHistory();
            document.querySelector('.table-container').scrollTop = 0;
        }

        function showReportDetails(r) {
            currentReport = r;
            document.getElementById('p_id').value = r.id;
            document.getElementById('p_reporter').value = r.nama_pelapor || r.full_name || '';
            document.getElementById('p_created_at').value = r.created_at;
            document.getElementById('v_jenis').value = r.jenis_aset;
            document.getElementById('v_siri').value = r.nombor_siri;
            document.getElementById('v_pengguna').value = r.pengguna_terakhir;
            document.getElementById('v_tarikh_rosak').value = r.tarikh_kerosakan;
            document.getElementById('v_perihal').value = r.perihal_kerosakan;
            document.getElementById('v_nama_jawatan').value = (r.nama_pelapor || r.full_name || '') + ' / ' + (r.jawatan_pelapor || '');
            document.getElementById('v_lokasi').value = r.location || '-';
            document.getElementById('v_kos_dahulu').value = r.kos_penyelenggaraan_dahulu || '';
            document.getElementById('v_anggaran_kos').value = r.anggaran_kos || '';
            document.getElementById('v_syor').value = r.syor_ulasan || '';
            document.getElementById('v_admin_nama').value = r.admin_name_jawatan || '';
            document.getElementById('v_admin_jawatan').value = r.admin_jawatan || '';

            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
            document.getElementById('v_admin_tarikh').value = (isCompleted && r.admin_tarikh)
                ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' })
                : 'Belum Diproses';

            document.getElementById('v_keputusan').value = r.keputusan || 'Diluluskan';
            document.getElementById('v_kep_nama').value = r.keputusan_nama || '';
            document.getElementById('v_kep_tarikh').value = r.keputusan_tarikh || '';

            // ISO badge
            const modalDays = (isCompleted && r.admin_tarikh) ? calcIsoDays(r.created_at, r.admin_tarikh) : null;
            const isoEl = document.getElementById('v_iso_badge');
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

            document.getElementById('viewModal').style.display = 'flex';
        }


        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function printKEWPA9() {
            try {
                const njParts = document.getElementById('v_nama_jawatan').value.split(' / ');
                const prNama = njParts[0] || '';
                const prJawatan = njParts[1] || '';

                const kosDahulu = parseFloat(document.getElementById('v_kos_dahulu').value) || 0;
                const anggaranKos = parseFloat(document.getElementById('v_anggaran_kos').value) || 0;
                const adminNama = document.getElementById('v_admin_nama').value;
                const adminJawatan = document.getElementById('v_admin_jawatan').value;
                const kep = document.getElementById('v_keputusan').value;
                const kepLine = kep === 'Diluluskan'
                    ? '<u><strong>Diluluskan</strong></u>/ Tidak Diluluskan/ Syor Dilupuskan*'
                    : kep === 'Tidak Diluluskan'
                        ? 'Diluluskan/ <u><strong>Tidak Diluluskan</strong></u>/ Syor Dilupuskan*'
                        : kep === 'Syor Dilupuskan'
                            ? 'Diluluskan/ Tidak Diluluskan/ <u><strong>Syor Dilupuskan</strong></u>*'
                            : 'Diluluskan/ Tidak Diluluskan/ Syor Dilupuskan*';

                document.getElementById('pr_jenis').textContent = document.getElementById('v_jenis').value || '';
                document.getElementById('pr_siri').textContent = document.getElementById('v_siri').value || '';
                document.getElementById('pr_pengguna').textContent = document.getElementById('v_pengguna').value || '';
                document.getElementById('pr_tarikh_rosak').textContent = document.getElementById('v_tarikh_rosak').value || '';
                document.getElementById('pr_perihal').textContent = document.getElementById('v_perihal').value || '';
                document.getElementById('pr_nama').textContent = prNama || '';
                document.getElementById('pr_jawatan').textContent = prJawatan || '';

                const pCreatedAtVal = document.getElementById('p_created_at').value;
                document.getElementById('pr_tarikh_aduan').textContent = pCreatedAtVal ? new Date(pCreatedAtVal).toLocaleDateString('ms-MY') : '';

                document.getElementById('pr_kos_dahulu').textContent = 'RM ' + kosDahulu.toFixed(2);
                document.getElementById('pr_anggaran_kos').textContent = 'RM ' + anggaranKos.toFixed(2);
                document.getElementById('pr_syor').textContent = document.getElementById('v_syor').value || '-';

                document.getElementById('pr_admin_nama').textContent = adminJawatan ? adminNama + ' / ' + adminJawatan : adminNama;
                document.getElementById('pr_admin_tarikh').textContent = new Date().toLocaleDateString('ms-MY');
                document.getElementById('pr_keputusan_line').innerHTML = kepLine;
                document.getElementById('pr_kep_nama').textContent = document.getElementById('v_kep_nama').value || '';
                document.getElementById('pr_kep_jawatan').textContent = currentReport ? (currentReport.keputusan_jawatan || '') : '';
                document.getElementById('pr_kep_tarikh').textContent = document.getElementById('v_kep_tarikh').value || '';

                document.getElementById('printableArea').style.display = 'block';
                window.print();
                document.getElementById('printableArea').style.display = 'none';
            } catch (err) {
                console.error(err);
                alert('Ralat teknikal semasa mencetak: ' + err.stack);
            }
        }
    </script>
</body>

</html>