<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetapan Semula Kata Laluan - eICT Desk</title>
    <link rel="stylesheet" href="assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { overflow: hidden; height: 100vh; }

        .input-wrap { position: relative; }
        .toggle-pw {
            position: absolute; right: 1rem; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            font-size: 1.1rem; color: var(--text-muted); padding: 0;
        }

        .strength-bar {
            height: 4px; border-radius: 4px; margin-top: 0.4rem;
            background: #e2e8f0; overflow: hidden;
        }
        .strength-fill {
            height: 100%; width: 0; border-radius: 4px;
            transition: all 0.3s ease;
        }
        .strength-text {
            font-size: 0.75rem; margin-top: 0.25rem;
            color: var(--text-muted);
        }

        .alert-box {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: none;
            text-align: center;
        }
        .alert-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    </style>
    <script src="assets/js/global.js?v=10"></script>
</head>

<body class="portal-body">

    <nav class="navbar container" style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100%; border-bottom: none;">
        <div class="logo">
            <a href="login.php" style="text-decoration:none; color:inherit;">eICT <span>Desk</span></a>
        </div>
    </nav>

    <main class="container centered-content" style="height: 100vh; padding: 0;">
        <div class="form-container fade-in" style="padding: 2rem; width: 100%; max-width: 420px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">

            <!-- Icon & Title -->
            <div style="text-align:center; margin-bottom:1.5rem;">
                <div style="font-size:2.5rem; margin-bottom:0.5rem;">🔐</div>
                <h2 class="form-title" style="margin-bottom: 0.25rem; font-size: 1.6rem;">Tetapan Semula Kata Laluan</h2>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Masukkan kata laluan baru anda di bawah.</p>
            </div>

            <!-- Alerts -->
            <div id="alertError" class="alert-box alert-error"></div>
            <div id="alertSuccess" class="alert-box alert-success"></div>

            <!-- Invalid token state -->
            <div id="invalidToken" style="display:none; text-align:center; padding:1rem 0;">
                <div style="font-size:2rem; margin-bottom:0.75rem;">⏱️</div>
                <p style="color:#dc2626; font-weight:700; margin-bottom:0.5rem;">Pautan Tidak Sah atau Tamat Tempoh</p>
                <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:1.5rem;">Pautan ini tidak sah atau telah tamat tempoh (1 jam). Sila mohon semula.</p>
                <a href="login.php" class="cta-btn primary" style="display:inline-block; text-decoration:none; padding:0.7rem 1.5rem; border-radius:10px; font-size:0.9rem;">
                    Kembali ke Log Masuk
                </a>
            </div>

            <!-- Reset Form -->
            <form id="resetForm" style="display:none;">
                <div class="auth-form-group" style="margin-bottom: 0.75rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); margin-bottom:0.35rem;">Kata Laluan Baru</label>
                    <div class="input-wrap">
                        <input type="password" id="new_password" class="auth-input" 
                               style="padding: 0.8rem 2.5rem 0.8rem 1rem;" 
                               placeholder="Masukkan kata laluan baru" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('new_password', this)">👁️</button>
                    </div>
                </div>

                <div class="auth-form-group" style="margin-bottom: 1.25rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); margin-bottom:0.35rem;">Sahkan Kata Laluan</label>
                    <div class="input-wrap">
                        <input type="password" id="confirm_password" class="auth-input"
                               style="padding: 0.8rem 2.5rem 0.8rem 1rem;"
                               placeholder="Ulang kata laluan baru" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('confirm_password', this)">👁️</button>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="cta-btn primary" style="width:100%; border:none; cursor:pointer; padding: 0.85rem; font-weight:700;">
                    Tetapkan Semula Kata Laluan
                </button>
            </form>

            <!-- Loading state -->
            <div id="loadingState" style="text-align:center; padding:1rem 0;">
                <p style="color:var(--text-muted); font-size:0.9rem;">🔄 Mengesahkan pautan...</p>
            </div>

        </div>
    </main>

    <footer class="container" style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); width: 100%; text-align: center; border-top: none; background: transparent;">
        <p>© 2026 Unit Teknologi Maklumat Majlis Perbandaran Muar. Hak cipta terpelihara.</p>
    </footer>


    <script>
        const params = new URLSearchParams(window.location.search);
        const token = params.get('token');

        // Validate token on page load
        window.addEventListener('DOMContentLoaded', () => {
            if (!token || token.length !== 64) {
                showInvalid();
                return;
            }
            // Show form directly — server validates on submit
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('resetForm').style.display = 'block';
        });

        function showInvalid() {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('resetForm').style.display = 'none';
            document.getElementById('invalidToken').style.display = 'block';
        }

        // ─── Toggle Password Visibility ───
        function togglePw(id, btn) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁️';
            }
        }

        // ─── Form Submit ───
        document.getElementById('resetForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const pw  = document.getElementById('new_password').value;
            const cpw = document.getElementById('confirm_password').value;
            const btn = document.getElementById('submitBtn');

            hideAlerts();

            if (pw.length < 6) {
                showError('Kata laluan mestilah sekurang-kurangnya 6 aksara.');
                return;
            }
            if (pw !== cpw) {
                showError('Kata laluan tidak sepadan. Sila semak semula.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Menetapkan semula...';

            const formData = new FormData();
            formData.append('token', token);
            formData.append('password', pw);
            formData.append('confirm_password', cpw);

            try {
                const res  = await fetch("api/reset_password.php", { method: 'POST', body: formData });
                const data = await res.json();

                if (data.status === 'success') {
                    document.getElementById('resetForm').style.display = 'none';
                    showSuccess(data.message + ' Mengalihkan ke Log Masuk...');
                    setTimeout(() => window.location.href="login.php", 2500);
                } else {
                    showError(data.message || 'Ralat tidak diketahui.');
                    if (data.message.includes('tidak sah') || data.message.includes('tamat')) {
                        setTimeout(showInvalid, 1500);
                    }
                }
            } catch (err) {
                showError('Ralat sambungan. Sila cuba lagi.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Tetapkan Semula Kata Laluan';
            }
        });

        function showError(msg)   { const el = document.getElementById('alertError');   el.textContent = '⚠️ ' + msg; el.style.display = 'block'; }
        function showSuccess(msg) { const el = document.getElementById('alertSuccess'); el.textContent = '✅ ' + msg; el.style.display = 'block'; }
        function hideAlerts()     { document.getElementById('alertError').style.display = 'none'; document.getElementById('alertSuccess').style.display = 'none'; }
    </script>

</body>
</html>
