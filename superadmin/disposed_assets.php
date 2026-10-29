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
    <title>Aset Lupus - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .stats-grid-4 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }
        @media (max-width: 1024px) {
            .stats-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 640px) {
            .stats-grid-4 {
                grid-template-columns: 1fr;
            }
        }
        .stat-card-custom {
            background: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }
        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
        }
        .tabs-header {
            display: flex;
            gap: 0.5rem;
            border-bottom: 2px solid var(--border);
            margin-bottom: 1.5rem;
        }
        .tab-btn {
            padding: 0.75rem 1.4rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-muted);
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .tab-btn:hover {
            color: var(--primary);
        }
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        .tab-count-badge {
            background: #e2e8f0;
            color: #334155;
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
            border-radius: 12px;
            font-weight: 800;
        }
        .tab-btn.active .tab-count-badge {
            background: var(--primary-light);
            color: var(--primary);
        }
        .table-action-btn {
            padding: 0.4rem 0.7rem;
            font-size: 0.78rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-main);
        }
        .table-action-btn:hover {
            background: #f1f5f9;
        }
        .badge-method {
            padding: 0.3rem 0.65rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }
        .method-ewaste {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .method-musnah {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .method-jualan {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .method-tukar {
            background: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }
        .method-hadiah {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .method-default {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }
        .asset-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.85rem;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
        }
        .spec-item-card {
            background: #ffffff;
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }
        .spec-item-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .spec-item-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 0.15rem;
        }
        .spec-item-value {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            word-break: break-word;
        }
        .kewpa9-card {
            background: #ffffff;
            border: 1.5px solid #3b82f6;
            border-radius: 14px;
            overflow: hidden;
            margin-top: 1.5rem;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.08);
        }
        .kewpa9-header {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            body.printing-kewpa9 #printableAreaKEWPA9,
            body.printing-kewpa9 #printableAreaKEWPA9 * {
                visibility: visible !important;
            }
            body.printing-kewpa9 #printableAreaKEWPA9 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
                background: white !important;
                color: black !important;
                padding: 1cm;
            }
            body:not(.printing-kewpa9) #printSection,
            body:not(.printing-kewpa9) #printSection * {
                visibility: visible;
            }
            body:not(.printing-kewpa9) #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
                color: black;
                padding: 1.5cm;
            }
            .modal, .sidebar, header, nav {
                display: none !important;
            }
        }

        #printableAreaKEWPA9 {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
        }
        #printableAreaKEWPA9 .pa9-title {
            text-align: right;
            font-size: 11pt;
            font-style: italic;
            margin-bottom: 8px;
        }
        #printableAreaKEWPA9 .pa9-heading {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13pt;
            margin-bottom: 20px;
        }
        #printableAreaKEWPA9 .pa9-section-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
        }
        #printableAreaKEWPA9 .pa9-row {
            display: flex;
            margin-bottom: 4px;
            font-size: 10pt;
            line-height: 1.8;
        }
        #printableAreaKEWPA9 .pa9-label {
            min-width: 160px;
            flex-shrink: 0;
        }
        #printableAreaKEWPA9 .pa9-colon {
            width: 10px;
            text-align: center;
            flex-shrink: 0;
        }
        #printableAreaKEWPA9 .pa9-value {
            flex: 1;
            border-bottom: 1px solid #000;
            padding-left: 4px;
        }
        #printableAreaKEWPA9 .pa9-box {
            border: 1px solid #000;
            padding: 12px;
            width: 240px;
            font-size: 9pt;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        #printableAreaKEWPA9 .pa9-sign-block {
            margin-top: 15px;
        }
        #printableAreaKEWPA9 .pa9-sign-line {
            border-bottom: 1px solid #000;
            height: 30px;
            width: 280px;
            margin-bottom: 3px;
        }
        #printableAreaKEWPA9 .pa9-sign-row {
            display: flex;
            font-size: 10pt;
            line-height: 1.8;
        }
        #printableAreaKEWPA9 .pa9-sign-label {
            width: 70px;
            flex-shrink: 0;
        }
        #printableAreaKEWPA9 .pa9-nota {
            font-size: 9pt;
            margin-top: 30px;
            font-style: italic;
        }
        #printableAreaKEWPA9 .pa9-bahagian2-label {
            width: 240px;
            flex-shrink: 0;
        }
    </style>
    <script src="../assets/js/global.js?v=12"></script>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <img src="../assets/images/logo-mpm.png" alt="MPM Logo" class="logo-image">
                <h2>eICT Desk</h2>
            </div>
            <div class="user-profile" style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Selamat kembali,</p>
                <p id="sidebarSuperadminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Super Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">🪪 Profil Saya</a>
                <a href="reports.php" class="nav-link">📝 Kelulusan Laporan</a>
                <a href="history_reports.php" class="nav-link">📜 Sejarah Laporan</a>
                <a href="users.php" class="nav-link">👤 Pengguna</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link">👥 Aset Staf</a>
                <a href="disposed_assets.php" class="nav-link active">🗑️ Aset Lupus</a>
                <a href="audit_logs.php" class="nav-link">🔎 Jejak Audit</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0).php" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪 Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Super Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Pengurusan Aset Lupus</h2>
                </div>
                <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                    <div id="current-date" style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                        <!-- Tarikh Semasa via JS -->
                    </div>
                </div>
            </header>

            <!-- Ringkasan Statistik Pelupusan -->
            <div class="stats-grid-4">
                <div class="stat-card-custom">
                    <div class="stat-icon-wrapper" style="background: rgba(220, 38, 38, 0.1); color: var(--danger);">
                        🗑️
                    </div>
                    <div>
                        <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Aset Telah Dilupuskan</p>
                        <h3 id="statTotalDisposed" style="font-size: 1.6rem; color: var(--text-main); font-weight: 800; margin: 0.1rem 0;">0</h3>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Tindakan selesai</span>
                    </div>
                </div>

                <div class="stat-card-custom">
                    <div class="stat-icon-wrapper" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        ⚠️
                    </div>
                    <div>
                        <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Cadangan Pelupusan</p>
                        <h3 id="statPendingSyor" style="font-size: 1.6rem; color: #d97706; font-weight: 800; margin: 0.1rem 0;">0</h3>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Syor dari laporan kerosakan</span>
                    </div>
                </div>


                <div class="stat-card-custom">
                    <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                        🏢
                    </div>
                    <div>
                        <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Jabatan Terlibat</p>
                        <h3 id="statDeptCount" style="font-size: 1.6rem; color: #059669; font-weight: 800; margin: 0.1rem 0;">0</h3>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Bahagian / Unit</span>
                    </div>
                </div>
            </div>

            <!-- Heading Senarai Aset Telah Dilupuskan -->
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.25rem;">
                <h3 style="margin: 0; font-size: 1.25rem; color: var(--text-main); font-weight: 700;">
                    📋 Senarai Aset Telah Dilupuskan
                </h3>
                <span class="tab-count-badge" id="tabCountDisposed" style="background: var(--primary-light); color: var(--primary); font-size: 0.85rem; padding: 0.2rem 0.65rem;">0</span>
            </div>

            <!-- ========================================== -->
            <!-- SENARAI ASET TELAH DILUPUSKAN              -->
            <!-- ========================================== -->
            <div id="tabContentDisposed">
                <!-- Penapis Carian -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                        <div class="form-group" style="margin-bottom: 0; flex: 2; min-width: 240px;">
                            <label for="filterSearch" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Carian Aset Lupus</label>
                            <input type="text" id="filterSearch" class="form-control" placeholder="Cari No. Siri, Model, Staf, No. Rujukan..." oninput="handleFilter()">
                        </div>

                        <div class="form-group" style="margin-bottom: 0; flex: 1.2; min-width: 180px;">
                            <label for="filterDept" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Jabatan / Unit</label>
                            <select id="filterDept" class="form-control" onchange="handleFilter()">
                                <option value="">Semua Jabatan</option>
                            </select>
                        </div>

                        <button onclick="resetFilters()" class="btn btn-secondary" style="height: 42px; border-radius: 10px;" title="Set Semula Penapis">
                            ↺ Reset
                        </button>
                    </div>
                </div>

                <!-- Jadual Aset Telah Dilupuskan -->
                <div class="card table-card" style="box-shadow: var(--shadow);">
                    <div class="table-container">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid var(--border);">
                                    <th style="padding: 1rem; width: 16%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">No. Siri / ID</th>
                                    <th style="padding: 1rem; width: 22%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Aset & Model</th>
                                    <th style="padding: 1rem; width: 22%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Pemilik Asal / Jabatan</th>
                                    <th style="padding: 1rem; width: 14%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Tarikh Lupus</th>
                                    <th style="padding: 1rem; width: 14%; font-weight: 700; color: var(--text-main); font-size: 0.88rem; text-align: center;">Status</th>
                                    <th style="padding: 1rem; width: 12%; text-align: center; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="disposedTableBody">
                                <tr><td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-muted);">⏳ Memuatkan rekod aset lupus...</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-top: 1px solid var(--border);">
                        <div class="pagination-info" id="paginationInfo" style="font-size: 0.85rem; color: var(--text-muted);">Menunjukkan 0 hingga 0 daripada 0 rekod</div>
                        <div class="pagination-controls" style="display: flex; gap: 0.5rem;">
                            <button onclick="prevPage()" id="prevBtn" class="pagination-btn" disabled>Sebelumnya</button>
                            <button onclick="nextPage()" id="nextBtn" class="pagination-btn">Seterusnya</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: DAFTAR / KEMASKINI REKOD PELUPUSAN ASET            -->
    <!-- ======================================================== -->
    <div id="disposalModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 800px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2); padding: 2rem;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Tatacara Pelupusan Aset Alih</span>
                    <h2 id="modalDisposalTitle" style="font-size: 1.4rem; color: var(--text-main); margin-top: 0.2rem;">Rekod Pelupusan Aset</h2>
                </div>
                <button type="button" onclick="closeDisposalModal()" style="background: none; border: none; font-size: 1.7rem; color: var(--text-muted); cursor: pointer; line-height: 1;">&times;</button>
            </div>

            <div id="disposalModalAlert" style="display: none; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600;"></div>

            <form id="disposalForm" onsubmit="handleDisposalSubmit(event)">
                <input type="hidden" name="id" id="f_disposal_id">
                <input type="hidden" name="asset_id" id="f_asset_id">
                <input type="hidden" name="report_id" id="f_report_id">

                <!-- Pilih daripada Aset Staf Sedia Ada -->
                <div id="assetSelectorWrapper" style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px dashed var(--border);">
                    <label for="f_select_active_asset" style="font-weight: 700; font-size: 0.88rem; color: var(--text-main); display: block; margin-bottom: 0.4rem;">
                        Pautkan dengan Aset Staf Sedia Ada (Pilihan)
                    </label>
                    <select id="f_select_active_asset" class="form-control" onchange="onActiveAssetSelect(this.value)">
                        <option value="">-- Pilih Aset Staf (atau Masukkan Maklumat Manual di Bawah) --</option>
                    </select>
                    <small style="color: var(--text-muted); display: block; margin-top: 0.35rem;">
                        Memilih aset staf akan mengisi maklumat model, staf dan jabatan secara automatik serta mengemaskini status aset tersebut kepada <em>Dilupuskan</em>.
                    </small>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">No. Siri CPU / Nombor Siri <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="serial_number" id="f_serial_number" class="form-control" placeholder="cth: 0000 / DELL-98213" required>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">No. Siri Pendaftaran Aset</label>
                        <input type="text" name="no_siri_pendaftaran" id="f_no_siri_pendaftaran" class="form-control" placeholder="cth: MPM/ICT/2021/04">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Jenis Aset <span style="color: var(--danger);">*</span></label>
                        <select name="asset_type" id="f_asset_type" class="form-control" required>
                            <option value="Desktop PC">Desktop PC</option>
                            <option value="Laptop">Laptop / NoteBook</option>
                            <option value="Printer">Pencetak / Printer</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Projektor">Projektor</option>
                            <option value="Pengimbas">Pengimbas / Scanner</option>
                            <option value="Lain-lain">Lain-lain Peralatan ICT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Jenama & Model Aset <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="model_komputer" id="f_model_komputer" class="form-control" placeholder="cth: Acer Veriton M200 / Dell OptiPlex" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Pemilik Asal / Nama Staf</label>
                        <input type="text" name="nama_pegawai" id="f_nama_pegawai" class="form-control" placeholder="Nama staf pengguna terakhir">
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Jabatan / Bahagian / Unit</label>
                        <select name="jabatan_unit" id="f_jabatan_unit" class="form-control">
                            <option value="">-- Pilih Jabatan / Unit --</option>
                            <option value="Jabatan Bangunan">Jabatan Bangunan</option>
                            <option value="Jabatan Kejuruteraan">Jabatan Kejuruteraan</option>
                            <option value="Jabatan Kesihatan dan Pelesenan">Jabatan Kesihatan dan Pelesenan</option>
                            <option value="Jabatan Kewangan">Jabatan Kewangan</option>
                            <option value="Jabatan Khidmat Pengurusan">Jabatan Khidmat Pengurusan</option>
                            <option value="Jabatan Komunikasi Koprat dan Kemasyarakatan">Jabatan Komunikasi Koprat dan Kemasyarakatan</option>
                            <option value="Jabatan Penguatkuasaan">Jabatan Penguatkuasaan</option>
                            <option value="Jabatan Penilaian dan Pengurusan Harta">Jabatan Penilaian dan Pengurusan Harta</option>
                            <option value="Jabatan Perancangan dan Pembangunan Landskap">Jabatan Perancangan dan Pembangunan Landskap</option>
                            <option value="Kaunter Hasil">Kaunter Hasil</option>
                            <option value="Pejabat Setiausaha">Pejabat Setiausaha</option>
                            <option value="Pejabat YDP">Pejabat YDP</option>
                            <option value="Unit Audit Dalaman">Unit Audit Dalaman</option>
                            <option value="Unit Perolehan dan Pengurusan Kontrak">Unit Perolehan dan Pengurusan Kontrak</option>
                            <option value="Unit Persuruhjaya Bangunan">Unit Persuruhjaya Bangunan</option>
                            <option value="Unit Pusat Setempat">Unit Pusat Setempat</option>
                            <option value="Unit Teknologi Maklumat">Unit Teknologi Maklumat</option>
                            <option value="Unit Undang-Undang">Unit Undang-Undang</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Tarikh Pelupusan <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="tarikh_lupus" id="f_tarikh_lupus" class="form-control" required>
                    <input type="hidden" name="kaedah_pelupusan" id="f_kaedah_pelupusan" value="-">
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">No. Rujukan Kelulusan Pelupusan</label>
                        <input type="text" name="no_rujukan_kelulusan" id="f_no_rujukan_kelulusan" class="form-control" placeholder="cth: MPM/BTM/LUPUS/2026/01">
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Pegawai Pelulus / Pengesah</label>
                        <input type="text" name="pegawai_pelulus" id="f_pegawai_pelulus" class="form-control" placeholder="Nama Pegawai Pelulus">
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Sebab / Justifikasi Pelupusan <span style="color: var(--danger);">*</span></label>
                    <textarea name="sebab_lupus" id="f_sebab_lupus" class="form-control" rows="2" placeholder="Nyatakan justifikasi (cth: Rosak teruk tidak ekonomi dibaiki, Usang melebihi had umur ekonomi, Tiada alat ganti di pasaran)..." required></textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Catatan Tambahan</label>
                    <textarea name="catatan" id="f_catatan" class="form-control" rows="2" placeholder="Sebarang catatan tambahan mengenai aset atau sijil pelupusan..."></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
                    <button type="button" onclick="closeDisposalModal()" class="btn btn-secondary" style="padding: 0.65rem 1.4rem;">Batal</button>
                    <button type="submit" id="btnSubmitDisposal" class="btn btn-primary" style="padding: 0.65rem 1.5rem; font-weight: 700;">Simpan Rekod Pelupusan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: LIHAT BUTIRAN LENGKAP ASET LUPUS                 -->
    <!-- ======================================================== -->
    <div id="viewDetailModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 950px; width: 100%; max-height: 92vh; overflow-y: auto; box-shadow: 0 25px 70px rgba(0,0,0,0.25); padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.9rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px;">Portal Super Admin &bull; Rekod Pelupusan</span>
                    <h2 style="margin: 0.2rem 0 0; font-size: 1.4rem; color: var(--text-main);">Butiran Inventori & Pelupusan Aset</h2>
                </div>
                <button type="button" onclick="closeViewDetailModal()" style="background: none; border: none; font-size: 1.8rem; color: var(--text-muted); cursor: pointer; line-height: 1;">&times;</button>
            </div>
            
            <div id="viewDetailContent" style="font-size: 0.9rem; line-height: 1.6;">
                <!-- Dinamik via JS -->
            </div>
            
            <div id="viewDetailFooter" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.75rem; border-top: 1px solid var(--border); padding-top: 1.1rem; flex-wrap: wrap; gap: 0.75rem;">
                <div id="viewDetailActionBtns" style="display: flex; gap: 0.6rem; flex-wrap: wrap;"></div>
                <button type="button" onclick="closeViewDetailModal()" class="btn btn-secondary" style="padding: 0.6rem 1.5rem; font-weight: 600;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL / PRINT SECTION: CETAK KEW.PA-19 BORANG PELUPUSAN  -->
    <!-- ======================================================== -->
    <div id="printModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 16px; max-width: 900px; width: 100%; max-height: 92vh; overflow-y: auto; padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem;">
                <h3 style="margin: 0; font-size: 1.2rem;">Pratonton Borang Pelupusan (KEW.PA-19)</h3>
                <div style="display: flex; gap: 0.5rem;">
                    <button onclick="window.print()" class="btn btn-primary" style="padding: 0.4rem 1rem; font-weight: 700;">🖨️ Cetak Dokumen</button>
                    <button onclick="document.getElementById('printModal').style.display='none'" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;">Tutup</button>
                </div>
            </div>

            <div id="printSection" style="padding: 1rem; font-family: 'Outfit', sans-serif; color: #1e293b;">
                <div style="text-align: right; font-weight: 700; font-size: 0.9rem; margin-bottom: 0.5rem;">KEW.PA-19</div>
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <img src="../assets/images/logo-mpm.png" alt="MPM Logo" style="height: 65px; margin-bottom: 0.5rem;">
                    <h3 style="margin: 0; text-transform: uppercase; font-size: 1.1rem; color: #0f172a;">MAJLIS PERBANDARAN MANJUNG</h3>
                    <h4 style="margin: 0.3rem 0; font-size: 0.95rem; text-decoration: underline;">LAPORAN PELUPUSAN ASET ALIH</h4>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0;">Bahagian Teknologi Maklumat | Penjanaan Sistem eICT Desk</p>
                </div>

                <div style="margin-bottom: 1rem; font-size: 0.85rem; display: flex; justify-content: space-between;">
                    <div><strong>Tarikh Cetakan:</strong> <span id="printCurrentDate">-</span></div>
                    <div><strong>Kategori:</strong> Peralatan ICT & Perkakasan Komputer</div>
                </div>

                <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem; margin-bottom: 2rem;" border="1">
                    <thead>
                        <tr style="background: #f1f5f9; text-align: center;">
                            <th style="padding: 6px;">Bil</th>
                            <th style="padding: 6px;">Keterangan / Model Aset</th>
                            <th style="padding: 6px;">No. Siri / Pendaftaran</th>
                            <th style="padding: 6px;">Jabatan Asal</th>
                            <th style="padding: 6px;">Tarikh Lupus</th>
                            <th style="padding: 6px;">Justifikasi Pelupusan</th>
                        </tr>
                    </thead>
                    <tbody id="printTableBody">
                        <!-- Loaded dynamically -->
                    </tbody>
                </table>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 3rem; font-size: 0.85rem;">
                    <div>
                        <p style="margin-bottom: 3.5rem;">Disediakan Oleh:</p>
                        <p style="border-top: 1px dotted #475569; padding-top: 0.4rem; font-weight: 700; margin: 0;">( Super Admin eICT Desk )</p>
                        <p style="color: #64748b; font-size: 0.8rem; margin: 0;">Bahagian Teknologi Maklumat, MPM</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 3.5rem;">Disahkan & Diluluskan Oleh:</p>
                        <p style="border-top: 1px dotted #475569; padding-top: 0.4rem; font-weight: 700; margin: 0;">( Pegawai Aset / Ketua Jabatan )</p>
                        <p style="color: #64748b; font-size: 0.8rem; margin: 0;">Majlis Perbandaran Manjung</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Printable KEW.PA-9 (Rasmi) -->
    <div id="printableAreaKEWPA9" style="display: none; padding: 10px;">
        <div class="pa9-title">KEW.PA-9</div>
        <div class="pa9-heading">BORANG ADUAN KEROSAKAN ASET ALIH</div>

        <div class="pa9-section-title">Bahagian I (Untuk diisi oleh Pengadu)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row">
                    <span class="pa9-label">1. Jenis Aset</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="kpr_jenis"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">2. Nombor Siri Pendaftaran Aset/ Komponen</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="kpr_siri"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">3. Pengguna Terakhir</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="kpr_pengguna"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">4. Tarikh Kerosakan</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="kpr_tarikh_rosak"></span>
                </div>
                <div class="pa9-row">
                    <span class="pa9-label">5. Perihal Kerosakan</span>
                    <span class="pa9-colon">:</span>
                    <span class="pa9-value" id="kpr_perihal"></span>
                </div>
            </div>
            <div class="pa9-box">
                <div style="font-weight: bold; margin-bottom: 5px;">Tandatangan Pengadu:</div>
                <div class="pa9-sign-block" style="margin-top: auto;">
                    <div class="pa9-sign-line"></div>
                    <div>Nama: <span id="kpr_nama"></span></div>
                    <div>Jawatan: <span id="kpr_jawatan"></span></div>
                    <div>Tarikh: <span id="kpr_tarikh_aduan"></span></div>
                </div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian II (Untuk diisi oleh Pegawai Aset/ Pegawai Teknikal)</div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">6. Jumlah Kos Penyelenggaraan Terdahulu</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="kpr_kos_dahulu"></span>
        </div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">7. Anggaran Kos Penyelenggaraan</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="kpr_anggaran_kos"></span>
        </div>
        <div class="pa9-row">
            <span class="pa9-bahagian2-label">8. Syor Dan Ulasan</span>
            <span class="pa9-colon">:</span>
            <span class="pa9-value" id="kpr_syor"></span>
        </div>
        <div class="pa9-sign-block" style="margin-top: 25px; margin-left: 20px;">
            <div class="pa9-sign-line"></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tandatangan</span><span>:</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Nama</span><span>: <span id="kpr_admin_nama"></span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Jawatan</span><span>: Pegawai Teknikal ICT</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tarikh</span><span>: <span id="kpr_admin_tarikh"></span></span></div>
        </div>

        <div class="pa9-section-title" style="margin-top: 25px;">Bahagian III (Keputusan Ketua Jabatan/ Bahagian/ Seksyen/ Unit)</div>
        <div style="font-size: 10pt; line-height: 1.8; margin-bottom: 10px;">
            9. Diluluskan / Tidak Diluluskan / Syor Dilupuskan :
            <div style="margin-top: 5px; font-weight: bold; font-size: 11pt;" id="kpr_keputusan_line"></div>
        </div>
        <div class="pa9-sign-block" style="margin-top: 25px; margin-left: 20px;">
            <div class="pa9-sign-line"></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tandatangan</span><span>:</span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Nama</span><span>: <span id="kpr_kep_nama"></span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Jawatan</span><span>: <span id="kpr_kep_jawatan">Ketua Jabatan</span></span></div>
            <div class="pa9-sign-row"><span class="pa9-sign-label">Tarikh</span><span>: <span id="kpr_kep_tarikh"></span></span></div>
        </div>

        <div class="pa9-nota">Nota: * Potong mana yang tidak berkenaan.</div>
    </div>

    <!-- SCRIPT JAVASCRIPT LOGIK PENGURUSAN ASET LUPUS -->
    <script>
        let allDisposed = [];
        let filteredDisposed = [];
        let pendingReports = [];
        let activeStaffAssets = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        let activeTab = 'disposed';

        document.addEventListener('DOMContentLoaded', () => {
            const dateElem = document.getElementById('current-date');
            if (dateElem) {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateElem.textContent = now.toLocaleDateString('ms-MY', options);
            }
            document.getElementById('printCurrentDate').textContent = new Date().toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' });
            
            // Set default date for disposal form
            document.getElementById('f_tarikh_lupus').value = new Date().toISOString().split('T')[0];

            fetchDisposedData();
            fetchActiveStaffAssets();
        });

        function switchTab(tab) {
            activeTab = tab;
            const btnDisposed = document.getElementById('tabBtnDisposed');
            const btnPending = document.getElementById('tabBtnPending');
            const contentDisposed = document.getElementById('tabContentDisposed');
            const contentPending = document.getElementById('tabContentPending');

            if (tab === 'disposed') {
                if (btnDisposed) btnDisposed.classList.add('active');
                if (btnPending) btnPending.classList.remove('active');
                if (contentDisposed) contentDisposed.style.display = 'block';
                if (contentPending) contentPending.style.display = 'none';
            } else {
                if (btnPending) btnPending.classList.add('active');
                if (btnDisposed) btnDisposed.classList.remove('active');
                if (contentPending) contentPending.style.display = 'block';
                if (contentDisposed) contentDisposed.style.display = 'none';
                renderPendingTable();
            }
        }

        async function fetchDisposedData() {
            try {
                const res = await fetch('../api/admin/admin_get_disposed_assets.php?_t=' + Date.now());
                const result = await res.json();

                if (result.status === 'success') {
                    allDisposed = result.data.disposed_assets || [];
                    filteredDisposed = [...allDisposed];
                    pendingReports = result.data.pending_reports || [];

                    // Update Badge Counts
                    if (document.getElementById('tabCountDisposed')) {
                        document.getElementById('tabCountDisposed').textContent = allDisposed.length;
                    }
                    if (document.getElementById('tabCountPending')) {
                        document.getElementById('tabCountPending').textContent = pendingReports.length;
                    }

                    // Update Stats
                    if (document.getElementById('statTotalDisposed')) {
                        document.getElementById('statTotalDisposed').textContent = allDisposed.length;
                    }
                    if (document.getElementById('statPendingSyor')) {
                        document.getElementById('statPendingSyor').textContent = pendingReports.length;
                    }
                    
                    // Unique depts
                    const depts = new Set();
                    allDisposed.forEach(d => { if (d.jabatan_unit) depts.add(d.jabatan_unit); });
                    if (document.getElementById('statDeptCount')) {
                        document.getElementById('statDeptCount').textContent = depts.size;
                    }

                    // Populate Dept Filter Dropdown
                    populateDeptFilter(depts);

                    renderDisposedTable();
                    if (typeof renderPendingTable === 'function' && document.getElementById('pendingTableBody')) {
                        renderPendingTable();
                    }
                } else {
                    document.getElementById('disposedTableBody').innerHTML = `<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--danger);">❌ ${result.message}</td></tr>`;
                }
            } catch (err) {
                document.getElementById('disposedTableBody').innerHTML = `<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--danger);">❌ Ralat sambungan: ${err.message}</td></tr>`;
            }
        }

        async function fetchActiveStaffAssets() {
            try {
                const res = await fetch('../api/admin/admin_get_assets.php?_t=' + Date.now());
                const result = await res.json();
                if (result.status === 'success' && result.data) {
                    activeStaffAssets = result.data;
                    const select = document.getElementById('f_select_active_asset');
                    select.innerHTML = '<option value="">-- Pilih Aset Staf (atau Masukkan Maklumat Manual di Bawah) --</option>';
                    activeStaffAssets.forEach(a => {
                        const opt = document.createElement('option');
                        opt.value = a.id;
                        const statusNote = a.status === 'Dilupuskan' ? ' [Sudah Dilupuskan]' : '';
                        opt.textContent = `${a.serial_number || 'Tiada S/N'} - ${a.model_komputer || 'PC'} (${a.nama_pegawai || a.name || 'Staf'}) ${statusNote}`;
                        select.appendChild(opt);
                    });
                }
            } catch (err) {
                console.warn('Gagal memuat aset staf sedia ada:', err);
            }
        }

        function onActiveAssetSelect(assetId) {
            if (!assetId) return;
            const asset = activeStaffAssets.find(a => a.id == assetId);
            if (asset) {
                document.getElementById('f_asset_id').value = asset.id;
                document.getElementById('f_serial_number').value = asset.serial_number || '';
                document.getElementById('f_no_siri_pendaftaran').value = asset.no_siri_pendaftaran || asset.serial_number || '';
                document.getElementById('f_asset_type').value = asset.asset_type || 'Desktop PC';
                document.getElementById('f_model_komputer').value = asset.model_komputer || '';
                document.getElementById('f_nama_pegawai').value = asset.nama_pegawai || asset.name || '';
                
                const dept = asset.jabatan_unit || asset.department || '';
                if (dept) {
                    document.getElementById('f_jabatan_unit').value = dept;
                }
                document.getElementById('f_sebab_lupus').value = 'Rosak teruk dan tidak ekonomik dibaiki / Melebihi tempoh jangka hayat ekonomik.';
            }
        }

        function populateDeptFilter(deptSet) {
            const select = document.getElementById('filterDept');
            const currentVal = select.value;
            select.innerHTML = '<option value="">Semua Jabatan</option>';
            Array.from(deptSet).sort().forEach(dept => {
                const opt = document.createElement('option');
                opt.value = dept;
                opt.textContent = dept;
                if (dept === currentVal) opt.selected = true;
                select.appendChild(opt);
            });
        }

        function handleFilter() {
            const query = document.getElementById('filterSearch').value.toLowerCase().trim();
            const dept = document.getElementById('filterDept').value;

            filteredDisposed = allDisposed.filter(d => {
                const snMatch = (d.serial_number || '').toLowerCase().includes(query);
                const regMatch = (d.no_siri_pendaftaran || '').toLowerCase().includes(query);
                const modelMatch = (d.model_komputer || '').toLowerCase().includes(query);
                const staffMatch = (d.nama_pegawai || '').toLowerCase().includes(query);
                const refMatch = (d.no_rujukan_kelulusan || '').toLowerCase().includes(query);
                const queryPass = !query || snMatch || regMatch || modelMatch || staffMatch || refMatch;

                const deptPass = !dept || d.jabatan_unit === dept;

                return queryPass && deptPass;
            });

            currentPage = 1;
            renderDisposedTable();
        }

        function resetFilters() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterDept').value = '';
            handleFilter();
        }

        function getMethodBadge(method) {
            let cls = 'method-default';
            if (!method) return `<span class="badge-method ${cls}">Tidak Dinyatakan</span>`;
            if (method.includes('E-Waste')) cls = 'method-ewaste';
            else if (method.includes('Musnah')) cls = 'method-musnah';
            else if (method.includes('Jualan')) cls = 'method-jualan';
            else if (method.includes('Pindahan')) cls = 'method-tukar';
            else if (method.includes('Hadiah')) cls = 'method-hadiah';
            return `<span class="badge-method ${cls}">${method}</span>`;
        }

        function formatDateSafe(dateStr, fallback = '-') {
            if (!dateStr || dateStr === '0000-00-00' || dateStr === '0000-00-00 00:00:00' || dateStr === 'null') {
                return fallback;
            }
            try {
                const cleanStr = typeof dateStr === 'string' ? dateStr.trim().replace(' ', 'T') : dateStr;
                const d = new Date(cleanStr);
                if (isNaN(d.getTime())) {
                    if (typeof dateStr === 'string' && /^\d{4}-\d{2}-\d{2}/.test(dateStr)) {
                        const parts = dateStr.substring(0, 10).split('-');
                        const y = parseInt(parts[0], 10);
                        const m = parseInt(parts[1], 10);
                        const day = parseInt(parts[2], 10);
                        if (y > 1970 && m >= 1 && m <= 12 && day >= 1 && day <= 31) {
                            const months = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
                            return `${day} ${months[m - 1]} ${y}`;
                        }
                    }
                    return fallback;
                }
                return d.toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' });
            } catch (e) {
                return fallback;
            }
        }

        function renderDisposedTable() {
            const tbody = document.getElementById('disposedTableBody');
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = filteredDisposed.slice(start, end);

            if (!filteredDisposed.length) {
                tbody.innerHTML = '<tr><td colspan="6" style="padding:2.5rem;text-align:center;color:var(--text-muted)">Tiada rekod aset lupus ditemui.</td></tr>';
                updatePagination(0);
                return;
            }

            tbody.innerHTML = pageItems.map(d => {
                const dataSafe = JSON.stringify(d).replace(/'/g, "&#39;");
                return `
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">
                            <div>${escapeHtml(d.serial_number || 'N/A')}</div>
                            ${d.no_siri_pendaftaran && d.no_siri_pendaftaran !== d.serial_number ? `<span style="font-size:0.75rem; color:var(--text-muted);">${escapeHtml(d.no_siri_pendaftaran)}</span>` : ''}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle;">
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${escapeHtml(d.model_komputer || '-')}</div>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">${escapeHtml(d.asset_type || 'Desktop PC')}</span>
                        </td>
                        <td style="padding: 1rem; vertical-align: middle;">
                            <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">${escapeHtml(d.nama_pegawai || 'Tiada Staf')}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">${escapeHtml(d.jabatan_unit || '-')}</div>
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-size: 0.85rem; color: var(--text-main); white-space: nowrap;">
                            📅 ${formatDateSafe(d.tarikh_lupus, escapeHtml(d.tarikh_lupus || '-'))}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            ${d.status === 'Syor Dilupuskan' 
                                ? `<span class="status-pill" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 0.75rem; font-weight: 700;">🗂️ Syor Dilupuskan</span>`
                                : `<span class="status-pill" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.75rem; font-weight: 700;">✅ Dilupuskan</span>`
                            }
                            ${d.report_id ? `<div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px;"><a href="reports.php?id=${d.report_id}" style="color:var(--primary); font-weight:700; text-decoration:none;" title="Lihat Laporan KEW.PA-9">📄 KEW.PA-9 #${d.report_id}</a></div>` : ''}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            <div style="display: flex; gap: 0.35rem; justify-content: center; flex-wrap: wrap;">
                                <button onclick="viewDisposalDetailById(${d.id})" class="table-action-btn" title="Lihat Butiran">
                                    📃
                                </button>
                                <button onclick="restoreAsset(${d.id}, '${(d.serial_number||'').replace(/'/g, "\\'")}')" class="table-action-btn" title="Pulihkan ke Aset Aktif" style="color: #059669;">
                                    🔄
                                </button>
                                <button onclick="deleteDisposal(${d.id}, '${(d.serial_number||'').replace(/'/g, "\\'")}')" class="table-action-btn" title="Padam Rekod" style="color: var(--danger);">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            updatePagination(filteredDisposed.length);
        }

        function renderPendingTable() {
            const tbody = document.getElementById('pendingTableBody');
            if (!tbody) return;
            if (!pendingReports || pendingReports.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="padding:2.5rem;text-align:center;color:var(--text-muted)">🎉 Tiada aduan yang menunggu tindakan pelupusan pada masa ini.</td></tr>';
                return;
            }

            tbody.innerHTML = pendingReports.map(r => {
                const rSafe = JSON.stringify(r).replace(/'/g, "&#39;");
                return `
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 700; color: var(--primary);">
                            #${r.id}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 700; color: var(--text-main);">
                            ${r.nombor_siri || 'N/A'}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 600;">
                            ${r.jenis_aset || '-'}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle;">
                            <div style="font-weight: 600;">${r.nama_pelapor || r.pengguna_terakhir || '-'}</div>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">${r.staff_department || r.location || '-'}</span>
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-size: 0.85rem; color: var(--text-muted); line-height: 1.4;">
                            ${r.perihal_kerosakan || '-'}
                            ${r.syor_ulasan ? `<div style="font-size: 0.78rem; color: #b45309; margin-top: 0.2rem;"><em>Ulasan: ${r.syor_ulasan}</em></div>` : ''}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            <button onclick='recordFromReport(${rSafe})' class="btn btn-primary" style="padding: 0.45rem 0.9rem; font-size: 0.8rem; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                                ⚡ Rekodkan Pelupusan
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function updatePagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const start = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('paginationInfo').textContent = totalItems > 0 
                ? `Menunjukkan ${start} hingga ${end} daripada ${totalItems} rekod`
                : `Menunjukkan 0 hingga 0 daripada 0 rekod`;

            document.getElementById('prevBtn').disabled = currentPage <= 1;
            document.getElementById('nextBtn').disabled = currentPage >= totalPages || totalPages === 0;
        }

        function nextPage() {
            currentPage++;
            renderDisposedTable();
        }

        function prevPage() {
            currentPage--;
            renderDisposedTable();
        }

        // ==========================================
        // MODAL HANDLERS
        // ==========================================
        function openDisposalModal() {
            document.getElementById('modalDisposalTitle').textContent = 'Rekod Pelupusan Aset Baharu';
            document.getElementById('disposalForm').reset();
            document.getElementById('f_disposal_id').value = '';
            document.getElementById('f_asset_id').value = '';
            document.getElementById('f_report_id').value = '';
            document.getElementById('f_tarikh_lupus').value = new Date().toISOString().split('T')[0];
            document.getElementById('assetSelectorWrapper').style.display = 'block';
            document.getElementById('disposalModalAlert').style.display = 'none';
            document.getElementById('disposalModal').style.display = 'flex';
        }

        function openEditDisposalModal(data) {
            if (typeof data === 'number' || typeof data === 'string') {
                data = allDisposed.find(x => x.id == data) || filteredDisposed.find(x => x.id == data) || {};
            }
            document.getElementById('modalDisposalTitle').textContent = 'Kemaskini Maklumat Aset Lupus';
            document.getElementById('f_disposal_id').value = data.id || '';
            document.getElementById('f_asset_id').value = data.asset_id || '';
            document.getElementById('f_report_id').value = data.report_id || '';
            document.getElementById('f_serial_number').value = data.serial_number || '';
            document.getElementById('f_no_siri_pendaftaran').value = data.no_siri_pendaftaran || '';
            document.getElementById('f_asset_type').value = data.asset_type || 'Desktop PC';
            document.getElementById('f_model_komputer').value = data.model_komputer || '';
            document.getElementById('f_nama_pegawai').value = data.nama_pegawai || '';
            document.getElementById('f_jabatan_unit').value = data.jabatan_unit || '';
            document.getElementById('f_tarikh_lupus').value = data.tarikh_lupus || new Date().toISOString().split('T')[0];
            document.getElementById('f_kaedah_pelupusan').value = data.kaedah_pelupusan || 'E-Waste / Buangan Terjadual';
            document.getElementById('f_no_rujukan_kelulusan').value = data.no_rujukan_kelulusan || '';
            document.getElementById('f_pegawai_pelulus').value = data.pegawai_pelulus || '';
            document.getElementById('f_sebab_lupus').value = data.sebab_lupus || '';
            document.getElementById('f_catatan').value = data.catatan || '';
            
            // Sembunyikan selector aset aktif semasa mode edit
            document.getElementById('assetSelectorWrapper').style.display = 'none';
            document.getElementById('disposalModalAlert').style.display = 'none';
            document.getElementById('disposalModal').style.display = 'flex';
        }

        function recordFromReport(rep) {
            openDisposalModal();
            document.getElementById('modalDisposalTitle').textContent = `Rekod Pelupusan bagi Laporan #${rep.id}`;
            document.getElementById('f_report_id').value = rep.id;
            document.getElementById('f_asset_id').value = rep.asset_id || '';
            document.getElementById('f_serial_number').value = rep.nombor_siri || '';
            document.getElementById('f_no_siri_pendaftaran').value = rep.nombor_siri || '';
            document.getElementById('f_asset_type').value = rep.jenis_aset || 'Desktop PC';
            document.getElementById('f_model_komputer').value = rep.jenis_aset || '';
            document.getElementById('f_nama_pegawai').value = rep.nama_pelapor || rep.pengguna_terakhir || '';
            document.getElementById('f_jabatan_unit').value = rep.staff_department || rep.location || '';
            document.getElementById('f_sebab_lupus').value = rep.perihal_kerosakan ? `Aduan #${rep.id}: ${rep.perihal_kerosakan}` : 'Disyorkan lupus melalui kelulusan aduan kerosakan.';
            if (rep.keputusan_nama) {
                document.getElementById('f_pegawai_pelulus').value = rep.keputusan_nama;
            }
        }

        function closeDisposalModal() {
            document.getElementById('disposalModal').style.display = 'none';
        }

        async function handleDisposalSubmit(event) {
            event.preventDefault();
            const btn = document.getElementById('btnSubmitDisposal');
            const alertBox = document.getElementById('disposalModalAlert');
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';

            const form = document.getElementById('disposalForm');
            const formData = new FormData(form);

            try {
                const res = await fetch('../api/admin/admin_manage_disposal.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();

                if (result.status === 'success') {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#dcfce7';
                    alertBox.style.color = '#15803d';
                    alertBox.textContent = '✅ ' + result.message;

                    setTimeout(() => {
                        closeDisposalModal();
                        fetchDisposedData();
                        fetchActiveStaffAssets();
                    }, 800);
                } else {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#fee2e2';
                    alertBox.style.color = '#b91c1c';
                    alertBox.textContent = '❌ ' + (result.message || 'Ralat semasa menyimpan rekod.');
                }
            } catch (err) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#fee2e2';
                alertBox.style.color = '#b91c1c';
                alertBox.textContent = '❌ Ralat penghantaran: ' + err.message;
            } finally {
                btn.disabled = false;
                btn.textContent = 'Simpan Rekod Pelupusan';
            }
        }

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function renderKaedahBadge(method) {
            return getMethodBadge(method);
        }

        function closeViewDetailModal() {
            document.getElementById('viewDetailModal').style.display = 'none';
        }

        function printKEWPA9Direct(reportData) {
            let r = null;
            if (typeof reportData === 'object' && reportData !== null) {
                r = reportData;
            } else if (reportData) {
                const found = allDisposed.find(item => item.report_id == reportData && item.kewpa9_report)
                           || allDisposed.find(item => item.kewpa9_report && item.kewpa9_report.id == reportData);
                r = found ? found.kewpa9_report : null;
            }
            if (!r && window.currentViewingDisposal && window.currentViewingDisposal.kewpa9_report) {
                r = window.currentViewingDisposal.kewpa9_report;
            }
            if (!r) {
                alert('Maklumat laporan KEW.PA-9 tidak lengkap untuk dicetak.');
                return;
            }

            const kosDahulu = parseFloat(r.kos_penyelenggaraan_dahulu || 0);
            const anggaranKos = parseFloat(r.anggaran_kos || 0);
            const kep = r.keputusan || 'Syor Dilupuskan';
            const kepLine = kep === 'Diluluskan'
                ? '<u><strong>Diluluskan</strong></u>/ Tidak Diluluskan/ Syor Dilupuskan*'
                : kep === 'Tidak Diluluskan'
                    ? 'Diluluskan/ <u><strong>Tidak Diluluskan</strong></u>/ Syor Dilupuskan*'
                    : kep === 'Syor Dilupuskan'
                        ? 'Diluluskan/ Tidak Diluluskan/ <u><strong>Syor Dilupuskan</strong></u>*'
                        : 'Diluluskan/ Tidak Diluluskan/ Syor Dilupuskan*';

            document.getElementById('kpr_jenis').textContent = r.jenis_aset || '-';
            document.getElementById('kpr_siri').textContent = r.nombor_siri || '-';
            document.getElementById('kpr_pengguna').textContent = r.pengguna_terakhir || '-';
            document.getElementById('kpr_tarikh_rosak').textContent = formatDateSafe(r.tarikh_kerosakan, r.tarikh_kerosakan || '-');
            document.getElementById('kpr_perihal').textContent = r.perihal_kerosakan || '-';
            document.getElementById('kpr_nama').textContent = r.nama_pelapor || r.reporter_user_name || '-';
            document.getElementById('kpr_jawatan').textContent = r.jawatan_pelapor || r.reporter_user_jawatan || '-';
            document.getElementById('kpr_tarikh_aduan').textContent = formatDateSafe(r.created_at, '-');

            document.getElementById('kpr_kos_dahulu').textContent = 'RM ' + kosDahulu.toFixed(2);
            document.getElementById('kpr_anggaran_kos').textContent = 'RM ' + anggaranKos.toFixed(2);
            document.getElementById('kpr_syor').textContent = r.syor_ulasan || '-';
            document.getElementById('kpr_admin_nama').textContent = r.admin_name_jawatan || '-';
            document.getElementById('kpr_admin_tarikh').textContent = formatDateSafe(r.admin_tarikh, r.admin_tarikh || '-');

            document.getElementById('kpr_keputusan_line').innerHTML = kepLine;
            document.getElementById('kpr_kep_nama').textContent = r.keputusan_nama || 'Super Admin';
            document.getElementById('kpr_kep_jawatan').textContent = r.keputusan_jawatan || 'Ketua Jabatan / Super Admin';
            document.getElementById('kpr_kep_tarikh').textContent = formatDateSafe((r.keputusan_tarikh && r.keputusan_tarikh !== '0000-00-00') ? r.keputusan_tarikh : (window.currentViewingDisposal ? window.currentViewingDisposal.tarikh_lupus : ''), '-');

            document.body.classList.add('printing-kewpa9');
            window.print();
            setTimeout(() => {
                document.body.classList.remove('printing-kewpa9');
            }, 1000);
        }

        function viewDisposalDetailById(id) {
            const d = allDisposed.find(x => x.id == id) || filteredDisposed.find(x => x.id == id);
            if (d) {
                viewDisposalDetail(d);
            } else {
                console.warn('Aset lupus tidak dijumpai dengan ID:', id);
            }
        }

        function viewDisposalDetail(d) {
            if (typeof d === 'number' || typeof d === 'string') {
                return viewDisposalDetailById(d);
            }
            const container = document.getElementById('viewDetailContent');
            const footerActions = document.getElementById('viewDetailActionBtns');
            if (!container) return;

            window.currentViewingDisposal = d;

            const rep = d.kewpa9_report || null;
            const assetImages = d.asset_images || [];

            // Status Badge
            const statusBadge = d.status === 'Syor Dilupuskan'
                ? `<span class="status-pill" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 0.8rem; font-weight: 700; padding: 0.25rem 0.75rem;">🗂️ Syor Dilupuskan</span>`
                : `<span class="status-pill" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.8rem; font-weight: 700; padding: 0.25rem 0.75rem;">✅ Selesai Dilupuskan</span>`;

            // Specs items for Bahagian B
            const specItems = [
                { label: 'Jenis Aset', val: d.asset_type || 'Desktop PC' },
                { label: 'Jenama & Model Komputer', val: d.model_komputer || '-' },
                { label: 'No. Siri CPU / Komputer Riba', val: d.serial_number || '-' },
                { label: 'No. Siri Pendaftaran', val: d.no_siri_pendaftaran || '-' },
                { label: 'Model Monitor', val: d.model_monitor || '-' },
                { label: 'No. Siri Monitor', val: d.serial_monitor || '-' },
                { label: 'Sistem Operasi (OS)', val: d.os || '-' },
                { label: 'Model Pemproses (Processor)', val: d.processor || '-' },
                { label: 'Model & Kapasiti RAM', val: d.ram || '-' },
                { label: 'Jenis Cakera Keras (HDD/SSD)', val: d.hard_disk || '-' },
                { label: 'Tetikus & Papan Kekunci', val: (d.mouse || d.keyboard) ? `${d.mouse || '-'} / ${d.keyboard || '-'}` : '-' },
                { label: 'Versi Microsoft Office', val: d.ms_office ? `Office ${d.ms_office}` : '-' },
                { label: 'Versi Antivirus', val: d.antivirus || '-' },
                { label: 'No. Alamat IP', val: d.ip_address || '-' },
                { label: 'Pencetak (Printer)', val: d.printer || '-' },
                { label: 'Perisian Lain / Catatan', val: d.perisian_lain || d.maklumat_ict || '-' }
            ];

            let html = `
                <!-- 1. RINGKASAN REKOD PELUPUSAN -->
                <div style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1.5px solid var(--border); border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.9rem;">
                        <div>
                            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Status Pelupusan Aset</div>
                            <div style="display: flex; align-items: center; gap: 0.6rem; margin-top: 0.35rem; flex-wrap: wrap;">
                                ${statusBadge}
                                ${getMethodBadge(d.kaedah_pelupusan)}
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Tarikh Pelupusan</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-top: 0.2rem;">📅 ${formatDateSafe(d.tarikh_lupus, escapeHtml(d.tarikh_lupus || '-'))}</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.9rem; font-size: 0.88rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Sebab / Justifikasi:</span>
                            <div style="color: #b91c1c; font-weight: 700; margin-top: 2px;">${escapeHtml(d.sebab_lupus || '-')}</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">No. Rujukan Kelulusan:</span>
                            <div style="font-weight: 700; color: var(--text-main); margin-top: 2px;">${escapeHtml(d.no_rujukan_kelulusan || 'Tiada')}</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Pegawai Pelulus:</span>
                            <div style="font-weight: 700; color: var(--text-main); margin-top: 2px;">${escapeHtml(d.pegawai_pelulus || '-')}</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Catatan:</span>
                            <div style="color: var(--text-main); margin-top: 2px;">${escapeHtml(d.catatan || 'Tiada catatan')}</div>
                        </div>
                    </div>
                </div>

                <!-- 2. SPESIFIKASI INVENTORI ASET (BAHAGIAN A & B) -->
                <div style="margin-bottom: 2rem;">
                    <!-- BAHAGIAN A: MAKLUMAT PEMOHON / STAF -->
                    <div style="background: #f8fafc; padding: 1.25rem 1.4rem; border-radius: 14px; margin-bottom: 1.25rem; border: 1px solid var(--border);">
                        <div class="asset-section-title">
                            <span>👤</span> Bahagian A: Maklumat Pemohon (Staf)
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                            <div class="spec-item-card">
                                <div class="spec-item-label">Nama Pemohon (Staf)</div>
                                <div class="spec-item-value" style="color: var(--primary); font-size: 0.95rem;">${escapeHtml(d.nama_pegawai || '-')}</div>
                            </div>
                            <div class="spec-item-card">
                                <div class="spec-item-label">Jawatan</div>
                                <div class="spec-item-value">${escapeHtml(d.jawatan || '-')}</div>
                            </div>
                            <div class="spec-item-card">
                                <div class="spec-item-label">Bahagian / Unit</div>
                                <div class="spec-item-value">${escapeHtml(d.jabatan_unit || '-')}</div>
                            </div>
                        </div>
                    </div>

                    <!-- BAHAGIAN B: MAKLUMAT KOMPUTER / KOMPUTER RIBA -->
                    <div style="background: #f8fafc; padding: 1.25rem 1.4rem; border-radius: 14px; border: 1px solid var(--border);">
                        <div class="asset-section-title">
                            <span>💻</span> Bahagian B: Maklumat Komputer / Peralatan (Spesifikasi ICT)
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.75rem;">
                            ${specItems.map(item => `
                                <div class="spec-item-card">
                                    <div class="spec-item-label">${item.label}</div>
                                    <div class="spec-item-value">${escapeHtml(item.val)}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>

                    <!-- BAHAGIAN C: GAMBAR FIZIKAL ASET (JIKA ADA) -->
                    ${assetImages.length > 0 ? `
                        <div style="background: #f8fafc; padding: 1.25rem 1.4rem; border-radius: 14px; border: 1px solid var(--border); margin-top: 1.25rem;">
                            <div class="asset-section-title">
                                <span>📸</span> Bahagian C: Maklumat Gambar Aset (${assetImages.length} keping)
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 0.9rem;">
                                ${assetImages.map(img => {
                                    const path = typeof img === 'string' ? img : (img.image_path || '');
                                    const cleanP = '../' + path.replace(/^\/+/, '');
                                    return `
                                        <a href="${cleanP}" target="_blank" style="aspect-ratio: 1; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); display: block; background: #000; box-shadow: 0 2px 8px rgba(0,0,0,0.06);" title="Klik untuk lihat gambar penuh">
                                            <img src="${cleanP}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                    `;
                                }).join('')}
                            </div>
                        </div>
                    ` : ''}
                </div>

                <!-- 3. LAMPIRAN PENUH LAPORAN KEW.PA-9 -->
                <div style="margin-top: 2rem;">
            `;

            if (rep) {
                const repDate = formatDateSafe(rep.created_at, formatDateSafe(rep.tarikh_kerosakan, '-'));
                
                // Tarikh Keputusan: guna rep.keputusan_tarikh jika sah, atau guna d.tarikh_lupus rekod pelupusan
                const rawKepTarikh = (rep.keputusan_tarikh && rep.keputusan_tarikh !== '0000-00-00' && rep.keputusan_tarikh !== '0000-00-00 00:00:00')
                    ? rep.keputusan_tarikh
                    : ((d.tarikh_lupus && d.tarikh_lupus !== '0000-00-00') ? d.tarikh_lupus : null);
                
                const kepDate = formatDateSafe(rawKepTarikh, '-');
                const repImages = rep.images || [];

                // Kira tempoh ISO
                let isoHtml = '<span style="color:var(--text-muted);font-size:0.8rem;">-</span>';
                const isoEnd = rawKepTarikh;
                if (rep.created_at && isoEnd && isoEnd !== '0000-00-00' && isoEnd !== '0000-00-00 00:00:00') {
                    const d1 = new Date(rep.created_at.replace(' ', 'T'));
                    const d2 = new Date(isoEnd.replace(' ', 'T'));
                    if (!isNaN(d1.getTime()) && !isNaN(d2.getTime())) {
                        const diffDays = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
                        if (diffDays >= 0 && diffDays <= 14) {
                            isoHtml = `<span style="font-size:0.75rem; background:#dcfce7; color:#166534; padding:0.25rem 0.6rem; border-radius:12px; font-weight:700;">🟢 Mematuhi ISO (${diffDays} hari)</span>`;
                        } else if (diffDays > 14) {
                            isoHtml = `<span style="font-size:0.75rem; background:#fee2e2; color:#991b1b; padding:0.25rem 0.6rem; border-radius:12px; font-weight:700;">⚠️ Melebihi Tempoh (${diffDays} hari)</span>`;
                        }
                    }
                }

                const repSafe = JSON.stringify(rep).replace(/'/g, "&#39;");

                html += `
                    <div class="kewpa9-card">
                        <!-- HEADER KEW.PA-9 -->
                        <div class="kewpa9-header">
                            <div>
                                <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85;">Pekeliling Perbendaharaan Bil. 5 Tahun 2009</div>
                                <h3 style="margin: 0.2rem 0 0; font-size: 1.25rem; font-weight: 800; color: white;">BORANG ADUAN KEROSAKAN ASET ALIH (KEW.PA-9)</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                                <span style="background: rgba(255,255,255,0.22); padding: 0.35rem 0.85rem; border-radius: 20px; font-weight: 800; font-size: 0.85rem; letter-spacing: 0.5px;">
                                    NO. ADUAN: #${String(rep.id).padStart(2, '0')}
                                </span>
                                <button type="button" onclick="printKEWPA9Direct(${rep.id})" class="btn" style="background: white; color: #1d4ed8; font-weight: 700; padding: 0.45rem 1rem; border-radius: 8px; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 0.35rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                    🖨️ Cetak KEW.PA-9
                                </button>
                                <a href="reports.php?id=${rep.id}" target="_blank" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); font-weight: 600; padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    ↗️ Buka di Kelulusan Laporan
                                </a>
                            </div>
                        </div>

                        <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; background: #ffffff;">
                            <!-- BAHAGIAN I: MAKLUMAT PENGADU -->
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.45rem;">
                                    <h4 style="margin: 0; color: #1e40af; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 0.45rem;">
                                        <span>📝</span> Bahagian I: Butiran Aduan (Untuk Diisi Oleh Pengadu)
                                    </h4>
                                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Tarikh Aduan: ${repDate}</span>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.85rem; margin-bottom: 0.9rem;">
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">1. Jenis Aset</div>
                                        <div class="spec-item-value">${escapeHtml(rep.jenis_aset || '-')}</div>
                                    </div>
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">2. No. Siri Pendaftaran</div>
                                        <div class="spec-item-value" style="color: var(--primary);">${escapeHtml(rep.nombor_siri || '-')}</div>
                                    </div>
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">3. Pengguna Terakhir</div>
                                        <div class="spec-item-value">${escapeHtml(rep.pengguna_terakhir || '-')}</div>
                                    </div>
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">4. Tarikh Kerosakan</div>
                                        <div class="spec-item-value">📅 ${formatDateSafe(rep.tarikh_kerosakan, escapeHtml(rep.tarikh_kerosakan || '-'))}</div>
                                    </div>
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">5. Nama Pelapor & Jawatan</div>
                                        <div class="spec-item-value">${escapeHtml(rep.nama_pelapor || '-')} ${rep.jawatan_pelapor ? '<span style="font-weight:400; color:var(--text-muted);">(' + escapeHtml(rep.jawatan_pelapor) + ')</span>' : ''}</div>
                                    </div>
                                    <div class="spec-item-card">
                                        <div class="spec-item-label">6. Lokasi / Bahagian</div>
                                        <div class="spec-item-value">${escapeHtml(rep.location || '-')}</div>
                                    </div>
                                </div>

                                <div>
                                    <div class="spec-item-label">7. Perihal Kerosakan:</div>
                                    <div style="background: #ffffff; border: 1px solid #fecaca; border-left: 4px solid #ef4444; padding: 0.75rem 1rem; border-radius: 8px; font-weight: 600; color: #991b1b; margin-top: 0.3rem; line-height: 1.5;">
                                        ⚠️ ${escapeHtml(rep.perihal_kerosakan || 'Tiada catatan perihal kerosakan.')}
                                    </div>
                                </div>

                                ${repImages.length > 0 ? `
                                    <div style="margin-top: 1rem;">
                                        <div class="spec-item-label">Lampiran Bukti Kerosakan (${repImages.length} fail):</div>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 0.75rem; margin-top: 0.4rem;">
                                            ${repImages.map(img => {
                                                const path = typeof img === 'string' ? img : (img.image_path || '');
                                                const cleanP = '../' + path.replace(/^\/+/, '');
                                                return `
                                                    <a href="${cleanP}" target="_blank" style="aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); display: block; background: #000;" title="Klik untuk besarkan">
                                                        <img src="${cleanP}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </a>
                                                `;
                                            }).join('')}
                                        </div>
                                    </div>
                                ` : ''}
                            </div>

                            <!-- BAHAGIAN II: PENEMUAN TEKNIKAL -->
                            <div style="background: #f0f7ff; border: 1.5px solid #bfdbfe; border-radius: 12px; padding: 1.25rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem; border-bottom: 1px solid #bfdbfe; padding-bottom: 0.45rem;">
                                    <h4 style="margin: 0; color: #1e40af; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 0.45rem;">
                                        <span>🛠️</span> Bahagian II: Penemuan Teknikal (Pegawai Teknikal ICT)
                                    </h4>
                                    <span style="font-size: 0.78rem; font-weight: 700; background: #dbeafe; color: #1e40af; padding: 0.2rem 0.65rem; border-radius: 12px;">
                                        Proses: ${escapeHtml(rep.proses_semasa || 'Selesai Dilupuskan')}
                                    </span>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; margin-bottom: 0.9rem;">
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Kos Penyelenggaraan Terdahulu (RM)</div>
                                        <div class="spec-item-value" style="font-size: 1.05rem; color: var(--text-main);">RM ${parseFloat(rep.kos_penyelenggaraan_dahulu || 0).toFixed(2)}</div>
                                    </div>
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Anggaran Kos Penyelenggaraan (RM)</div>
                                        <div class="spec-item-value" style="font-size: 1.05rem; color: #b45309;">RM ${parseFloat(rep.anggaran_kos || 0).toFixed(2)}</div>
                                    </div>
                                </div>

                                <div style="margin-bottom: 0.9rem;">
                                    <div class="spec-item-label">Syor Dan Ulasan Pegawai Teknikal:</div>
                                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-left: 4px solid #3b82f6; padding: 0.75rem 1rem; border-radius: 8px; color: var(--text-main); margin-top: 0.3rem; line-height: 1.5; font-weight: 600;">
                                        💬 ${escapeHtml(rep.syor_ulasan || 'Tiada syor/ulasan teknikal.')}
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.75rem; font-size: 0.85rem;">
                                    <div><span style="color:var(--text-muted);">Pegawai Teknikal:</span> <strong>${escapeHtml(rep.admin_name_jawatan || '-')}</strong></div>
                                    <div><span style="color:var(--text-muted);">Jawatan:</span> <strong>${escapeHtml(rep.admin_jawatan || 'Pegawai Teknikal ICT')}</strong></div>
                                    <div><span style="color:var(--text-muted);">Tarikh Pemeriksaan:</span> <strong>📅 ${formatDateSafe(rep.admin_tarikh, escapeHtml(rep.admin_tarikh || '-'))}</strong></div>
                                </div>
                            </div>

                            <!-- BAHAGIAN III: KEPUTUSAN KETUA JABATAN / SUPER ADMIN -->
                            <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 1.25rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem; border-bottom: 1px solid #bbf7d0; padding-bottom: 0.45rem;">
                                    <h4 style="margin: 0; color: #166534; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 0.45rem;">
                                        <span>🔒</span> Bahagian III: Keputusan Ketua Jabatan (Super Admin)
                                    </h4>
                                    <span style="font-size: 0.8rem; font-weight: 800; background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 12px; border: 1px solid #86efac;">
                                        ${escapeHtml(rep.keputusan || 'Syor Dilupuskan')}
                                    </span>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.85rem;">
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Keputusan Muktamad</div>
                                        <div class="spec-item-value" style="color: #166534; font-size: 1.1rem;">${escapeHtml(rep.keputusan || '-')}</div>
                                    </div>
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Tarikh Keputusan</div>
                                        <div class="spec-item-value">📅 ${kepDate}</div>
                                    </div>
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Pegawai Pelulus</div>
                                        <div class="spec-item-value">${escapeHtml(rep.keputusan_nama || 'Super Admin')}</div>
                                    </div>
                                    <div class="spec-item-card" style="background: white;">
                                        <div class="spec-item-label">Pematuhan ISO (&lt; 14 Hari)</div>
                                        <div style="margin-top: 0.2rem;">${isoHtml}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div style="background: #f8fafc; border: 1.5px dashed var(--border); border-radius: 14px; padding: 2rem; text-align: center;">
                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">📄</div>
                        <h4 style="margin: 0 0 0.35rem 0; color: var(--text-main); font-size: 1.1rem;">Tiada Lampiran Laporan KEW.PA-9</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 500px; margin: 0 auto;">
                            Rekod aset ini tidak dipautkan dengan mana-mana aduan KEW.PA-9 dalam sistem (ia dilupuskan secara manual atau pelupusan dalaman pentadbir).
                        </p>
                    </div>
                `;
            }

            html += `</div>`;
            container.innerHTML = html;

            // Configure footer action buttons
            if (footerActions) {
                let footerHtml = '';
                if (rep) {
                    footerHtml += `
                        <button type="button" onclick="printKEWPA9Direct(${rep.id})" class="btn btn-primary" style="padding: 0.6rem 1.25rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem;">
                            🖨️ Cetak Borang KEW.PA-9
                        </button>
                    `;
                }
                footerActions.innerHTML = footerHtml;
            }

            document.getElementById('viewDetailModal').style.display = 'flex';
        }

        async function restoreAsset(id, sn) {
            if (!confirm(`Adakah anda pasti mahu memulihkan aset ini (S/N: ${sn}) kembali ke status Aktif? Rekod pelupusan ini akan dikeluarkan.`)) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'restore');
                formData.append('id', id);

                const res = await fetch('../api/admin/admin_manage_disposal.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                if (result.status === 'success') {
                    alert(result.message);
                    fetchDisposedData();
                    fetchActiveStaffAssets();
                } else {
                    alert('Ralat: ' + result.message);
                }
            } catch (err) {
                alert('Ralat sambungan: ' + err.message);
            }
        }

        async function deleteDisposal(id, sn) {
            const revert = confirm(`Adakah anda mahu memadam rekod pelupusan ini (S/N: ${sn})?\n\nKlik 'OK' untuk padam dan kembalikan aset kepada status Aktif, atau 'Batal' untuk keluar.`);
            if (!revert) return;

            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                formData.append('revert_status', 'yes');

                const res = await fetch('../api/admin/admin_manage_disposal.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                if (result.status === 'success') {
                    alert(result.message);
                    fetchDisposedData();
                    fetchActiveStaffAssets();
                } else {
                    alert('Ralat: ' + result.message);
                }
            } catch (err) {
                alert('Ralat sambungan: ' + err.message);
            }
        }

        function openPrintModal(singleAsset = null) {
            const tbody = document.getElementById('printTableBody');
            const list = singleAsset ? [singleAsset] : allDisposed;
            if (!list.length) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:1rem;">Tiada rekod aset lupus.</td></tr>';
            } else {
                tbody.innerHTML = list.map((d, idx) => `
                    <tr>
                        <td style="padding:6px; text-align:center;">${idx + 1}</td>
                        <td style="padding:6px;">${escapeHtml(d.model_komputer || '-')} (${escapeHtml(d.asset_type || 'PC')})</td>
                        <td style="padding:6px; font-weight:bold;">${escapeHtml(d.serial_number || '-')}${d.no_siri_pendaftaran && d.no_siri_pendaftaran !== d.serial_number ? '<br><small style="color:#64748b; font-weight:normal;">' + escapeHtml(d.no_siri_pendaftaran) + '</small>' : ''}</td>
                        <td style="padding:6px;">${escapeHtml(d.jabatan_unit || '-')}${d.nama_pegawai ? '<br><small style="color:#64748b;">' + escapeHtml(d.nama_pegawai) + '</small>' : ''}</td>
                        <td style="padding:6px; text-align:center;">${escapeHtml(d.tarikh_lupus || '-')}</td>
                        <td style="padding:6px;">${escapeHtml(d.sebab_lupus || '-')}</td>
                    </tr>
                `).join('');
            }
            document.getElementById('printModal').style.display = 'flex';
        }
    </script>
</body>
</html>
