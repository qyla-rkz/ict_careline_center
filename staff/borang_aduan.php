<?php
// staff/borang_aduan.php
$pageTitle = 'Borang Aduan KEW.PA-9 - eICT Desk';
include 'includes/header.php';
?>

<div class="wide-content active">
    <div class="view active" id="view-borang">
        <a href="dashboard.php" class="back-btn">‹ Kembali</a>
        <div class="view-subheading">KEW.PA-9</div>
        <div class="view-heading">Borang Aduan Kerosakan Aset</div>

        <div class="view-scroll">
            <div id="borangAlert" class="alert"></div>

            <form id="borangForm">
                <!-- Bahagian Pilihan Aset Berdaftar Staf & Spesifikasi (Wajib Sepadan) -->
                <div class="card-spec-section" style="background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:12px; padding:1.25rem; margin-bottom:1.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem; flex-wrap:wrap; gap:0.5rem;">
                        <label class="form-label" style="font-size:0.95rem; font-weight:700; color:var(--primary, #1e40af); margin:0;">
                            💻 Pilih Aset Berdaftar Anda (Lampiran Spesifikasi KEW.PA-9)
                        </label>
                        <a href="aset_saya.php" style="font-size:0.8rem; color:var(--primary, #1e40af); text-decoration:none; font-weight:600;">
                            🔎 Semak Aset Saya ›
                        </a>
                    </div>

                    <div class="form-group" style="margin-bottom:0.85rem;">
                        <select id="b_pilih_aset" class="form-select" style="font-size:0.9rem; font-weight:600;">
                            <option value="">-- Memuatkan senarai aset anda... --</option>
                        </select>
                        <small id="assetLoadHint" style="display:block; margin-top:0.35rem; color:var(--text-muted, #64748b); font-size:0.8rem;">
                            Sila pilih aset anda di atas. Maklumat jenis aset dan nombor siri akan dipadankan secara automatik.
                        </small>
                    </div>

                    <!-- Box Preview Spesifikasi Aset -->
                    <div id="specCard" style="display:none; background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:1rem; margin-bottom:0.85rem; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f1f5f9; padding-bottom:0.5rem; margin-bottom:0.75rem; flex-wrap:wrap; gap:0.5rem;">
                            <span style="font-weight:700; font-size:0.88rem; color:#0f172a;" id="specAssetTitle">Spesifikasi Aset</span>
                            <span id="specMatchStatus" style="font-size:0.75rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; background:#dcfce7; color:#15803d; border:1px solid #86efac;">
                                ✅ Spesifikasi Sepadan
                            </span>
                        </div>
                        <div id="specGridItems" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:0.6rem; font-size:0.82rem;">
                            <!-- Populated via JS -->
                        </div>
                    </div>

                    <!-- Checkbox Wajib Lampirkan Spec -->
                    <div id="specCheckboxWrap" style="display:none; background:#eff6ff; border:1.5px solid #3b82f6; border-radius:10px; padding:0.9rem 1.1rem;">
                        <label style="display:flex; align-items:flex-start; gap:0.75rem; cursor:pointer; margin:0;">
                            <input type="checkbox" id="b_lampirkan_spec" name="lampirkan_spec" required style="width:19px; height:19px; min-width:19px; margin-top:2px; accent-color:#2563eb; cursor:pointer;">
                            <div>
                                <strong style="font-size:0.9rem; color:#1e3a8a; display:block;">
                                    Lampirkan Spesifikasi Aset Ini Bersama Borang Aduan KEW.PA-9 <span style="color:#ef4444;">*</span>
                                </strong>
                                <span style="font-size:0.8rem; color:#475569; line-height:1.45; display:block; margin-top:0.2rem;">
                                    Saya mengesahkan bahawa spesifikasi aset di atas adalah sama dengan aset yang hendak dibuat aduan dan bersetuju melampirkannya bersama borang aduan KEW.PA-9 ini. (Wajib ditanda sebelum menghantar borang aduan)
                                </span>
                            </div>
                        </label>
                    </div>

                    <!-- Warning Mismatch Alert -->
                    <div id="specMismatchAlert" style="display:none; margin-top:0.75rem; padding:0.75rem 1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; color:#991b1b; font-size:0.82rem;">
                        ⚠️ <strong>Spesifikasi Tidak Sepadan:</strong> Nombor siri yang dinyatakan tidak sepadan dengan spesifikasi aset yang dipilih. Sila pastikan spesifikasi adalah sama dengan aset yang hendak dibuat aduan!
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="b_jenis">Jenis Aset</label>
                        <select id="b_jenis" class="form-select" required>
                            <option value="">Pilih Jenis Aset</option>
                            <option value="Desktop PC">Desktop / CPU</option>
                            <option value="Laptop/NoteBook">Laptop / NoteBook</option>
                            <option value="Pencetak">Pencetak (Printer)</option>
                            <option value="Pengimbas">Pengimbas (Scanner)</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_siri">Nombor Siri Pendaftaran Aset/ Komponen</label>
                        <input type="text" id="b_siri" class="form-input" placeholder="MPM/KEW/..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_pengguna">Pengguna Terakhir</label>
                        <input type="text" id="b_pengguna" class="form-input" placeholder="Nama pengguna terakhir..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_tarikh">Tarikh Kerosakan</label>
                        <input type="date" id="b_tarikh" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_lokasi">Lokasi (Bahagian / Unit)</label>
                        <input type="text" id="b_lokasi" class="form-input" placeholder="Cth: Jabatan Khidmat Pengurusan..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_nama">Nama Pelapor</label>
                        <input type="text" id="b_nama" class="form-input" placeholder="Nama penuh anda..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_jawatan_pelapor">Jawatan Pelapor</label>
                        <input type="text" id="b_jawatan_pelapor" class="form-input" placeholder="Jawatan anda..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="b_gambar">Gambar Bukti (Pilihan, Maks 3)</label>
                        <input type="file" id="b_gambar" accept="image/*" multiple style="font-size:.82rem;">
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="b_perihal">Perihal Kerosakan</label>
                        <textarea id="b_perihal" class="form-textarea" placeholder="Huraikan masalah atau kerosakan dengan jelas..." rows="4" required></textarea>
                    </div>
                </div>

                <div style="display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;">
                    <button type="submit" class="btn-primary" id="btnSubmitReport">📤 Hantar Aduan</button>
                    <a href="dashboard.php" class="btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentUser = null;
    let userAssets = [];
    let selectedAsset = null;

    document.addEventListener('DOMContentLoaded', async () => {
        const raw = sessionStorage.getItem('user');
        if (!raw) {
            window.location.replace('../login.php');
            return;
        }
        currentUser = JSON.parse(raw);

        populateBorangDefaults();
        await loadStaffAssets();
        handleQueryPrefill();

        // Listen for manual changes on serial number to check match
        document.getElementById('b_siri').addEventListener('input', () => {
            validateAssetMatch();
        });
        document.getElementById('b_jenis').addEventListener('change', () => {
            validateAssetMatch();
        });
    });

    function populateBorangDefaults() {
        if (!currentUser) return;
        document.getElementById('b_nama').value = currentUser.full_name || currentUser.name || '';
        document.getElementById('b_jawatan_pelapor').value = currentUser.jawatan || '';
        document.getElementById('b_pengguna').value = currentUser.full_name || currentUser.name || '';
        document.getElementById('b_lokasi').value = currentUser.department || '';
        document.getElementById('b_tarikh').value = new Date().toISOString().split('T')[0];
    }

    async function loadStaffAssets() {
        const selectEl = document.getElementById('b_pilih_aset');
        const hintEl = document.getElementById('assetLoadHint');

        try {
            const res = await fetch('../api/staff/staff_get_assets.php');
            const data = await res.json();

            if (data.status === 'success' && Array.isArray(data.data) && data.data.length > 0) {
                userAssets = data.data;
                selectEl.innerHTML = '<option value="">-- Sila Pilih Aset Anda Untuk Memuatkan Spesifikasi --</option>';
                
                userAssets.forEach(a => {
                    const snLabel = a.no_siri_pendaftaran || a.serial_number || 'Tiada S/N';
                    const modelLabel = a.model_komputer || a.asset_type || 'Aset';
                    const opt = document.createElement('option');
                    opt.value = a.id;
                    opt.textContent = `[${a.asset_type || 'Aset'}] ${modelLabel} (S/N: ${snLabel})`;
                    selectEl.appendChild(opt);
                });

                selectEl.disabled = false;
                hintEl.textContent = 'Pilih aset anda di atas. Maklumat jenis aset dan nombor siri akan dipadankan secara automatik.';
                hintEl.style.color = 'var(--text-muted, #64748b)';
            } else {
                userAssets = [];
                selectEl.innerHTML = '<option value="">-- Tiada aset berdaftar ditemui atas nama anda --</option>';
                selectEl.disabled = true;
                hintEl.innerHTML = '⚠️ Anda belum mendaftar aset. Sila <a href="aset_saya.php" target="_blank" style="color:#2563eb;text-decoration:underline;font-weight:600;">Daftar Aset di sini</a> terlebih dahulu untuk melampirkan spesifikasi.';
                hintEl.style.color = '#dc2626';
            }
        } catch (err) {
            console.error('Ralat memuatkan aset:', err);
            selectEl.innerHTML = '<option value="">-- Gagal memuatkan senarai aset --</option>';
            hintEl.textContent = 'Ralat sambungan untuk memuatkan senarai aset.';
            hintEl.style.color = '#dc2626';
        }

        selectEl.addEventListener('change', (e) => {
            const assetId = parseInt(e.target.value);
            if (!assetId) {
                selectedAsset = null;
                document.getElementById('specCard').style.display = 'none';
                document.getElementById('specCheckboxWrap').style.display = 'none';
                document.getElementById('specMismatchAlert').style.display = 'none';
                document.getElementById('b_lampirkan_spec').checked = false;
                return;
            }

            const found = userAssets.find(a => parseInt(a.id) === assetId);
            if (found) {
                applySelectedAsset(found);
            }
        });
    }

    function applySelectedAsset(asset) {
        selectedAsset = asset;

        // Auto-match jenis aset
        const jLower = (asset.asset_type || '').toLowerCase();
        let matchedOption = 'Desktop PC';
        if (jLower.includes('laptop') || jLower.includes('notebook')) matchedOption = 'Laptop/NoteBook';
        else if (jLower.includes('printer') || jLower.includes('cetak')) matchedOption = 'Pencetak';
        else if (jLower.includes('scanner') || jLower.includes('imbas')) matchedOption = 'Pengimbas';
        else if (jLower.includes('desktop') || jLower.includes('pc') || jLower.includes('cpu')) matchedOption = 'Desktop PC';
        else matchedOption = 'Lain-lain';

        document.getElementById('b_jenis').value = matchedOption;

        // Auto-fill registration / serial number
        document.getElementById('b_siri').value = asset.no_siri_pendaftaran || asset.serial_number || '';

        // Render specification preview grid
        renderSpecCard(asset);

        // Show card and checkbox
        document.getElementById('specCard').style.display = 'block';
        document.getElementById('specCheckboxWrap').style.display = 'block';
        document.getElementById('specMismatchAlert').style.display = 'none';

        // Reset checkbox to require explicit staff confirmation
        const chk = document.getElementById('b_lampirkan_spec');
        chk.checked = false;

        validateAssetMatch();
    }

    function renderSpecCard(asset) {
        document.getElementById('specAssetTitle').textContent = `Spesifikasi: ${asset.asset_type || 'Aset'} - ${asset.model_komputer || 'Peranti'}`;

        const items = [
            { label: 'Model Komputer / Peranti', val: asset.model_komputer },
            { label: 'No. Siri Pendaftaran', val: asset.no_siri_pendaftaran },
            { label: 'No. Siri Komputer (S/N)', val: asset.serial_number },
            { label: 'Model & No. Siri Monitor', val: asset.model_monitor ? `${asset.model_monitor} (${asset.serial_monitor || '-'})` : asset.serial_monitor },
            { label: 'Sistem Pengendalian (OS)', val: asset.os },
            { label: 'Pemproses (CPU)', val: asset.processor },
            { label: 'RAM', val: asset.ram },
            { label: 'Storan (Hard Disk/SSD)', val: asset.hard_disk },
            { label: 'Alamat IP', val: asset.ip_address },
            { label: 'Pencetak (Printer)', val: asset.printer },
            { label: 'Tetikus & Papan Kekunci', val: (asset.mouse || asset.keyboard) ? `${asset.mouse || '-'} / ${asset.keyboard || '-'}` : '' },
            { label: 'Perisian (Office & Antivirus)', val: (asset.ms_office || asset.antivirus) ? `${asset.ms_office ? 'Office ' + asset.ms_office : '-'} | ${asset.antivirus || '-'}` : '' },
            { label: 'Catatan ICT / Maklumat', val: asset.perisian_lain || asset.maklumat_ict }
        ];

        const grid = document.getElementById('specGridItems');
        grid.innerHTML = items
            .filter(it => it.val && it.val !== '-' && it.val !== '')
            .map(it => `
                <div style="background:#f8fafc;padding:0.5rem 0.75rem;border-radius:6px;border:1px solid #e2e8f0;">
                    <div style="font-size:0.72rem;color:#64748b;font-weight:600;">${it.label}</div>
                    <div style="font-size:0.83rem;color:#0f172a;font-weight:700;word-break:break-word;">${escapeHtml(it.val)}</div>
                </div>
            `).join('');
    }

    function validateAssetMatch() {
        if (!selectedAsset) return false;

        const typedSiri = (document.getElementById('b_siri').value || '').trim().toLowerCase();
        const assetNoSiri = (selectedAsset.no_siri_pendaftaran || '').trim().toLowerCase();
        const assetSN = (selectedAsset.serial_number || '').trim().toLowerCase();

        // Check if typed serial matches currently selected asset
        const isMatched = typedSiri !== '' && (typedSiri === assetNoSiri || typedSiri === assetSN);

        const statusBadge = document.getElementById('specMatchStatus');
        const mismatchAlert = document.getElementById('specMismatchAlert');
        const chk = document.getElementById('b_lampirkan_spec');

        if (isMatched) {
            statusBadge.textContent = '✅ Spesifikasi Sepadan';
            statusBadge.style.background = '#dcfce7';
            statusBadge.style.color = '#15803d';
            statusBadge.style.border = '1px solid #86efac';
            mismatchAlert.style.display = 'none';
            chk.disabled = false;
            return true;
        } else {
            // Check if user typed s/n of another registered asset
            const otherFound = userAssets.find(a => {
                const s1 = (a.no_siri_pendaftaran || '').trim().toLowerCase();
                const s2 = (a.serial_number || '').trim().toLowerCase();
                return typedSiri !== '' && (typedSiri === s1 || typedSiri === s2);
            });

            if (otherFound) {
                // Auto switch to that asset
                document.getElementById('b_pilih_aset').value = otherFound.id;
                applySelectedAsset(otherFound);
                return true;
            }

            statusBadge.textContent = '⚠️ Tidak Sepadan';
            statusBadge.style.background = '#fee2e2';
            statusBadge.style.color = '#b91c1c';
            statusBadge.style.border = '1px solid #fca5a5';
            mismatchAlert.style.display = 'block';
            chk.checked = false;
            return false;
        }
    }

    function handleQueryPrefill() {
        const params = new URLSearchParams(window.location.search);
        const assetId = params.get('asset_id');
        const sn = params.get('sn');
        const jenis = params.get('jenis');

        if (assetId && userAssets.length > 0) {
            const found = userAssets.find(a => parseInt(a.id) === parseInt(assetId));
            if (found) {
                document.getElementById('b_pilih_aset').value = found.id;
                applySelectedAsset(found);
                return;
            }
        }

        if (sn && userAssets.length > 0) {
            const found = userAssets.find(a => {
                const s1 = (a.no_siri_pendaftaran || '').trim().toLowerCase();
                const s2 = (a.serial_number || '').trim().toLowerCase();
                return sn.trim().toLowerCase() === s1 || sn.trim().toLowerCase() === s2;
            });
            if (found) {
                document.getElementById('b_pilih_aset').value = found.id;
                applySelectedAsset(found);
                return;
            }
        }

        if (sn || jenis) {
            if (sn) document.getElementById('b_siri').value = sn;
            if (jenis) {
                const jLower = jenis.toLowerCase();
                let matchedOption = 'Desktop PC';
                if (jLower.includes('laptop') || jLower.includes('notebook')) matchedOption = 'Laptop/NoteBook';
                else if (jLower.includes('printer') || jLower.includes('cetak')) matchedOption = 'Pencetak';
                else if (jLower.includes('desktop') || jLower.includes('pc')) matchedOption = 'Desktop PC';
                else matchedOption = 'Lain-lain';
                document.getElementById('b_jenis').value = matchedOption;
            }
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.getElementById('borangForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const alertEl = document.getElementById('borangAlert');
        const btn = document.getElementById('btnSubmitReport');

        // Validation: Must select matching asset spec
        if (!selectedAsset) {
            showAlert(alertEl, '❌ Sila pilih aset berdaftar anda terlebih dahulu untuk melampirkan spesifikasi.', 'error');
            document.getElementById('b_pilih_aset').focus();
            return;
        }

        if (!validateAssetMatch()) {
            showAlert(alertEl, '❌ Spesifikasi aset mesti sama dengan nombor siri aset yang hendak dibuat aduan!', 'error');
            document.getElementById('b_siri').focus();
            return;
        }

        const chk = document.getElementById('b_lampirkan_spec');
        if (!chk || !chk.checked) {
            showAlert(alertEl, '❌ Sila tandakan kotak pengesahan untuk melampirkan spesifikasi aset sebelum menghantar borang aduan KEW.PA-9!', 'error');
            if (chk) chk.focus();
            return;
        }

        try {
            btn.disabled = true;
            btn.textContent = '⏳ Menghantar...';

            const fd = new FormData();
            fd.append('asset_id', selectedAsset.id);
            fd.append('jenis_aset', document.getElementById('b_jenis').value);
            fd.append('nombor_siri', document.getElementById('b_siri').value);
            fd.append('pengguna_terakhir', document.getElementById('b_pengguna').value);
            fd.append('tarikh_kerosakan', document.getElementById('b_tarikh').value);
            fd.append('nama_pelapor', document.getElementById('b_nama').value);
            fd.append('jawatan_pelapor', document.getElementById('b_jawatan_pelapor').value);
            fd.append('location', document.getElementById('b_lokasi').value);
            fd.append('perihal_kerosakan', document.getElementById('b_perihal').value);
            fd.append('confirm_spec', '1');

            // Snapshot snapshot of asset specification at submission time
            const specSnapshot = {
                asset_id: selectedAsset.id,
                asset_type: selectedAsset.asset_type || document.getElementById('b_jenis').value,
                model_komputer: selectedAsset.model_komputer || '',
                no_siri_pendaftaran: selectedAsset.no_siri_pendaftaran || '',
                serial_number: selectedAsset.serial_number || '',
                model_monitor: selectedAsset.model_monitor || '',
                serial_monitor: selectedAsset.serial_monitor || '',
                os: selectedAsset.os || '',
                processor: selectedAsset.processor || '',
                ram: selectedAsset.ram || '',
                hard_disk: selectedAsset.hard_disk || '',
                ip_address: selectedAsset.ip_address || '',
                printer: selectedAsset.printer || '',
                mouse: selectedAsset.mouse || '',
                keyboard: selectedAsset.keyboard || '',
                ms_office: selectedAsset.ms_office || '',
                antivirus: selectedAsset.antivirus || '',
                perisian_lain: selectedAsset.perisian_lain || '',
                maklumat_ict: selectedAsset.maklumat_ict || '',
                nama_pegawai: selectedAsset.nama_pegawai || '',
                jawatan: selectedAsset.jawatan || '',
                jabatan_unit: selectedAsset.jabatan_unit || '',
                tarikh_lampiran: new Date().toISOString()
            };
            fd.append('lampiran_spec', JSON.stringify(specSnapshot));

            const files = document.getElementById('b_gambar').files;
            for (let i = 0; i < files.length; i++) {
                fd.append('images[]', files[i]);
            }

            const res = await fetch('../api/staff/staff_submit_report.php', {
                method: 'POST',
                body: fd
            });
            const data = await res.json();

            if (data.status === 'success') {
                const rawId = data.report_id || (data.data && data.data.report_id) || null;
                const formattedRef = rawId ? '#ICT' + String(rawId).padStart(2, '0') : '-';
                showAlert(alertEl, '✅ Aduan berjaya dihantar bersama lampiran spesifikasi aset! No. Rujukan: <strong>' + formattedRef + '</strong>. <a href="laporan_saya.php" style="margin-left:0.5rem; text-decoration:underline; font-weight:700; color:inherit;">Lihat Senarai Aduan ›</a>', 'success');
                document.getElementById('borangForm').reset();
                populateBorangDefaults();
                selectedAsset = null;
                document.getElementById('b_pilih_aset').value = '';
                document.getElementById('specCard').style.display = 'none';
                document.getElementById('specCheckboxWrap').style.display = 'none';
                document.getElementById('specMismatchAlert').style.display = 'none';
            } else {
                showAlert(alertEl, '❌ ' + (data.message || 'Gagal menghantar laporan.'), 'error');
            }
        } catch (err) {
            showAlert(alertEl, '❌ Ralat sambungan pelayan: ' + err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = '📤 Hantar Aduan';
        }
    });

    function showAlert(el, msg, type) {
        if (!el) return;
        el.innerHTML = msg;
        el.className = 'alert alert-' + type;
        el.style.display = 'block';

        // Auto skrol ke bahagian atas supaya mesej status/notifikasi jelas kelihatan
        const scrollContainer = el.closest('.view-scroll') || document.querySelector('.view-scroll');
        if (scrollContainer) {
            scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
</script>

<?php include 'includes/footer.php'; ?>
