<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Pemuka Staf - ICT Careline Center</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <script src="../assets/js/global.js?v=10"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <script>mermaid.initialize({ startOnLoad: true });</script>
    <style>
        body {
            overflow: hidden;
        }

        /* Fix double scrollbar */
        .mermaid svg {
            width: 100% !important;
            max-width: 550px !important;
            height: auto !important;
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
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link active">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="assets.php" class="nav-link">🖥️ Aset Saya</a>
                <a href="report_form.php" class="nav-link">📝 Hantar KEW.PA-9</a>
                <a href="history.php" class="nav-link">📜 Laporan Saya</a>
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
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Staff Portal
                    </p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Ringkasan Papan Pemuka</h2>
                </div>
                <div id="current-date"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date will be loaded here -->
                </div>
            </header>

            <section id="section-overview">
                <!-- Premium Quick-Action Banner -->
                <div class="card"
                    style="background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); color: white; border: none; padding: 2.25rem; position: relative; overflow: hidden; margin-bottom: 2rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(30, 64, 175, 0.15);">
                    <div style="position: relative; z-index: 2;">
                        <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 0.5rem; color: white;">Pusat
                            Tindakan & Bantuan ICT</h2>
                        <p
                            style="opacity: 0.9; font-size: 0.95rem; max-width: 650px; margin-bottom: 1.5rem; line-height: 1.6;">
                            Urus aset anda, laporkan kerosakan peralatan ICT melalui borang KEW.PA-9 dengan pantas, dan
                            jejaki status tindakan laporan aktif anda secara langsung.
                        </p>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="report_form.php"
                                style="background: white; color: var(--primary); font-weight: 700; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.2)';"
                                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';">
                                📝 Hantar Laporan Kerosakan
                            </a>
                            <a href="assets.php"
                                style="background: rgba(255,255,255,0.15); color: white; font-weight: 600; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; backdrop-filter: blur(5px); transition: background 0.2s;"
                                onmouseover="this.style.background='rgba(255,255,255,0.25)';"
                                onmouseout="this.style.background='rgba(255,255,255,0.15)';">
                                🖥️ Senarai Aset Saya
                            </a>
                        </div>
                    </div>
                    <!-- Decorative background shapes -->
                    <div
                        style="position: absolute; right: -50px; bottom: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.08); border-radius: 50%; pointer-events: none; z-index: 1;">
                    </div>
                    <div
                        style="position: absolute; right: 100px; top: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.05); border-radius: 50%; pointer-events: none; z-index: 1;">
                    </div>
                </div>

                <!-- Reminder Alert Box -->
                <div
                    style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: flex-start; gap: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <div style="font-size: 1.5rem;">🔔</div>
                    <div>
                        <h4 style="margin: 0 0 0.25rem; color: #92400e;">Peringatan Status Laporan KEW.PA-9</h4>
                        <p style="margin: 0; font-size: 0.9rem; color: #b45309;">Sila semak menu <strong>Laporan
                                Saya</strong> dari semasa ke semasa untuk mengetahui status terkini laporan anda. Admin
                            akan mengemaskini status laporan dan menjana borang cetakan setelah tindakan diambil.</p>
                    </div>
                </div>

                <div class="stats-grid"
                    style="margin-top: 2.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="stat-icon"
                            style="background: #fef3c7; color: #92400e; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            📝</div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Laporan Belum Selesai
                            </div>
                            <div id="stat-pending"
                                style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">0</div>
                        </div>
                    </div>
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="stat-icon"
                            style="background: #dcfce7; color: #166534; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            📜</div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Jumlah Laporan</div>
                            <div id="stat-total" style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">0
                            </div>
                        </div>
                    </div>
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
                        <div class="stat-icon"
                            style="background: #e0e7ff; color: #3730a3; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            📅</div>
                        <div>
                            <div class="text-muted" style="font-size: 0.9rem; font-weight: 600;">Laporan Tahun Ini</div>
                            <div id="stat-yearly" style="font-size: 1.8rem; font-weight: 800; color: var(--text-main);">
                                0</div>
                        </div>
                    </div>
                </div>

                <!-- Real-Time Status Tracking -->
                <div class="card" style="margin-top: 2.5rem; border-left: 4px solid var(--primary);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                            📡 Status Semasa Laporan KEW.PA-9
                        </h3>
                        <a href="history.php" style="font-size: 0.85rem; color: var(--primary); text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
                    </div>
                    
                    <div id="liveTrackingContainer" style="display: flex; flex-direction: column; gap: 1rem;">
                        <p class="text-muted" style="text-align: center; padding: 1rem;">Memuatkan status laporan...</p>
                    </div>
                </div>


                <div class="card" style="margin-top: 2.5rem;">
                    <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Carta Alir Proses KEW.PA-9</h3>
                    <div style="overflow: auto; text-align: center; width: 100%;">
                        <pre class="mermaid">
flowchart TD
    %% Define styles
    classDef default fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-family:sans-serif,font-weight:600;
    classDef diamond fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-family:sans-serif,font-weight:600;

    %% Nodes
    A([Mula])
    B[Isi Maklumat Laporan<br />Kerosakan Aset]
    C[Hantar Laporan<br />Kerosakan Aset]
    D[Semak Laporan<br />Kerosakan Aset]
    E[Ambil Aset yang<br />dilaporkan rosak]
    F[Mengenalpasti masalah<br />aset yang dilaporkan rosak]
    G{Adakah aset tersebut<br />boleh dibaikpulih?}
    H[Hantar aset tersebut<br />ke panel lantikan]
    I[Mencari dan mengganti<br />alat komponen yang rosak]
    J[Penyelenggaran dan<br />pembaikian selesai]
    K{Adakah aset telah<br />dibaikpulihkan?}
    L[Melupuskan aset yang<br />tidak dapat dibaiki]
    M[Kembalikan aset<br />yang dibaiki]
    N[Kemaskini keputusan<br />laporan kerosakan aset]
    O[Menjana laporan<br />kerosakan aset]
    P[Tandatangan laporan<br />pengesahan kerosakan aset]
    Q([Tamat])

    %% Edges
    A --> B
    B --> C
    C --> D
    D --> E
    E --> F
    F --> G
    G -- No --> H
    G -- Yes --> I
    H --> J
    I --> J
    J --> K
    K -- No --> L
    K -- Yes --> M
    L --> N
    M --> N
    N --> O
    O --> P
    P --> Q

    %% Apply class
    class G,K diamond;
                        </pre>
                    </div>
                </div>

                <div class="card" style="margin-top: 2.5rem;">
                    <h3 style="margin-bottom: 1.5rem;">Aktiviti Terkini</h3>
                    <div id="activity-list" style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Activities will be loaded here -->
                        <p class="text-muted">Memuatkan aktiviti terkini anda...</p>
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

    <script>
        async function handleLogout() {
            try {
                await fetch('../api/logout.php');
            } catch (err) { }
            sessionStorage.clear();
            sessionStorage.clear();
            window.location.replace('../login.php');
        }

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

        document.addEventListener('DOMContentLoaded', async () => {
            // Display Current Date
            const dateOpts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('current-date').textContent = new Date().toLocaleDateString('ms-MY', dateOpts);

            // Fetch Profile (Critical for welcome message)
            try {
                const profileRes = await fetch('../api/staff_get_profile.php');
                if (!profileRes.ok) throw new Error(`HTTP error! status: ${profileRes.status}`);

                const profile = await profileRes.json();
                if (profile.status === 'success') {
                    sessionStorage.setItem('user', JSON.stringify(profile.data));
                    if (typeof setupStaffSidebarProfile === 'function') {
                        setupStaffSidebarProfile();
                    }
                    // Check password age
                    checkPasswordAge(profile.data.updated_at);
                } else {
                    console.error('Profile fetch failed:', profile.message);
                    // Show specific error to help user debug
                    if (profile.message !== 'Not logged in') {
                        alert('Profile Error: ' + profile.message);
                    } else {
                        window.location.replace('../login.php');
                    }
                }
            } catch (err) {
                console.error('Profile fetch error:', err);
                alert('Connection Error: Could not connect to profile API.');
            }

            // Fetch Stats (History) & Update Real-time tracking
            try {
                const historyRes = await fetch('../api/staff_get_history.php');
                const history = await historyRes.json();

                if (history.status === 'success') {
                    // Update Stats
                    document.getElementById('stat-total').textContent = history.data.length;
                    const pending = history.data.filter(r => r.status === 'Pending').length;
                    document.getElementById('stat-pending').textContent = pending;

                    // Calculate reports for current year
                    const currentYear = new Date().getFullYear();
                    const yearly = history.data.filter(r => new Date(r.created_at).getFullYear() === currentYear).length;
                    document.getElementById('stat-yearly').textContent = yearly;

                    // Update Real-Time Tracking (Active/Baru Dihantar)
                    const container = document.getElementById('liveTrackingContainer');
                    const activeReports = history.data.filter(r => r.status === 'Pending' || r.status === 'In Progress');
                    
                    if (activeReports.length > 0) {
                        const recentReports = activeReports.slice(0, 3);
                        container.innerHTML = '';
                        recentReports.forEach(report => {
                            let statusColor = '#b45309', statusBg = '#fef3c7', statusIcon = '🕒';
                            const status = report.status || 'Pending';
                            if (status === 'In Progress') { statusColor = '#1d4ed8'; statusBg = '#dbeafe'; statusIcon = '🔄'; }

                            const dateStr = new Date(report.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
                            
                            // Proses Semasa dari Admin
                            let prosesHTML = '';
                            if (report.proses_semasa) {
                                const prosesColors = {
                                    'Diterima': { bg: '#e0f2fe', color: '#0369a1' },
                                    'Sedang Dibaikpulih': { bg: '#fef9c3', color: '#854d0e' },
                                    'Tunggu Panel / Alat Ganti': { bg: '#ffedd5', color: '#9a3412' },
                                    'Dihantar ke Panel Lantikan': { bg: '#ede9fe', color: '#6d28d9' },
                                    'Siap - Sedia Diambil': { bg: '#dcfce7', color: '#166534' },
                                };
                                const pc = prosesColors[report.proses_semasa] || { bg: '#f1f5f9', color: '#475569' };
                                prosesHTML = `<div style="margin-top: 0.4rem; display: inline-flex; align-items: center; gap: 0.4rem; background: ${pc.bg}; color: ${pc.color}; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700;">
                                    🔄 Proses: ${report.proses_semasa}
                                </div>`;
                            } else {
                                prosesHTML = `<div style="margin-top: 0.4rem; display: inline-flex; align-items: center; gap: 0.4rem; color: var(--text-muted); font-size: 0.78rem;">⏳ Menunggu tindakan admin...</div>`;
                            }

                            container.innerHTML += `
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border: 1px solid var(--border); border-radius: 12px; background: #f8fafc; gap: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: ${statusBg}; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">${statusIcon}</div>
                                        <div style="flex: 1;">
                                            <div style="font-weight: 700; color: var(--text-main); font-size: 1rem;">${report.jenis_aset}</div>
                                            <div style="color: var(--text-muted); font-size: 0.82rem;">S/N: ${report.nombor_siri} • Dihantar: ${dateStr}</div>
                                            ${prosesHTML}
                                        </div>
                                    </div>
                                    <div style="background: ${statusBg}; color: ${statusColor}; padding: 0.4rem 1rem; border-radius: 20px; font-weight: 700; font-size: 0.8rem; white-space: nowrap;">
                                        ${status === 'Pending' ? 'Belum Selesai' : 'Dalam Proses'}
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        container.innerHTML = '<p class="text-muted" style="text-align: center; padding: 1rem;">Tiada laporan yang sedang diproses pada masa ini.</p>';
                    }
                }
            } catch (err) { console.error('Stats fetch error:', err); }

            // Fetch Recent Activity
            const activityList = document.getElementById('activity-list');
            try {
                const activityRes = await fetch('../api/staff_get_activity.php');
                const activity = await activityRes.json();

                if (activity.status === 'success' && activity.data.length > 0) {
                    activityList.innerHTML = activity.data.map(a => {
                        let icon = '📝';
                        let bgColor = '#f1f5f9';
                        let textColor = '#475569';

                        if (a.activity_type.includes('Profile')) { icon = '👤'; bgColor = '#eff6ff'; textColor = '#1e40af'; }
                        if (a.activity_type.includes('Asset')) { icon = '🖥️'; bgColor = '#f0f9ff'; textColor = '#0369a1'; }
                        if (a.activity_type.includes('Report')) { icon = '📝'; bgColor = '#fff7ed'; textColor = '#9a3412'; }

                        return `
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: rgba(0,0,0,0.02); border-radius: 12px; border: 1px solid var(--border);">
                                <div style="background: ${bgColor}; color: ${textColor}; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    ${icon}
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; font-size: 0.95rem;">${a.activity_type}</div>
                                    <div class="text-muted" style="font-size: 0.85rem;">${a.description}</div>
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem; font-weight: 600;">
                                    ${new Date(a.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short' })}
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    activityList.innerHTML = '<p class="text-muted" style="text-align: center; padding: 1rem;">Tiada aktiviti terkini ditemui.</p>';
                }
            } catch (err) {
                console.error('Activity fetch error:', err);
                activityList.innerHTML = '<p class="text-muted" style="text-align: center; padding: 1rem;">Tiada aktiviti terkini ditemui.</p>';
            }
        });
    </script>
</body>

</html>