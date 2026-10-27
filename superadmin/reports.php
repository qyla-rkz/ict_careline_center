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
    <title>Kelulusan Laporan KEW.PA-9 - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=12"></script>
    <style>
        .readonly-sec {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            padding: 1.25rem;
        }
        .form-control-readonly {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border: 1.5px solid #cbd5e1 !important;
            cursor: not-allowed !important;
            font-weight: 600;
        }
        body.dark-theme .readonly-sec {
            background: rgba(30, 41, 59, 0.45) !important;
            border-color: #334155 !important;
        }
        body.dark-theme .form-control-readonly {
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
                <a href="reports.php" class="nav-link active">📝 Kelulusan Laporan</a>
                <a href="history_reports.php" class="nav-link">📜 Sejarah Laporan</a>
                <a href="users.php" class="nav-link">👥 Pengguna</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link">👥 Aset Staf</a>
                <a href="audit_logs.php" class="nav-link">📜 Jejak Audit</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0).php" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪 Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Super Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Kelulusan Laporan KEW.PA-9</h2>
                </div>
                <div id="superadminDate"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                </div>
            </header>

            <!-- Kad Statistik Ringkas -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 2rem;">
                <div class="card stat-card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="background: #eff6ff; color: #1e40af; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">📥</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Jumlah Laporan</div>
                        <div id="count_total" style="font-size: 1.6rem; font-weight: 800; color: var(--text-main);">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem; border-left: 4px solid #f59e0b;">
                    <div style="background: #fef3c7; color: #92400e; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">⏳</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Menunggu Kelulusan</div>
                        <div id="count_pending_super" style="font-size: 1.6rem; font-weight: 800; color: #b45309;">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="background: #dcfce7; color: #166534; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">✅</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Diluluskan / Selesai</div>
                        <div id="count_approved" style="font-size: 1.6rem; font-weight: 800; color: #166534;">0</div>
                    </div>
                </div>
                <div class="card stat-card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="background: #fee2e2; color: #991b1b; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">❌</div>
                    <div>
                        <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Tidak Diluluskan</div>
                        <div id="count_rejected" style="font-size: 1.6rem; font-weight: 800; color: #991b1b;">0</div>
                    </div>
                </div>
            </div>

            <!-- Penapis dan Carian -->
            <div class="card" style="margin-bottom: 1.5rem; padding: 1.25rem;">
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <div style="flex: 2; min-width: 250px;">
                        <input type="text" id="reportSearchInput" class="form-control" placeholder="🔍 Cari ID (#ICT..), nama staf, no. siri, atau aset..." oninput="handleReportSearch()">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <select id="statusFilter" class="form-control" onchange="handleReportSearch()">
                            <option value="all">Semua Status Keputusan</option>
                            <option value="pending_decision">⏳ Menunggu Kelulusan Super Admin</option>
                            <option value="Diluluskan">✅ Diluluskan</option>
                            <option value="Tidak Diluluskan">❌ Tidak Diluluskan</option>
                            <option value="Syor Dilupuskan">🗂️ Syor Dilupuskan</option>
                        </select>
                    </div>
                    <div>
                        <button onclick="fetchReports()" class="btn btn-secondary" style="padding: 0.65rem 1.2rem;">🔄 Muat Semula</button>
                    </div>
                </div>
            </div>

            <!-- Jadual Laporan -->
            <div class="card table-card" style="padding: 0; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid var(--border);">
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">ID</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">Pelapor & Jabatan</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">Aset (Jenis & No. Siri)</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">Tarikh Aduan</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">Proses Semasa (Admin)</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted);">Keputusan Bahagian III</th>
                            <th style="padding: 1.1rem 1.25rem; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted); text-align: center;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="superReportsTableBody">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">⏳ Memuatkan rekod laporan KEW.PA-9...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- MODAL: KELULUSAN LAPORAN KEW.PA-9 (SUPER ADMIN) -->
    <div id="superApprovalModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div class="modal-content" style="background: white; border-radius: 20px; max-width: 900px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-transform: uppercase;">Portal Super Admin</span>
                    <h2 id="modalSuperTitle" style="font-size: 1.5rem; color: var(--text-main); margin-top: 0.2rem;">Keputusan Laporan KEW.PA-9</h2>
                </div>
                <button type="button" onclick="closeApprovalModal()" style="background: none; border: none; font-size: 1.7rem; color: var(--text-muted); cursor: pointer;">&times;</button>
            </div>

            <form id="superApprovalForm" onsubmit="handleSuperSubmit(event)">
                <input type="hidden" id="s_id" name="id">

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- BAHAGIAN I: MAKLUMAT PENGADU (READ-ONLY) -->
                    <div class="readonly-sec">
                        <h4 style="margin: 0 0 1rem 0; color: var(--primary); font-size: 0.95rem; border-bottom: 1px solid var(--border); padding-bottom: 0.4rem;">
                            Bahagian I: Maklumat Pengadu (Staf)
                        </h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Jenis Aset</label>
                                <input type="text" id="s_v_jenis" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">No. Siri Pendaftaran</label>
                                <input type="text" id="s_v_siri" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Pengguna Terakhir</label>
                                <input type="text" id="s_v_pengguna" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Tarikh Kerosakan</label>
                                <input type="text" id="s_v_tarikh_rosak" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Nama Pelapor & Jawatan</label>
                                <input type="text" id="s_v_nama_pelapor" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Lokasi</label>
                                <input type="text" id="s_v_lokasi" readonly tabindex="-1" class="form-control form-control-readonly">
                            </div>
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Perihal Kerosakan</label>
                                <textarea id="s_v_perihal" readonly tabindex="-1" class="form-control form-control-readonly" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- LAMPIRAN SPESIFIKASI & GAMBAR BUKTI -->
                    <div id="s_spec_box" style="background: rgba(241, 245, 249, 0.7); border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 1.25rem;">
                        <h4 style="color: var(--primary); margin-bottom: 0.75rem; font-size: 0.95rem;">💻 Lampiran Spesifikasi Aset</h4>
                        <div id="s_spec_content"></div>
                    </div>

                    <div id="s_images_box" style="background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem;">
                        <h4 style="color: var(--text-main); margin-bottom: 0.75rem; font-size: 0.95rem;">📸 Gambar / Dokumen Lampiran Kerosakan</h4>
                        <div id="s_images_content"></div>
                    </div>

                    <!-- BAHAGIAN II: PENEMUAN TEKNIKAL OLEH ADMIN / SUPER ADMIN -->
                    <div style="border: 1.5px solid #93c5fd; background: #f0f7ff; border-radius: 14px; padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; border-bottom: 1px solid #bfdbfe; padding-bottom: 0.4rem;">
                            <h4 style="margin: 0; color: #1e40af; font-size: 0.95rem;">
                                🛠️ Bahagian II: Penemuan Teknikal (Pegawai Teknikal)
                            </h4>
                            <span id="s_v_proses_badge" style="font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 999px; font-weight: 700; background: #dbeafe; color: #1e40af;">
                                —
                            </span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Kos Penyelenggaraan Terdahulu (RM)</label>
                                <input type="number" step="0.01" name="kos_penyelenggaraan_dahulu" id="s_v_kos_dahulu" class="form-control" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Anggaran Kos Penyelenggaraan (RM)</label>
                                <input type="number" step="0.01" name="anggaran_kos" id="s_v_anggaran_kos" class="form-control" placeholder="0.00">
                            </div>
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Syor dan Ulasan Pegawai Teknikal</label>
                                <textarea name="syor_ulasan" id="s_v_syor" class="form-control" rows="2" placeholder="Syor dan ulasan teknikal..."></textarea>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Nama Pegawai Teknikal</label>
                                <input type="text" name="pegawai_teknikal_nama" id="s_v_admin_nama" class="form-control" placeholder="Nama pegawai...">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Jawatan Pegawai Teknikal</label>
                                <input type="text" name="pegawai_teknikal_jawatan" id="s_v_admin_jawatan" class="form-control" placeholder="Jawatan pegawai...">
                            </div>
                        </div>
                    </div>

                    <!-- BAHAGIAN III: KEPUTUSAN KETUA JABATAN (DIISI OLEH SUPER ADMIN) -->
                    <div style="border: 2px solid var(--primary); background: #ffffff; border-radius: 14px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 2px solid var(--primary-light); padding-bottom: 0.5rem;">
                            <h4 style="margin: 0; color: var(--primary); font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                                ✍️ Bahagian III: Keputusan Ketua Jabatan
                            </h4>
                            <span style="font-size: 0.75rem; background: var(--primary); color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 700;">
                                KHAS SUPER ADMIN
                            </span>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div class="form-group">
                                <label style="font-weight: 700; color: var(--text-main);">Keputusan Ketua Jabatan <span style="color:var(--danger)">*</span></label>
                                <select name="keputusan" id="s_edit_keputusan" class="form-control" required style="font-size: 0.95rem; font-weight: 600; border: 1.5px solid var(--primary);">
                                    <option value="" disabled selected>— Sila Pilih Keputusan —</option>
                                    <option value="Diluluskan">✅ Diluluskan</option>
                                    <option value="Tidak Diluluskan">❌ Tidak Diluluskan</option>
                                    <option value="Syor Dilupuskan">🗂️ Syor Dilupuskan</option>
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: var(--text-main);">Nama Pegawai Pelulus (Ketua Jabatan) <span style="color:var(--danger)">*</span></label>
                                    <input type="text" name="keputusan_nama" id="s_edit_kep_nama" class="form-control" required placeholder="Nama penuh ketua jabatan...">
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: 600; color: var(--text-main);">Tarikh Keputusan <span style="color:var(--danger)">*</span></label>
                                    <input type="date" name="keputusan_tarikh" id="s_edit_kep_tarikh" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 2; padding: 0.85rem; font-weight: 700; font-size: 1rem;">
                            💾 Simpan & Muktamadkan Laporan (Bahagian II & III)
                        </button>
                        <button type="button" onclick="printSuperKEWPA9()" class="btn btn-secondary" style="flex: 1; padding: 0.85rem;">
                            🖨️ Cetak KEW.PA-9
                        </button>
                        <button type="button" onclick="closeApprovalModal()" class="btn btn-secondary" style="padding: 0.85rem 1.5rem;">
                            Tutup
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- CETAKAN KEW.PA-9 HIDDEN -->
    <div id="superPrintableArea" style="display: none; padding: 10px;">
        <div class="pa9-title">KEW.PA-9</div>
        <div class="pa9-heading">BORANG ADUAN KEROSAKAN ASET ALIH</div>

        <div class="pa9-section-title">Bahagian I (Untuk diisi oleh Pengadu)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row"><div class="pa9-label">1. Jenis Aset</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_jenis"></div></div>
                <div class="pa9-row"><div class="pa9-label">2. Keterangan Aset</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_keterangan"></div></div>
                <div class="pa9-row"><div class="pa9-label">3. No. Siri Pendaftaran</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_siri"></div></div>
                <div class="pa9-row"><div class="pa9-label">4. Pengguna Terakhir</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_pengguna"></div></div>
                <div class="pa9-row"><div class="pa9-label">5. Tarikh Kerosakan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_tarikh"></div></div>
                <div class="pa9-row"><div class="pa9-label">6. Perihal Kerosakan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_perihal"></div></div>
            </div>
            <div style="width: 250px; border-left: 1px solid #000; padding-left: 15px; display: flex; flex-direction: column; justify-content: flex-end;">
                <div class="pa9-signature-block">
                    <div>Tandatangan Pengadu:</div>
                    <div style="height: 40px;"></div>
                    <div>Nama: <span id="pr_s_nama"></span></div>
                    <div>Jawatan: <span id="pr_s_jawatan"></span></div>
                    <div>Tarikh: <span id="pr_s_tarikh_aduan"></span></div>
                </div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian II (Untuk diisi oleh Pegawai Aset/Pegawai Teknikal)</div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <div class="pa9-row"><div class="pa9-label">7. Jumlah Kos Penyelenggaraan Terdahulu</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_kos_dahulu"></div></div>
                <div class="pa9-row"><div class="pa9-label">8. Anggaran Kos Penyelenggaraan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_anggaran_kos"></div></div>
                <div class="pa9-row"><div class="pa9-label">9. Syor Dan Ulasan</div><div class="pa9-colon">:</div><div class="pa9-value" id="pr_s_syor"></div></div>
            </div>
            <div style="width: 250px; border-left: 1px solid #000; padding-left: 15px; display: flex; flex-direction: column; justify-content: flex-end;">
                <div class="pa9-signature-block">
                    <div>Tandatangan:</div>
                    <div style="height: 40px;"></div>
                    <div>Nama: <span id="pr_s_admin_nama"></span></div>
                    <div>Jawatan: <span id="pr_s_admin_jawatan"></span></div>
                    <div>Tarikh: <span id="pr_s_admin_tarikh"></span></div>
                </div>
            </div>
        </div>

        <div class="pa9-section-title">Bahagian III (Keputusan Ketua Jabatan/Bahagian/Seksyen/Unit)</div>
        <div style="border: 1px solid #000; padding: 10px; margin-bottom: 20px;">
            <div style="margin-bottom: 15px;">
                <div>10. Keputusan:</div>
                <div style="margin-top: 5px; font-weight: bold; font-size: 14px;" id="pr_s_keputusan_line"></div>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <div class="pa9-signature-block" style="width: 250px;">
                    <div>Tandatangan:</div>
                    <div style="height: 40px;"></div>
                    <div>Nama: <span id="pr_s_kep_nama"></span></div>
                    <div>Jawatan: Ketua Jabatan</div>
                    <div>Tarikh: <span id="pr_s_kep_tarikh"></span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allReports = [];
        let filteredReports = [];
        let currentViewingReport = null;

        document.addEventListener('DOMContentLoaded', () => {
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

            const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const dateEl = document.getElementById('superadminDate');
            if (dateEl) dateEl.textContent = new Date().toLocaleDateString('ms-MY', opts);

            if (user && user.full_name) {
                document.getElementById('sidebarSuperadminName').textContent = user.full_name;
            }

            fetchReports();
        });

        function formatReportId(id) {
            if (!id && id !== 0) return '';
            const num = parseInt(id);
            if (isNaN(num)) return `#ICT${id}`;
            return `#ICT${String(num).padStart(2, '0')}`;
        }

        async function fetchReports() {
            const tbody = document.getElementById('superReportsTableBody');
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">⏳ Memuatkan rekod laporan...</td></tr>';

            try {
                const res = await fetch("../api/admin/admin_get_reports.php?_t=" + Date.now());
                const result = await res.json();

                if (result.status === 'success') {
                    allReports = result.data || [];
                    updateStatCounters();
                    handleReportSearch();

                    // Semak jika ada parameter ?id= untuk terus buka modal kelulusan
                    const urlParams = new URLSearchParams(window.location.search);
                    const targetId = urlParams.get('id');
                    if (targetId) {
                        openSuperApproval(targetId);
                    }
                } else {
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 2rem; color: var(--danger);">❌ ${result.message || 'Gagal memuatkan laporan.'}</td></tr>`;
                }
            } catch (err) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 2rem; color: var(--danger);">❌ Ralat sambungan: ${err.message}</td></tr>`;
            }
        }

        function updateStatCounters() {
            let total = allReports.length;
            let pendingSuper = 0;
            let approved = 0;
            let rejected = 0;

            allReports.forEach(r => {
                if (!r.keputusan || r.keputusan === 'Pending') {
                    pendingSuper++;
                } else if (r.keputusan === 'Diluluskan' || r.keputusan === 'Syor Dilupuskan') {
                    approved++;
                } else if (r.keputusan === 'Tidak Diluluskan') {
                    rejected++;
                }
            });

            document.getElementById('count_total').textContent = total;
            document.getElementById('count_pending_super').textContent = pendingSuper;
            document.getElementById('count_approved').textContent = approved;
            document.getElementById('count_rejected').textContent = rejected;
        }

        function handleReportSearch() {
            const q = (document.getElementById('reportSearchInput').value || '').toLowerCase().trim();
            const filter = document.getElementById('statusFilter').value;

            filteredReports = allReports.filter(r => {
                const idFormatted = formatReportId(r.id).toLowerCase();
                const rawId = String(r.id || '');
                const name = (r.nama_pelapor || r.full_name || '').toLowerCase();
                const siri = (r.nombor_siri || '').toLowerCase();
                const jenis = (r.jenis_aset || '').toLowerCase();

                const matchQ = !q || idFormatted.includes(q) || rawId.includes(q) || name.includes(q) || siri.includes(q) || jenis.includes(q);

                let matchFilter = true;
                if (filter === 'pending_decision') {
                    matchFilter = (!r.keputusan || r.keputusan === 'Pending');
                } else if (filter !== 'all') {
                    matchFilter = (r.keputusan === filter);
                }

                return matchQ && matchFilter;
            });

            renderReportsTable();
        }

        function renderReportsTable() {
            const tbody = document.getElementById('superReportsTableBody');
            if (!filteredReports.length) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">📭 Tiada laporan ditemui.</td></tr>';
                return;
            }

            tbody.innerHTML = filteredReports.map(r => {
                const hasDecision = r.keputusan && r.keputusan !== 'Pending';
                let decisionBadge = '';
                if (!hasDecision) {
                    decisionBadge = '<span class="status-pill" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a;">⏳ Menunggu Keputusan</span>';
                } else if (r.keputusan === 'Diluluskan') {
                    decisionBadge = '<span class="status-pill" style="background:#dcfce7; color:#166534; border:1px solid #bbf7d0;">✅ Diluluskan</span>';
                } else if (r.keputusan === 'Tidak Diluluskan') {
                    decisionBadge = '<span class="status-pill" style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca;">❌ Tidak Diluluskan</span>';
                } else if (r.keputusan === 'Syor Dilupuskan') {
                    decisionBadge = '<span class="status-pill" style="background:#e2e8f0; color:#334155; border:1px solid #cbd5e1;">🗂️ Syor Dilupuskan</span>';
                }

                let prosesLabel = '<span style="color:var(--text-muted); font-size:0.8rem;">—</span>';
                if (r.proses_semasa) {
                    const isSelesai = r.proses_semasa.includes('Selesai') || r.proses_semasa.includes('Siap');
                    prosesLabel = `<span style="font-size:0.8rem; font-weight:600; color:${isSelesai ? '#166534' : '#4338ca'}; background:${isSelesai ? '#dcfce7' : '#e0e7ff'}; padding:0.2rem 0.5rem; border-radius:6px;">${r.proses_semasa}</span>`;
                }

                const reporterName = r.nama_pelapor || r.full_name || 'Staf';
                const department = r.department || r.location || 'MPM';
                const reportDate = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

                return `
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s ease;">
                        <td style="padding: 1.1rem 1.25rem; font-weight: 700; color: var(--primary); font-size: 0.9rem;">
                            ${formatReportId(r.id)}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">${reporterName}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted);">${department}</div>
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${r.jenis_aset || 'Aset ICT'}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted); font-family: monospace;">S/N: ${r.nombor_siri || '-'}</div>
                        </td>
                        <td style="padding: 1.1rem 1.25rem; font-size: 0.85rem; color: var(--text-muted);">
                            ${reportDate}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            ${prosesLabel}
                        </td>
                        <td style="padding: 1.1rem 1.25rem;">
                            ${decisionBadge}
                        </td>
                        <td style="padding: 1.1rem 1.25rem; text-align: center;">
                            <button onclick="openSuperApproval(${r.id})" class="btn btn-primary" style="padding: 0.45rem 0.9rem; font-size: 0.82rem; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                                ⚖️ Keputusan KEW.PA-9
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function openSuperApproval(reportId) {
            const r = allReports.find(item => item.id == reportId);
            if (!r) return;
            currentViewingReport = r;

            document.getElementById('modalSuperTitle').textContent = `Urus Keputusan KEW.PA-9 (${formatReportId(r.id)})`;
            document.getElementById('s_id').value = r.id;

            // Bahagian I
            document.getElementById('s_v_jenis').value = r.jenis_aset || '-';
            document.getElementById('s_v_siri').value = r.nombor_siri || '-';
            document.getElementById('s_v_pengguna').value = r.pengguna_terakhir || '-';
            document.getElementById('s_v_tarikh_rosak').value = r.tarikh_kerosakan || '-';
            document.getElementById('s_v_nama_pelapor').value = (r.nama_pelapor || r.full_name || '') + (r.jawatan_pelapor ? ` / ${r.jawatan_pelapor}` : '');
            document.getElementById('s_v_lokasi').value = r.location || r.department || '-';
            document.getElementById('s_v_perihal').value = r.perihal_kerosakan || '-';

            // Lampiran Spec & Gambar
            renderSuperSpec(r.lampiran_spec);
            renderSuperImages(r.images);

            // Bahagian II
            document.getElementById('s_v_kos_dahulu').value = (r.kos_penyelenggaraan_dahulu !== null && r.kos_penyelenggaraan_dahulu !== undefined) ? r.kos_penyelenggaraan_dahulu : '';
            document.getElementById('s_v_anggaran_kos').value = (r.anggaran_kos !== null && r.anggaran_kos !== undefined) ? r.anggaran_kos : '';
            document.getElementById('s_v_syor').value = r.syor_ulasan || '';
            document.getElementById('s_v_admin_nama').value = r.admin_name_jawatan || '';
            document.getElementById('s_v_admin_jawatan').value = r.admin_jawatan || '';
            document.getElementById('s_v_proses_badge').textContent = r.proses_semasa ? `Proses Semasa: ${r.proses_semasa}` : 'Belum Diproses';

            // Bahagian III Form
            const currentUser = JSON.parse(sessionStorage.getItem('user') || '{}');
            document.getElementById('s_edit_keputusan').value = (r.keputusan && r.keputusan !== 'Pending') ? r.keputusan : '';
            document.getElementById('s_edit_kep_nama').value = r.keputusan_nama || currentUser.full_name || 'Ketua Jabatan';
            document.getElementById('s_edit_kep_tarikh').value = r.keputusan_tarikh || new Date().toISOString().split('T')[0];

            document.getElementById('superApprovalModal').style.display = 'flex';
        }

        function closeApprovalModal() {
            document.getElementById('superApprovalModal').style.display = 'none';
        }

        function renderSuperSpec(specData) {
            const bodyEl = document.getElementById('s_spec_content');
            if (!bodyEl) return;

            let spec = null;
            if (typeof specData === 'string') {
                let cleanStr = specData.trim();
                if (cleanStr.includes('&quot;') || cleanStr.includes('&#039;')) {
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
                bodyEl.innerHTML = '<div style="color:var(--text-muted);font-size:0.85rem;">ℹ️ Tiada spesifikasi aset dilampirkan bagi aduan ini.</div>';
                return;
            }

            const items = [
                { label: 'Jenis Aset', val: spec.asset_type },
                { label: 'Model Komputer', val: spec.model_komputer },
                { label: 'No. Siri CPU', val: spec.serial_number || spec.no_siri_pendaftaran },
                { label: 'Model Monitor', val: spec.model_monitor },
                { label: 'No. Siri Monitor', val: spec.serial_monitor },
                { label: 'OS', val: spec.os },
                { label: 'Pemproses', val: spec.processor },
                { label: 'RAM', val: spec.ram },
                { label: 'Cakera Keras', val: spec.hard_disk },
                { label: 'Alamat IP', val: spec.ip_address }
            ];

            const gridHtml = items
                .filter(it => it.val && it.val !== '-' && it.val !== '')
                .map(it => `
                    <div style="background:#ffffff;padding:0.5rem 0.75rem;border-radius:8px;border:1px solid var(--border);">
                        <div style="font-size:0.72rem;font-weight:600;color:var(--text-muted);">${it.label}</div>
                        <div style="font-size:0.85rem;font-weight:700;color:var(--text-main);">${it.val}</div>
                    </div>
                `).join('');

            bodyEl.innerHTML = `
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:0.5rem;">
                    ${gridHtml || '<div style="color:var(--text-muted);font-size:0.83rem;">Maklumat spesifikasi kosong.</div>'}
                </div>
            `;
        }

        function renderSuperImages(images) {
            const bodyEl = document.getElementById('s_images_content');
            if (!bodyEl) return;

            if (images && images.length > 0) {
                bodyEl.innerHTML = `
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(120px, 1fr));gap:0.75rem;">
                        ${images.map(img => {
                            const p = typeof img === 'string' ? img : (img.image_path || '');
                            const cleanPath = '../' + p.replace(/^\/+/, '');
                            return `
                                <div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--border);position:relative;background:#000;">
                                    <a href="${cleanPath}" target="_blank" title="Klik untuk besarkan">
                                        <img src="${cleanPath}" style="width:100%;height:100%;object-fit:cover;">
                                    </a>
                                </div>
                            `;
                        }).join('')}
                    </div>
                `;
            } else {
                bodyEl.innerHTML = '<div style="color:var(--text-muted);font-size:0.85rem;font-style:italic;">Tiada gambar kerosakan dimuat naik.</div>';
            }
        }

        async function handleSuperSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            try {
                const res = await fetch("../api/admin/admin_update_report.php", {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();

                if (result.status === 'success') {
                    alert('✅ ' + (result.message || 'Keputusan Ketua Jabatan (Bahagian III) berjaya dimuktamadkan!'));
                    closeApprovalModal();
                    fetchReports();
                } else {
                    alert('❌ Ralat: ' + result.message);
                }
            } catch (err) {
                alert('Ralat sambungan pelayan: ' + err.message);
            }
        }

        function printSuperKEWPA9() {
            if (!currentViewingReport) return;
            const r = currentViewingReport;

            document.getElementById('pr_s_jenis').textContent = r.jenis_aset || '-';
            document.getElementById('pr_s_keterangan').textContent = r.jenis_aset || '-';
            document.getElementById('pr_s_siri').textContent = r.nombor_siri || '-';
            document.getElementById('pr_s_pengguna').textContent = r.pengguna_terakhir || '-';
            document.getElementById('pr_s_tarikh').textContent = r.tarikh_kerosakan || '-';
            document.getElementById('pr_s_perihal').textContent = r.perihal_kerosakan || '-';
            document.getElementById('pr_s_nama').textContent = r.nama_pelapor || r.full_name || '';
            document.getElementById('pr_s_jawatan').textContent = r.jawatan_pelapor || 'Staff';
            document.getElementById('pr_s_tarikh_aduan').textContent = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '-';

            document.getElementById('pr_s_kos_dahulu').textContent = r.kos_penyelenggaraan_dahulu ? `RM ${parseFloat(r.kos_penyelenggaraan_dahulu).toFixed(2)}` : '0.00';
            document.getElementById('pr_s_anggaran_kos').textContent = r.anggaran_kos ? `RM ${parseFloat(r.anggaran_kos).toFixed(2)}` : '0.00';
            document.getElementById('pr_s_syor').textContent = r.syor_ulasan || '-';
            document.getElementById('pr_s_admin_nama').textContent = r.admin_name_jawatan || '-';
            document.getElementById('pr_s_admin_jawatan').textContent = r.admin_jawatan || 'Pegawai ICT';
            document.getElementById('pr_s_admin_tarikh').textContent = r.admin_tarikh ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY') : '-';

            const kep = document.getElementById('s_edit_keputusan').value;
            let kepText = 'Diluluskan / Tidak Diluluskan / Syor Dilupuskan';
            if (kep === 'Diluluskan') kepText = 'Diluluskan';
            else if (kep === 'Tidak Diluluskan') kepText = 'Tidak Diluluskan';
            else if (kep === 'Syor Dilupuskan') kepText = 'Syor Dilupuskan';

            document.getElementById('pr_s_keputusan_line').textContent = kepText;
            document.getElementById('pr_s_kep_nama').textContent = document.getElementById('s_edit_kep_nama').value || 'Ketua Jabatan';
            document.getElementById('pr_s_kep_tarikh').textContent = document.getElementById('s_edit_kep_tarikh').value ? new Date(document.getElementById('s_edit_kep_tarikh').value).toLocaleDateString('ms-MY') : '-';

            const originalBody = document.body.innerHTML;
            const printContent = document.getElementById('superPrintableArea').innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalBody;
            window.location.reload();
        }
    </script>
</body>

</html>
