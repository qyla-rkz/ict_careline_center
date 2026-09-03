<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Careline Center - Log Masuk</title>
    <link rel="stylesheet" href="assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
            height: 100vh;
        }
    </style>
    <script src="assets/js/global.js?v=10"></script>
</head>

<body class="portal-body">

    <nav class="navbar container" style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100%; border-bottom: none; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo">
            <a href="index.php" style="text-decoration:none; color:inherit; display: flex; align-items: center; gap: 15px;">
                <img src="assets/images/logo-mpm.png" alt="Logo MPM" style="height: 70px; width: auto;">
                <div>ICT Careline <span>Center</span></div>
            </a>
        </div>
        <div>
            <a href="select-portal.php" style="text-decoration: none; font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; background: rgba(79, 70, 229, 0.05); padding: 0.5rem 1.25rem; border-radius: 20px; border: 1.5px solid var(--primary); transition: all 0.2s ease;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(79, 70, 229, 0.05)'; this.style.color='var(--primary)';">
                ← Kembali
            </a>
        </div>
    </nav>

    <main class="container centered-content" style="height: 100vh; padding: 0;">
        <div class="form-container fade-in" style="padding: 2rem 2.5rem; width: 100%; max-width: 450px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
            <h2 class="form-title" style="margin-bottom: 0.15rem; font-size: 1.6rem;">Log Masuk</h2>
            <p style="text-align:center; margin-bottom: 1rem; color: var(--text-muted); font-size: 0.8rem;">Akses papan pemuka anda.</p>

            <form id="loginForm">
                <div class="role-selector" style="margin-bottom: 1rem; padding: 0.3rem;">
                    <label class="role-option" style="padding: 0.4rem; font-size: 0.85rem;">
                        <input type="radio" name="role" value="Staff" checked> Staf
                    </label>
                    <label class="role-option" style="padding: 0.4rem; font-size: 0.85rem;">
                        <input type="radio" name="role" value="Admin"> Admin
                    </label>
                </div>

                <div class="auth-form-group" style="margin-bottom: 0.65rem;">
                    <input type="text" name="username" class="auth-input" style="padding: 0.7rem 0.9rem; font-size: 0.85rem;" placeholder="ID Staf / Nama Pengguna" required>
                </div>
                <div class="auth-form-group" style="margin-bottom: 0.65rem;">
                    <input type="password" name="password" class="auth-input" style="padding: 0.7rem 0.9rem; font-size: 0.85rem;" placeholder="Kata Laluan" required>
                </div>

                <div class="form-footer" style="margin-bottom: 1rem; font-size: 0.8rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; color: var(--text-muted);">
                        <input type="checkbox" style="width:auto;"> Remember Me
                    </label>
                    <a href="#.php" onclick="showForgotModal(); return false;" style="color: var(--primary);">Lupa?</a>
                </div>

                <button type="submit" class="cta-btn primary" style="width:100%; border:none; cursor:pointer; padding: 0.7rem; font-size: 0.85rem;">
                    Log Masuk
                </button>
                
                <p style="text-align:center; margin-top:1rem; font-size:0.8rem; color: var(--text-muted);">
                    Belum mempunyai akaun? <a href="register.php" style="color:var(--primary); font-weight:700; text-decoration:none;">Daftar</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="container" style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); width: 100%; text-align: center; border-top: none; background: transparent;">
        <p>&copy; 2026 Unit Teknologi Maklumat Majlis Perbandaran Muar. Hak cipta terpelihara.</p>
    </footer>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:20px; padding:2.5rem 2rem; max-width:390px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.15); animation:fadeIn 0.25s ease;">

            <!-- Default view -->
            <div id="forgotDefault">
                <div style="text-align:center; margin-bottom:1.5rem;">
                    <div style="font-size:2.5rem; margin-bottom:0.5rem;">🔑</div>
                    <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:0.4rem; color:#1e293b;">Lupa Kata Laluan?</h3>
                    <p style="color:#64748b; font-size:0.85rem; line-height:1.5;">
                        Masukkan emel yang didaftarkan. Kami akan menghantar pautan tetapan semula.
                    </p>
                </div>

                <div id="forgotAlert" style="display:none; padding:0.7rem 1rem; border-radius:10px; font-size:0.82rem; font-weight:600; margin-bottom:1rem; text-align:center;"></div>

                <form id="forgotForm">
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.78rem; font-weight:700; color:#64748b; margin-bottom:0.4rem;">ALAMAT EMEL</label>
                        <input type="email" id="forgotEmail"
                               style="width:100%; padding:0.8rem 1rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border 0.2s; box-sizing:border-box; font-family:inherit;"
                               placeholder="nama@domain.com" required
                               onfocus="this.style.borderColor='#6366f1'"
                               onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <button type="submit" id="forgotBtn"
                            style="width:100%; padding:0.8rem; background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; border:none; border-radius:12px; font-weight:700; font-size:0.95rem; cursor:pointer; transition:opacity 0.2s;">
                        Hantar Pautan Tetapan Semula
                    </button>
                </form>

                <button onclick="closeForgotModal()"
                        style="width:100%; margin-top:0.75rem; padding:0.7rem; background:none; border:1.5px solid #e2e8f0; border-radius:12px; font-weight:600; font-size:0.9rem; cursor:pointer; color:#64748b;">
                    Batal
                </button>
            </div>

            <!-- Success view -->
            <div id="forgotSuccess" style="display:none; text-align:center; padding:0.5rem 0;">
                <div style="font-size:3rem; margin-bottom:1rem;">📧</div>
                <h3 style="font-size:1.2rem; font-weight:800; color:#16a34a; margin-bottom:0.5rem;">Emel Dihantar!</h3>
                <p style="color:#64748b; font-size:0.875rem; line-height:1.6; margin-bottom:1rem;" id="forgotSuccessMsg"></p>
                <p style="color:#9ca3af; font-size:0.78rem; margin-bottom:1.5rem;">⏱️ Pautan tamat tempoh dalam <strong>1 jam</strong>. Semak juga folder <em>Spam</em>.</p>
                <button onclick="closeForgotModal()"
                        style="width:100%; padding:0.75rem; background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; border:none; border-radius:12px; font-weight:700; font-size:0.95rem; cursor:pointer;">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <script>
        function showForgotModal() {
            document.getElementById('forgotModal').style.display = 'flex';
            document.getElementById('forgotDefault').style.display = 'block';
            document.getElementById('forgotSuccess').style.display = 'none';
            document.getElementById('forgotEmail').value = '';
            hideForgotAlert();
        }
        function closeForgotModal() {
            document.getElementById('forgotModal').style.display = 'none';
        }
        document.getElementById('forgotModal').addEventListener('click', function(e) {
            if (e.target === this) closeForgotModal();
        });
        function showForgotAlert(msg, type) {
            const el = document.getElementById('forgotAlert');
            el.textContent = (type === 'error' ? '⚠️ ' : '✅ ') + msg;
            el.style.display = 'block';
            el.style.background = type === 'error' ? '#fef2f2' : '#f0fdf4';
            el.style.color      = type === 'error' ? '#dc2626' : '#16a34a';
            el.style.border     = type === 'error' ? '1px solid #fecaca' : '1px solid #bbf7d0';
        }
        function hideForgotAlert() {
            document.getElementById('forgotAlert').style.display = 'none';
        }
        document.getElementById('forgotForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn   = document.getElementById('forgotBtn');
            const email = document.getElementById('forgotEmail').value.trim();
            hideForgotAlert();
            btn.disabled = true;
            btn.textContent = 'Menghantar...';
            const fd = new FormData();
            fd.append('email', email);
            try {
                const res  = await fetch("api/forgot_password.php")), { method: 'POST', body: fd });
                const data = await res.json();
                if (data.status === 'success') {
                    document.getElementById('forgotDefault').style.display = 'none';
                    document.getElementById('forgotSuccessMsg').textContent = data.message;
                    document.getElementById('forgotSuccess').style.display = 'block';
                } else {
                    showForgotAlert(data.message || 'Ralat tidak diketahui.', 'error');
                }
            } catch (err) {
                showForgotAlert('Ralat sambungan. Sila cuba lagi.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Hantar Pautan Tetapan Semula';
            }
        });
    </script>

    <script type="module" src="assets/js/main.js?v=3"></script>
</body>

</html>
