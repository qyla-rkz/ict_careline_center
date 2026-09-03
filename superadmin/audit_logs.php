<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Jejak Sistem (Audit) - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=10"></script>
    <style>
        .table-container {
            overflow-x: auto;
            margin-top: 1.5rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
        }

        .badge-action {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #334155;
            white-space: nowrap;
            display: inline-block;
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
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="users.php" class="nav-link">👥 Pengguna</a>
                <a href="audit_logs.php" class="nav-link active">📜 Jejak Audit</a>
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
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Log Jejak Sistem (Audit Trails)</h2>
                </div>
                <div id="superadminDate"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date loaded via JS -->
                </div>
            </header>

            <section>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Menunjukkan 100 aktiviti sistem terakhir
                        yang dilakukan oleh pengguna.</p>

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div id="activityCount"
                            style="font-weight: 600; color: var(--primary); background: #eff6ff; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem; display: none;">
                            Jumlah Aktiviti: -
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <label for="dateFilter" style="font-size: 0.9rem; font-weight: 600; color: #475569;">Tapis
                                Tarikh:</label>
                            <input type="date" id="dateFilter"
                                style="padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-family: 'Outfit', sans-serif;">
                            <button id="btnPaparSemua" onclick="resetFilter()"
                                style="padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; color: #475569; font-family: 'Outfit', sans-serif; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">🔄 Papar Semua</button>
                        </div>
                    </div>
                </div>

                <div class="table-container" style="margin-top: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Tarikh & Masa</th>
                                <th>Pengguna</th>
                                <th>Tindakan</th>
                                <th>Butiran</th>
                            </tr>
                        </thead>
                        <tbody id="logsTableBody">
                            <tr>
                                <td colspan="4" style="text-align:center;">Memuatkan data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        let allLogsData = [];

        document.addEventListener('DOMContentLoaded', () => {
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

            // Set tarikh hari ini sebagai nilai default untuk filter
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            document.getElementById('dateFilter').value = `${yyyy}-${mm}-${dd}`;

            loadDeanName();
            fetchLogs();

            document.getElementById('dateFilter').addEventListener('change', function (e) {
                const selectedDate = e.target.value;

                if (!selectedDate) {
                    renderLogs(allLogsData);
                    document.getElementById('activityCount').style.display = 'none';
                    return;
                }

                const filteredLogs = allLogsData.filter(log => {
                    const logDate = log.created_at.split(' ')[0]; // Ambil bahagian tarikh sahaja (YYYY-MM-DD)
                    return logDate === selectedDate;
                });

                renderLogs(filteredLogs);
                const countDiv = document.getElementById('activityCount');
                countDiv.style.display = 'block';
                countDiv.textContent = `Jumlah Aktiviti: ${filteredLogs.length}`;
            });
        });

        async function loadDeanName() {
            try {
                const res = await fetch("../api/superadmin/settings.php");
                const data = await res.json();
            } catch (e) {
                console.error('Ralat mengambil nama dekan:', e);
            }
        }

        async function fetchLogs() {
            try {
                const res = await fetch("../api/superadmin/audit_logs.php");
                const data = await res.json();

                if (data.status === 'success') {
                    allLogsData = data.data.logs;

                    // Tapis automatik ikut tarikh yang dipilih (hari ini by default)
                    const selectedDate = document.getElementById('dateFilter').value;
                    if (selectedDate) {
                        const filteredLogs = allLogsData.filter(log => log.created_at.split(' ')[0] === selectedDate);
                        renderLogs(filteredLogs);
                        const countDiv = document.getElementById('activityCount');
                        countDiv.style.display = 'block';
                        countDiv.textContent = `Jumlah Aktiviti: ${filteredLogs.length}`;
                    } else {
                        renderLogs(allLogsData);
                    }
                } else {
                    alert(data.message);
                }
            } catch (e) {
                console.error(e);
                alert("Gagal memuatkan log audit.");
            }
        }

        function renderLogs(logs) {
            const tbody = document.getElementById('logsTableBody');
            tbody.innerHTML = '';

            if (logs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding: 2rem;">Tiada log direkodkan untuk tarikh ini.</td></tr>';
                return;
            }

            logs.forEach(log => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="white-space:nowrap; color:#64748b;">${new Date(log.created_at).toLocaleString('ms-MY')}</td>
                    <td><strong>${log.user_name || 'Tidak diketahui'}</strong><br><small>${log.staff_id || '-'}</small></td>
                    <td><span class="badge-action">${log.action}</span></td>
                    <td>${log.details || '-'}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function resetFilter() {
            document.getElementById('dateFilter').value = '';
            document.getElementById('activityCount').style.display = 'none';
            renderLogs(allLogsData);
        }

    </script>
</body>

</html>