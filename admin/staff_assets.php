<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Assets - eICT Desk</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dept-filter-opt {
            transition: all 0.2s ease;
        }
        .dept-filter-opt:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary) !important;
        }
    </style>
    <script src="../assets/js/global.js?v=10"></script>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <img src="../assets/images/logo-mpm.png" alt="MPM Logo" class="logo-image">
                <h2>eICT Desk</h2>
            </div>
            <div class="user-profile" style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Selamat kembali,</p>
                <p id="sidebarAdminName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">Admin</p>
            </div>
            <nav class="nav-links">
                <a href="dashboard.php" class="nav-link">📊 Papan Pemuka</a>
                <a href="profile.php" class="nav-link">👤 Profil Saya</a>
                <a href="report_management.php" class="nav-link">📝 Pengurusan Laporan</a>
                <a href="inventory.php" class="nav-link">🖥️ Inventori Aset</a>
                <a href="staff_assets.php" class="nav-link active">👥 Aset Staf</a>
                <a href="history_reports.php" class="nav-link">📜 Log Sejarah</a>
            </nav>
            <div style="margin-top: auto;">
                <a href="javascript:void(0)" onclick="handleLogout()" class="nav-link" style="color: var(--danger);">🚪 Log Keluar</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 1rem;">
                <div>
                    <p style="color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">Admin Portal</p>
                    <h2 style="font-size: 1.8rem; color: var(--text-main);">Aset Staf</h2>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div id="current-date"
                        style="background: rgba(255,255,255,0.9); padding: 0.6rem 1.25rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-weight: 600; color: var(--text-main); backdrop-filter: blur(10px); font-size: 0.9rem;">
                        <script>document.currentScript.parentElement.textContent = new Date().toLocaleDateString('ms-MY', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });</script>
                    </div>
                </div>
            </header>

            <div class="card" style="margin-bottom: 1.5rem; position: relative; z-index: 100; overflow: visible !important;">
                <div style="display: flex; gap: 1rem; align-items: flex-end; padding: 0.5rem;">
                    <div class="form-group" style="margin-bottom: 0; flex: 2;">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Carian Aset</label>
                        <input type="text" id="filterSearch" class="form-control" placeholder="Cari Nama atau ID Aset..." oninput="handleSearch()">
                    </div>
                    <div class="form-group" style="margin-bottom: 0; flex: 1; position: relative;">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Pilih Jabatan</label>
                        <input type="hidden" id="filterDept" value="">
                        <div id="customDeptSelect" class="form-control" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                            <span id="deptDisplay">Semua Jabatan</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">▼</span>
                        </div>
                        <div id="deptDropdownOptions" style="display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); z-index: 1000; max-height: 180px; overflow-y: auto; margin-top: 5px; font-size: 0.9rem;">
                            <div class="dept-filter-opt" data-value="" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Semua Jabatan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Bangunan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Bangunan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kejuruteraan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kejuruteraan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kesihatan dan Pelesenan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kesihatan dan Pelesenan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Kewangan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Kewangan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Khidmat Pengurusan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Khidmat Pengurusan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Komunikasi Koprat dan Kemasyarakatan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Komunikasi Koprat dan Kemasyarakatan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Penguatkuasaan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Penguatkuasaan</div>
                            <div class="dept-filter-opt" data-value="Jabatan Penilaian dan Pengurusan Harta" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Penilaian dan Pengurusan Harta</div>
                            <div class="dept-filter-opt" data-value="Jabatan Perancangan dan Pembangunan Landskap" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Jabatan Perancangan dan Pembangunan Landskap</div>
                            <div class="dept-filter-opt" data-value="Kaunter Hasil" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Kaunter Hasil</div>
                            <div class="dept-filter-opt" data-value="Pejabat Setiausaha" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Pejabat Setiausaha</div>
                            <div class="dept-filter-opt" data-value="Pejabat YDP" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Pejabat YDP</div>
                            <div class="dept-filter-opt" data-value="Unit Audit Dalaman" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Audit Dalaman</div>
                            <div class="dept-filter-opt" data-value="Unit Perolehan dan Pengurusan Kontrak" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Perolehan dan Pengurusan Kontrak</div>
                            <div class="dept-filter-opt" data-value="Unit Persuruhjaya Bangunan" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Persuruhjaya Bangunan</div>
                            <div class="dept-filter-opt" data-value="Unit Pusat Setempat" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Pusat Setempat</div>
                            <div class="dept-filter-opt" data-value="Unit Teknologi Maklumat" style="padding: 0.6rem 1rem; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.03);">Unit Teknologi Maklumat</div>
                            <div class="dept-filter-opt" data-value="Unit Undang-Undang" style="padding: 0.6rem 1rem; cursor: pointer;">Unit Undang-Undang</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="table-container">
                    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                        <thead>
                            <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid var(--border);">
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">ID Aset</th>
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Pemilik</th>
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Jabatan</th>
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Jenis</th>
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Jenama/Model</th>
                                <th style="padding: 1rem; width: 14.28%; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Sejarah Laporan</th>
                                <th style="padding: 1rem; width: 14.28%; text-align: center; font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="assetTableBody">
                            <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">⏳ Memuatkan data...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">Menunjukkan 0 hingga 0 daripada 0 entri</div>
                    <div class="pagination-controls">
                        <button onclick="prevPage()" id="prevBtn" class="pagination-btn" disabled>Sebelumnya</button>
                        <button onclick="nextPage()" id="nextBtn" class="pagination-btn">Seterusnya</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="assetModal" class="modal">
        <div class="modal-content" style="max-width: 900px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 id="modalTitle">Butiran Aset</h2>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <div id="assetDetailsContent">
                <!-- Loaded via JS -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const user = JSON.parse(sessionStorage.getItem('user'));
            if (user && user.full_name) {
                document.getElementById('sidebarAdminName').textContent = user.full_name;
            }
            
            // Custom Dropdown Logic
            const customDeptSelect = document.getElementById('customDeptSelect');
            const deptDropdownOptions = document.getElementById('deptDropdownOptions');
            const deptDisplay = document.getElementById('deptDisplay');
            const filterDeptInput = document.getElementById('filterDept');

            customDeptSelect.addEventListener('click', (e) => {
                e.stopPropagation();
                const isVisible = deptDropdownOptions.style.display === 'block';
                deptDropdownOptions.style.display = isVisible ? 'none' : 'block';
            });

            deptDropdownOptions.addEventListener('click', (e) => {
                const opt = e.target.closest('.dept-filter-opt');
                if (opt) {
                    const val = opt.getAttribute('data-value');
                    const text = opt.textContent;
                    filterDeptInput.value = val;
                    deptDisplay.textContent = text;
                    deptDropdownOptions.style.display = 'none';
                    handleSearch(); // trigger filtering
                }
            });

            document.addEventListener('click', () => {
                deptDropdownOptions.style.display = 'none';
            });

            fetchAssets();
        });

        let currentPage = 1;
        const itemsPerPage = 10;
        let allAssets = [];
        let filteredAssets = [];

        async function fetchAssets() {
            const tbody = document.getElementById('assetTableBody');
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">⏳ Memuatkan data...</td></tr>';
            try {
                const response = await fetch('../api/admin/admin_get_assets.php?_t=' + new Date().getTime());
                const rawText = await response.text();
                console.log('[DEBUG] Raw response dari admin_get_assets.php:', rawText);
                let result;
                try {
                    result = JSON.parse(rawText);
                } catch(parseErr) {
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:red;">❌ Ralat parsing JSON:<br><pre style="text-align:left;font-size:0.75rem;">${rawText.substring(0, 500)}</pre></td></tr>`;
                    return;
                }
                if (result.status === 'success') {
                    allAssets = result.data || [];
                    filteredAssets = [...allAssets];
                    if (allAssets.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">📭 Tiada aset staf didaftarkan lagi.</td></tr>';
                        updatePagination(0);
                    } else {
                        renderAssets();
                    }
                } else {
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:red;">❌ ${result.message || 'Ralat tidak diketahui'}</td></tr>`;
                    console.error('[DEBUG] API returned error:', result);
                }
            } catch (err) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:2rem;color:red;">❌ Fetch gagal: ${err.message}</td></tr>`;
                console.error('[DEBUG] Fetch error:', err);
            }
        }

        function handleSearch() {
            const searchTerm = document.getElementById('filterSearch').value.toLowerCase();
            const selectedDept = document.getElementById('filterDept').value;
            
            filteredAssets = allAssets.filter(a => {
                const nameMatch = (a.name || '').toLowerCase().includes(searchTerm);
                const idMatch = (a.serial_number || '').toLowerCase().includes(searchTerm);
                const searchMatch = nameMatch || idMatch;
                
                const deptMatch = !selectedDept || a.department === selectedDept;
                
                return searchMatch && deptMatch;
            });
            currentPage = 1;
            renderAssets();
        }

        function renderAssets() {
            const tbody = document.getElementById('assetTableBody');
            
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = filteredAssets.slice(start, end);

            if (!filteredAssets.length) {
                tbody.innerHTML = '<tr><td colspan="7" style="padding:2rem;text-align:center;color:var(--text-muted)">Tiada rekod ditemui.</td></tr>';
                updatePagination(0);
                return;
            }
            
            tbody.innerHTML = pageItems.map(a => `
                <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s ease;">
                    <td style="padding: 1rem; vertical-align: middle; font-weight: 600; color: var(--text-main); font-size: 0.9rem; word-break: break-all;">${a.serial_number || 'N/A'}</td>
                    <td style="padding: 1rem; vertical-align: middle; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">${a.name}</td>
                    <td style="padding: 1rem; vertical-align: middle; font-size: 0.9rem; color: var(--text-muted); line-height: 1.4; word-wrap: break-word; overflow-wrap: break-word;">${a.department || '-'}</td>
                    <td style="padding: 1rem; vertical-align: middle; font-size: 0.9rem; color: var(--text-main);">${a.asset_type}</td>
                    <td style="padding: 1rem; vertical-align: middle; font-size: 0.9rem; color: var(--text-main);">${a.model_komputer || '-'}</td>
                    <td style="padding: 1rem; vertical-align: middle;">
                        <button class="btn btn-secondary" title="Jumlah laporan oleh staf" style="padding: 0.35rem 0.6rem; font-size:0.75rem; border-radius:6px;" data-user-id="${a.user_id || ''}" data-user-name="${(a.name||'').replace(/\"/g, '&quot;')}" onclick="viewUserHistoryFromBtn(this)">
                         (${a.total_report_count || 0})
                        </button>
                    </td>
                    <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                        <button onclick='viewAssetDetails(${JSON.stringify(a).replace(/'/g, "&#39;")})' 
                                class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; border-radius: 6px; font-weight: 600; min-width: 80px;">
                            🔍 Butiran
                        </button>
                    </td>
                </tr>
            `).join('');

            updatePagination(filteredAssets.length);
        }

        function updatePagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('paginationInfo').textContent = totalItems > 0 
                ? `Menunjukkan ${start} hingga ${end} daripada ${totalItems} entri`
                : `Menunjukkan 0 hingga 0 daripada 0 entri`;

            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
        }

        function nextPage() {
            currentPage++;
            renderAssets();
            document.querySelector('.table-container').scrollTop = 0;
        }

        function prevPage() {
            currentPage--;
            renderAssets();
            document.querySelector('.table-container').scrollTop = 0;
        }

        function viewAssetDetails(a) {
            const content = document.getElementById('assetDetailsContent');
            
            let imagesHtml = '<p class="text-muted">Tiada gambar dimuat naik</p>';
            if (a.images && a.images.length > 0) {
                imagesHtml = `
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        ${a.images.map(img => `
                            <div style="aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 1px solid var(--border);">
                                <img src="../${img.image_path}" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            content.innerHTML = `
                <form id="editAssetForm" onsubmit="saveAssetDetails(event)">
                    <input type="hidden" name="id" value="${a.id}">
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--border);">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label style="font-size:0.75rem; color:var(--text-muted); display:block; margin-bottom:0.25rem;">Nama Pemilik</label>
                                <div style="font-weight:600;">${a.name || '-'}</div>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; color:var(--text-muted); display:block; margin-bottom:0.25rem;">Jawatan</label>
                                <div style="font-weight:600;">${a.jawatan || '-'}</div>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size:0.75rem; color:var(--text-muted); display:block; margin-bottom:0.25rem;">Bahagian / Unit</label>
                                <div style="font-weight:600;">${a.department || '-'}</div>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                        ${renderInputRow('Model Komputer', 'model_komputer', a.model_komputer)}
                        ${renderInputRow('No. Siri', 'serial_number', a.serial_number)}
                        ${renderInputRow('Model Monitor', 'model_monitor', a.model_monitor)}
                        ${renderInputRow('No. Siri Monitor', 'serial_monitor', a.serial_monitor)}
                        ${renderInputRow('OS', 'os', a.os)}
                        ${renderInputRow('Pemproses', 'processor', a.processor)}
                        ${renderInputRow('RAM', 'ram', a.ram)}
                        ${renderInputRow('Cakera Keras', 'hard_disk', a.hard_disk)}
                        ${renderInputRow('Tetikus', 'mouse', a.mouse)}
                        ${renderInputRow('Papan Kekunci', 'keyboard', a.keyboard)}
                        ${renderInputRow('MS Office', 'ms_office', a.ms_office)}
                        ${renderInputRow('Antivirus', 'antivirus', a.antivirus)}
                        ${renderInputRow('Alamat IP', 'ip_address', a.ip_address)}
                        ${renderInputRow('Pencetak', 'printer', a.printer)}
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="font-weight:700; display:block; margin-bottom:0.5rem; color:var(--primary);">PERISIAN LAIN</label>
                        <textarea name="perisian_lain" class="form-control" rows="3" style="width: 100%;">${a.perisian_lain || ''}</textarea>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="font-weight:700; display:block; margin-bottom:1rem; color:var(--primary);">GAMBAR LAMPIRAN</label>
                        ${imagesHtml}
                        <div style="margin-top: 1rem;">
                            <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-main);">Muat Naik Gambar Baru (Maksimum 3 keping, Pilihan)</label>
                            <div style="border: 2px dashed var(--border); padding: 1.5rem; border-radius: 12px; text-align: center; background: #fafafa; transition: all 0.3s ease; position: relative; margin-top: 0.5rem;">
                                <input type="file" name="images[]" id="asset_images" multiple accept="image/*" 
                                       style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" onchange="handleImagePreview(event)">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">📸</div>
                                <p style="font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem; font-size: 0.9rem;">Klik atau seret gambar untuk memuat naik</p>
                                <p class="text-muted" style="font-size: 0.8rem;">Jika gambar baru dimuat naik, gambar lama akan digantikan.</p>
                            </div>
                            <div id="image-preview-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 1rem; margin-top: 1rem;"></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveAssetBtn">💾 Simpan Perubahan</button>
                    </div>
                </form>
            `;
            document.getElementById('assetModal').style.display = 'flex';
        }

        function viewUserHistoryFromBtn(btn) {
            const userId = btn.getAttribute('data-user-id');
            const userName = btn.getAttribute('data-user-name') || 'Staf';
            if (!userId) {
                alert('ID pengguna tidak tersedia untuk melihat sejarah.');
                return;
            }
            viewUserHistory(userId, userName);
        }

        async function viewUserHistory(userId, userName) {
            const content = document.getElementById('assetDetailsContent');
            document.getElementById('modalTitle').textContent = `Sejarah Laporan - ${userName}`;
            content.innerHTML = '<p style="padding:1rem; color:var(--text-muted);">⏳ Memuatkan sejarah...</p>';
            document.getElementById('assetModal').style.display = 'flex';
            try {
                const res = await fetch(`../api/admin/admin_get_reports.php?user_id=${encodeURIComponent(userId)}`);
                const result = await res.json();
                if (result.status !== 'success') {
                    content.innerHTML = `<p style="padding:1rem;color:red;">Ralat: ${result.message || 'Gagal memuatkan sejarah.'}</p>`;
                    return;
                }
                const reports = result.data || [];
                if (!reports.length) {
                    content.innerHTML = '<p style="padding:1rem;color:var(--text-muted);">Tiada laporan ditemui untuk staf ini.</p>';
                    return;
                }

                content.innerHTML = `
                    <div style="display:flex;flex-direction:column;gap:1rem;padding:0.5rem;">
                        ${reports.map(r => `
                            <div style="border:1px solid var(--border); padding:1rem; border-radius:8px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                                    <div style="font-weight:700;">${r.nama_pelapor || r.full_name || '-'}</div>
                                    <div style="font-size:0.8rem; color:var(--text-muted);">${new Date(r.created_at).toLocaleString()}</div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.5rem; font-size: 0.9rem;">
                                    <div><strong>Jenis Aset:</strong> ${r.jenis_aset || '-'}</div>
                                    <div><strong>No. Siri Pendaftaran:</strong> ${r.nombor_siri || '-'}</div>
                                    <div><strong>Tarikh Kerosakan:</strong> ${r.tarikh_kerosakan ? new Date(r.tarikh_kerosakan).toLocaleDateString('ms-MY') : '-'}</div>
                                    <div><strong>Keputusan:</strong> ${r.keputusan || r.status || '-'}</div>
                                    <div><strong>Tarikh Aduan:</strong> ${r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '-'}</div>
                                    <div><strong>Tarikh Siap:</strong> ${(r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected' || r.keputusan === 'Syor Dilupuskan') && r.admin_tarikh ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY') : '-'}</div>
                                    <div style="grid-column: 1 / -1;"><strong>Pematuhan ISO:</strong> ${(() => {
                                        const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected' || r.keputusan === 'Syor Dilupuskan';
                                        if (!isCompleted || !r.admin_tarikh) return '<span style="color: var(--text-muted);">—</span>';
                                        const start = new Date(r.created_at);
                                        const end = new Date(r.admin_tarikh);
                                        start.setHours(0,0,0,0);
                                        end.setHours(0,0,0,0);
                                        const days = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24));
                                        const pass = days <= 14;
                                        return \`<span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: \${pass ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)'}; color: \${pass ? '#059669' : '#dc2626'}; border: 1px solid \${pass ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)'};">\${pass ? '✅' : '⚠️'} \${days} hari</span>\`;
                                    })()}</div>
                                </div>
                                <div style="margin-bottom:0.5rem; font-size: 0.9rem;"><strong>Perihal Kerosakan:</strong> <span style="color:var(--text-main);">${r.perihal_kerosakan || r.perihal || '-'}</span></div>
                                ${r.images && r.images.length ? `
                                    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap:0.5rem; margin-top:0.5rem;">
                                        ${r.images.map(img => `<div style="aspect-ratio:1; overflow:hidden; border-radius:6px; border:1px solid var(--border);"><img src="../${img.image_path}" style="width:100%; height:100%; object-fit:cover;"></div>`).join('')}
                                    </div>
                                ` : ''}
                                <div style="margin-top:0.5rem; text-align:right;"><button onclick='showReportDetails(${JSON.stringify(r).replace(/'/g, "&#39;")})' class="btn btn-primary" style="padding:0.35rem 0.6rem; font-size:0.8rem;">Lihat Butiran</button></div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } catch (err) {
                content.innerHTML = `<p style="padding:1rem;color:red;">Ralat teknikal: ${err.message}</p>`;
            }
        }

        function showReportDetails(r) {
            const content = document.getElementById('assetDetailsContent');
            document.getElementById('modalTitle').textContent = `Butiran Laporan #${r.id}`;
            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
            const adminTarikh = (isCompleted && r.admin_tarikh) ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY') : (r.admin_tarikh || 'Belum Diproses');

            content.innerHTML = `
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div style="background:#f8fafc;padding:1rem;border-radius:8px;border:1px solid var(--border);">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <div style="font-weight:700;">${r.nama_pelapor || r.full_name || '-'}</div>
                            <div style="font-size:0.9rem;color:var(--text-muted);">${new Date(r.created_at).toLocaleString()}</div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                            <div><strong>Jenis Aset</strong><div>${r.jenis_aset || '-'}</div></div>
                            <div><strong>No. Siri</strong><div>${r.nombor_siri || '-'}</div></div>
                            <div><strong>Pengguna Terakhir</strong><div>${r.pengguna_terakhir || '-'}</div></div>
                            <div><strong>Tarikh Kerosakan</strong><div>${r.tarikh_kerosakan || '-'}</div></div>
                            <div style="grid-column: span 2;"><strong>Perihal Kerosakan</strong><div style="color:var(--text-main);">${r.perihal_kerosakan || '-'}</div></div>
                            <div><strong>Lokasi</strong><div>${r.location || '-'}</div></div>
                            <div><strong>Status/Keputusan</strong><div>${r.keputusan || r.status || '-'}</div></div>
                        </div>
                    </div>

                    <div style="background:#fff;padding:1rem;border-radius:8px;border:1px solid var(--border);">
                        <h4 style="margin:0 0 0.5rem 0;color:var(--primary);">Bahagian II & III</h4>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                            <div><strong>Kos Dahulu (RM)</strong><div>${r.kos_penyelenggaraan_dahulu || '0.00'}</div></div>
                            <div><strong>Anggaran Kos (RM)</strong><div>${r.anggaran_kos || '0.00'}</div></div>
                            <div style="grid-column: span 2;"><strong>Syor / Ulasan</strong><div>${r.syor_ulasan || '-'}</div></div>
                            <div><strong>Pegawai Teknikal</strong><div>${r.admin_name_jawatan || r.admin_jawatan || '-'}</div></div>
                            <div><strong>Tarikh Siap</strong><div>${adminTarikh}</div></div>
                            <div><strong>Keputusan Nama</strong><div>${r.keputusan_nama || '-'}</div></div>
                            <div><strong>Tarikh Keputusan</strong><div>${r.keputusan_tarikh || '-'}</div></div>
                        </div>
                    </div>

                    ${r.images && r.images.length ? `
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:0.5rem;">
                            ${r.images.map(img => `<div style="aspect-ratio:1;overflow:hidden;border-radius:6px;border:1px solid var(--border);"><img src="../${img.image_path}" style="width:100%;height:100%;object-fit:cover;"></div>`).join('')}
                        </div>
                    ` : ''}

                    <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                        <button class="btn btn-secondary" onclick="viewUserHistory(${r.user_id || ''}, '${(r.full_name||r.nama_pelapor||'Staf').replace(/'/g,'\\\\\\'')}')">Kembali</button>
                        <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
                    </div>
                </div>
            `;
        }

        function handleImagePreview(e) {
            const grid = document.getElementById('image-preview-grid');
            grid.innerHTML = '';
            const files = e.target.files;
            
            if (files.length > 3) {
                alert('Anda hanya boleh memuat naik maksimum 3 gambar.');
                e.target.value = '';
                return;
            }

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const div = document.createElement('div');
                    div.style.cssText = 'position:relative; aspect-ratio:1; border-radius:8px; overflow:hidden; border:1px solid var(--border);';
                    div.innerHTML = `
                        <img src="${event.target.result}" style="width:100%; height:100%; object-fit:cover;">
                        <div style="position:absolute; top:4px; right:4px; background:rgba(0,0,0,0.5); color:#fff; width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; cursor:pointer;" onclick="this.parentElement.remove()">×</div>
                    `;
                    grid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function renderInputRow(label, name, value) {
            return `
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 0.25rem;">${label}</label>
                    <input type="text" name="${name}" class="form-control" value="${(value || '').replace(/"/g, '&quot;')}" style="font-weight: 500;">
                </div>
            `;
        }

        async function saveAssetDetails(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const btn = document.getElementById('saveAssetBtn');
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';

            try {
                const res = await fetch("../api/admin/admin_update_asset.php", {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                if (result.status === 'success') {
                    alert('Maklumat aset berjaya dikemaskini.');
                    closeModal();
                    fetchAssets(); // Refresh table
                } else {
                    alert('Ralat: ' + result.message);
                }
            } catch (err) {
                console.error(err);
                alert('Ralat teknikal semasa menyimpan.');
            } finally {
                btn.disabled = false;
                btn.textContent = '💾 Simpan Perubahan';
            }
        }

        function closeModal() {
            document.getElementById('assetModal').style.display = 'none';
        }


    </script>
</body>
</html>

