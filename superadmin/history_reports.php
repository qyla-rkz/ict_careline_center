<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role'] ?? ''), ['super admin', 'superadmin'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Laporan & Rekod Kelulusan - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=14"></script>
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

        @media (max-width: 1200px) {
            .stats-grid-responsive {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
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

        .readonly-sec {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            padding: 1.25rem;
        }
        .form-control-readonly,
        .readonly-sec input.form-control,
        .readonly-sec textarea.form-control {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border: 1.5px solid #cbd5e1 !important;
            cursor: not-allowed !important;
            font-weight: 600;
            user-select: none;
        }
        .form-control-readonly:focus,
        .readonly-sec input.form-control:focus,
        .readonly-sec textarea.form-control:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #cbd5e1 !important;
        }
        body.dark-theme .readonly-sec {
            background: rgba(30, 41, 59, 0.45) !important;
            border-color: #334155 !important;
        }
        body.dark-theme .form-control-readonly,
        body.dark-theme .readonly-sec input.form-control,
        body.dark-theme .readonly-sec textarea.form-control {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            border-color: #334155 !important;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <img src="../assets/images/logo-mpm.png" alt="MPM Logo" class="logo-image">
                <h2>eICT Desk</h2>
            </div>
            <div class="user-profile"
                style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Selamat kembali,</p>
                <p id="sidebarSuperadminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Super Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="reports.php" class="nav-link">📝 Kelulusan Laporan</a>
                <a href="history_reports.php" class="nav-link active">📜 Sejarah Laporan</a>
                <a href="users.php" class="nav-link">👥 Pengguna</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link">👥 Aset Staf</a>
                <a href="audit_logs.php" class="nav-link">📜 Jejak Audit</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0)" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪
                    Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Super Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Sejarah &amp; Rekod Kelulusan Laporan</h2>
                </div>
                <div id="current-date"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                </div>
            </header>

            <!-- Statistik Keseluruhan -->
            <div class="stats-grid-responsive no-print" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="card stat-card" style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem;">
                    <div class="stat-icon" style="background: #eff6ff; color: #1e40af; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📋</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Jumlah Rekod Diputuskan</div>
                        <div id="stat-total" style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem;">
                    <div class="stat-icon" style="background: #dcfce7; color: #166534; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">✅</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Diluluskan</div>
                        <div id="stat-resolved" style="font-size: 1.8rem; font-weight: 800; color: #166534;">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem;">
                    <div class="stat-icon" style="background: #fee2e2; color: #991b1b; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">❌</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Tidak Diluluskan</div>
                        <div id="stat-rejected" style="font-size: 1.8rem; font-weight: 800; color: #991b1b;">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem;">
                    <div class="stat-icon" style="background: #e2e8f0; color: #475569; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🗂️</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Syor Dilupuskan</div>
                        <div id="stat-disposed" style="font-size: 1.8rem; font-weight: 800; color: #475569;">0</div>
                    </div>
                </div>
            </div>

            <!-- Bar Penapis -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-end; padding: 0.5rem; flex-wrap: wrap;">
                    <div class="form-group" style="margin-bottom: 0; flex: 2; min-width: 200px;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Cari Laporan</label>
                        <input type="text" id="filterSearch" class="form-control" placeholder="Cari ID, Pelapor, No. Siri, atau Aset..."
                            oninput="applyFilters()">
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 130px;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Tahun</label>
                        <select id="filterYear" class="form-control" onchange="applyFilters()">
                            <option value="">Semua Tahun</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 140px;">
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
                    <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 150px;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Jabatan / Unit</label>
                        <select id="filterDept" class="form-control" onchange="applyFilters()">
                            <option value="">Semua Jabatan</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 160px;">
                        <label
                            style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Keputusan Super Admin</label>
                        <select id="filterKeputusan" class="form-control" onchange="applyFilters()">
                            <option value="">Semua Keputusan</option>
                            <option value="Diluluskan">✅ Diluluskan</option>
                            <option value="Tidak Diluluskan">❌ Tidak Diluluskan</option>
                            <option value="Syor Dilupuskan">🗂️ Syor Dilupuskan</option>
                        </select>
                    </div>
                    <div>
                        <button onclick="fetchHistoryReports()" class="btn btn-secondary" style="padding: 0.65rem 1.25rem;">🔄 Reset</button>
                    </div>
                </div>
            </div>

            <!-- Jadual Rekod -->
            <div class="card table-card" style="padding: 0; overflow: hidden; border-radius: 14px;">
                <div class="table-container" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">ID</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Pengadu</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Jabatan / Unit</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Aset</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Pegawai Teknikal</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; white-space: nowrap;">Tarikh Keputusan</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em;">Keputusan</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; white-space: nowrap;">Pematuhan ISO</th>
                                <th style="padding: 1.15rem 1.25rem; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; text-align: center; white-space: nowrap;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Loaded via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); background: #f8fafc;">
                    <div class="pagination-info" id="paginationInfo" style="font-size: 0.88rem; color: var(--text-muted);">Menunjukkan 0 hingga 0 daripada 0 entri</div>
                    <div class="pagination-controls" style="display: flex; gap: 0.5rem;">
                        <button onclick="prevPage()" id="prevBtn" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;" disabled>Sebelumnya</button>
                        <button onclick="nextPage()" id="nextBtn" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">Seterusnya</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal" onclick="if(event.target===this) closeModal()">
        <div class="modal-content" style="max-width: 860px; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 id="modalHistoryTitle" style="margin: 0; font-size: 1.4rem; color: var(--text-main);">Butiran Rekod Laporan KEW.PA-9</h2>
                <button onclick="closeModal()"
                    style="background: none; border: none; font-size: 1.7rem; cursor: pointer; color: var(--text-muted);">&times;</button>
            </div>

            <form id="processForm">
                <input type="hidden" id="p_id" name="id">
                <input type="hidden" id="p_reporter" name="reporter">
                <input type="hidden" id="p_created_at" name="created_at">

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Bahagian I (Maklumat Pengadu - Read-only) -->
                    <div class="readonly-sec">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 0.5rem;">
                            <h4 style="margin: 0; color: var(--primary); font-size: 1rem;">Bahagian I: Maklumat Pengadu</h4>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Jenis Aset</label>
                                <input type="text" id="v_jenis" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">No. Siri Pendaftaran</label>
                                <input type="text" id="v_siri" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Pengguna Terakhir</label>
                                <input type="text" id="v_pengguna" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Tarikh Kerosakan</label>
                                <input type="text" id="v_tarikh_rosak" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Nama Pelapor &amp; Jawatan</label>
                                <input type="text" id="v_nama_jawatan" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Lokasi</label>
                                <input type="text" id="v_lokasi" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 0.75rem;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Perihal Kerosakan</label>
                            <textarea id="v_perihal" readonly tabindex="-1" class="form-control form-control-readonly" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Lampiran Spesifikasi Aset Yang Rosak -->
                    <div id="v_spec_container" style="background: rgba(241, 245, 249, 0.7); border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 1.25rem;">
                        <h4 style="color: var(--primary); margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.95rem;">
                            <span style="display: flex; align-items: center; gap: 0.5rem;">
                                💻 Lampiran Spesifikasi Aset Yang Rosak
                            </span>
                            <span id="v_spec_status_badge" style="font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 700;"></span>
                        </h4>
                        <div id="v_spec_body">
                            <!-- Populated via renderAttachedSpec -->
                        </div>
                    </div>

                    <!-- Gambar / Dokumen Lampiran Kerosakan (Jika Ada) -->
                    <div id="v_images_container" style="background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem;">
                        <h4 style="color: var(--text-main); margin-bottom: 0.75rem; font-size: 0.95rem; display: flex; align-items: center; justify-content: space-between;">
                            <span style="display: flex; align-items: center; gap: 0.5rem;">📸 Gambar / Bukti Kerosakan Aset</span>
                            <span id="v_images_count_badge" style="font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 999px; font-weight: 600; background: #e2e8f0; color: #475569;"></span>
                        </h4>
                        <div id="v_images_body">
                            <!-- Populated via renderReportImages -->
                        </div>
                    </div>

                    <!-- Proses Semasa -->
                    <div style="background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(168,85,247,0.05)); border: 1px solid rgba(99,102,241,0.2); border-radius: 12px; padding: 1.25rem;">
                        <h4 style="color: #6366f1; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem;">
                            🔄 Proses Semasa
                        </h4>
                        <input type="text" id="v_proses_semasa" class="form-control form-control-readonly" readonly tabindex="-1">
                    </div>

                    <!-- Bahagian II: Penemuan Teknikal -->
                    <div class="readonly-sec">
                        <h4 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                            Bahagian II: Penemuan Teknikal (Pegawai Teknikal)
                        </h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group"><label>Kos Penyelenggaraan Terdahulu (RM)</label><input
                                    type="text" id="v_kos_dahulu" class="form-control form-control-readonly" readonly></div>
                            <div class="form-group"><label>Anggaran Kos Penyelenggaraan (RM)</label><input type="text"
                                    id="v_anggaran_kos" class="form-control form-control-readonly" readonly></div>
                        </div>
                        <div class="form-group"><label>Syor Dan Ulasan</label><textarea id="v_syor"
                                class="form-control form-control-readonly" rows="3" readonly></textarea></div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group"><label>Nama Pegawai Teknikal</label><input type="text"
                                    id="v_admin_nama" class="form-control form-control-readonly" readonly></div>
                            <div class="form-group"><label>Jawatan Pegawai Teknikal</label><input type="text"
                                    id="v_admin_jawatan" class="form-control form-control-readonly" readonly></div>
                        </div>
                    </div>

                    <!-- Bahagian III: Keputusan Super Admin -->
                    <div style="border: 1.5px solid #10b981; background: #f0fdf4; border-radius: 14px; padding: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; border-bottom: 1px solid #bbf7d0; padding-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
                            <h4 style="margin: 0; color: #166534; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                                🔒 Bahagian III: Keputusan Ketua Jabatan (Super Admin)
                            </h4>
                            <span id="v_kep_badge" style="font-size: 0.75rem; padding: 0.25rem 0.65rem; border-radius: 999px; font-weight: 700;"></span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: #166534;">Keputusan</label>
                                <input type="text" id="v_keputusan" class="form-control form-control-readonly" readonly tabindex="-1">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: #166534;">Tarikh Keputusan</label>
                                <input type="text" id="v_kep_tarikh" class="form-control form-control-readonly" readonly tabindex="-1">
                            </div>
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label style="font-size: 0.8rem; font-weight: 600; color: #166534;">Nama Pegawai Pelulus (Ketua Jabatan)</label>
                                <input type="text" id="v_kep_nama" class="form-control form-control-readonly" readonly tabindex="-1">
                            </div>
                            <div class="form-group" id="iso_badge_group" style="grid-column: 1 / -1;">
                                <label style="font-size: 0.8rem; font-weight: 600; color: #166534;">Pematuhan ISO (&lt;14 hari)</label>
                                <div id="v_iso_badge" style="padding-top: 0.3rem;"></div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                        <button type="button" onclick="printKEWPA9()" class="btn btn-primary" style="flex: 2; padding: 0.75rem;">🖨️
                            Cetak Borang KEW.PA-9 Rasmi</button>
                        <button type="button" onclick="closeModal()" class="btn btn-secondary"
                            style="flex: 1; padding: 0.75rem;">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Printable KEW.PA-9 -->
    <div id="printableArea" style="display: none; padding: 10px;">
        <div class="pa9-title">KEW.PA-9</div>
        <div class="pa9-heading">BORANG ADUAN KEROSAKAN ASET ALIH</div>

        <div class="pa9-section-title">Bahagian I (Untuk diisi oleh Pengadu)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row">
                    <span class="pa9-label">1. Jenis Aset</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="pr_jenis"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">2. Nombor Siri Pendaftaran Aset/ Komponen</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="pr_siri"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">3. Pengguna Terakhir</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="pr_pengguna"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">4. Tarikh Kerosakan</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="pr_tarikh_rosak"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">5. Perihal Kerosakan</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="pr_perihal"></span>
                </div>
            </div>
            <div class="pa9-box">
                <div style="font-weight: bold; margin-bottom: 5px;">Tandatangan Pengadu:</div>
                <div class="pa9-sign-block" style="margin-top: auto;">
                    <div class="pa9-sign-line"></div>
                    <div>Nama: <span id="pr_nama"></span></div>
                    <div>Jawatan: <span id="pr_jawatan"></span></div>
                    <div>Tarikh: <span id="pr_tarikh_aduan"></span></div>
                </div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian II (Untuk diisi oleh Pegawai Aset/ Pegawai Teknikal)</div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">6. Jumlah Kos Penyelenggaraan Terdahulu</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="pr_kos_dahulu"></span>
        </div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">7. Anggaran Kos Penyelenggaraan</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="pr_anggaran_kos"></span>
        </div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">8. Syor Dan Ulasan</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="pr_syor"></span>
        </div>
        <div class="pa9-sign-block" style="margin-top: 25px; margin-left: 20px;">
            <div class="pa9-sign-line"></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tandatangan</span><span>:</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Nama</span><span>: <span id="pr_admin_nama"></span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Jawatan</span><span>: Pegawai Teknikal ICT</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tarikh</span><span>: <span id="pr_admin_tarikh"></span></span></div>
        </div>

        <div class="pa9-section-title" style="margin-top: 25px;">Bahagian III (Keputusan Ketua Jabatan/ Bahagian/ Seksyen/ Unit)</div>
        <div style="font-size: 10pt; line-height: 1.8; margin-bottom: 10px;">
            9. Diluluskan / Tidak Diluluskan / Syor Dilupuskan :
            <div style="margin-top: 5px; font-weight: bold; font-size: 11pt;" id="pr_keputusan_line"></div>
        </div>
        <div class="pa9-sign-block" style="margin-top: 25px; margin-left: 20px;">
            <div class="pa9-sign-line"></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tandatangan</span><span>:</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Nama</span><span>: <span id="pr_kep_nama"></span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Jawatan</span><span>: <span id="pr_kep_jawatan">Ketua Jabatan</span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tarikh</span><span>: <span id="pr_kep_tarikh"></span></span></div>
        </div>

        <div class="pa9-nota">Nota: * Potong mana yang tidak berkenaan.</div>
    </div>

    <script>
        let allReports = [];
        let filteredReports = [];
        let currentReport = null;
        let currentPage = 1;
        const itemsPerPage = 10;

        document.addEventListener('DOMContentLoaded', async () => {
            const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('current-date').textContent = new Date().toLocaleDateString('ms-MY', opts);

            const userStr = sessionStorage.getItem('user');
            if (userStr) {
                try {
                    const u = JSON.parse(userStr);
                    if (u.full_name) document.getElementById('sidebarSuperadminName').textContent = u.full_name;
                } catch(e) {}
            }

            await fetchHistoryReports();
        });

        async function handleLogout() {
            try { await fetch("../api/logout.php"); } catch(e){}
            sessionStorage.clear();
            window.location.replace('../login.php');
        }

        function formatReportId(id) {
            if (!id && id !== 0) return '';
            const num = parseInt(id);
            return isNaN(num) ? `#ICT${id}` : `#ICT${String(num).padStart(2, '0')}`;
        }

        function calcIsoDays(createdStr, finishStr) {
            if (!createdStr || !finishStr) return null;
            const d1 = new Date(createdStr);
            const d2 = new Date(finishStr);
            if (isNaN(d1) || isNaN(d2)) return null;
            const diffTime = d2.getTime() - d1.getTime();
            return Math.max(0, Math.round(diffTime / (1000 * 60 * 60 * 24)));
        }

        async function fetchHistoryReports() {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">⏳ Memuatkan rekod sejarah laporan...</td></tr>';

            try {
                const res = await fetch("../api/admin/admin_get_reports.php?_t=" + Date.now());
                const result = await res.json();

                if (result.status === 'success' && Array.isArray(result.data)) {
                    // Hanya paparkan laporan yang TELAH DIPUTUSKAN / DILULUSKAN oleh Super Admin
                    allReports = result.data.filter(r => {
                        const hasDecision = r.keputusan && r.keputusan !== 'Pending';
                        return hasDecision;
                    });

                    populateDropdowns();
                    updateCounters();
                    applyFilters();

                    // Semak jika ada URL parameter ?id=... untuk buka modal secara automatik
                    const urlParams = new URLSearchParams(window.location.search);
                    const targetId = urlParams.get('id');
                    if (targetId) {
                        const targetReport = allReports.find(r => String(r.id) === String(targetId));
                        if (targetReport) {
                            openHistoryDetails(targetReport.id);
                        }
                    }
                } else {
                    tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 2.5rem; color: var(--danger);">❌ ${result.message || 'Gagal memuatkan data.'}</td></tr>`;
                }
            } catch (err) {
                tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 2.5rem; color: var(--danger);">❌ Ralat sambungan: ${err.message}</td></tr>`;
            }
        }

        function updateCounters() {
            let total = allReports.length;
            let approved = 0, rejected = 0, disposed = 0;

            allReports.forEach(r => {
                if (r.keputusan === 'Diluluskan') approved++;
                else if (r.keputusan === 'Tidak Diluluskan') rejected++;
                else if (r.keputusan === 'Syor Dilupuskan') disposed++;
            });

            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-resolved').textContent = approved;
            document.getElementById('stat-rejected').textContent = rejected;
            document.getElementById('stat-disposed').textContent = disposed;
        }

        function populateDropdowns() {
            const years = new Set();
            const depts = new Set();

            allReports.forEach(r => {
                if (r.keputusan_tarikh || r.created_at) {
                    const yr = new Date(r.keputusan_tarikh || r.created_at).getFullYear();
                    if (!isNaN(yr)) years.add(yr);
                }
                const d = r.department || r.location;
                if (d && d.trim() !== '') depts.add(d.trim());
            });

            const yearSelect = document.getElementById('filterYear');
            yearSelect.innerHTML = '<option value="">Semua Tahun</option>';
            Array.from(years).sort((a,b)=>b-a).forEach(y => {
                const opt = document.createElement('option');
                opt.value = y;
                opt.textContent = y;
                yearSelect.appendChild(opt);
            });

            const deptSelect = document.getElementById('filterDept');
            deptSelect.innerHTML = '<option value="">Semua Jabatan</option>';
            Array.from(depts).sort().forEach(dp => {
                const opt = document.createElement('option');
                opt.value = dp;
                opt.textContent = dp;
                deptSelect.appendChild(opt);
            });
        }

        function applyFilters() {
            const q = (document.getElementById('filterSearch').value || '').toLowerCase().trim();
            const yr = document.getElementById('filterYear').value;
            const mo = document.getElementById('filterMonth').value;
            const dept = document.getElementById('filterDept').value;
            const kep = document.getElementById('filterKeputusan').value;

            filteredReports = allReports.filter(r => {
                const idStr = formatReportId(r.id).toLowerCase();
                const rawId = String(r.id || '');
                const name = (r.nama_pelapor || r.full_name || '').toLowerCase();
                const asset = (r.jenis_aset || '').toLowerCase();
                const siri = (r.nombor_siri || '').toLowerCase();

                const matchQ = !q || idStr.includes(q) || rawId.includes(q) || name.includes(q) || asset.includes(q) || siri.includes(q);

                let matchDate = true;
                const dStr = r.keputusan_tarikh || r.created_at;
                if (dStr && (yr || mo !== '')) {
                    const d = new Date(dStr);
                    if (!isNaN(d.getTime())) {
                        if (yr && d.getFullYear().toString() !== yr) matchDate = false;
                        if (mo !== '' && d.getMonth().toString() !== mo) matchDate = false;
                    }
                }

                let matchDept = true;
                if (dept) {
                    const d = (r.department || r.location || '').trim();
                    matchDept = (d === dept);
                }

                let matchKep = true;
                if (kep) {
                    matchKep = (r.keputusan === kep);
                }

                return matchQ && matchDate && matchDept && matchKep;
            });

            // Susun yang paling terkini dahulu (keputusan_tarikh desc, id desc)
            filteredReports.sort((a,b) => {
                const tA = a.keputusan_tarikh ? new Date(a.keputusan_tarikh).getTime() : a.id;
                const tB = b.keputusan_tarikh ? new Date(b.keputusan_tarikh).getTime() : b.id;
                if (tB !== tA) return tB - tA;
                return b.id - a.id;
            });

            currentPage = 1;
            renderTable();
        }

        function renderTable() {
            const tbody = document.getElementById('historyTableBody');
            const total = filteredReports.length;

            if (total === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 3rem; color: var(--text-muted); font-style: italic;">📭 Tiada rekod sejarah kelulusan ditemui.</td></tr>';
                updatePagination(0);
                return;
            }

            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = Math.min(startIdx + itemsPerPage, total);
            const pageData = filteredReports.slice(startIdx, endIdx);

            tbody.innerHTML = pageData.map(r => {
                let badge = '';
                if (r.keputusan === 'Diluluskan') {
                    badge = '<span class="status-pill" style="background:#dcfce7; color:#166534; border:1px solid #bbf7d0;">✅ Diluluskan</span>';
                } else if (r.keputusan === 'Tidak Diluluskan') {
                    badge = '<span class="status-pill" style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca;">❌ Tidak Diluluskan</span>';
                } else if (r.keputusan === 'Syor Dilupuskan') {
                    badge = '<span class="status-pill" style="background:#e2e8f0; color:#334155; border:1px solid #cbd5e1;">🗂️ Syor Dilupuskan</span>';
                } else {
                    badge = `<span class="status-pill" style="background:#f1f5f9; color:#475569;">${r.keputusan || '-'}</span>`;
                }

                const reporter = r.nama_pelapor || r.full_name || '-';
                const department = r.department || r.location || '-';

                const rawDecisionDate = r.keputusan_tarikh || r.admin_tarikh;
                const decisionDateStr = rawDecisionDate ? new Date(rawDecisionDate).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

                // Pengiraan ISO
                const isoDays = calcIsoDays(r.created_at, rawDecisionDate);
                let isoBadge = '<span style="color:var(--text-muted);font-size:0.8rem;">—</span>';
                if (isoDays !== null) {
                    const pass = isoDays <= 14;
                    isoBadge = `<span style="display:inline-flex;align-items:center;padding:0.25rem 0.6rem;border-radius:12px;font-size:0.75rem;font-weight:700;background:${pass ? '#dcfce7' : '#fee2e2'};color:${pass ? '#166534' : '#991b1b'};white-space:nowrap;">${pass ? '✅ &le; 14 Hari' : '⚠️ ' + isoDays + ' Hari'}</span>`;
                }

                return `
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s ease;">
                        <td style="padding: 1.1rem 1.25rem; font-weight: 700; color: var(--primary); font-size: 0.9rem;">
                            ${formatReportId(r.id)}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;">${reporter}</div>
                        </td>
                        <td style="padding: 1.1rem 1.25rem; color: var(--text-muted); font-size: 0.85rem;">
                            ${department}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${r.jenis_aset || '-'}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted); font-family: monospace;">S/N: ${r.nombor_siri || '-'}</div>
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${r.admin_name_jawatan || 'Admin ICT'}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted);">${r.admin_jawatan || 'Pegawai Teknikal'}</div>
                        </td>
                        <td style="padding: 1.1rem 1.25rem; font-size: 0.85rem; color: var(--text-main); white-space: nowrap;">
                            ${decisionDateStr}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            ${badge}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            ${isoBadge}
                        </td>
                        <td style="padding: 1.1rem 1.25rem; text-align: center; white-space: nowrap;">
                            <button onclick="openHistoryDetails(${r.id})" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.82rem; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                                📋 Lihat / Cetak
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');

            updatePagination(total);
        }

        function updatePagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const start = totalItems > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0;
            const end = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('paginationInfo').textContent = `Menunjukkan ${start} hingga ${end} daripada ${totalItems} rekod`;
            document.getElementById('prevBtn').disabled = (currentPage === 1);
            document.getElementById('nextBtn').disabled = (currentPage >= totalPages || totalPages === 0);
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredReports.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        }

        function openHistoryDetails(reportId) {
            const r = allReports.find(it => it.id == reportId);
            if (!r) return;
            currentReport = r;

            document.getElementById('modalHistoryTitle').textContent = `Butiran Rekod Laporan KEW.PA-9 (${formatReportId(r.id)})`;
            document.getElementById('p_id').value = r.id;
            document.getElementById('p_reporter').value = r.nama_pelapor || r.full_name || '';
            document.getElementById('p_created_at').value = r.created_at || '';

            // Bahagian I
            document.getElementById('v_jenis').value = r.jenis_aset || '-';
            document.getElementById('v_siri').value = r.nombor_siri || '-';
            document.getElementById('v_pengguna').value = r.pengguna_terakhir || '-';
            document.getElementById('v_tarikh_rosak').value = r.tarikh_kerosakan || '-';
            document.getElementById('v_nama_jawatan').value = (r.nama_pelapor || r.full_name || '') + (r.jawatan_pelapor ? ` / ${r.jawatan_pelapor}` : '');
            document.getElementById('v_lokasi').value = r.location || r.department || '-';
            document.getElementById('v_perihal').value = r.perihal_kerosakan || '-';

            // Lampiran & Bukti
            renderAttachedSpec(r.lampiran_spec);
            renderReportImages(r.images);

            // Proses Semasa
            document.getElementById('v_proses_semasa').value = r.proses_semasa ? `Status Terkini: ${r.proses_semasa}` : 'Selesai Diproses';

            // Bahagian II
            document.getElementById('v_kos_dahulu').value = (r.kos_penyelenggaraan_dahulu !== null && r.kos_penyelenggaraan_dahulu !== undefined) ? Number(r.kos_penyelenggaraan_dahulu).toFixed(2) : '0.00';
            document.getElementById('v_anggaran_kos').value = (r.anggaran_kos !== null && r.anggaran_kos !== undefined) ? Number(r.anggaran_kos).toFixed(2) : '0.00';
            document.getElementById('v_syor').value = r.syor_ulasan || '-';
            document.getElementById('v_admin_nama').value = r.admin_name_jawatan || '-';
            document.getElementById('v_admin_jawatan').value = r.admin_jawatan || 'Pegawai Teknikal ICT';

            // Bahagian III
            document.getElementById('v_keputusan').value = r.keputusan || '-';
            document.getElementById('v_kep_tarikh').value = r.keputusan_tarikh ? new Date(r.keputusan_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
            document.getElementById('v_kep_nama').value = r.keputusan_nama || 'Ketua Jabatan MPM';

            const badgeEl = document.getElementById('v_kep_badge');
            if (badgeEl) {
                badgeEl.textContent = r.keputusan || '';
                badgeEl.style.background = (r.keputusan === 'Diluluskan') ? '#dcfce7' : ((r.keputusan === 'Tidak Diluluskan') ? '#fee2e2' : '#e2e8f0');
                badgeEl.style.color = (r.keputusan === 'Diluluskan') ? '#166534' : ((r.keputusan === 'Tidak Diluluskan') ? '#991b1b' : '#334155');
            }

            // ISO badge
            const isoDays = calcIsoDays(r.created_at, r.keputusan_tarikh || r.admin_tarikh);
            const isoBadgeEl = document.getElementById('v_iso_badge');
            if (isoDays !== null) {
                const pass = isoDays <= 14;
                isoBadgeEl.innerHTML = `<span style="display:inline-flex;align-items:center;padding:0.35rem 0.8rem;border-radius:20px;font-size:0.8rem;font-weight:700;background:${pass ? '#dcfce7' : '#fee2e2'};color:${pass ? '#166534' : '#991b1b'};">${pass ? '✅ Mematuhi ISO' : '⚠️ Melebihi Tempoh ISO'} (${isoDays} hari)</span>`;
            } else {
                isoBadgeEl.innerHTML = '<span style="color:var(--text-muted);font-size:0.85rem;">—</span>';
            }

            document.getElementById('viewModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function renderAttachedSpec(specData) {
            const bodyEl = document.getElementById('v_spec_body');
            const badgeEl = document.getElementById('v_spec_status_badge');
            if (!bodyEl) return;

            let spec = null;
            if (typeof specData === 'string') {
                let cleanStr = specData.trim();
                if (cleanStr.includes('&quot;') || cleanStr.includes('&#039;') || cleanStr.includes('&amp;')) {
                    const txt = document.createElement('textarea');
                    txt.innerHTML = cleanStr;
                    cleanStr = txt.value;
                }
                if (cleanStr.startsWith('{')) {
                    try { spec = JSON.parse(cleanStr); } catch (e) { spec = null; }
                }
            } else if (typeof specData === 'object' && specData !== null) {
                spec = specData;
            }

            if (!spec) {
                if (badgeEl) {
                    badgeEl.textContent = 'Tiada Lampiran Spesifikasi';
                    badgeEl.style.background = '#e2e8f0';
                    badgeEl.style.color = '#475569';
                }
                bodyEl.innerHTML = '<div style="color:var(--text-muted);font-size:0.83rem;font-style:italic;">Tiada data spesifikasi aset yang dilampirkan bagi aduan ini.</div>';
                return;
            }

            if (badgeEl) {
                badgeEl.textContent = 'Spesifikasi Lengkap';
                badgeEl.style.background = '#dcfce7';
                badgeEl.style.color = '#166534';
            }

            const items = [
                { label: 'Jenis Aset', val: spec.asset_type },
                { label: 'Model Komputer', val: spec.model_komputer },
                { label: 'No. Siri Pendaftaran', val: spec.no_siri_pendaftaran },
                { label: 'Serial Number Komputer', val: spec.serial_number },
                { label: 'Model Monitor', val: spec.model_monitor },
                { label: 'Serial Number Monitor', val: spec.serial_monitor },
                { label: 'Sistem Operasi (OS)', val: spec.os },
                { label: 'Pemproses (Processor)', val: spec.processor },
                { label: 'Memori (RAM)', val: spec.ram },
                { label: 'Storan (Hard Disk/SSD)', val: spec.hard_disk },
                { label: 'Alamat IP', val: spec.ip_address },
                { label: 'Pencetak (Printer)', val: spec.printer },
                { label: 'Tetikus & Papan Kekunci', val: (spec.mouse || spec.keyboard) ? `${spec.mouse || '-'} / ${spec.keyboard || '-'}` : '' },
                { label: 'Perisian (Office & Antivirus)', val: (spec.ms_office || spec.antivirus) ? `${spec.ms_office ? 'Office ' + spec.ms_office : '-'} | ${spec.antivirus || '-'}` : '' },
                { label: 'Perisian Lain / Catatan', val: spec.perisian_lain || spec.maklumat_ict }
            ];

            const gridHtml = items
                .filter(it => it.val && it.val !== '-' && it.val !== '')
                .map(it => `
                    <div style="background:#ffffff;padding:0.55rem 0.8rem;border-radius:8px;border:1px solid var(--border);">
                        <div style="font-size:0.73rem;font-weight:600;color:var(--text-muted);margin-bottom:0.15rem;">${it.label}</div>
                        <div style="font-size:0.84rem;font-weight:700;color:var(--text-main);word-break:break-word;">${escapeHtml(it.val)}</div>
                    </div>
                `).join('');

            bodyEl.innerHTML = `
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(210px, 1fr));gap:0.6rem;">
                    ${gridHtml || '<div style="color:var(--text-muted);font-size:0.83rem;">Maklumat spesifikasi kosong.</div>'}
                </div>
            `;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function renderReportImages(images) {
            const container = document.getElementById('v_images_container');
            const bodyEl = document.getElementById('v_images_body');
            const countEl = document.getElementById('v_images_count_badge');
            if (!container || !bodyEl) return;

            if (images && images.length > 0) {
                if (countEl) countEl.textContent = `${images.length} fail`;
                bodyEl.innerHTML = `
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:0.75rem;">
                        ${images.map(img => {
                            const p = typeof img === 'string' ? img : (img.image_path || '');
                            const cleanPath = '../' + p.replace(/^\/+/, '');
                            return `
                                <div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--border);position:relative;background:#000;">
                                    <a href="${cleanPath}" target="_blank" title="Klik untuk besarkan">
                                        <img src="${cleanPath}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                </div>
                            `;
                        }).join('')}
                    </div>
                `;
            } else {
                if (countEl) countEl.textContent = '0 fail';
                bodyEl.innerHTML = `<div style="color:var(--text-muted);font-size:0.83rem;font-style:italic;">Tiada gambar kerosakan dimuat naik oleh pengadu.</div>`;
            }
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
                document.getElementById('pr_admin_tarikh').textContent = currentReport && currentReport.admin_tarikh ? new Date(currentReport.admin_tarikh).toLocaleDateString('ms-MY') : new Date().toLocaleDateString('ms-MY');
                document.getElementById('pr_keputusan_line').innerHTML = kepLine;
                document.getElementById('pr_kep_nama').textContent = document.getElementById('v_kep_nama').value || '';
                document.getElementById('pr_kep_jawatan').textContent = currentReport ? (currentReport.keputusan_jawatan || 'Ketua Jabatan') : 'Ketua Jabatan';
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
