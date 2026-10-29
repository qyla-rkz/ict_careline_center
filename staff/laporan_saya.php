<?php
// staff/laporan_saya.php
$pageTitle = 'Laporan Saya - eICT Desk';
include 'includes/header.php';
?>

<div class="wide-content active">
    <div class="view active" id="view-laporan">
        <a href="dashboard.php" class="back-btn">‹ Kembali</a>
        <div class="view-subheading">Staff Portal</div>
        <div class="view-heading">Laporan Saya</div>

        <div class="view-scroll" id="portalLaporanSaya">
            <div class="hist-filter-bar">
                <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
                    <div class="hist-filter-row">
                        <label for="filterYear" class="form-label" style="margin:0;">Tahun:</label>
                        <select id="filterYear" class="form-select" style="min-width:130px;padding:.5rem .9rem;" onchange="filterHistory()">
                            <option value="">Semua Tahun</option>
                        </select>
                    </div>
                    <div class="hist-filter-row">
                        <label for="filterMonth" class="form-label" style="margin:0;">Bulan:</label>
                        <select id="filterMonth" class="form-select" style="min-width:140px;padding:.5rem .9rem;" onchange="filterHistory()">
                            <option value="">Semua Bulan</option>
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Mac</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Jun</option>
                            <option value="6">Julai</option>
                            <option value="7">Ogos</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Disember</option>
                        </select>
                    </div>
                </div>

                <div class="hist-legend">
                    <span class="hist-legend-title">Petunjuk Status &amp; Keputusan:</span>
                    <div class="hist-legend-grid">
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#f59e0b;"></span> Baru / Dalam Proses</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#10b981;"></span> Selesai / Diluluskan</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#ef4444;"></span> Ditolak / Tidak Diluluskan</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#64748b;"></span> Syor Dilupuskan</span>
                    </div>
                </div>
            </div>

            <div class="hist-table-wrap">
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jenis Aset</th>
                            <th>Tarikh Dihantar</th>
                            <th>Tarikh Siap</th>
                            <th>Pematuhan ISO</th>
                            <th>Proses</th>
                            <th>Keputusan</th>
                            <th style="text-align:center;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <tr><td colspan="8" style="padding:2rem;text-align:center;color:#66768c;">⏳ Memuatkan rekod laporan...</td></tr>
                    </tbody>
                </table>
            </div>

            <div id="paginationControls" class="hist-pager" style="display:none;">
                <div id="paginationInfo" style="font-size:.8rem;color:#66768c;font-weight:600;"></div>
                <div style="display:flex;align-items:center;gap:.4rem;">
                    <button type="button" id="btnPrev" onclick="changePage(currentPage - 1)" class="btn-ghost" style="padding:.4rem .8rem;font-size:.78rem;">← Sebelum</button>
                    <div id="pageNumbers" style="display:flex;gap:.3rem;"></div>
                    <button type="button" id="btnNext" onclick="changePage(currentPage + 1)" class="btn-ghost" style="padding:.4rem .8rem;font-size:.78rem;">Seterus →</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Butiran Laporan KEW.PA-9 -->
<div id="detailModal" class="portal-modal" onclick="if(event.target===this)closeModal()">
    <div class="portal-modal-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 id="d_modal_title">Butiran Laporan KEW.PA-9</h2>
            <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
        </div>

        <h4>Bahagian I: Maklumat Pengadu &amp; Kerosakan</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Jenis Aset</label><input type="text" id="d_jenis" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri Pendaftaran</label><input type="text" id="d_siri" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pengguna Terakhir</label><input type="text" id="d_pengguna" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Kerosakan</label><input type="text" id="d_tarikh_rosak" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Nama Pelapor &amp; Jawatan</label><input type="text" id="d_nama_jawatan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Lokasi</label><input type="text" id="d_lokasi" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;">
            <label class="form-label">Perihal Kerosakan</label>
            <textarea id="d_perihal" class="form-textarea" rows="3" readonly></textarea>
        </div>
        <div class="form-group" style="margin-top:.85rem;">
            <label class="form-label">Tarikh Aduan</label>
            <input type="text" id="d_created_at" class="form-input" readonly>
        </div>

        <!-- Lampiran Spesifikasi Aset -->
        <div id="d_spec_container" style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:1.1rem; margin-top:1rem;">
            <h4 style="color:var(--primary, #1e40af); margin:0 0 0.65rem 0; border:none; padding:0; display:flex; align-items:center; justify-content:space-between; font-size:0.9rem;">
                <span style="display:flex;align-items:center;gap:0.4rem;">💻 Lampiran Spesifikasi Aset Yang Rosak</span>
                <span id="d_spec_status_badge" style="font-size:0.72rem; padding:0.2rem 0.65rem; border-radius:999px; font-weight:700;"></span>
            </h4>
            <div id="d_spec_body">
                <!-- Populated via renderAttachedSpec -->
            </div>
        </div>

        <!-- Proses Semasa (Web Only) -->
        <div style="background:linear-gradient(135deg,rgba(99,102,241,.05),rgba(168,85,247,.05));border:1px solid rgba(99,102,241,.2);border-radius:12px;padding:1rem;margin-top:1rem;">
            <h4 style="color:#6366f1;margin:0 0 .6rem;border:none;padding:0;display:flex;align-items:center;gap:.45rem;font-size:.9rem;">
                🔄 Proses Semasa <span style="font-size:.68rem;background:#6366f1;color:#fff;padding:.15rem .5rem;border-radius:20px;font-weight:600;">WEB SAHAJA</span>
            </h4>
            <div id="d_proses_semasa">—</div>
        </div>

        <h4 style="margin-top:1.25rem;">Bahagian II: Penemuan Teknikal</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Kos Penyelenggaraan Terdahulu (RM)</label><input type="text" id="d_kos_dahulu" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Anggaran Kos Penyelenggaraan (RM)</label><input type="text" id="d_anggaran_kos" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;">
            <label class="form-label">Syor Dan Ulasan</label>
            <textarea id="d_syor" class="form-textarea" rows="3" readonly></textarea>
        </div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Nama Pegawai Teknikal</label><input type="text" id="d_admin_nama" class="form-input" readonly></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Jawatan Pegawai Teknikal</label><input type="text" id="d_admin_jawatan" class="form-input" readonly></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Tarikh Siap (Admin ICT)</label><input type="text" id="d_admin_tarikh" class="form-input" readonly></div>

        <h4 style="margin-top:1.25rem;">Bahagian III: Keputusan</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Keputusan</label><input type="text" id="d_keputusan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Nama Ketua</label><input type="text" id="d_kep_nama" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Keputusan</label><input type="text" id="d_kep_tarikh" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pematuhan ISO (&lt;14 hari)</label><div id="d_iso_badge" style="padding-top:.4rem;"></div></div>
        </div>

        <h4>Gambar Lampiran</h4>
        <div id="d_images"></div>
        <div style="margin-top:1.5rem;">
            <button type="button" onclick="closeModal()" class="btn-ghost" style="width:100%;">Tutup</button>
        </div>
    </div>
</div>

<script>
    let reportsData = [];
    let filteredData = [];
    let currentPage = 1;
    const PAGE_SIZE = 5;

    document.addEventListener('DOMContentLoaded', () => {
        loadHistoryData();
    });

    async function loadHistoryData() {
        try {
            const res = await fetch('../api/staff/staff_get_history.php?_t=' + Date.now());
            const data = await res.json();
            if (data.status === 'success') {
                reportsData = data.data || [];
                
                // Populate years dropdown
                const years = [...new Set(reportsData.map(r => new Date(r.created_at).getFullYear()))].sort((a, b) => b - a);
                const yearSelect = document.getElementById('filterYear');
                yearSelect.innerHTML = '<option value="">Semua Tahun</option>';
                years.forEach(yr => {
                    if (!isNaN(yr)) {
                        const opt = document.createElement('option');
                        opt.value = yr;
                        opt.textContent = yr;
                        yearSelect.appendChild(opt);
                    }
                });

                filterHistory();
            } else {
                document.getElementById('historyTableBody').innerHTML = `<tr><td colspan="8" style="padding:2rem;text-align:center;color:#dc2626;">❌ ${data.message || 'Ralat memuatkan sejarah laporan.'}</td></tr>`;
            }
        } catch (err) {
            document.getElementById('historyTableBody').innerHTML = `<tr><td colspan="8" style="padding:2rem;text-align:center;color:#dc2626;">❌ Ralat sambungan: ${err.message}</td></tr>`;
        }
    }

    function calcIsoDays(createdAt, completedAt) {
        if (!completedAt) return null;
        return Math.round((new Date(completedAt) - new Date(createdAt)) / (1000 * 60 * 60 * 24));
    }

    function isobadge(r) {
        const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
        if (!isCompleted || !r.admin_tarikh) return '<span style="color:#66768c;font-size:.78rem;">—</span>';
        const days = calcIsoDays(r.created_at, r.admin_tarikh);
        if (days === null) return '<span style="color:#66768c;font-size:.78rem;">—</span>';
        const pass = days <= 14;
        return `<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:20px;font-size:.7rem;font-weight:700;background:${pass ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)'};color:${pass ? '#059669' : '#dc2626'};border:1px solid ${pass ? 'rgba(16,185,129,.3)' : 'rgba(239,68,68,.3)'};">${pass ? '✅' : '⚠️'} ${days} hari</span>`;
    }

    function filterHistory() {
        const selectedYear = document.getElementById('filterYear').value;
        const selectedMonth = document.getElementById('filterMonth').value;
        filteredData = reportsData.filter(r => {
            const date = new Date(r.created_at);
            const matchYear = !selectedYear || date.getFullYear().toString() === selectedYear;
            const matchMonth = !selectedMonth || date.getMonth().toString() === selectedMonth;
            return matchYear && matchMonth;
        });
        currentPage = 1;
        renderPage();
    }

    function changePage(page) {
        currentPage = page;
        renderPage();
        const el = document.getElementById('portalLaporanSaya');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function formatReportId(id) {
        if (!id && id !== 0) return '';
        const num = parseInt(id);
        if (isNaN(num)) return `#ICT${id}`;
        return `#ICT${String(num).padStart(2, '0')}`;
    }

    function renderPage() {
        const totalItems = filteredData.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / PAGE_SIZE));
        currentPage = Math.min(Math.max(1, currentPage), totalPages);
        const start = (currentPage - 1) * PAGE_SIZE;
        const pageData = filteredData.slice(start, start + PAGE_SIZE);
        const tbody = document.getElementById('historyTableBody');

        if (!pageData.length) {
            tbody.innerHTML = '<tr><td colspan="8" style="padding:2.5rem;text-align:center;color:#66768c;">Tiada laporan ditemui untuk tapisan yang dipilih.</td></tr>';
            document.getElementById('paginationControls').style.display = 'none';
            return;
        }

        tbody.innerHTML = pageData.map(r => {
            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
            const tarikhSiap = (isCompleted && r.admin_tarikh)
                ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })
                : '<span style="color:#66768c;font-size:.78rem;">Belum Diproses</span>';
            const kepColor = r.keputusan === 'Diluluskan' ? '#15803d' : r.keputusan === 'Tidak Diluluskan' ? '#b91c1c' : r.keputusan === 'Syor Dilupuskan' ? '#475569' : '#66768c';
            const safeJson = JSON.stringify(r).replace(/'/g, '&apos;').replace(/</g, '&lt;');

            return `<tr>
                <td style="font-weight:700;color:#2563eb;">${formatReportId(r.id)}</td>
                <td style="font-weight:600;">${escapeHtml(r.jenis_aset || '—')}</td>
                <td style="color:#66768c;">${new Date(r.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                <td>${tarikhSiap}</td>
                <td>${isobadge(r)}</td>
                <td>${r.proses_semasa
                    ? `<span style="display:inline-flex;padding:.25rem .65rem;border-radius:20px;font-size:.7rem;font-weight:700;background:#f1f5f9;color:#475569;">${escapeHtml(r.proses_semasa)}</span>`
                    : '<span style="color:#66768c;">—</span>'}</td>
                <td><span style="font-weight:700;font-size:.78rem;color:${kepColor};">${escapeHtml(r.keputusan || 'Menunggu')}</span></td>
                <td style="text-align:center;"><button type="button" class="btn-lihat" onclick='viewDetails(${safeJson})'>🔍 Lihat</button></td>
            </tr>`;
        }).join('');

        const from = totalItems === 0 ? 0 : start + 1;
        const to = Math.min(start + PAGE_SIZE, totalItems);
        document.getElementById('paginationInfo').textContent = `Menunjukkan ${from}–${to} daripada ${totalItems} laporan`;
        document.getElementById('btnPrev').disabled = currentPage <= 1;
        document.getElementById('btnNext').disabled = currentPage >= totalPages;

        const pageNums = document.getElementById('pageNumbers');
        pageNums.innerHTML = '';
        let startP = Math.max(1, currentPage - 2);
        let endP = Math.min(totalPages, startP + 4);
        if (endP - startP < 4) startP = Math.max(1, endP - 4);
        for (let p = startP; p <= endP; p++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = p;
            btn.onclick = () => changePage(p);
            btn.style.cssText = `width:32px;height:32px;border-radius:8px;border:1px solid rgba(37,99,235,.22);font-weight:700;font-size:.78rem;cursor:pointer;font-family:Outfit,sans-serif;background:${p === currentPage ? '#2563eb' : '#fff'};color:${p === currentPage ? '#fff' : '#24324b'};`;
            pageNums.appendChild(btn);
        }
        document.getElementById('paginationControls').style.display = totalPages <= 1 ? 'none' : 'flex';
    }

    function viewDetails(r) {
        document.getElementById('d_modal_title').textContent = 'Butiran Laporan KEW.PA-9 (' + formatReportId(r.id) + ')';
        const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
        document.getElementById('d_jenis').value = r.jenis_aset || '-';
        document.getElementById('d_siri').value = r.nombor_siri || '-';
        document.getElementById('d_pengguna').value = r.pengguna_terakhir || '-';
        document.getElementById('d_tarikh_rosak').value = r.tarikh_kerosakan ? new Date(r.tarikh_kerosakan).toLocaleDateString('ms-MY') : '-';
        document.getElementById('d_nama_jawatan').value = (r.nama_pelapor || '-') + ' / ' + (r.jawatan_pelapor || '-');
        document.getElementById('d_lokasi').value = r.location || '-';
        document.getElementById('d_perihal').value = r.perihal_kerosakan || '-';
        document.getElementById('d_created_at').value = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '-';

        // Papar Lampiran Spesifikasi Aset
        renderAttachedSpec(r.lampiran_spec);

        const kos = parseFloat(r.kos_penyelenggaraan_dahulu) || 0;
        const anggaran = parseFloat(r.anggaran_kos) || 0;
        document.getElementById('d_kos_dahulu').value = kos > 0 ? 'RM ' + kos.toFixed(2) : '-';
        document.getElementById('d_anggaran_kos').value = anggaran > 0 ? 'RM ' + anggaran.toFixed(2) : '-';
        document.getElementById('d_syor').value = r.syor_ulasan || '-';
        document.getElementById('d_admin_nama').value = r.admin_name_jawatan || '-';
        document.getElementById('d_admin_jawatan').value = r.admin_jawatan || '-';
        document.getElementById('d_admin_tarikh').value = (isCompleted && r.admin_tarikh)
            ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' })
            : 'Belum Diproses';
        document.getElementById('d_keputusan').value = r.keputusan || '-';
        document.getElementById('d_kep_nama').value = r.keputusan_nama || '-';
        document.getElementById('d_kep_tarikh').value = r.keputusan_tarikh ? new Date(r.keputusan_tarikh).toLocaleDateString('ms-MY') : '-';

        const prosesEl = document.getElementById('d_proses_semasa');
        if (r.proses_semasa) {
            const prosesColors = {
                'Diterima': { bg: '#e0f2fe', color: '#0369a1' },
                'Sedang Dibaikpulih': { bg: '#fef9c3', color: '#854d0e' },
                'Tunggu Panel / Alat Ganti': { bg: '#ffedd5', color: '#9a3412' },
                'Dihantar ke Panel Lantikan': { bg: '#ede9fe', color: '#6d28d9' },
                'Selesai Dibaiki': { bg: '#dcfce7', color: '#166534' },
                'Siap - Sedia Diambil': { bg: '#dcfce7', color: '#166534' },
            };
            const pc = prosesColors[r.proses_semasa] || { bg: '#f1f5f9', color: '#475569' };
            prosesEl.innerHTML = `<span style="display:inline-flex;padding:.45rem .9rem;border-radius:20px;font-size:.82rem;font-weight:700;background:${pc.bg};color:${pc.color};">${escapeHtml(r.proses_semasa)}</span>`;
        } else {
            prosesEl.innerHTML = '<span style="color:#66768c;font-size:.85rem;">⏳ Menunggu tindakan admin...</span>';
        }

        const modalDays = (isCompleted && r.admin_tarikh) ? calcIsoDays(r.created_at, r.admin_tarikh) : null;
        const isoEl = document.getElementById('d_iso_badge');
        if (modalDays !== null) {
            const pass = modalDays <= 14;
            isoEl.innerHTML = `<span style="display:inline-flex;padding:.35rem .85rem;border-radius:20px;font-size:.78rem;font-weight:700;background:${pass ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)'};color:${pass ? '#059669' : '#dc2626'};border:1px solid ${pass ? 'rgba(16,185,129,.3)' : 'rgba(239,68,68,.3)'};">${pass ? '✅ Memenuhi ISO' : '⚠️ Melebihi ISO'} (${modalDays} hari)</span>`;
        } else {
            isoEl.innerHTML = '<span style="color:#66768c;font-size:.82rem;">—</span>';
        }

        const imgEl = document.getElementById('d_images');
        if (r.images && r.images.length > 0) {
            imgEl.innerHTML = `<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.75rem;">
                ${r.images.map(img => {
                    const imgPath = '../' + img.image_path.replace(/^\/+/, '');
                    return `<div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid rgba(37,99,235,.16);"><a href="${imgPath}" target="_blank"><img src="${imgPath}" style="width:100%;height:100%;object-fit:cover;"></a></div>`;
                }).join('')}
            </div>`;
        } else {
            imgEl.innerHTML = '<p style="color:#66768c;font-size:.82rem;">Tiada gambar dilampirkan.</p>';
        }

        document.getElementById('detailModal').classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeModal() {
        const modal = document.getElementById('detailModal');
        if (modal) modal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    function renderAttachedSpec(specData) {
        const bodyEl = document.getElementById('d_spec_body');
        const badgeEl = document.getElementById('d_spec_status_badge');
        if (!bodyEl) return;

        let spec = null;
        if (typeof specData === 'string') {
            let cleanStr = specData.trim();
            if (cleanStr.includes('&quot;') || cleanStr.includes('&#039;') || cleanStr.includes('&amp;')) {
                const txt = document.createElement('textarea');
                txt.innerHTML = cleanStr;
                cleanStr = txt.value;
            }
            if (cleanStr.startsWith('{')) {
                try { spec = JSON.parse(cleanStr); } catch (e) { spec = null; }
            }
        } else if (typeof specData === 'object' && specData !== null) {
            spec = specData;
        }

        if (!spec) {
            if (badgeEl) {
                badgeEl.textContent = 'Tiada Lampiran';
                badgeEl.style.background = '#f1f5f9';
                badgeEl.style.color = '#64748b';
                badgeEl.style.border = '1px solid #cbd5e1';
            }
            bodyEl.innerHTML = `
                <div style="padding:0.7rem 0.9rem;color:#64748b;font-style:italic;font-size:0.82rem;background:#ffffff;border-radius:8px;border:1px dashed #cbd5e1;">
                    ℹ️ Tiada spesifikasi aset dilampirkan bagi aduan ini.
                </div>`;
            return;
        }

        if (badgeEl) {
            badgeEl.textContent = '✅ Spesifikasi Dilampirkan';
            badgeEl.style.background = 'rgba(16, 185, 129, 0.12)';
            badgeEl.style.color = '#059669';
            badgeEl.style.border = '1px solid rgba(16, 185, 129, 0.3)';
        }

        const items = [
            { label: 'Model Komputer / Peranti', val: spec.model_komputer },
            { label: 'No. Siri Pendaftaran', val: spec.no_siri_pendaftaran },
            { label: 'No. Siri Komputer (S/N)', val: spec.serial_number },
            { label: 'Model & No. Siri Monitor', val: spec.model_monitor ? `${spec.model_monitor} (${spec.serial_monitor || '-'})` : spec.serial_monitor },
            { label: 'Sistem Pengendalian (OS)', val: spec.os },
            { label: 'Pemproses (CPU)', val: spec.processor },
            { label: 'RAM', val: spec.ram },
            { label: 'Storan (Hard Disk/SSD)', val: spec.hard_disk },
            { label: 'Alamat IP', val: spec.ip_address },
            { label: 'Pencetak (Printer)', val: spec.printer },
            { label: 'Tetikus & Papan Kekunci', val: (spec.mouse || spec.keyboard) ? `${spec.mouse || '-'} / ${spec.keyboard || '-'}` : '' },
            { label: 'Perisian (Office & Antivirus)', val: (spec.ms_office || spec.antivirus) ? `${spec.ms_office ? 'Office ' + spec.ms_office : '-'} | ${spec.antivirus || '-'}` : '' },
            { label: 'Perisian Lain / Catatan', val: spec.perisian_lain || spec.maklumat_ict }
        ];

        const gridHtml = items
            .filter(it => it.val && it.val !== '-' && it.val !== '')
            .map(it => `
                <div style="background:#ffffff;padding:0.5rem 0.75rem;border-radius:8px;border:1px solid #e2e8f0;">
                    <div style="font-size:0.72rem;font-weight:600;color:#64748b;margin-bottom:0.15rem;">${it.label}</div>
                    <div style="font-size:0.83rem;font-weight:700;color:#0f172a;word-break:break-word;">${escapeHtml(it.val)}</div>
                </div>
            `).join('');

        bodyEl.innerHTML = `
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:0.55rem;">
                ${gridHtml || '<div style="color:#64748b;font-size:0.82rem;">Maklumat spesifikasi kosong.</div>'}
            </div>
        `;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
</script>

<?php include 'includes/footer.php'; ?>
