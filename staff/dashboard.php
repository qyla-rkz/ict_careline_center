<?php
// staff/dashboard.php
$pageTitle = 'Papan Pemuka Staf - eICT Desk';
include 'includes/header.php';
?>

<!-- LEFT PANEL: USER PROFILE & PILIH PORTAL -->
<div class="card-shell">
    <div class="view active" id="view-home">
        <div class="home-grid">
            <div class="user-section">
                <div class="avatar-wrapper">
                    <div class="avatar-ring"></div>
                    <div class="avatar-inner">
                        <img id="homeAvatar" src="" alt="" style="display:none;">
                        <span class="avatar-placeholder" id="homeInitial">?</span>
                    </div>
                </div>
                <div style="text-align:center;">
                    <div class="user-name" id="homeName">Memuatkan...</div>
                    <div class="user-jawatan" id="homeJawatan"></div>
                </div>
                <div class="user-dept" id="homeDept" style="display:none;"></div>
                <div class="user-actions">
                    <a href="profile.php" class="btn-action btn-edit">✏️ Edit Profil</a>
                    <button class="btn-action btn-logout" onclick="handleLogout()">🚪 Log Keluar</button>
                </div>
            </div>

            <div>
                <div class="view-heading" style="margin-bottom:1.2rem;">Pilih Portal</div>
                <div class="portal-grid portal-static-scroll">
                    <a href="#" class="portal-btn" aria-label="Dashboard MPM">
                        <div class="portal-btn-icon icon-purple">📊</div>
                        <span class="portal-btn-label">Dashboard MPM</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                    <a href="#" class="portal-btn" aria-label="Tempahan Bilik Mesyuarat">
                        <div class="portal-btn-icon icon-amber">📅</div>
                        <span class="portal-btn-label">Tempahan Bilik Mesyuarat</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                    <a href="borang_aduan.php" class="portal-btn" aria-label="Borang Aduan KEW.PA-9">
                        <div class="portal-btn-icon icon-blue">📋</div>
                        <span class="portal-btn-label">Borang Aduan KEW.PA-9</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                    <a href="aset_saya.php" class="portal-btn" aria-label="Aset Saya">
                        <div class="portal-btn-icon icon-cyan">💻</div>
                        <span class="portal-btn-label">Aset Saya</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                    <a href="laporan_saya.php" class="portal-btn" aria-label="Laporan Saya">
                        <div class="portal-btn-icon icon-rose">📜</div>
                        <span class="portal-btn-label">Laporan Saya</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                    <a href="../admin/dashboard.php" class="portal-btn admin-only" aria-label="Pengurusan Admin" style="display:none;">
                        <div class="portal-btn-icon icon-rose">🛡️</div>
                        <span class="portal-btn-label">Modul Admin</span>
                        <span class="portal-btn-arrow">›</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RIGHT PANEL: DASHBOARD SUMMARY -->
<div class="dashboard-side-view active" id="dashboard-side-container">
    <div class="view active" id="view-dashboard">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.75rem;flex-wrap:wrap;margin-bottom:.4rem;">
            <div>
                <div class="view-subheading">Papan Pemuka</div>
                <div class="view-heading" style="margin-bottom:.15rem;">Ringkasan Papan Pemuka</div>
            </div>
            <div id="portalHistDate" style="background:rgba(255,255,255,.9);padding:.45rem 1rem;border-radius:20px;box-shadow:0 4px 12px rgba(0,0,0,.05);font-weight:600;color:#24324b;font-size:.82rem;"></div>
        </div>

        <div class="view-scroll">
            <!-- Stats -->
            <div class="dashboard-summary">
                <div class="dashboard-stat">
                    <span class="dashboard-stat-icon">📝</span>
                    <div>
                        <div class="dashboard-stat-label">Jumlah Laporan Belum Selesai</div>
                        <div class="dashboard-stat-value" id="dashPendingCount">—</div>
                    </div>
                </div>
                <div class="dashboard-stat">
                    <span class="dashboard-stat-icon">📜</span>
                    <div>
                        <div class="dashboard-stat-label" id="dashYearLabel">Jumlah Laporan Tahun Ini</div>
                        <div class="dashboard-stat-value" id="dashYearCount">—</div>
                    </div>
                </div>
                <div class="dashboard-stat">
                    <span class="dashboard-stat-icon">📅</span>
                    <div>
                        <div class="dashboard-stat-label">Jumlah Laporan Keseluruhan</div>
                        <div class="dashboard-stat-value" id="dashTotalCount">—</div>
                    </div>
                </div>
            </div>

            <!-- Real-Time Status Tracking -->
            <div class="dashboard-list" style="margin-top:0;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.85rem;flex-wrap:wrap;gap:.5rem;">
                    <div class="dashboard-list-title" style="margin:0;">📡 Status Semasa Laporan KEW.PA-9</div>
                    <a href="laporan_saya.php" style="font-size:.76rem;color:#2563eb;font-weight:700;text-decoration:none;">Lihat Semua Laporan ›</a>
                </div>
                <div id="portalLiveTracking">
                    <p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Memuatkan status terkini...</p>
                </div>
            </div>

            <!-- Flowchart Link Card -->
            <div class="dashboard-list" style="margin-top:1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;">
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        <div style="width:38px;height:38px;border-radius:10px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0;">
                            📊
                        </div>
                        <div>
                            <div class="dashboard-list-title" style="margin:0;">Carta Alir Proses KEW.PA-9</div>
                            <div style="font-size:.76rem;color:#66768c;margin-top:.15rem;">Ketahui langkah-langkah proses pengendalian aduan kerosakan aset secara visual.</div>
                        </div>
                    </div>
                    <a href="carta_alir.php" class="flow-toggle-btn" style="text-decoration:none;">🔍 Paparan Penuh ›</a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="dashboard-list" style="margin-top:1rem;">
                <div class="dashboard-list-title">🕒 Aktiviti Terkini</div>
                <div id="portalActivityList">
                    <p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Memuatkan aktiviti...</p>
                </div>
            </div>
        </div>
    </div>
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
            <button onclick="document.getElementById('pwReminderModal').style.display='none'; document.body.classList.remove('modal-open');" style="background:#f1f5f9; color:#475569; font-weight:600; padding:0.75rem 1.5rem; border-radius:12px; border:none; cursor:pointer; font-size:0.9rem;">Abaikan Buat Masa Ini</button>
        </div>
        <p style="color:#94a3b8; font-size:0.75rem; margin-top:1.25rem;">Peringatan ini akan terus muncul sehingga kata laluan anda dikemas kini.</p>
    </div>
</div>
<!-- ===== END PASSWORD REMINDER MODAL ===== -->

<script>
    let currentUser = null;

    document.addEventListener('DOMContentLoaded', async () => {
        let raw = sessionStorage.getItem('user');
        if (!raw) {
            try {
                const res = await fetch('../api/check_session.php', { cache: 'no-store', credentials: 'same-origin' });
                const json = await res.json();
                if (json.status === 'success' && json.data) {
                    sessionStorage.setItem('user', JSON.stringify(json.data));
                    raw = JSON.stringify(json.data);
                } else {
                    window.location.replace('../login.php');
                    return;
                }
            } catch (err) {
                window.location.replace('../login.php');
                return;
            }
        }
        currentUser = JSON.parse(raw);
        const name = currentUser.full_name || currentUser.name || 'Pengguna';
        document.getElementById('homeName').textContent = name;
        if (currentUser.jawatan) document.getElementById('homeJawatan').textContent = currentUser.jawatan;
        if (currentUser.department) {
            const d = document.getElementById('homeDept');
            d.textContent = currentUser.department;
            d.style.display = 'block';
        }
        document.getElementById('homeInitial').textContent = name.trim().charAt(0).toUpperCase();
        if (currentUser.profile_picture) {
            const i = document.getElementById('homeAvatar');
            i.src = '../uploads/' + currentUser.profile_picture;
            i.style.display = 'block';
            document.getElementById('homeInitial').style.display = 'none';
        }

        const isAdmin = ['admin','super admin','superadmin'].includes((currentUser.role || '').toLowerCase());
        if (isAdmin) {
            document.querySelectorAll('.admin-only').forEach(el => el.style.display = 'flex');
        }

        const histDate = document.getElementById('portalHistDate');
        if (histDate) {
            histDate.textContent = new Date().toLocaleDateString('ms-MY', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }

        // Fetch staff profile to check password age and sync session
        try {
            const profileRes = await fetch('../api/staff/staff_get_profile.php');
            const profile = await profileRes.json();
            if (profile.status === 'success' && profile.data) {
                sessionStorage.setItem('user', JSON.stringify(profile.data));
                currentUser = profile.data;
                const updatedName = currentUser.full_name || currentUser.name || 'Pengguna';
                document.getElementById('homeName').textContent = updatedName;
                if (currentUser.jawatan) document.getElementById('homeJawatan').textContent = currentUser.jawatan;
                if (currentUser.department) {
                    const d = document.getElementById('homeDept');
                    d.textContent = currentUser.department;
                    d.style.display = 'block';
                }
                document.getElementById('homeInitial').textContent = updatedName.trim().charAt(0).toUpperCase();
                if (currentUser.profile_picture) {
                    const i = document.getElementById('homeAvatar');
                    i.src = '../uploads/' + currentUser.profile_picture;
                    i.style.display = 'block';
                    document.getElementById('homeInitial').style.display = 'none';
                }
                checkPasswordAge(profile.data.updated_at);
            }
        } catch (err) {
            console.error('Staff profile fetch error:', err);
        }

        loadPortalDashboard();
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
            document.body.classList.add('modal-open');
        }
    }

    async function loadPortalDashboard() {
        try {
            const res = await fetch('../api/staff/staff_get_history.php');
            const data = await res.json();
            if (data.status === 'success') {
                const reports = data.data || [];
                const currentYear = new Date().getFullYear();
                document.getElementById('dashTotalCount').textContent   = reports.length;
                document.getElementById('dashPendingCount').textContent = reports.filter(r => r.status === 'Pending').length;
                document.getElementById('dashYearLabel').textContent    = 'JUMLAH LAPORAN TAHUN ' + currentYear;
                document.getElementById('dashYearCount').textContent    = reports.filter(r => new Date(r.created_at).getFullYear() === currentYear).length;

                // Live Tracking
                const container = document.getElementById('portalLiveTracking');
                const active = reports.filter(r => r.status === 'Pending' || r.status === 'In Progress').slice(0, 3);
                if (active.length > 0) {
                    container.innerHTML = active.map(report => {
                        let sColor = '#b45309', sBg = '#fef3c7', sIcon = '🕒', sLabel = 'Belum Selesai';
                        if (report.status === 'In Progress') { 
                            sColor = '#1d4ed8'; sBg = '#dbeafe'; sIcon = '🔄'; sLabel = 'Dalam Proses'; 
                        }
                        const dateStr = new Date(report.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
                        const prosesColors = { 
                            'Diterima': ['#e0f2fe','#0369a1'], 
                            'Sedang Dibaikpulih': ['#fef9c3','#854d0e'], 
                            'Tunggu Panel / Alat Ganti': ['#ffedd5','#9a3412'], 
                            'Dihantar ke Panel Lantikan': ['#ede9fe','#6d28d9'], 
                            'Selesai Dibaiki': ['#dcfce7','#166534'], 
                            'Siap - Sedia Diambil': ['#dcfce7','#166534'] 
                        };
                        let prosesHTML = '';
                        if (report.proses_semasa) {
                            const pc = prosesColors[report.proses_semasa] || ['#f1f5f9','#475569'];
                            prosesHTML = `<div style="margin-top:.35rem;display:inline-flex;align-items:center;gap:.3rem;background:${pc[0]};color:${pc[1]};padding:.2rem .65rem;border-radius:20px;font-size:.74rem;font-weight:700;">🔄 ${report.proses_semasa}</div>`;
                        } else {
                            prosesHTML = `<div style="margin-top:.3rem;font-size:.74rem;color:#66768c;">⏳ Menunggu tindakan admin...</div>`;
                        }
                        return `
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:.85rem 1rem;border:1px solid rgba(37,99,235,.15);border-radius:10px;background:#f8fafc;gap:.75rem;margin-bottom:.5rem;">
                            <div style="display:flex;align-items:center;gap:.75rem;flex:1;">
                                <div style="width:38px;height:38px;border-radius:50%;background:${sBg};display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">${sIcon}</div>
                                <div style="flex:1;">
                                    <div style="font-weight:700;color:#24324b;font-size:.88rem;">${report.jenis_aset}</div>
                                    <div style="color:#66768c;font-size:.76rem;">S/N: ${report.nombor_siri || '—'} &bull; ${dateStr}</div>
                                    ${prosesHTML}
                                </div>
                            </div>
                            <div style="background:${sBg};color:${sColor};padding:.3rem .75rem;border-radius:20px;font-weight:700;font-size:.74rem;white-space:nowrap;">${sLabel}</div>
                        </div>`;
                    }).join('');
                } else {
                    container.innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada laporan aktif pada masa ini. ✅</p>';
                }
            }
        } catch(e) { 
            console.error('Dashboard fetch error:', e); 
        }

        // Activity List
        try {
            const aRes = await fetch('../api/staff/staff_get_activity.php');
            const aData = await aRes.json();
            const aList = document.getElementById('portalActivityList');
            if (aData.status === 'success' && aData.data && aData.data.length > 0) {
                const iconMap = { 
                    'Profile': ['👤','#eff6ff','#1e40af'], 
                    'Asset': ['🖥️','#f0f9ff','#0369a1'], 
                    'Report': ['📝','#fff7ed','#9a3412'] 
                };
                aList.innerHTML = aData.data.slice(0, 5).map(a => {
                    const key = Object.keys(iconMap).find(k => a.activity_type.includes(k)) || 'Report';
                    const [icon, bg, color] = iconMap[key];
                    const dateStr = new Date(a.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short' });
                    return `
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;background:rgba(0,0,0,.02);border-radius:10px;border:1px solid rgba(37,99,235,.1);margin-bottom:.4rem;">
                        <div style="background:${bg};color:${color};width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">${icon}</div>
                        <div style="flex:1;">
                            <div style="font-weight:700;font-size:.84rem;color:#24324b;">${a.activity_type}</div>
                            <div style="color:#66768c;font-size:.76rem;">${a.description}</div>
                        </div>
                        <div style="font-size:.72rem;color:#66768c;font-weight:600;white-space:nowrap;">${dateStr}</div>
                    </div>`;
                }).join('');
            } else {
                aList.innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada aktiviti terkini.</p>';
            }
        } catch(e) { 
            document.getElementById('portalActivityList').innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada aktiviti terkini.</p>'; 
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
