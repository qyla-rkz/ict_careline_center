<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - eICT Desk</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=12"></script>
    <style>
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.32rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }
        body.dark-theme .table-card table thead tr {
            background: #1e293b !important;
        }
        body.dark-theme .table-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
        body.dark-theme #superActivityTableBody tr:hover {
            background: rgba(255, 255, 255, 0.03) !important;
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
                <p id="sidebarSuperadminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Super
                    Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link active">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">🪪 Profil Saya</a>
                <a href="reports.php" class="nav-link">📝 Kelulusan Laporan</a>
                <a href="history_reports.php" class="nav-link">📜 Sejarah Laporan</a>
                <a href="users.php" class="nav-link">👤 Pengguna</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link">👥 Aset Staf</a>
                <a href="disposed_assets.php" class="nav-link">🗑️ Aset Lupus</a>
                <a href="audit_logs.php" class="nav-link">📜 Jejak Audit</a>
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
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Super Admin Portal
                    </p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Papan Pemuka Utama</h2>
                </div>
                <div id="superadminDate"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date loaded via JS -->
                </div>
            </header>

            <section id="section-overview">
                <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-main);">Selamat
                    Datang ke Super Admin</h1>
                <p class="text-muted">Pantau dan urus keseluruhan sistem daripada satu tempat berpusat.</p>

                <div class="stats-grid"
                    style="margin-top: 2.5rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="stat-icon"
                            style="background: #eff6ff; color: #1e40af; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            👥
                        </div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Jumlah Pengguna</div>
                            <div id="totalUsers" style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">-
                            </div>
                        </div>
                    </div>
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="stat-icon"
                            style="background: #dcfce7; color: #166534; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            🖥️
                        </div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Jumlah Aset</div>
                            <div id="totalAssets" style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">
                                -</div>
                        </div>
                    </div>
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem; cursor: pointer; transition: transform 0.2s;" onclick="window.location.href='reports.php'" title="Klik untuk lihat dan luluskan laporan">
                        <div class="stat-icon"
                            style="background: #fef3c7; color: #92400e; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            📝
                        </div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Jumlah Laporan/Tiket
                            </div>
                            <div id="totalReports"
                                style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">-</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Profil Saya section removed as requested -->

            <!-- Activity Report Table Section (Pengesahan KEW.PA-9) -->
            <section style="margin-top: 3.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3
                            style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                            <span
                                style="width: 4px; height: 24px; background: var(--primary); border-radius: 2px; display: inline-block;"></span>
                            Laporan Aktiviti Pengesahan KEW.PA-9
                        </h3>
                        <p id="activitySectionSubtitle" style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">
                            Laporan terkini yang menunggu semakan &amp; keputusan Ketua Jabatan.
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap;">
                        <a href="history_reports.php" class="btn btn-outline"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; padding: 0.55rem 1.1rem; border-radius: 8px; text-decoration: none;">
                            <span>📜 Semua Sejarah Laporan</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="reports.php" class="btn btn-primary"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; padding: 0.55rem 1.1rem; border-radius: 8px; text-decoration: none;">
                            <span>📝 Kelulusan Laporan</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>


                <div class="card table-card" style="padding: 0; overflow: hidden; border-radius: 14px;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid var(--border);">
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">ID</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Pelapor</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Aset</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Pegawai Teknikal</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Tarikh Hantar</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Keputusan</th>
                                    <th style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="superActivityTableBody">
                                <tr>
                                    <td colspan="7" style="padding: 2.5rem; text-align: center; color: var(--text-muted);">
                                        ⏳ Memuatkan aktiviti laporan...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>


    <!-- ===== PASSWORD REMINDER MODAL ===== -->
    <div id="pwReminderModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.5); backdrop-filter:blur(6px); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:24px; padding:2.5rem; max-width:440px; width:90%; box-shadow:0 25px 60px rgba(0,0,0,0.15); animation:modalSlide 0.4s cubic-bezier(0.34,1.56,0.64,1); text-align:center; position:relative;">
            <div style="width:64px; height:64px; background:linear-gradient(135deg,#fee2e2,#fecaca); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2rem; margin:0 auto 1.25rem;">🔑</div>
            <h3 style="font-size:1.3rem; color:#0f172a; margin-bottom:0.5rem;">Peringatan Kata Laluan</h3>
            <p style="color:#64748b; font-size:0.9rem; line-height:1.6; margin-bottom:0.5rem;">
                Kata laluan anda telah melebihi <strong>90 hari</strong> dan perlu dikemas kini.
            </p>
            <p id="pwReminderDays" style="color:#dc2626; font-weight:700; font-size:0.95rem; margin-bottom:1.75rem;"></p>
            <div style="display:flex; gap:0.75rem; justify-content:center; flex-wrap:wrap;">
                <a href="profile.php" style="background:linear-gradient(135deg,#dc2626,#2563eb); color:white; font-weight:700; padding:0.75rem 1.5rem; border-radius:12px; text-decoration:none; font-size:0.9rem; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">🔒 Tukar Kata Laluan Sekarang</a>
                <button onclick="document.getElementById('pwReminderModal').style.display='none'" style="background:#f1f5f9; color:#475569; font-weight:600; padding:0.75rem 1.5rem; border-radius:12px; border:none; cursor:pointer; font-size:0.9rem;">Abaikan Buat Masa Ini</button>
            </div>
            <p style="color:#94a3b8; font-size:0.75rem; margin-top:1.25rem;">Peringatan ini akan terus muncul sehingga kata laluan anda dikemas kini.</p>
        </div>
    </div>
    <!-- ===== END PASSWORD REMINDER MODAL ===== -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const userStr = sessionStorage.getItem('user');
            if (!userStr) {
                window.location.replace('../login.php');
                return;
            }
            const user = JSON.parse(userStr);
            if (user.role !== 'Super Admin' && user.role !== 'superadmin') {
                alert('Akses Ditolak. Anda bukan Super Admin.');
                window.location.replace('../login.php');
                return;
            }

            // Set date and name
            const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('superadminDate').textContent = new Date().toLocaleDateString('ms-MY', opts);
            if (user && user.full_name) {
                document.getElementById('sidebarSuperadminName').textContent = user.full_name;
            }

            // Fetch profile to check password age
            try {
                const profileRes = await fetch("../api/admin/admin_get_profile.php");
                const profile = await profileRes.json();
                if (profile.status === 'success') {
                    sessionStorage.setItem('user', JSON.stringify(profile.data));
                    document.getElementById('sidebarSuperadminName').textContent = profile.data.full_name || user.full_name || 'Super Admin';
                    checkPasswordAge(profile.data.updated_at);
                }
            } catch (err) { console.error('Superadmin profile fetch error:', err); }

            loadDeanName();
            loadProfileSummary();
            fetchStats();
            fetchActivityReports();
        });

        function checkPasswordAge(updatedAt) {
            if (!updatedAt) return;
            const lastChanged = new Date(updatedAt);
            const now = new Date();
            const diffDays = Math.floor((now - lastChanged) / (1000 * 60 * 60 * 24));
            if (diffDays >= 90) {
                const modal = document.getElementById('pwReminderModal');
                const daysEl = document.getElementById('pwReminderDays');
                daysEl.textContent = `Kata laluan anda telah ${diffDays} hari tidak ditukar.`;
                modal.style.display = 'flex';
            }
        }

        function loadProfileSummary() {
            const user = JSON.parse(sessionStorage.getItem('user') || '{}');
            const nameEl = document.getElementById('profileName');
            const usernameEl = document.getElementById('profileUsername');
            const roleEl = document.getElementById('profileRole');

            if (nameEl && user.full_name) nameEl.textContent = user.full_name;
            if (usernameEl && user.username) usernameEl.textContent = user.username;
            if (roleEl && user.role) roleEl.textContent = user.role;
        }

        async function loadDeanName() {
            try {
                const res = await fetch("../api/superadmin/settings.php");
                const data = await res.json();
            } catch (e) {
                console.error('Ralat mengambil nama dekan:', e);
            }
        }

        async function fetchStats() {
            try {
                const res = await fetch("../api/superadmin/system_stats.php");
                const data = await res.json();

                if (data.status === 'success') {
                    document.getElementById('totalUsers').textContent = data.data.total_users;
                    document.getElementById('totalAssets').textContent = data.data.total_assets;
                    document.getElementById('totalReports').textContent = data.data.total_reports;
                }
            } catch (e) {
                console.error("Gagal mengambil statistik:", e);
            }
        }

        let currentActivityTab = 'pending';
        let cachedPendingReports = [];

        function switchActivityTab(tab) {
            renderActivityTable(cachedPendingReports, 'pending');
        }

        function formatId(id) {
            if (!id && id !== 0) return '';
            const num = parseInt(id);
            return isNaN(num) ? `#ICT${id}` : `#ICT${String(num).padStart(2, '0')}`;
        }

        function formatSentDate(r) {
            const dateVal = r.updated_at || r.admin_tarikh || r.created_at;
            if (!dateVal) return '—';
            const d = new Date(String(dateVal).replace(' ', 'T'));
            if (isNaN(d.getTime())) return dateVal;
            const dateStr = d.toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
            const timeStr = d.toLocaleTimeString('ms-MY', { hour: '2-digit', minute: '2-digit', hour12: true });
            return `<div style="font-weight:600; color:var(--text-main); font-size:0.85rem;">${dateStr}</div><div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">🕒 ${timeStr}</div>`;
        }

        function renderActivityTable(reports, tabType) {
            const tbody = document.getElementById('superActivityTableBody');
            if (!tbody) return;

            const displayReports = reports.slice(0, 5);

            if (displayReports.length === 0) {
                if (tabType === 'pending') {
                    tbody.innerHTML = '<tr><td colspan="7" style="padding: 3rem; text-align: center; color: var(--text-muted); font-style: italic;">🎉 Tiada laporan menunggu pengesahan. Semua laporan telah selesai diambil tindakan oleh Super Admin.</td></tr>';
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" style="padding: 3rem; text-align: center; color: var(--text-muted); font-style: italic;">Belum ada rekod kelulusan laporan. Laporan yang telah diberi keputusan akan dipaparkan di sini.</td></tr>';
                }
                return;
            }

            tbody.innerHTML = '';
            displayReports.forEach(r => {
                const hasDecision = r.keputusan && r.keputusan !== 'Pending';
                let badge = '';
                if (!hasDecision) {
                    badge = '<span class="status-pill" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a;">⏳ Menunggu Keputusan</span>';
                } else if (r.keputusan === 'Diluluskan') {
                    badge = '<span class="status-pill" style="background:#dcfce7; color:#166534; border:1px solid #bbf7d0;">✅ Diluluskan</span>';
                } else if (r.keputusan === 'Tidak Diluluskan') {
                    badge = '<span class="status-pill" style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca;">❌ Tidak Diluluskan</span>';
                } else if (r.keputusan === 'Syor Dilupuskan') {
                    badge = '<span class="status-pill" style="background:#e2e8f0; color:#334155; border:1px solid #cbd5e1;">🗂️ Syor Dilupuskan</span>';
                }

                let actionBtn = '';
                if (tabType === 'pending') {
                    actionBtn = `
                        <a href="reports.php?id=${r.id}" class="btn btn-primary" style="padding: 0.45rem 1rem; font-size: 0.82rem; font-weight: 700; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;" title="Buka dan buat keputusan KEW.PA-9">
                            ⚖️ Keputusan ›
                        </a>
                    `;
                } else {
                    actionBtn = `
                        <a href="history_reports.php?id=${r.id}" class="btn btn-outline" style="padding: 0.45rem 1rem; font-size: 0.82rem; font-weight: 600; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; border-color: #10b981; color: #10b981;" title="Lihat Rekod Kelulusan">
                            📃 Butiran ›
                        </a>
                    `;
                }

                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid var(--border)';
                tr.style.transition = 'background 0.15s ease';
                tr.onmouseover = () => tr.style.background = 'rgba(0,0,0,0.015)';
                tr.onmouseout = () => tr.style.background = 'transparent';

                const safeReporter = escapeHtml(r.nama_pelapor || r.full_name || '-');
                const safeDept = escapeHtml(r.department || r.location || '-');
                const safeAssetType = escapeHtml(r.jenis_aset || '-');
                const safeSN = escapeHtml(r.nombor_siri || '-');
                const safeAdminName = escapeHtml(r.admin_name_jawatan || 'Admin ICT');
                const safeAdminJawatan = escapeHtml(r.admin_jawatan || 'Pegawai Teknikal');

                tr.innerHTML = `
                    <td style="padding: 1.15rem 1.5rem; font-weight: 700; color: var(--primary); font-size: 0.9rem;">
                        ${formatId(r.id)}
                    </td>
                    <td style="padding: 1.15rem 1.5rem;">
                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;">${safeReporter}</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">${safeDept}</div>
                    </td>
                    <td style="padding: 1.15rem 1.5rem;">
                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${safeAssetType}</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); font-family: monospace;">S/N: ${safeSN}</div>
                    </td>
                    <td style="padding: 1.15rem 1.5rem;">
                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">${safeAdminName}</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">${safeAdminJawatan}</div>
                    </td>
                    <td style="padding: 1.15rem 1.5rem; white-space: nowrap;">
                        ${formatSentDate(r)}
                    </td>
                    <td style="padding: 1.15rem 1.5rem; white-space: nowrap;">
                        ${badge}
                    </td>
                    <td style="padding: 1.15rem 1.5rem; text-align: center; white-space: nowrap;">
                        ${actionBtn}
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        async function fetchActivityReports() {
            const tbody = document.getElementById('superActivityTableBody');
            if (!tbody) return;

            try {
                const res = await fetch("../api/admin/admin_get_reports.php?_t=" + Date.now());
                const result = await res.json();

                if (result.status !== 'success' || !Array.isArray(result.data)) {
                    tbody.innerHTML = '<tr><td colspan="7" style="padding: 2.5rem; text-align: center; color: var(--danger);">❌ Gagal memuatkan laporan aktiviti.</td></tr>';
                    return;
                }

                const all = result.data;

                // 1. Tapis laporan yang MENUNGGU keputusan
                cachedPendingReports = all.filter(r => {
                    const hasDecision = r.keputusan && r.keputusan !== 'Pending';
                    return !hasDecision;
                });

                // 2. Tapis laporan yang TELAH DIBERI KEPUTUSAN (Diluluskan, dsb)
                cachedApprovedReports = all.filter(r => {
                    return r.keputusan && r.keputusan !== 'Pending';
                });

                // Helper sorting: Bahagian 2 terisi di atas, kemudian tarikh terkini
                const sortReports = (list) => {
                    return list.slice().sort((a, b) => {
                        const aHasAdmin = !!(a.admin_name_jawatan || a.admin_tarikh || a.syor_ulasan) ? 1 : 0;
                        const bHasAdmin = !!(b.admin_name_jawatan || b.admin_tarikh || b.syor_ulasan) ? 1 : 0;
                        if (aHasAdmin !== bHasAdmin) {
                            return bHasAdmin - aHasAdmin;
                        }

                        const getTimeVal = (item) => {
                            if (item.updated_at) {
                                const t = new Date(String(item.updated_at).replace(' ', 'T')).getTime();
                                if (!isNaN(t)) return t;
                            }
                            if (item.admin_tarikh) {
                                const t = new Date(String(item.admin_tarikh)).getTime();
                                if (!isNaN(t)) return t;
                            }
                            if (item.tarikh_kelulusan) {
                                const t = new Date(String(item.tarikh_kelulusan)).getTime();
                                if (!isNaN(t)) return t;
                            }
                            return parseInt(item.id) || 0;
                        };

                        const timeDiff = getTimeVal(b) - getTimeVal(a);
                        if (timeDiff !== 0) return timeDiff;
                        return (parseInt(b.id) || 0) - (parseInt(a.id) || 0);
                    });
                };

                cachedPendingReports = sortReports(cachedPendingReports);

                // Kemas kini badge jumlah menunggu
                const pendingBadge = document.getElementById('pendingBadge');
                if (pendingBadge) pendingBadge.innerText = cachedPendingReports.length;

                // Paparkan senarai menunggu keputusan
                renderActivityTable(cachedPendingReports, 'pending');

            } catch (err) {
                console.error("Ralat memuatkan laporan aktiviti superadmin:", err);
                tbody.innerHTML = `<tr><td colspan="7" style="padding: 2.5rem; text-align: center; color: var(--danger);">❌ Ralat sambungan: ${err.message}</td></tr>`;
            }
        }
    </script>
</body>

</html>
