<?php
// staff/aset_saya.php
$pageTitle = 'Aset Saya - eICT Desk';
include 'includes/header.php';
?>

<div class="wide-content active">
    <div class="view active" id="view-aset">
        <a href="dashboard.php" class="back-btn">‹ Kembali</a>
        
        <div class="asset-view-header">
            <div>
                <div class="view-subheading">Portal Staf</div>
                <div class="view-heading" style="margin-bottom:.3rem;">Aset Saya</div>
                <p style="font-size:.82rem;color:#66768c;">Senarai peralatan ICT dan komputer yang didaftarkan oleh Pentadbir ICT MPM untuk kegunaan anda.</p>
            </div>
            <div style="background:rgba(37,99,235,.08);color:#2563eb;font-weight:700;font-size:.82rem;padding:.45rem 1.1rem;border-radius:20px;border:1px solid rgba(37,99,235,.2);display:inline-flex;align-items:center;gap:.4rem;">
                📋 Jumlah Aset: <span id="assetCountBadge" style="font-weight:800;color:#1e40af;">0</span>
            </div>
        </div>

        <div class="view-scroll">
            <div id="asetAlert" class="alert"></div>

            <!-- Search & Status Bar -->
            <div style="display:flex;gap:.75rem;align-items:center;margin-bottom:1.1rem;flex-wrap:wrap;">
                <div style="position:relative;flex:1;min-width:240px;">
                    <input type="text" id="assetSearchInput" class="form-input" placeholder="🔍 Cari model komputer, no. siri, atau spesifikasi..." oninput="filterUserAssets(this.value)">
                </div>
                <div style="font-size:.78rem;color:#66768c;background:rgba(255,255,255,.75);padding:.6rem 1rem;border-radius:12px;border:1px solid rgba(37,99,235,.15);font-weight:600;display:flex;align-items:center;gap:.4rem;">
                    <span>Status Rekod:</span> <span style="color:#15803d;font-weight:800;">● Aktif</span>
                </div>
            </div>

            <!-- List Cards Container -->
            <div id="assetCardsContainer">
                <div style="text-align:center;padding:3rem 1rem;color:#66768c;">
                    ⏳ Memuatkan senarai aset anda...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Asset Detail Modal (Read-Only) -->
<div id="assetDetailModal" class="portal-modal" onclick="if(event.target===this)closeAssetModal()">
    <div class="portal-modal-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <div>
                <span style="font-size:.72rem;font-weight:800;color:#2563eb;text-transform:uppercase;letter-spacing:.06em;">Maklumat Lengkap Aset</span>
                <h2 id="adm_title" style="margin-top:.2rem;">Butiran Aset ICT</h2>
            </div>
            <button type="button" class="modal-close" onclick="closeAssetModal()">&times;</button>
        </div>

        <div style="display:flex;gap:.5rem;margin-bottom:1rem;flex-wrap:wrap;">
            <span id="adm_badge_type" class="asset-badge asset-badge-type">Desktop PC</span>
            <span class="asset-badge asset-badge-admin">🛡️ Didaftarkan Melalui Admin</span>
            <span id="adm_badge_sn" class="asset-badge asset-badge-sn">S/N: -</span>
        </div>

        <h4>Bahagian A: Maklumat Pemohon / Staf</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Nama Pemohon</label><input type="text" id="adm_nama" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Jawatan</label><input type="text" id="adm_jawatan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Bahagian / Unit</label><input type="text" id="adm_dept" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Pendaftaran</label><input type="text" id="adm_tarikh" class="form-input" readonly></div>
        </div>

        <h4>Bahagian B: Maklumat Komputer &amp; Perkakasan</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Model Komputer / Laptop</label><input type="text" id="adm_model_comp" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri CPU / Laptop</label><input type="text" id="adm_serial_comp" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Model Monitor</label><input type="text" id="adm_model_mon" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri Monitor</label><input type="text" id="adm_serial_mon" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Sistem Operasi (OS)</label><input type="text" id="adm_os" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pemproses (CPU)</label><input type="text" id="adm_proc" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">RAM</label><input type="text" id="adm_ram" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Cakera Keras (Storage)</label><input type="text" id="adm_disk" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Alamat IP</label><input type="text" id="adm_ip" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pencetak (Printer)</label><input type="text" id="adm_printer" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tetikus &amp; Papan Kekunci</label><input type="text" id="adm_accessories" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Microsoft Office &amp; Antivirus</label><input type="text" id="adm_software" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;">
            <label class="form-label">Perisian Lain</label>
            <textarea id="adm_perisian_lain" class="form-textarea" rows="2" readonly></textarea>
        </div>

        <h4>Bahagian C: Gambar Lampiran Aset</h4>
        <div id="adm_images" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:1rem;margin-top:.5rem;"></div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;justify-content:flex-end;">
            <button type="button" id="adm_btn_report" class="btn-asset-report" style="padding:.6rem 1.2rem;font-size:.85rem;">📤 Lapor Kerosakan (KEW.PA-9)</button>
            <button type="button" onclick="closeAssetModal()" class="btn-ghost" style="padding:.6rem 1.2rem;font-size:.85rem;">Tutup</button>
        </div>
    </div>
</div>

<script>
    let currentUser = null;
    let userAssetsList = [];

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

        loadAssetData();
    });

    async function loadAssetData() {
        const container = document.getElementById('assetCardsContainer');
        if (!container) return;
        container.innerHTML = '<div style="text-align:center;padding:3rem 1rem;color:#66768c;">⏳ Memuatkan rekod aset anda...</div>';

        try {
            const response = await fetch('../api/staff/staff_get_assets.php?_t=' + Date.now());
            const result = await response.json();
            if (result.status !== 'success') {
                container.innerHTML = `<div style="text-align:center;padding:2.5rem;color:#dc2626;">❌ ${result.message || 'Gagal memuatkan data aset.'}</div>`;
                return;
            }

            userAssetsList = result.data || [];
            const badge = document.getElementById('assetCountBadge');
            if (badge) badge.textContent = userAssetsList.length;

            renderAssetList(userAssetsList);
        } catch (err) {
            console.error('loadAssetData error:', err);
            container.innerHTML = `<div style="text-align:center;padding:2.5rem;color:#dc2626;">❌ Ralat sambungan memuatkan aset: ${err.message}</div>`;
        }
    }

    function renderAssetList(assets) {
        const container = document.getElementById('assetCardsContainer');
        if (!container) return;

        if (!assets || assets.length === 0) {
            container.innerHTML = `
                <div style="background:rgba(255,255,255,.8);border:2px dashed rgba(37,99,235,.2);border-radius:18px;padding:3rem 1.5rem;text-align:center;margin-top:.5rem;">
                    <div style="width:64px;height:64px;background:#e0f2fe;color:#0284c7;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1rem;">💻</div>
                    <h3 style="font-size:1.15rem;font-weight:800;color:#24324b;margin-bottom:.35rem;">Tiada Aset Didaftarkan</h3>
                    <p style="font-size:.84rem;color:#66768c;max-width:480px;margin:0 auto;line-height:1.5;">
                        Belum ada aset komputer atau perkakasan ICT yang didaftarkan untuk akaun anda oleh Pentadbir ICT MPM. Sila hubungi Admin untuk pendaftaran dan penetapan aset bagi akaun anda.
                    </p>
                </div>
            `;
            return;
        }

        container.innerHTML = assets.map(a => {
            const typeLower = (a.asset_type || '').toLowerCase();
            let icon = '💻';
            if (typeLower.includes('desktop') || typeLower.includes('pc')) icon = '🖥️';
            else if (typeLower.includes('laptop') || typeLower.includes('notebook')) icon = '💻';
            else if (typeLower.includes('printer') || typeLower.includes('cetak')) icon = '🖨️';
            else if (typeLower.includes('monitor')) icon = '🖥️';
            else icon = '📟';

            const assetTypeDisplay = a.asset_type || 'Desktop PC';
            const model = a.model_komputer || 'Model Tidak Dinyatakan';
            const serial = a.serial_number || 'N/A';
            const regDate = a.created_at ? new Date(a.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

            // Image thumbnails
            let imagesHtml = '';
            if (a.images && a.images.length > 0) {
                imagesHtml = `
                    <div class="asset-thumb-strip">
                        <span style="font-size:.7rem;font-weight:700;color:#64748b;margin-right:.25rem;">Gambar:</span>
                        ${a.images.map(img => `<img src="../${img.image_path.replace(/^\/+/, '')}" class="asset-thumb" title="Klik untuk lihat butiran" onclick="openAssetDetail(${a.id})">`).join('')}
                    </div>
                `;
            }

            return `
                <div class="asset-card">
                    <div class="asset-card-top">
                        <div class="asset-card-badges">
                            <span class="asset-badge asset-badge-type">${icon} ${escapeHtml(assetTypeDisplay)}</span>
                            <span class="asset-badge asset-badge-admin">🛡️ Didaftarkan Melalui Admin</span>
                            <span class="asset-badge asset-badge-sn">S/N: ${escapeHtml(serial)}</span>
                        </div>
                        <div style="font-size:.74rem;color:#64748b;font-weight:600;">
                            📅 Didaftar: ${regDate}
                        </div>
                    </div>

                    <div class="asset-card-title">
                        <div>
                            <span>${escapeHtml(model)}</span>
                            ${a.no_siri_pendaftaran ? `<span style="font-size:.75rem;font-weight:600;color:#64748b;margin-left:.5rem;">(No. Pendaftaran: <strong>${escapeHtml(a.no_siri_pendaftaran)}</strong>)</span>` : ''}
                        </div>
                    </div>

                    <div class="asset-specs-grid">
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🖥️ Monitor</span>
                            <span class="asset-spec-value">${escapeHtml(a.model_monitor ? a.model_monitor + (a.serial_monitor ? ' (' + a.serial_monitor + ')' : '') : 'Tiada / Bersepadu')}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">⚙️ OS &amp; Pemproses</span>
                            <span class="asset-spec-value">${escapeHtml((a.os || '-') + ' / ' + (a.processor || '-'))}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">💾 RAM &amp; Storan</span>
                            <span class="asset-spec-value">${escapeHtml((a.ram || '-') + ' / ' + (a.hard_disk || '-'))}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🌐 Alamat IP</span>
                            <span class="asset-spec-value">${escapeHtml(a.ip_address || '-')}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🖨️ Pencetak</span>
                            <span class="asset-spec-value">${escapeHtml(a.printer || 'Tiada')}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">📄 Perisian Office & Antivirus</span>
                            <span class="asset-spec-value">${escapeHtml((a.ms_office ? 'Office ' + a.ms_office : '-') + (a.antivirus ? ' | ' + a.antivirus : ''))}</span>
                        </div>
                    </div>

                    ${imagesHtml}

                    <div class="asset-card-actions">
                        <a href="borang_aduan.php?asset_id=${a.id}&sn=${encodeURIComponent(a.serial_number || a.no_siri_pendaftaran || '')}&jenis=${encodeURIComponent(a.asset_type || '')}" class="btn-asset-report" title="Hantar borang aduan KEW.PA-9 dengan maklumat aset ini">
                            📤 Lapor Kerosakan (KEW.PA-9)
                        </a>
                        <button type="button" class="btn-asset-action" onclick="openAssetDetail(${a.id})">
                            👁️ Butiran Penuh
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterUserAssets(term) {
        const query = (term || '').toLowerCase().trim();
        if (!query) {
            renderAssetList(userAssetsList);
            return;
        }

        const filtered = userAssetsList.filter(a => {
            const m = (a.model_komputer || '').toLowerCase();
            const s = (a.serial_number || '').toLowerCase();
            const t = (a.asset_type || '').toLowerCase();
            const mon = (a.model_monitor || '').toLowerCase();
            const os = (a.os || '').toLowerCase();
            const ip = (a.ip_address || '').toLowerCase();
            const reg = (a.no_siri_pendaftaran || '').toLowerCase();
            return m.includes(query) || s.includes(query) || t.includes(query) || mon.includes(query) || os.includes(query) || ip.includes(query) || reg.includes(query);
        });

        renderAssetList(filtered);
    }

    function openAssetDetail(assetId) {
        const a = userAssetsList.find(item => item.id == assetId);
        if (!a) return;

        document.getElementById('adm_title').textContent = a.model_komputer || 'Butiran Aset ICT';
        document.getElementById('adm_badge_type').textContent = a.asset_type || 'Desktop PC';
        document.getElementById('adm_badge_sn').textContent = 'S/N: ' + (a.serial_number || '-');

        document.getElementById('adm_nama').value = a.display_name || a.nama_pegawai || (currentUser ? currentUser.full_name : '-');
        document.getElementById('adm_jawatan').value = a.display_jawatan || a.jawatan || (currentUser ? currentUser.jawatan : '-');
        document.getElementById('adm_dept').value = a.display_dept || a.jabatan_unit || (currentUser ? currentUser.department : '-');
        document.getElementById('adm_tarikh').value = a.created_at ? new Date(a.created_at).toLocaleString('ms-MY') : '-';

        document.getElementById('adm_model_comp').value = a.model_komputer || '-';
        document.getElementById('adm_serial_comp').value = a.serial_number || '-';
        document.getElementById('adm_model_mon').value = a.model_monitor || '-';
        document.getElementById('adm_serial_mon').value = a.serial_monitor || '-';
        document.getElementById('adm_os').value = a.os || '-';
        document.getElementById('adm_proc').value = a.processor || '-';
        document.getElementById('adm_ram').value = a.ram || '-';
        document.getElementById('adm_disk').value = a.hard_disk || '-';
        document.getElementById('adm_ip').value = a.ip_address || '-';
        document.getElementById('adm_printer').value = a.printer || 'Tiada';
        document.getElementById('adm_accessories').value = 'Tetikus: ' + (a.mouse || '-') + ' | Papan Kekunci: ' + (a.keyboard || '-');
        document.getElementById('adm_software').value = 'Office: ' + (a.ms_office || '-') + ' | Antivirus: ' + (a.antivirus || '-');
        document.getElementById('adm_perisian_lain').value = a.perisian_lain || 'Tiada';

        // Images preview
        const imgContainer = document.getElementById('adm_images');
        imgContainer.innerHTML = '';
        if (a.images && a.images.length > 0) {
            a.images.forEach(img => {
                const imgPath = '../' + img.image_path.replace(/^\/+/, '');
                const div = document.createElement('div');
                div.style.cssText = 'aspect-ratio:1;border-radius:10px;overflow:hidden;border:1px solid rgba(37,99,235,.2);box-shadow:0 4px 10px rgba(0,0,0,.06);';
                div.innerHTML = `<a href="${imgPath}" target="_blank" title="Buka gambar saiz penuh"><img src="${imgPath}" style="width:100%;height:100%;object-fit:cover;cursor:pointer;"></a>`;
                imgContainer.appendChild(div);
            });
        } else {
            imgContainer.innerHTML = '<p style="color:#64748b;font-size:.82rem;">Tiada gambar lampiran dimuat naik.</p>';
        }

        // Setup report button inside modal
        const repBtn = document.getElementById('adm_btn_report');
        if (repBtn) {
            repBtn.onclick = () => {
                window.location.href = `borang_aduan.php?asset_id=${a.id}&sn=${encodeURIComponent(a.serial_number || a.no_siri_pendaftaran || '')}&jenis=${encodeURIComponent(a.asset_type || '')}`;
            };
        }

        document.getElementById('assetDetailModal').classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeAssetModal() {
        const modal = document.getElementById('assetDetailModal');
        if (modal) modal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAssetModal();
    });
</script>

<?php include 'includes/footer.php'; ?>
