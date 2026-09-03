<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - ICT Careline Center</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=10"></script>
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
                <p id="sidebarSuperadminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Super
                    Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link active">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="users.php" class="nav-link">👥 Pengguna</a>
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
                    <div class="card stat-card" style="display: flex; align-items: center; gap: 1.5rem;">
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

            <section style="margin-top: 3.5rem;">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <div class="card" style="padding: 1.5rem;">
                        <h3 style="margin-bottom: 1rem; color: var(--text-main);">Ringkasan Data (Carta)</h3>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>
                    <div class="card" style="padding: 1.5rem;">
                        <h3 style="margin-bottom: 1rem; color: var(--text-main);">Jejak Audit Terkini</h3>
                        <ul id="recentActivityList" style="list-style: none; padding: 0; margin: 0;">
                            <li
                                style="padding: 1rem 0; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; color: #64748b;">
                                Memuatkan...</li>
                        </ul>
                        <div style="margin-top: 1.5rem; text-align: center;">
                            <a href="audit_logs.php" class="btn btn-outline"
                                style="width: 100%; display: block; font-size: 0.9rem;">Lihat Semua Jejak Audit
                                &rarr;</a>
                        </div>
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
                const profileRes = await fetch('../api/admin_get_profile.php');
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
                const res = await fetch('../api/superadmin/settings.php');
                const data = await res.json();
            } catch (e) {
                console.error('Ralat mengambil nama dekan:', e);
            }
        }

        async function fetchStats() {
            try {
                const res = await fetch('../api/superadmin/system_stats.php');
                const data = await res.json();

                if (data.status === 'success') {
                    document.getElementById('totalUsers').textContent = data.data.total_users;
                    document.getElementById('totalAssets').textContent = data.data.total_assets;
                    document.getElementById('totalReports').textContent = data.data.total_reports;

                    renderChart(data.data);
                    renderRecentLogs(data.data.recent_logs);
                }
            } catch (e) {
                console.error("Gagal mengambil statistik:", e);
            }
        }

        let mainChartInstance = null;

        function renderChart(stats) {
            const ctx = document.getElementById('mainChart').getContext('2d');

            if (mainChartInstance) {
                mainChartInstance.destroy();
            }

            const isDarkNow = document.body.classList.contains('dark-theme');
            const textColor = isDarkNow ? '#94a3b8' : '#64748b';
            const gridColor = isDarkNow ? '#334155' : '#f1f5f9';

            const primaryGrad = ctx.createLinearGradient(0, 0, 0, 300);
            primaryGrad.addColorStop(0, 'rgba(79, 70, 229, 0.85)');
            primaryGrad.addColorStop(1, 'rgba(79, 70, 229, 0.05)');

            const successGrad = ctx.createLinearGradient(0, 0, 0, 300);
            successGrad.addColorStop(0, 'rgba(13, 148, 136, 0.85)');
            successGrad.addColorStop(1, 'rgba(13, 148, 136, 0.05)');

            const warningGrad = ctx.createLinearGradient(0, 0, 0, 300);
            warningGrad.addColorStop(0, 'rgba(245, 158, 11, 0.85)');
            warningGrad.addColorStop(1, 'rgba(245, 158, 11, 0.05)');

            mainChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pengguna', 'Aset', 'Tiket/Laporan'],
                    datasets: [{
                        label: 'Jumlah Keseluruhan',
                        data: [stats.total_users, stats.total_assets, stats.total_reports],
                        backgroundColor: [primaryGrad, successGrad, warningGrad],
                        borderColor: ['#4f46e5', '#0d9488', '#f59e0b'],
                        borderWidth: 2,
                        borderRadius: 12,
                        borderSkipped: false,
                        barPercentage: 0.55
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDarkNow ? '#1e293b' : '#ffffff',
                            titleColor: isDarkNow ? '#f8fafc' : '#0f172a',
                            bodyColor: isDarkNow ? '#94a3b8' : '#64748b',
                            borderColor: isDarkNow ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 14,
                            cornerRadius: 12,
                            displayColors: true,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    return ` ${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    family: 'Outfit, sans-serif',
                                    size: 13,
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0,
                                color: textColor,
                                font: {
                                    family: 'Outfit, sans-serif',
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }

        window.updateChartsTheme = (isDark) => {
            if (mainChartInstance) {
                const textColor = isDark ? '#94a3b8' : '#64748b';
                const gridColor = isDark ? '#334155' : '#f1f5f9';

                mainChartInstance.options.scales.x.ticks.color = textColor;
                mainChartInstance.options.scales.y.ticks.color = textColor;
                mainChartInstance.options.scales.y.grid.color = gridColor;

                mainChartInstance.options.plugins.tooltip.backgroundColor = isDark ? '#1e293b' : '#ffffff';
                mainChartInstance.options.plugins.tooltip.titleColor = isDark ? '#f8fafc' : '#0f172a';
                mainChartInstance.options.plugins.tooltip.bodyColor = isDark ? '#94a3b8' : '#64748b';
                mainChartInstance.options.plugins.tooltip.borderColor = isDark ? '#334155' : '#e2e8f0';

                mainChartInstance.update();
            }
        };

        function renderRecentLogs(logs) {
            const list = document.getElementById('recentActivityList');
            list.innerHTML = '';

            if (!logs || logs.length === 0) {
                list.innerHTML = '<li style="padding: 1rem 0; font-size: 0.9rem; color: #64748b;">Tiada aktiviti.</li>';
                return;
            }

            logs.forEach(log => {
                const li = document.createElement('li');
                li.style.cssText = 'padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem;';
                li.innerHTML = `
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 0.2rem;">${log.action}</div>
                    <div style="color: #64748b; font-size: 0.8rem;">Oleh <strong>${log.name || 'System'}</strong> pada ${new Date(log.created_at).toLocaleString('ms-MY')}</div>
                `;
                list.appendChild(li);
            });
        }
    </script>
</body>

</html>