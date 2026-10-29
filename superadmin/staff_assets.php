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
    <title>Aset Staf - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .dept-filter-opt {
            transition: all 0.2s ease;
        }
        .dept-filter-opt:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary) !important;
        }

        .asset-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (max-width: 900px) {
            .form-grid-3, .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .upload-zone {
            border: 2px dashed var(--border);
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background: rgba(220, 38, 38, 0.02);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .image-preview-card {
            position: relative;
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background: #f8fafc;
        }

        .image-preview-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .table-action-btn {
            padding: 0.4rem 0.75rem;
            font-size: 0.78rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            transition: all 0.2s ease;
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
                <a href="staff_assets.php" class="nav-link active">👥 Aset Staf</a>
                <a href="disposed_assets.php" class="nav-link">🗑️ Aset Lupus</a>
                <a href="audit_logs.php" class="nav-link">🔎 Jejak Audit</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0).php" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪 Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Super Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Aset Staf</h2>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div id="current-date" style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                        <!-- Tarikh Semasa via JS -->
                    </div>
                </div>
            </header>

            <!-- Carian, Penapis & Butang Tambah Aset Staf -->
            <div class="card" style="margin-bottom: 1.5rem; position: relative; z-index: 100; overflow: visible !important;">
                <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                    <div class="form-group" style="margin-bottom: 0; flex: 2; min-width: 240px;">
                        <label for="filterSearch" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Carian Aset</label>
                        <input type="text" id="filterSearch" class="form-control" placeholder="Cari Nama Staf, No. Siri, atau Model..." oninput="handleSearch()">
                    </div>

                    <div class="form-group" style="margin-bottom: 0; flex: 1.5; min-width: 200px; position: relative;">
                        <div id="filterDeptLabel" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Pilih Jabatan</div>
                        <input type="hidden" id="filterDept" value="">
                        <div id="customDeptSelect" class="form-control" role="combobox" aria-labelledby="filterDeptLabel" aria-controls="deptDropdownOptions" aria-expanded="false" tabindex="0" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                            <span id="deptDisplay">Semua Jabatan</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">▼</span>
                        </div>
                        <div id="deptDropdownOptions" style="display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); z-index: 1000; max-height: 220px; overflow-y: auto; margin-top: 5px; font-size: 0.88rem;">
                            <div class="dept-filter-opt" data-value="" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Semua Jabatan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Bangunan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Bangunan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kejuruteraan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kejuruteraan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kesihatan dan Pelesenan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kesihatan dan Pelesenan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kewangan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kewangan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Khidmat Pengurusan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Khidmat Pengurusan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Komunikasi Koprat dan Kemasyarakatan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Komunikasi Koprat dan Kemasyarakatan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Penguatkuasaan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Penguatkuasaan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Penilaian dan Pengurusan Harta" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Penilaian dan Pengurusan Harta</div>
                            <div class="dept-filter-opt" data-value="Jabatan Perancangan dan Pembangunan Landskap" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Perancangan dan Pembangunan Landskap</div>
                            <div class="dept-filter-opt" data-value="Kaunter Hasil" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Kaunter Hasil</div>
                            <div class="dept-filter-opt" data-value="Pejabat Setiausaha" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Pejabat Setiausaha</div>
                            <div class="dept-filter-opt" data-value="Pejabat YDP" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Pejabat YDP</div>
                            <div class="dept-filter-opt" data-value="Unit Audit Dalaman" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Audit Dalaman</div>
                            <div class="dept-filter-opt" data-value="Unit Perolehan dan Pengurusan Kontrak" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Perolehan dan Pengurusan Kontrak</div>
                            <div class="dept-filter-opt" data-value="Unit Persuruhjaya Bangunan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Persuruhjaya Bangunan</div>
                            <div class="dept-filter-opt" data-value="Unit Pusat Setempat" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Pusat Setempat</div>
                            <div class="dept-filter-opt" data-value="Unit Teknologi Maklumat" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Teknologi Maklumat</div>
                            <div class="dept-filter-opt" data-value="Unit Undang-Undang" style="padding: 0.6rem 1rem; cursor: pointer;">Unit Undang-Undang</div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 140px;">
                        <label for="filterStatus" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Status Aset</label>
                        <select id="filterStatus" class="form-control" onchange="handleSearch()">
                            <option value="">Semua Status</option>
                            <option value="Aktif" selected>🟢 Aktif</option>
                            <option value="Dilupuskan">🔴 Dilupuskan</option>
                        </select>
                    </div>

                    <div style="margin-left: auto;">
                        <button onclick="openAddAssetModal()" class="btn btn-primary" style="padding: 0.75rem 1.4rem; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px var(--primary-light);">
                            ➕ Tambah Aset Staf
                        </button>
                    </div>
                </div>
            </div>

            <!-- Senarai Jadual Aset Staf -->
            <div class="card table-card" style="box-shadow: var(--shadow);">
                <div class="table-container">
                    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                        <thead>
                            <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid var(--border);">
                                <th style="padding: 1rem; width: 13%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">ID Aset / No Siri</th>
                                <th style="padding: 1rem; width: 16%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Pemilik (Staf)</th>
                                <th style="padding: 1rem; width: 16%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Jabatan / Unit</th>
                                <th style="padding: 1rem; width: 11%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Jenis Aset</th>
                                <th style="padding: 1rem; width: 13%; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Jenama / Model</th>
                                <th style="padding: 1rem; width: 9%; font-weight: 700; color: var(--text-main); font-size: 0.88rem; text-align: center;">Status</th>
                                <th style="padding: 1rem; width: 7%; font-weight: 700; color: var(--text-main); font-size: 0.88rem; text-align: center;">Laporan</th>
                                <th style="padding: 1rem; width: 15%; text-align: center; font-weight: 700; color: var(--text-main); font-size: 0.88rem;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="assetTableBody">
                            <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">⏳ Memuatkan data aset staf...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-top: 1px solid var(--border);">
                    <div class="pagination-info" id="paginationInfo" style="font-size: 0.85rem; color: var(--text-muted);">Menunjukkan 0 hingga 0 daripada 0 entri</div>
                    <div class="pagination-controls" style="display: flex; gap: 0.5rem;">
                        <button onclick="prevPage()" id="prevBtn" class="pagination-btn" disabled>Sebelumnya</button>
                        <button onclick="nextPage()" id="nextBtn" class="pagination-btn">Seterusnya</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: TAMBAH / KEMASKINI MAKLUMAT ASET STAF (Bahagian A, B, C) -->
    <div id="assetModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 950px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2); padding: 2rem;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Pengurusan Aset Staf</span>
                    <h2 id="modalTitle" style="font-size: 1.4rem; color: var(--text-main); margin-top: 0.2rem;">Tambah Maklumat Aset Staf</h2>
                </div>
                <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.7rem; color: var(--text-muted); cursor: pointer; line-height: 1;">&times;</button>
            </div>

            <div id="modalAlert" style="display: none; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600;"></div>

            <form id="staffAssetForm" onsubmit="handleAssetSubmit(event)">
                <input type="hidden" name="id" id="f_asset_id">
                <input type="hidden" name="asset_type" id="f_asset_type" value="Desktop PC">

                <!-- BAHAGIAN A: MAKLUMAT PEMOHON / STAF -->
                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem; border: 1px solid var(--border);">
                    <div class="asset-section-title">
                        <span>👤</span> Bahagian A: Maklumat Pemohon (Staf)
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="f_staff_select" style="font-weight: 600; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 0.35rem;">
                            Pilih Staf Berdaftar (Pilihan Pantas)
                        </label>
                        <select id="f_staff_select" class="form-control" onchange="onStaffSelectChange(this.value)">
                            <option value="">-- Pilih Staf dari Sistem atau Masukkan Manual di Bawah --</option>
                        </select>
                    </div>

                    <input type="hidden" name="user_id" id="f_user_id">

                    <div class="form-grid-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="f_nama_pegawai" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem; display: block;">
                                Nama Pemohon <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="nama_pegawai" id="f_nama_pegawai" class="form-control" placeholder="Nama penuh staf..." required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="f_jawatan" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem; display: block;">
                                Jawatan <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="jawatan" id="f_jawatan" class="form-control" placeholder="Jawatan staf..." required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="f_jabatan_unit" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem; display: block;">
                                Bahagian / Unit <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="jabatan_unit" id="f_jabatan_unit" class="form-control" placeholder="Bahagian atau unit..." required>
                        </div>
                    </div>
                </div>

                <!-- BAHAGIAN B: MAKLUMAT KOMPUTER / KOMPUTER RIBA -->
                <div style="margin-bottom: 2rem;">
                    <div class="asset-section-title">
                        <span>💻</span> Bahagian B: Maklumat Komputer / Komputer Riba
                    </div>

                    <div class="form-grid-3">
                        <div class="form-group">
                            <label for="f_model_comp" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">
                                Model Komputer / Komputer Riba <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="model_komputer" id="f_model_comp" class="form-control" placeholder="Cth: Acer / HP / Dell..." required>
                        </div>

                        <div class="form-group">
                            <label for="f_serial" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">
                                No. Siri CPU / Komputer Riba <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="serial_number" id="f_serial" class="form-control" placeholder="Cth: S/N: ABC123..." required>
                        </div>

                        <div class="form-group">
                            <label for="f_model_mon" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">
                                Model Monitor <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="model_monitor" id="f_model_mon" class="form-control" placeholder="Cth: Samsung / Dell..." required>
                        </div>

                        <div class="form-group">
                            <label for="f_serial_mon" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">
                                No. Siri Monitor <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="serial_monitor" id="f_serial_mon" class="form-control" placeholder="Cth: S/N:XYZ123..." required>
                        </div>

                        <div class="form-group">
                            <label for="f_os" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Sistem Operasi (Windows)</label>
                            <input type="text" name="os" id="f_os" class="form-control" placeholder="Cth: Windows 11 / Windows 10...">
                        </div>

                        <div class="form-group">
                            <label for="f_processor" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Model Pemproses</label>
                            <input type="text" name="processor" id="f_processor" class="form-control" placeholder="Cth: Intel i5 / i7 / Ryzen...">
                        </div>

                        <div class="form-group">
                            <label for="f_ram" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Model dan Kapasiti RAM</label>
                            <input type="text" name="ram" id="f_ram" class="form-control" placeholder="Cth: 8GB / 16GB DDR4...">
                        </div>

                        <div class="form-group">
                            <label for="f_disk" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Jenis Cakera Keras</label>
                            <input type="text" name="hard_disk" id="f_disk" class="form-control" placeholder="Cth: 512GB SSD / NVMe...">
                        </div>

                        <div class="form-group">
                            <label for="f_mouse" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Jenis Tetikus</label>
                            <input type="text" name="mouse" id="f_mouse" class="form-control" placeholder="Cth: USB Optical / Wireless...">
                        </div>

                        <div class="form-group">
                            <label for="f_keyboard" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Jenis Papan Kekunci</label>
                            <input type="text" name="keyboard" id="f_keyboard" class="form-control" placeholder="Cth: USB Standard / Wireless...">
                        </div>

                        <div class="form-group">
                            <label for="f_office" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Versi Microsoft Office</label>
                            <input type="text" name="ms_office" id="f_office" class="form-control" placeholder="Cth: Office 2019 / Office 2021...">
                        </div>

                        <div class="form-group">
                            <label for="f_antivirus" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Versi Antivirus</label>
                            <input type="text" name="antivirus" id="f_antivirus" class="form-control" placeholder="Cth: Panda Dome / Windows Security...">
                        </div>

                        <div class="form-group">
                            <label for="f_ip" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">No. Alamat IP</label>
                            <input type="text" name="ip_address" id="f_ip" class="form-control" placeholder="Cth: 192.168.1.50...">
                        </div>

                        <div class="form-group">
                            <label for="f_printer" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Pencetak (Printer)</label>
                            <input type="text" name="printer" id="f_printer" class="form-control" placeholder="Cth: HP LaserJet / Canon...">
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="f_others" style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.3rem; display: block;">Perisian Lain</label>
                            <textarea name="perisian_lain" id="f_others" class="form-control" rows="2" placeholder="Cth: Zoom, WhatsApp Desktop, Adobe Acrobat..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- BAHAGIAN C: MAKLUMAT GAMBAR ASET (MAX 3) -->
                <div style="margin-bottom: 2rem;">
                    <div class="asset-section-title">
                        <span>📸</span> Bahagian C: Maklumat Gambar Aset (Maksimum 3)
                    </div>

                    <div class="upload-zone">
                        <input type="file" name="images[]" id="f_images" accept="image/*" multiple onchange="handleModalImageSelect(event)">
                        <div style="font-size: 2.2rem; margin-bottom: 0.4rem;">📷</div>
                        <p style="font-weight: 700; color: var(--text-main); font-size: 0.95rem; margin-bottom: 0.2rem;">Klik atau seret gambar aset ke sini</p>
                        <p style="color: var(--text-muted); font-size: 0.82rem;">Maksimum 3 gambar (Format: JPEG, PNG, WEBP).</p>
                        <p style="color: var(--text-muted); font-size: 0.78rem; margin-top: 0.3rem;">Nota: Jika memuat naik gambar baru ketika kemaskini, gambar lama akan digantikan.</p>
                    </div>

                    <div id="modalImagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem; margin-top: 1rem;">
                        <!-- Previews injected via JS -->
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" id="modalSaveBtn" style="min-width: 160px; font-weight: 700;">
                        💾 Simpan Maklumat Aset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: SEJARAH LAPORAN PENGGUNA -->
    <div id="historyModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 800px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <h3 id="historyModalTitle" style="color: var(--text-main);">Sejarah Laporan Staf</h3>
                <button type="button" onclick="closeHistoryModal()" style="background: none; border: none; font-size: 1.7rem; color: var(--text-muted); cursor: pointer;">&times;</button>
            </div>
            <div id="historyModalBody">
                <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Memuatkan rekod...</p>
            </div>
        </div>
    </div>

    <script>
        let allAssets = [];
        let filteredAssets = [];
        let allStaffList = [];
        let currentPage = 1;
        const itemsPerPage = 10;

        async function handleLogout() {
            try {
                await fetch("../api/logout.php");
            } catch (err) {}
            sessionStorage.clear();
            window.location.replace('../login.php');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const userStr = sessionStorage.getItem('user');
            if (!userStr) {
                window.location.replace('../login.php');
                return;
            }
            const user = JSON.parse(userStr);
            const userRole = (user.role || '').toLowerCase();
            if (userRole !== 'super admin' && userRole !== 'superadmin') {
                alert('Akses Ditolak. Anda bukan Super Admin.');
                window.location.replace('../login.php');
                return;
            }

            const dateOpts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const dateDisplay = document.getElementById('current-date');
            if (dateDisplay) dateDisplay.textContent = new Date().toLocaleDateString('ms-MY', dateOpts);

            if (user && user.full_name) {
                document.getElementById('sidebarSuperadminName').textContent = user.full_name;
            }

            setupCustomDeptDropdown();
            await fetchStaffList();
            await fetchAssets();
        });

        // Setup Penapis Jabatan Custom Dropdown
        function setupCustomDeptDropdown() {
            const customDeptSelect = document.getElementById('customDeptSelect');
            const deptDropdownOptions = document.getElementById('deptDropdownOptions');
            const deptDisplay = document.getElementById('deptDisplay');
            const filterDeptInput = document.getElementById('filterDept');

            customDeptSelect.addEventListener('click', (e) => {
                e.stopPropagation();
                const isVisible = deptDropdownOptions.style.display === 'block';
                deptDropdownOptions.style.display = isVisible ? 'none' : 'block';
                customDeptSelect.setAttribute('aria-expanded', String(!isVisible));
            });

            deptDropdownOptions.addEventListener('click', (e) => {
                const opt = e.target.closest('.dept-filter-opt');
                if (opt) {
                    const val = opt.getAttribute('data-value');
                    filterDeptInput.value = val;
                    deptDisplay.textContent = opt.textContent;
                    deptDropdownOptions.style.display = 'none';
                    handleSearch();
                }
            });

            document.addEventListener('click', () => {
                deptDropdownOptions.style.display = 'none';
                customDeptSelect.setAttribute('aria-expanded', 'false');
            });
        }

        // Ambil senarai staf berdaftar untuk pilihan pantas di Bahagian A
        async function fetchStaffList() {
            try {
                const res = await fetch("../api/admin/admin_get_staff_list.php");
                const result = await res.json();
                if (result.status === 'success' && result.data) {
                    allStaffList = result.data;
                    const select = document.getElementById('f_staff_select');
                    select.innerHTML = '<option value="">-- Pilih Staf dari Sistem atau Masukkan Manual di Bawah --</option>';
                    allStaffList.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s.id;
                        opt.textContent = `${s.name} (${s.staff_id || 'Tiada ID'}) - ${s.department || 'Tiada Jabatan'}`;
                        select.appendChild(opt);
                    });
                }
            } catch (err) {
                console.warn('Gagal memuat senarai staf:', err);
            }
        }

        function onStaffSelectChange(userId) {
            if (!userId) return;
            const staff = allStaffList.find(s => s.id == userId);
            if (staff) {
                document.getElementById('f_user_id').value = staff.id;
                document.getElementById('f_nama_pegawai').value = staff.name || '';
                document.getElementById('f_jawatan').value = staff.jawatan || '';
                document.getElementById('f_jabatan_unit').value = staff.department || '';
            }
        }

        // Ambil senarai semua aset staf
        async function fetchAssets() {
            const tbody = document.getElementById('assetTableBody');
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2.5rem;color:var(--text-muted);">⏳ Memuatkan rekod aset staf...</td></tr>';

            try {
                const res = await fetch('../api/admin/admin_get_assets.php?_t=' + Date.now());
                const result = await res.json();

                if (result.status === 'success') {
                    allAssets = result.data || [];
                    filteredAssets = [...allAssets];
                    if (allAssets.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2.5rem;color:var(--text-muted);">📭 Tiada aset staf didaftarkan lagi. Klik <strong>+ Tambah Aset Staf</strong> untuk bermula.</td></tr>';
                        updatePagination(0);
                    } else {
                        renderAssets();
                    }
                } else {
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--danger);">❌ ${result.message || 'Ralat memuatkan rekod aset.'}</td></tr>`;
                }
            } catch (err) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--danger);">❌ Ralat sambungan: ${err.message}</td></tr>`;
            }
        }

        function handleSearch() {
            const searchTerm = document.getElementById('filterSearch').value.toLowerCase().trim();
            const selectedDept = document.getElementById('filterDept').value;
            const selectedStatus = document.getElementById('filterStatus') ? document.getElementById('filterStatus').value : '';

            filteredAssets = allAssets.filter(a => {
                const nameMatch = (a.name || a.nama_pegawai || '').toLowerCase().includes(searchTerm);
                const serialMatch = (a.serial_number || '').toLowerCase().includes(searchTerm);
                const modelMatch = (a.model_komputer || '').toLowerCase().includes(searchTerm);
                const searchPass = !searchTerm || nameMatch || serialMatch || modelMatch;

                const deptVal = a.department || a.jabatan_unit || '';
                const deptPass = !selectedDept || deptVal === selectedDept;

                const assetStatus = a.status || 'Aktif';
                const statusPass = !selectedStatus || assetStatus === selectedStatus;

                return searchPass && deptPass && statusPass;
            });

            currentPage = 1;
            renderAssets();
        }

        function renderAssets() {
            const tbody = document.getElementById('assetTableBody');
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = filteredAssets.slice(start, end);

            if (!filteredAssets.length) {
                tbody.innerHTML = '<tr><td colspan="8" style="padding:2.5rem;text-align:center;color:var(--text-muted)">Tiada rekod ditemui yang sepadan dengan carian.</td></tr>';
                updatePagination(0);
                return;
            }

            tbody.innerHTML = pageItems.map(a => {
                const assetDataSafe = JSON.stringify(a).replace(/'/g, "&#39;");
                const staffName = a.name || a.nama_pegawai || 'Staf';
                const staffDept = a.department || a.jabatan_unit || '-';
                const safeStaffName = escapeHtml(staffName);
                const safeStaffDept = escapeHtml(staffDept);
                const safeSN = escapeHtml(a.serial_number || 'N/A');
                const safeType = escapeHtml(a.asset_type || 'Desktop PC');
                const safeModel = escapeHtml(a.model_komputer || '-');
                const cleanStaffNameParam = (staffName || '').replace(/['"\\]/g, '');
                const reportCount = a.total_report_count || 0;
                const isDisposed = (a.status || 'Aktif') === 'Dilupuskan';
                const statusBadge = isDisposed
                    ? `<span class="status-pill" style="background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; font-size:0.75rem; font-weight:700;">Dilupuskan</span>`
                    : `<span class="status-pill" style="background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; font-size:0.75rem; font-weight:700;">Aktif</span>`;

                return `
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s ease;">
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 700; color: var(--text-main); font-size: 0.88rem; word-break: break-all;">
                            ${safeSN}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-weight: 600; color: var(--text-main); font-size: 0.88rem;">
                            ${safeStaffName}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-size: 0.85rem; color: var(--text-muted); line-height: 1.4; word-wrap: break-word;">
                            ${safeStaffDept}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-size: 0.85rem; color: var(--text-main);">
                            ${safeType}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; font-size: 0.85rem; color: var(--text-main); font-weight: 500;">
                            ${safeModel}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            ${statusBadge}
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            <button class="btn btn-secondary" title="Lihat sejarah laporan staf" style="padding: 0.35rem 0.65rem; font-size: 0.75rem; border-radius: 6px; font-weight: 700;" onclick="viewUserHistory('${a.user_id || ''}', '${cleanStaffNameParam}')">
                                📋 ${reportCount}
                            </button>
                        </td>
                        <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                            <div style="display: flex; gap: 0.35rem; justify-content: center; flex-wrap: wrap;">
                                <button onclick='openEditAssetModal(${assetDataSafe})' class="btn btn-primary table-action-btn" title="Kemaskini Maklumat Aset">
                                    ✏️
                                </button>
                                ${!isDisposed ? `
                                    <button onclick='openQuickDisposeModal(${assetDataSafe})' class="btn btn-secondary table-action-btn" style="color: #b91c1c; border-color: rgba(220,38,38,0.3);" title="Hantar Aset ke Pelupusan">
                                        🗑️ Lupus
                                    </button>
                                ` : `
                                    <a href="disposed_assets.php" class="btn btn-secondary table-action-btn" style="color: #b91c1c;" title="Lihat Rekod di Aset Lupus">
                                        📋 Lupus
                                    </a>
                                `}
                                <button onclick="deleteAsset(${a.id}, '${(a.serial_number||'').replace(/'/g, "\\'")}')" class="btn btn-secondary table-action-btn" style="color: var(--danger); border-color: rgba(220,38,38,0.2);" title="Padam Rekod">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            updatePagination(filteredAssets.length);
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
            renderAssets();
            document.querySelector('.table-container').scrollTop = 0;
        }

        function prevPage() {
            currentPage--;
            renderAssets();
            document.querySelector('.table-container').scrollTop = 0;
        }

        // Buka Modal Tambah Aset Baharu
        function openAddAssetModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Maklumat Aset Staf';
            document.getElementById('staffAssetForm').reset();
            document.getElementById('f_asset_id').value = '';
            document.getElementById('f_user_id').value = '';
            document.getElementById('f_asset_type').value = 'Desktop PC';
            document.getElementById('f_staff_select').value = '';
            document.getElementById('modalAlert').style.display = 'none';
            document.getElementById('modalImagePreview').innerHTML = '';

            const modal = document.getElementById('assetModal');
            modal.style.display = 'flex';
        }

        // Buka Modal Edit Aset
        function openEditAssetModal(a) {
            document.getElementById('modalTitle').textContent = `Kemaskini Maklumat Aset (#${a.id})`;
            document.getElementById('staffAssetForm').reset();
            document.getElementById('modalAlert').style.display = 'none';

            // Bahagian A
            document.getElementById('f_asset_id').value = a.id;
            document.getElementById('f_user_id').value = a.user_id || '';
            document.getElementById('f_staff_select').value = a.user_id || '';
            document.getElementById('f_nama_pegawai').value = a.name || a.nama_pegawai || '';
            document.getElementById('f_jawatan').value = a.jawatan || '';
            document.getElementById('f_jabatan_unit').value = a.department || a.jabatan_unit || '';

            // Bahagian B
            document.getElementById('f_asset_type').value = a.asset_type || 'Desktop PC';
            document.getElementById('f_model_comp').value = a.model_komputer || '';
            document.getElementById('f_serial').value = a.serial_number || '';
            document.getElementById('f_model_mon').value = a.model_monitor || '';
            document.getElementById('f_serial_mon').value = a.serial_monitor || '';
            document.getElementById('f_os').value = a.os || '';
            document.getElementById('f_processor').value = a.processor || '';
            document.getElementById('f_ram').value = a.ram || '';
            document.getElementById('f_disk').value = a.hard_disk || '';
            document.getElementById('f_mouse').value = a.mouse || '';
            document.getElementById('f_keyboard').value = a.keyboard || '';
            document.getElementById('f_office').value = a.ms_office || '';
            document.getElementById('f_antivirus').value = a.antivirus || '';
            document.getElementById('f_ip').value = a.ip_address || '';
            document.getElementById('f_printer').value = a.printer || '';
            document.getElementById('f_others').value = a.perisian_lain || '';

            // Bahagian C: Gambar Sedia Ada
            renderModalImages(a.images || []);

            const modal = document.getElementById('assetModal');
            modal.style.display = 'flex';
        }

        function renderModalImages(images) {
            const grid = document.getElementById('modalImagePreview');
            grid.innerHTML = '';
            if (!images || images.length === 0) return;

            images.forEach(img => {
                const imgPath = img.image_path.startsWith('../') ? img.image_path : `../${img.image_path}`;
                const div = document.createElement('div');
                div.className = 'image-preview-card';
                div.innerHTML = `
                    <img src="${imgPath}" alt="Lampiran Aset">
                    <span style="position: absolute; bottom: 4px; left: 4px; background: rgba(0,0,0,0.65); color: #fff; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight:600;">Sedia Ada</span>
                `;
                grid.appendChild(div);
            });
        }

        function handleModalImageSelect(e) {
            const files = e.target.files;
            const grid = document.getElementById('modalImagePreview');
            const alertBox = document.getElementById('modalAlert');

            if (files.length > 3) {
                alertBox.className = 'alert-box error';
                alertBox.style.display = 'block';
                alertBox.textContent = '❌ Maksimum 3 gambar sahaja dibenarkan.';
                e.target.value = '';
                return;
            }

            alertBox.style.display = 'none';
            grid.innerHTML = '';

            Array.from(files).forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = event => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-card';
                    div.innerHTML = `
                        <img src="${event.target.result}" alt="Gambar Baharu ${idx + 1}">
                        <span style="position: absolute; bottom: 4px; left: 4px; background: var(--primary); color: #fff; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight:600;">Baru</span>
                    `;
                    grid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Hantar Borang Simpan Aset (Tambah atau Kemaskini)
        async function handleAssetSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const btn = document.getElementById('modalSaveBtn');
            const alertBox = document.getElementById('modalAlert');

            try {
                btn.disabled = true;
                btn.innerHTML = '⏳ Menyimpan...';
                alertBox.style.display = 'none';

                const res = await fetch('../api/admin/admin_update_asset.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();

                if (result.status === 'success') {
                    alertBox.className = 'alert-box success';
                    alertBox.style.background = '#dcfce7';
                    alertBox.style.color = '#166534';
                    alertBox.style.border = '1px solid #bbf7d0';
                    alertBox.textContent = '✅ ' + (result.message || 'Maklumat aset berjaya disimpan.');
                    alertBox.style.display = 'block';

                    setTimeout(() => {
                        closeModal();
                        fetchAssets();
                    }, 1000);
                } else {
                    alertBox.className = 'alert-box error';
                    alertBox.style.background = '#fee2e2';
                    alertBox.style.color = '#991b1b';
                    alertBox.style.border = '1px solid #fecaca';
                    alertBox.textContent = '❌ ' + (result.message || 'Gagal menyimpan maklumat.');
                    alertBox.style.display = 'block';
                }
            } catch (err) {
                alertBox.className = 'alert-box error';
                alertBox.textContent = '❌ Ralat sambungan pelayan: ' + err.message;
                alertBox.style.display = 'block';
            } finally {
                btn.disabled = false;
                btn.innerHTML = '💾 Simpan Maklumat Aset';
            }
        }

        async function deleteAsset(assetId, serialNumber) {
            if (!confirm(`Adakah anda pasti ingin memadamkan rekod aset ini (No. Siri: ${serialNumber})?`)) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', assetId);

                const res = await fetch('../api/admin/admin_update_asset.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();

                if (result.status === 'success') {
                    alert('Rekod aset berjaya dipadam.');
                    fetchAssets();
                } else {
                    alert('Ralat: ' + (result.message || 'Gagal memadam aset.'));
                }
            } catch (err) {
                alert('Ralat sambungan: ' + err.message);
            }
        }

        function closeModal() {
            document.getElementById('assetModal').style.display = 'none';
        }

        // Lihat Sejarah Laporan Staf
        function formatReportId(id) {
            if (!id && id !== 0) return '';
            const num = parseInt(id);
            if (isNaN(num)) return `#ICT${id}`;
            return `#ICT${String(num).padStart(2, '0')}`;
        }

        async function viewUserHistory(userId, userName) {
            const modal = document.getElementById('historyModal');
            const title = document.getElementById('historyModalTitle');
            const body = document.getElementById('historyModalBody');

            title.textContent = `Sejarah Laporan - ${userName}`;
            body.innerHTML = '<p style="text-align:center;padding:2rem;color:var(--text-muted);">⏳ Memuatkan rekod laporan...</p>';
            modal.style.display = 'flex';

            if (!userId) {
                body.innerHTML = '<p style="text-align:center;padding:2rem;color:var(--text-muted);">Aset ini didaftarkan tanpa sambungan ID pengguna spesifik.</p>';
                return;
            }

            try {
                const res = await fetch(`../api/admin/admin_get_reports.php?user_id=${encodeURIComponent(userId)}`);
                const result = await res.json();

                if (result.status !== 'success') {
                    body.innerHTML = `<p style="padding:1rem;color:var(--danger);">Ralat: ${result.message || 'Gagal memuatkan laporan.'}</p>`;
                    return;
                }

                const reports = result.data || [];
                if (!reports.length) {
                    body.innerHTML = '<p style="text-align:center;padding:2rem;color:var(--text-muted);">Tiada sebarang laporan kerosakan daripada staf ini.</p>';
                    return;
                }

                body.innerHTML = `
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        ${reports.map(r => `
                            <div style="border:1px solid var(--border); padding:1.25rem; border-radius:12px; background: #fafafa;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                                    <div style="font-weight:700; color:var(--text-main); font-size:1rem;">${formatReportId(r.id)} - ${escapeHtml(r.jenis_aset || 'Aset ICT')}</div>
                                    <div style="font-size:0.8rem; color:var(--text-muted);">${r.created_at ? new Date(r.created_at).toLocaleString('ms-MY') : '-'}</div>
                                </div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0.6rem; font-size:0.88rem;">
                                    <div><strong>No. Siri:</strong> ${escapeHtml(r.nombor_siri || '-')}</div>
                                    <div><strong>Status Semasa:</strong> <span style="font-weight:700; color:var(--primary);">${escapeHtml(r.status || '-')}</span></div>
                                    <div><strong>Tarikh Kerosakan:</strong> ${escapeHtml(r.tarikh_kerosakan || '-')}</div>
                                    <div><strong>Keputusan:</strong> ${escapeHtml(r.keputusan || '-')}</div>
                                    <div style="grid-column: 1 / -1;"><strong>Perihal Kerosakan:</strong> ${escapeHtml(r.perihal_kerosakan || '-')}</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } catch (err) {
                body.innerHTML = `<p style="padding:1rem;color:var(--danger);">Ralat: ${err.message}</p>`;
            }
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').style.display = 'none';
        }

        // ==========================================
        // QUICK DISPOSAL MODAL LOGIC
        // ==========================================
        function openQuickDisposeModal(asset) {
            document.getElementById('qd_asset_id').value = asset.id || '';
            document.getElementById('qd_serial_number').value = asset.serial_number || '';
            document.getElementById('qd_no_siri_pendaftaran').value = asset.no_siri_pendaftaran || asset.serial_number || '';
            document.getElementById('qd_asset_type').value = asset.asset_type || 'Desktop PC';
            document.getElementById('qd_model_komputer').value = asset.model_komputer || '';
            document.getElementById('qd_nama_pegawai').value = asset.nama_pegawai || asset.name || '';
            document.getElementById('qd_jabatan_unit').value = asset.jabatan_unit || asset.department || '';
            
            document.getElementById('qd_asset_info_text').textContent = `${asset.model_komputer || 'Komputer'} (S/N: ${asset.serial_number || 'N/A'}) - ${asset.nama_pegawai || asset.name || 'Tiada Staf'}`;
            document.getElementById('qd_tarikh_lupus').value = new Date().toISOString().split('T')[0];
            document.getElementById('quickDisposalAlert').style.display = 'none';
            document.getElementById('quickDisposalModal').style.display = 'flex';
        }

        function closeQuickDisposalModal() {
            document.getElementById('quickDisposalModal').style.display = 'none';
        }

        async function handleQuickDisposeSubmit(event) {
            event.preventDefault();
            const btn = document.getElementById('btnSubmitQD');
            const alertBox = document.getElementById('quickDisposalAlert');
            btn.disabled = true;
            btn.textContent = 'Memproses Pelupusan...';

            const form = document.getElementById('quickDisposalForm');
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
                        closeQuickDisposalModal();
                        fetchAssets();
                    }, 800);
                } else {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#fee2e2';
                    alertBox.style.color = '#b91c1c';
                    alertBox.textContent = '❌ ' + (result.message || 'Ralat semasa memproses pelupusan.');
                }
            } catch (err) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#fee2e2';
                alertBox.style.color = '#b91c1c';
                alertBox.textContent = '❌ Ralat sambungan: ' + err.message;
            } finally {
                btn.disabled = false;
                btn.textContent = 'Sahkan & Hantar ke Aset Lupus';
            }
        }
    </script>

    <!-- MODAL: PELUPUSAN PANTAS ASET (QUICK DISPOSAL) -->
    <div id="quickDisposalModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2); padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.8rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--danger); text-transform: uppercase;">Tindakan Pelupusan</span>
                    <h3 style="margin: 0.2rem 0 0 0; font-size: 1.3rem; color: var(--text-main);">Hantar Aset ke Pelupusan</h3>
                </div>
                <button type="button" onclick="closeQuickDisposalModal()" style="background: none; border: none; font-size: 1.6rem; color: var(--text-muted); cursor: pointer;">&times;</button>
            </div>

            <div id="quickDisposalAlert" style="display: none; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 600;"></div>

            <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                <p style="margin: 0; font-size: 0.85rem; color: #9f1239; font-weight: 600;">Aset yang akan dilupuskan:</p>
                <p id="qd_asset_info_text" style="margin: 0.3rem 0 0 0; font-size: 0.95rem; font-weight: 700; color: #881337;">-</p>
            </div>

            <form id="quickDisposalForm" onsubmit="handleQuickDisposeSubmit(event)">
                <input type="hidden" name="asset_id" id="qd_asset_id">
                <input type="hidden" name="serial_number" id="qd_serial_number">
                <input type="hidden" name="no_siri_pendaftaran" id="qd_no_siri_pendaftaran">
                <input type="hidden" name="asset_type" id="qd_asset_type">
                <input type="hidden" name="model_komputer" id="qd_model_komputer">
                <input type="hidden" name="nama_pegawai" id="qd_nama_pegawai">
                <input type="hidden" name="jabatan_unit" id="qd_jabatan_unit">

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="font-weight: 600; font-size: 0.85rem;">Tarikh Pelupusan <span style="color:var(--danger)">*</span></label>
                    <input type="date" name="tarikh_lupus" id="qd_tarikh_lupus" class="form-control" required>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="font-weight: 600; font-size: 0.85rem;">Kaedah Pelupusan <span style="color:var(--danger)">*</span></label>
                    <select name="kaedah_pelupusan" id="qd_kaedah_pelupusan" class="form-control" required>
                        <option value="E-Waste / Buangan Terjadual">♻️ E-Waste / Buangan Terjadual</option>
                        <option value="Musnah">🔥 Musnah / Bakar / Tanam</option>
                        <option value="Jualan Sisa">💵 Jualan Sisa / Besi Buruk</option>
                        <option value="Pindahan / Tukar Ganti">🔄 Pindahan / Tukar Ganti (Trade-In)</option>
                        <option value="Hadiah">🎁 Hadiah</option>
                        <option value="Lain-lain">📦 Lain-lain Kaedah</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="font-weight: 600; font-size: 0.85rem;">Sebab / Justifikasi Pelupusan <span style="color:var(--danger)">*</span></label>
                    <textarea name="sebab_lupus" id="qd_sebab_lupus" class="form-control" rows="2" placeholder="Cth: Rosak teruk tidak ekonomi dibaiki, Usang melebihi tempoh hayat ekonomi..." required>Rosak teruk dan tidak ekonomik dibaiki / Melebihi had umur ekonomi.</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; font-size: 0.85rem;">No. Rujukan Kelulusan (Pilihan)</label>
                    <input type="text" name="no_rujukan_kelulusan" id="qd_no_rujukan" class="form-control" placeholder="cth: MPM/BTM/LUPUS/2026/01">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
                    <button type="button" onclick="closeQuickDisposalModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" id="btnSubmitQD" class="btn btn-primary" style="background: var(--danger); border-color: var(--danger); font-weight: 700;">Sahkan & Hantar ke Aset Lupus</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
