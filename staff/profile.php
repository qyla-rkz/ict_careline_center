<?php
// staff/profile.php
$pageTitle = 'Profil Saya - eICT Desk';
include 'includes/header.php';
?>

<div class="wide-content active">
    <div class="view active" id="view-profile">
        <a href="dashboard.php" class="back-btn">‹ Kembali</a>
        <div class="view-subheading">Akaun Saya</div>
        <div class="view-heading">Edit Profil &amp; Tetapan</div>

        <div class="view-scroll">
            <div id="profileAlert" class="alert"></div>

            <!-- BAHAGIAN 1: EDIT MAKLUMAT PROFIL -->
            <form id="profileForm">
                <div class="avatar-upload-area">
                    <div class="avatar-preview">
                        <img id="profileAvatarImg" src="" alt="" style="display:none;">
                        <span id="profileAvatarInitial">?</span>
                    </div>
                    <div>
                        <label class="avatar-upload-btn" for="profilePicInput">
                            📷 Pilih Gambar Profil
                            <input type="file" id="profilePicInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        </label>
                        <p style="font-size:.72rem;color:#66768c;margin-top:.35rem;">Format: JPG, PNG atau WEBP (Maks: 2MB)</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="pf_name">Nama Penuh</label>
                        <input type="text" id="pf_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pf_jawatan">Jawatan</label>
                        <input type="text" id="pf_jawatan" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pf_dept">Bahagian / Unit</label>
                        <input type="text" id="pf_dept" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pf_phone">No. Telefon</label>
                        <input type="text" id="pf_phone" class="form-input" placeholder="Cth: 012-3456789">
                    </div>
                    <div class="form-group full">
                        <label class="form-label" for="pf_office">Pejabat / Cawangan</label>
                        <input type="text" id="pf_office" class="form-input" placeholder="Cth: Ibu Pejabat MPM">
                    </div>
                </div>

                <div style="margin-top:1.2rem;">
                    <button type="submit" class="btn-primary" id="btnSaveProfile">💾 Simpan Perubahan Profil</button>
                </div>
            </form>

            <div class="portal-divider" style="margin:2rem 0;"></div>

            <!-- BAHAGIAN 2: TUKAR KATA LALUAN -->
            <div>
                <div class="view-subheading">Keselamatan</div>
                <h3 style="font-size:1.15rem;font-weight:800;color:#24324b;margin-bottom:1rem;">Tukar Kata Laluan</h3>

                <div id="settingsAlert" class="alert"></div>

                <form id="pwForm">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label" for="pw_current">Kata Laluan Semasa</label>
                            <input type="password" id="pw_current" class="form-input" placeholder="Masukkan kata laluan semasa..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pw_new">
                                Kata Laluan Baharu
                                <span class="pw-info-wrap">
                                    <span class="pw-info-icon" onmouseenter="showPwTooltip(this)" onmouseleave="hidePwTooltip(this)">i</span>
                                    <span class="pw-info-tooltip">
                                        Peraturan kata laluan selamat:<br>
                                        &bull; Minimum 8 aksara<br>
                                        &bull; Sekurang-kurangnya 1 huruf besar (A-Z)<br>
                                        &bull; Sekurang-kurangnya 1 nombor (0-9)<br>
                                        &bull; Sekurang-kurangnya 1 simbol khas (!@#$%^&amp;*)
                                    </span>
                                </span>
                            </label>
                            <input type="password" id="pw_new" class="form-input" placeholder="Minimum 8 aksara..." oninput="checkStrength(this.value)" required>
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pw_confirm">Sahkan Kata Laluan Baharu</label>
                            <input type="password" id="pw_confirm" class="form-input" placeholder="Ulangi kata laluan baharu..." required>
                        </div>
                    </div>

                    <div style="margin-top:1.2rem;">
                        <button type="submit" class="btn-primary" id="btnChangePassword">🔒 Tukar Kata Laluan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
        populateProfileForm();
    });

    function populateProfileForm() {
        if (!currentUser) return;
        document.getElementById('pf_name').value    = currentUser.full_name || currentUser.name || '';
        document.getElementById('pf_jawatan').value = currentUser.jawatan || '';
        document.getElementById('pf_dept').value    = currentUser.department || '';
        document.getElementById('pf_phone').value   = currentUser.phone || '';
        document.getElementById('pf_office').value  = currentUser.office || '';

        const name = currentUser.full_name || currentUser.name || '?';
        document.getElementById('profileAvatarInitial').textContent = name.trim().charAt(0).toUpperCase();

        if (currentUser.profile_picture) {
            const i = document.getElementById('profileAvatarImg');
            i.src = '../uploads/' + currentUser.profile_picture;
            i.style.display = 'block';
            document.getElementById('profileAvatarInitial').style.display = 'none';
        } else {
            document.getElementById('profileAvatarImg').style.display = 'none';
            document.getElementById('profileAvatarInitial').style.display = '';
        }
    }

    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const i = document.getElementById('profileAvatarImg');
            i.src = e.target.result;
            i.style.display = 'block';
            document.getElementById('profileAvatarInitial').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }

    document.getElementById('profileForm').addEventListener('submit', async e => {
        e.preventDefault();
        const alertEl = document.getElementById('profileAlert');
        const btn = document.getElementById('btnSaveProfile');

        try {
            btn.disabled = true;
            btn.textContent = '⏳ Menyimpan...';

            const fd = new FormData();
            fd.append('full_name', document.getElementById('pf_name').value);
            fd.append('jawatan', document.getElementById('pf_jawatan').value);
            fd.append('department', document.getElementById('pf_dept').value);
            fd.append('phone', document.getElementById('pf_phone').value);
            fd.append('office', document.getElementById('pf_office').value);

            const pic = document.getElementById('profilePicInput').files[0];
            if (pic) fd.append('profile_picture', pic);

            const res = await fetch('../api/staff/staff_update_profile.php', {
                method: 'POST',
                body: fd
            });
            const data = await res.json();

            if (data.status === 'success') {
                currentUser.full_name = document.getElementById('pf_name').value;
                currentUser.jawatan = document.getElementById('pf_jawatan').value;
                currentUser.department = document.getElementById('pf_dept').value;
                currentUser.phone = document.getElementById('pf_phone').value;
                currentUser.office = document.getElementById('pf_office').value;

                if (data.profile_picture) {
                    currentUser.profile_picture = data.profile_picture;
                }
                sessionStorage.setItem('user', JSON.stringify(currentUser));

                showAlert(alertEl, '✅ Profil berjaya dikemaskini!', 'success');
            } else {
                showAlert(alertEl, '❌ ' + (data.message || 'Gagal mengemaskini profil.'), 'error');
            }
        } catch (err) {
            showAlert(alertEl, '❌ Ralat sambungan pelayan: ' + err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = '💾 Simpan Perubahan Profil';
        }
    });

    function checkStrength(val) {
        const fill = document.getElementById('strengthFill');
        let s = 0;
        if (val.length >= 8) s++;
        if (/[A-Z]/.test(val)) s++;
        if (/[0-9]/.test(val)) s++;
        if (/[^A-Za-z0-9]/.test(val)) s++;
        fill.style.width = (s * 25) + '%';
        fill.style.background = ['#ef4444', '#f97316', '#eab308', '#22c55e'][s - 1] || '#ef4444';
    }

    document.getElementById('pwForm').addEventListener('submit', async e => {
        e.preventDefault();
        const alertEl = document.getElementById('settingsAlert');
        const nw = document.getElementById('pw_new').value;
        const cf = document.getElementById('pw_confirm').value;

        if (nw !== cf) {
            showAlert(alertEl, '❌ Kata laluan baharu dan pengesahan tidak sepadan.', 'error');
            return;
        }
        if (nw.length < 8) {
            showAlert(alertEl, '❌ Kata laluan mestilah sekurang-kurangnya 8 aksara.', 'error');
            return;
        }

        const btn = document.getElementById('btnChangePassword');
        try {
            btn.disabled = true;
            btn.textContent = '⏳ Mengemaskini...';

            const fd = new FormData();
            fd.append('current_password', document.getElementById('pw_current').value);
            fd.append('new_password', nw);

            const res = await fetch('../api/staff/staff_change_password.php', {
                method: 'POST',
                body: fd
            });
            const data = await res.json();

            if (data.status === 'success') {
                showAlert(alertEl, '✅ Kata laluan berjaya ditukar!', 'success');
                document.getElementById('pwForm').reset();
                document.getElementById('strengthFill').style.width = '0%';
            } else {
                showAlert(alertEl, '❌ ' + (data.message || 'Gagal menukar kata laluan.'), 'error');
            }
        } catch (err) {
            showAlert(alertEl, '❌ Ralat sambungan pelayan: ' + err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = '🔒 Tukar Kata Laluan';
        }
    });

    function showPwTooltip(icon) {
        const tooltip = icon.nextElementSibling;
        if (!tooltip) return;
        tooltip.classList.add('active');
        const rect = icon.getBoundingClientRect();
        const tooltipW = tooltip.offsetWidth;
        const tooltipH = tooltip.offsetHeight;
        let top = rect.top - tooltipH - 10;
        if (top < 8) top = rect.bottom + 10;
        let left = rect.right - tooltipW;
        if (left < 8) left = 8;
        if (left + tooltipW > window.innerWidth - 8) left = window.innerWidth - tooltipW - 8;
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
    }

    function hidePwTooltip(icon) {
        const tooltip = icon.nextElementSibling;
        if (tooltip) tooltip.classList.remove('active');
    }

    function showAlert(el, msg, type) {
        if (!el) return;
        el.textContent = msg;
        el.className = 'alert alert-' + type;
        el.style.display = 'block';
    }
</script>

<?php include 'includes/footer.php'; ?>
