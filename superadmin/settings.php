<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetapan Sistem - Super Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="../assets/js/global.js?v=10"></script>
    <style>
        .settings-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 1.75rem;
            transition: var(--transition);
        }

        .settings-card:hover {
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.04);
            border-color: rgba(79, 70, 229, 0.1);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }

        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 0.85rem 1.15rem;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            border-radius: 12px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: var(--transition);
            outline: none;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus,
        .form-group select:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .cta-btn {
            background: var(--primary);
            color: #fff;
            padding: 0.9rem 2.25rem;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.2);
            display: inline-block;
        }

        .cta-btn:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.3);
        }

        .cta-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="dashboard-body">
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
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
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
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Konfigurasi Sistem</h2>
                </div>
                <div id="superadminDate"
                    style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                    <!-- Date loaded via JS -->
                </div>
            </header>

            <section style="max-width: 800px;">
                <form id="settingsForm">
                    <!-- Mod Penyelenggaraan & Tetapan Am -->
                    <div class="settings-card">
                        <h3
                            style="margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; color: var(--text-main);">
                            Tetapan Am</h3>
                        <div class="form-group">
                            <label for="maintenance_mode">Mod Penyelenggaraan (Maintenance Mode)</label>
                            <select id="maintenance_mode" name="maintenance_mode">
                                <option value="0">Tidak Aktif (Off)</option>
                                <option value="1">Aktif (On) - Tutup sistem kepada pengguna biasa</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 1.25rem;">
                            <label for="nama_dekan">Nama</label>
                            <input type="text" id="nama_dekan" name="nama_dekan"
                                placeholder="Contoh: PM. Dr. Mohd Adil Bin Miah">
                        </div>
                    </div>

                    <!-- SMTP Email Settings -->
                    <div class="settings-card">
                        <h3
                            style="margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; color: var(--text-main);">
                            Tetapan Emel (SMTP)</h3>
                        <div class="form-group">
                            <label for="smtp_host">SMTP Host</label>
                            <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="smtp_port">SMTP Port</label>
                            <input type="text" id="smtp_port" name="smtp_port" placeholder="587">
                        </div>
                        <div class="form-group">
                            <label for="smtp_username">SMTP Username</label>
                            <input type="text" id="smtp_username" name="smtp_username" placeholder="email@domain.com">
                        </div>
                        <div class="form-group">
                            <label for="smtp_password">SMTP Password</label>
                            <input type="password" id="smtp_password" name="smtp_password"
                                placeholder="Kosongkan jika tidak mahu tukar">
                        </div>
                    </div>

                    <button type="submit" class="cta-btn" id="saveBtn">Simpan Tetapan</button>
                </form>
            </section>
        </main>
    </div>

    <script>
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

            fetchSettings();

            document.getElementById('settingsForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                await saveSettings();
            });
        });

        async function fetchSettings() {
            try {
                const res = await fetch('../api/superadmin/settings.php');
                const data = await res.json();

                if (data.status === 'success') {
                    const settings = data.data.settings;
                    if (settings.maintenance_mode) document.getElementById('maintenance_mode').value = settings.maintenance_mode;
                    if (settings.nama_dekan) {
                        document.getElementById('nama_dekan').value = settings.nama_dekan;
                    }
                    if (settings.smtp_host) document.getElementById('smtp_host').value = settings.smtp_host;
                    if (settings.smtp_port) document.getElementById('smtp_port').value = settings.smtp_port;
                    if (settings.smtp_username) document.getElementById('smtp_username').value = settings.smtp_username;
                }
            } catch (e) {
                console.error(e);
            }
        }

        async function saveSettings() {
            const btn = document.getElementById('saveBtn');
            btn.textContent = 'Menyimpan...';
            btn.disabled = true;

            const payload = {
                maintenance_mode: document.getElementById('maintenance_mode').value,
                nama_dekan: document.getElementById('nama_dekan').value.trim(),
                smtp_host: document.getElementById('smtp_host').value,
                smtp_port: document.getElementById('smtp_port').value,
                smtp_username: document.getElementById('smtp_username').value
            };

            // Only update password if provided
            const pass = document.getElementById('smtp_password').value;
            if (pass) {
                payload.smtp_password = pass;
            }

            try {
                const res = await fetch('../api/superadmin/settings.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (data.status === 'success') {
                    alert('Tetapan sistem telah berjaya disimpan.');
                    document.getElementById('smtp_password').value = '';
                } else {
                    alert('Ralat: ' + data.message);
                }
            } catch (e) {
                console.error(e);
                alert('Gagal menyimpan tetapan.');
            } finally {
                btn.textContent = 'Simpan Tetapan';
                btn.disabled = false;
            }
        }

    </script>
</body>

</html>