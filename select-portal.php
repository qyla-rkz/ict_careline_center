<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Careline Center - Pilih Portal Anda</title>
    <link rel="stylesheet" href="assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
            height: 100vh;
        }
        .roles h2 {
            font-size: clamp(1.5rem, 4vw, 2.5rem) !important;
        }
        .role-card {
            padding: 2.5rem 2rem !important;
            width: 340px !important;
        }
    </style>
    <script src="assets/js/global.js?v=10"></script>
</head>

<body class="portal-body">

    <nav class="navbar container" style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100%; border-bottom: none; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo">
            <a href="index" style="text-decoration:none; color:inherit; display: flex; align-items: center; gap: 15px;">
                <img src="assets/images/logo-mpm.png" alt="Logo MPM" style="height: 70px; width: auto;">
                <div>ICT Careline <span>Center</span></div>
            </a>
        </div>
        <div>
            <a href="index" style="text-decoration: none; font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; background: rgba(79, 70, 229, 0.05); padding: 0.5rem 1.25rem; border-radius: 20px; border: 1.5px solid var(--primary); transition: all 0.2s ease;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(79, 70, 229, 0.05)'; this.style.color='var(--primary)';">
                ← Kembali
            </a>
        </div>
    </nav>

    <main class="container centered-content" style="height: 100vh; padding: 0;">
        <section class="roles fade-in">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Pilih Portal Anda</h2>
            <div class="role-cards" style="margin-top: 2rem;">
                <div class="role-card register">
                    <div class="icon">📖</div>
                    <h3>Portal Pendaftaran Staf</h3>
                    <p>Daftar akaun Staf baru untuk mula menguruskan papan pemuka anda.</p>
                    <a href="register" class="role-btn">Daftar Sekarang</a>
                </div>
                <div class="role-card login">
                    <div class="icon">👤</div>
                    <h3>Portal Log Masuk</h3>
                    <p>Akses akaun sedia ada anda untuk aktiviti pengawasan dan pengurusan.</p>
                    <a href="login" class="role-btn">Log Masuk Sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="container" style="position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); width: 100%; text-align: center; border-top: none; background: transparent;">
        <p>&copy; 2026 Unit Teknologi Maklumat Majlis Perbandaran Muar. Hak cipta terpelihara.</p>
    </footer>

    <script type="module" src="assets/js/main.js?v=3"></script>
</body>

</html>
