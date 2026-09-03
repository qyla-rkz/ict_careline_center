<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Careline Center - Daftar</title>
    <link rel="stylesheet" href="assets/css/style.css?v=15">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .dept-opt:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary);
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
            <a href="select-portal" style="text-decoration: none; font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; background: rgba(79, 70, 229, 0.05); padding: 0.5rem 1.25rem; border-radius: 20px; border: 1.5px solid var(--primary); transition: all 0.2s ease;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(79, 70, 229, 0.05)'; this.style.color='var(--primary)';">
                ← Kembali
            </a>
        </div>
    </nav>

    <main class="container centered-content" style="padding-top: 100px;">
        <div class="form-container fade-in" style="padding: 3rem; max-width: 540px;">
            <h2 class="form-title" style="margin-bottom: 0.5rem; font-size: 2.2rem;">Daftar Akaun</h2>
            <p style="text-align:center; margin-bottom: 2rem; color: var(--text-muted);">Sertai Portal Sokongan ICT.</p>

            <form id="registerForm" enctype="multipart/form-data">
                <!-- Profile Picture Preview & Upload -->
                <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2rem;">
                    <div id="profile_preview_container" style="width: 120px; height: 120px; border-radius: 50%; border: 3px dashed var(--primary); display: flex; justify-content: center; align-items: center; cursor: pointer; position: relative; overflow: hidden; background: rgba(79, 70, 229, 0.05); transition: var(--transition);">
                        <span id="upload_placeholder" style="color: var(--primary); text-align: center; font-size: 0.8rem; font-weight: 600; padding: 10px; pointer-events: none;">Muat Naik Gambar Formal</span>
                        <img id="profile_preview_img" src="" style="width: 100%; height: 100%; object-fit: cover; display: none; position: absolute; top: 0; left: 0;">
                    </div>
                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" required style="display: none;">
                    <span style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem; text-align: center; font-weight: 600;">Gambar Profil Formal (Wajib)</span>
                </div>

                <div class="auth-form-group">
                    <input type="text" name="full_name" class="auth-input" placeholder="Nama Penuh" required>
                </div>
                <div class="auth-form-group">
                    <input type="text" name="username" class="auth-input" placeholder="ID Staf" required>
                </div>
                <div class="auth-form-group">
                    <input type="text" name="phone" class="auth-input" placeholder="Nombor Telefon">
                </div>
                <div class="auth-form-group">
                    <input type="email" name="email" class="auth-input" placeholder="Alamat Emel (untuk tetapan semula kata laluan)">
                </div>
                <div class="auth-form-group">
                    <input type="text" name="office" class="auth-input" placeholder="Sambungan Pejabat">
                </div>
                <div class="auth-form-group">
                    <input type="text" name="jawatan" class="auth-input" placeholder="Jawatan (cth: Penolong Pegawai IT)" required>
                </div>

                <div class="auth-form-group" style="position: relative;">
                    <input type="hidden" name="department" id="selected_dept" required>
                    <div id="custom_dept_select" class="auth-input" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                        <span id="dept_display">Pilih Jabatan / Unit</span>
                        <span style="font-size: 0.8rem;">▼</span>
                    </div>
                    <div id="dept_options" style="display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border: 1px solid var(--border); border-radius: 12px; box-shadow: var(--shadow); z-index: 1000; max-height: 250px; overflow-y: auto; margin-top: 5px;">
                        <div class="dept-opt" data-value="Jabatan Bangunan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Bangunan</div>
                        <div class="dept-opt" data-value="Jabatan Kejuruteraan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Kejuruteraan</div>
                        <div class="dept-opt" data-value="Jabatan Kesihatan dan Pelesenan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Kesihatan dan Pelesenan</div>
                        <div class="dept-opt" data-value="Jabatan Kewangan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Kewangan</div>
                        <div class="dept-opt" data-value="Jabatan Khidmat Pengurusan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Khidmat Pengurusan</div>
                        <div class="dept-opt" data-value="Jabatan Komunikasi Koprat dan Kemasyarakatan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Komunikasi Koprat dan Kemasyarakatan</div>
                        <div class="dept-opt" data-value="Jabatan Penguatkuasaan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Penguatkuasaan</div>
                        <div class="dept-opt" data-value="Jabatan Penilaian dan Pengurusan Harta" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Penilaian dan Pengurusan Harta</div>
                        <div class="dept-opt" data-value="Jabatan Perancangan dan Pembangunan Landskap" style="padding: 0.75rem 1.25rem; cursor: pointer;">Jabatan Perancangan dan Pembangunan Landskap</div>
                        <div class="dept-opt" data-value="Kaunter Hasil" style="padding: 0.75rem 1.25rem; cursor: pointer;">Kaunter Hasil</div>
                        <div class="dept-opt" data-value="Pejabat Setiausaha" style="padding: 0.75rem 1.25rem; cursor: pointer;">Pejabat Setiausaha</div>
                        <div class="dept-opt" data-value="Pejabat YDP" style="padding: 0.75rem 1.25rem; cursor: pointer;">Pejabat YDP</div>
                        <div class="dept-opt" data-value="Unit Audit Dalaman" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Audit Dalaman</div>
                        <div class="dept-opt" data-value="Unit Perolehan dan Pengurusan Kontrak" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Perolehan dan Pengurusan Kontrak</div>
                        <div class="dept-opt" data-value="Unit Persuruhjaya Bangunan" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Persuruhjaya Bangunan</div>
                        <div class="dept-opt" data-value="Unit Pusat Setempat" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Pusat Setempat</div>
                        <div class="dept-opt" data-value="Unit Teknologi Maklumat" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Teknologi Maklumat</div>
                        <div class="dept-opt" data-value="Unit Undang-Undang" style="padding: 0.75rem 1.25rem; cursor: pointer;">Unit Undang-Undang</div>
                    </div>
                </div>

                <div class="auth-form-group">
                    <input type="password" name="password" class="auth-input" placeholder="Kata Laluan" required>
                </div>

                <button type="submit" class="cta-btn primary" style="width:100%; border:none; cursor:pointer; margin-top: 1rem;">
                    Daftar Sekarang
                </button>

                <p style="text-align:center; margin-top:2rem; font-size:0.9rem; color: var(--text-muted);">
                    Sudah mempunyai akaun? <a href="login" style="color:var(--primary); font-weight:700; text-decoration:none;">Log masuk di sini</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="container" style="padding: 2rem 0;">
        <p>&copy; 2026 Unit Teknologi Maklumat Majlis Perbandaran Muar. Hak cipta terpelihara.</p>
    </footer>


    <script type="module">
        // Custom Dropdown Logic
        const deptSelect = document.getElementById('custom_dept_select');
        const deptOptions = document.getElementById('dept_options');
        const deptDisplay = document.getElementById('dept_display');
        const selectedDeptInput = document.getElementById('selected_dept');

        // Profile Picture Preview Logic
        const profilePreviewContainer = document.getElementById('profile_preview_container');
        const profilePictureInput = document.getElementById('profile_picture_input');
        const profilePreviewImg = document.getElementById('profile_preview_img');
        const uploadPlaceholder = document.getElementById('upload_placeholder');

        profilePreviewContainer.addEventListener('click', () => {
            profilePictureInput.click();
        });

        profilePictureInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    profilePreviewImg.src = event.target.result;
                    profilePreviewImg.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                    profilePreviewContainer.style.borderStyle = 'solid';
                };
                reader.readAsDataURL(file);
            }
        });

        deptSelect.addEventListener('click', (e) => {
            e.stopPropagation();
            const isVisible = deptOptions.style.display === 'block';
            deptOptions.style.display = isVisible ? 'none' : 'block';
        });

        // Use event delegation for options
        deptOptions.addEventListener('click', (e) => {
            const opt = e.target.closest('.dept-opt');
            if (opt) {
                const val = opt.getAttribute('data-value');
                selectedDeptInput.value = val;
                deptDisplay.textContent = val;
                deptDisplay.style.color = 'var(--text-main)';
                deptOptions.style.display = 'none';
            }
        });

        // Close when clicking outside
        document.addEventListener('click', () => {
            deptOptions.style.display = 'none';
        });

        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!selectedDeptInput.value) {
                alert('Sila pilih jabatan');
                return;
            }

            if (!profilePictureInput.files || profilePictureInput.files.length === 0) {
                alert('Sila muat naik Gambar Profil Formal anda untuk mendaftar.');
                return;
            }

            const formData = new FormData(e.target);
            try {
                const response = await fetch("api/register"), {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                if (res.status === 'success') {
                    alert('Pendaftaran berjaya! Sila log masuk.');
                    window.location.href="login";
                } else {
                    alert(res.message);
                }
            } catch (err) { console.error(err); }
        });
    </script>
</body>
</html>
