/**
 * ICT Careline Center - Global Core Features Script
 * Handles:
 * 1. Premium Dark Theme Switcher & Persistence
 * 2. Inactivity Session Auto-Logout (15 mins)
 * 3. Dynamic Password Strength Meter
 */

// ─────────────────────────────────────────────────────────────
// Navigation Guard — validates against PHP server session
// This fires early to protect portal pages but uses the real
// server session (not just sessionStorage) so that F5 / refresh
// does NOT kick the user out.
// ─────────────────────────────────────────────────────────────
(function () {
    const path = window.location.pathname;
    const inSubdir = path.includes('/staff/') || path.includes('/admin/') || path.includes('/superadmin/');
    const isWelcomePage = path.endsWith('/') || path.endsWith('index.html') || path === '/';
    const isGuestPage = !inSubdir;

    function hidePortalUntilAuth() {
        document.documentElement.style.visibility = 'hidden';
    }

    function restorePortalVisibility() {
        document.documentElement.style.visibility = '';
    }

    if (inSubdir) {
        // ── Portal page: hide stale content and check server session ──
        hidePortalUntilAuth();
        const apiPath = '../api/check_session.php';

        fetch(apiPath, { cache: 'no-store', credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (result) {
                if (result.status === 'success') {
                    // Valid session — sync sessionStorage so page code has user data
                    const existing = sessionStorage.getItem('user');
                    if (!existing) {
                        // Restore sessionStorage from server session (handles refresh / new tab)
                        sessionStorage.setItem('user', JSON.stringify(result.data));
                    }
                    restorePortalVisibility();
                } else {
                    // No server session — clear any stale client data and redirect
                    sessionStorage.clear();
                    window.location.replace('../login.html');
                }
            })
            .catch(function () {
                // Network error: if no sessionStorage either, play it safe and redirect
                if (!sessionStorage.getItem('user')) {
                    window.location.replace('../login.html');
                } else {
                    restorePortalVisibility();
                }
            });

    } else if (!isWelcomePage) {
        // ── Guest auth page (login, register, select-portal) ──
        // If sessionStorage says logged in, verify with server then redirect to dashboard
        const userStr = sessionStorage.getItem('user');
        if (userStr) {
            fetch('./api/check_session.php', { cache: 'no-store' })
                .then(function (r) { return r.json(); })
                .then(function (result) {
                    if (result.status === 'success') {
                        const role = (result.data.role || '').toLowerCase();
                        if (role === 'staff') {
                            window.location.replace('staff/dashboard.html');
                        } else if (role === 'super admin' || role === 'superadmin') {
                            window.location.replace('superadmin/dashboard.html');
                        } else if (role === 'admin') {
                            window.location.replace('admin/dashboard.html');
                        }
                    } else {
                        // Server session expired — clear stale sessionStorage
                        sessionStorage.clear();
                    }
                })
                .catch(function () { /* network error, stay on page */ });
        }
    }
})();

// Handle back-forward cache (bfcache): re-check auth when browser restores a cached page
window.addEventListener('pageshow', function (event) {
    const path = window.location.pathname;
    const inSubdir = path.includes('/staff/') || path.includes('/admin/') || path.includes('/superadmin/');
    if (inSubdir) {
        document.documentElement.style.visibility = 'hidden';
        fetch('../api/check_session.php', { cache: 'no-store', credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (result) {
                if (result.status !== 'success') {
                    sessionStorage.clear();
                    window.location.replace('../login.html');
                } else {
                    // Refresh sessionStorage in case it was stale
                    sessionStorage.setItem('user', JSON.stringify(result.data));
                    document.documentElement.style.visibility = '';
                }
            })
            .catch(function () {
                // On network error, restore visibility only if we still have a cached session
                if (sessionStorage.getItem('user')) {
                    document.documentElement.style.visibility = '';
                } else {
                    window.location.replace('../login.html');
                }
            });
    }
});


// ─────────────────────────────────────────────────────────────
// Tab-Close Auto Logout removed because it interferes with F5 page reloads.
// Session cookies naturally expire when the browser is closed.
// ─────────────────────────────────────────────────────────────

// Inactivity Session Logic
let inactivityTimeout;
let warningTimeout;
const INACTIVE_LIMIT = 14 * 60 * 1000; // 14 minutes before warning
const COUNTDOWN_LIMIT = 60 * 1000;     // 60 seconds warning countdown
let countdownInterval;

function initInactivityTimer() {
    // Only apply inactivity timer on logged-in portal pages
    const isPortalPage = window.location.pathname.includes('/staff/') || 
                         window.location.pathname.includes('/admin/') || 
                         window.location.pathname.includes('/superadmin/');
    if (!isPortalPage) return;

    // Reset timer on user interactions
    const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
    events.forEach(event => {
        document.addEventListener(event, resetInactivityTimer, true);
    });

    startInactivityTimer();
}

function startInactivityTimer() {
    clearTimeout(inactivityTimeout);
    clearTimeout(warningTimeout);
    clearInterval(countdownInterval);

    inactivityTimeout = setTimeout(showInactivityWarning, INACTIVE_LIMIT);
}

function resetInactivityTimer() {
    // If the inactivity modal is visible, do not reset automatically from subtle mousemove
    const warningModal = document.getElementById('inactivity-modal');
    if (warningModal && warningModal.style.display === 'flex') return;

    startInactivityTimer();
}

function showInactivityWarning() {
    // If modal already exists, don't recreate
    if (document.getElementById('inactivity-modal')) {
        document.getElementById('inactivity-modal').style.display = 'flex';
        startCountdown(60);
        return;
    }
    
    const modalHtml = `
        <div id="inactivity-modal" class="modal" style="display: flex; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 99999;">
            <div class="modal-content" style="max-width: 420px; text-align: center; padding: 2.5rem; border-radius: 24px; background: var(--bg-card); border: 1px solid var(--border); box-shadow: var(--shadow);">
                <div style="font-size: 3.5rem; margin-bottom: 1.5rem; filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.4));">⚠️</div>
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Sesi Anda Hampir Tamat</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.6;">
                    Sistem mengesan tiada aktiviti daripada anda. Sesi anda akan ditamatkan secara automatik dalam masa 
                    <span id="inactivity-countdown" style="font-weight: 700; color: var(--danger); font-size: 1.25rem; display: inline-block; min-width: 2ch;">60</span> saat demi keselamatan.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <button id="inactivity-keep-alive" class="btn btn-primary" style="padding: 0.8rem 1.8rem; font-weight: 600; width: 100%; border-radius: 12px; cursor: pointer;">
                        Kekal Log Masuk
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Wire up keep alive button
    document.getElementById('inactivity-keep-alive').addEventListener('click', () => {
        hideInactivityModal();
        startInactivityTimer();
    });

    startCountdown(60);
}

function startCountdown(seconds) {
    let currentSeconds = seconds;
    const countdownEl = document.getElementById('inactivity-countdown');
    
    clearInterval(countdownInterval);
    countdownInterval = setInterval(() => {
        currentSeconds--;
        if (countdownEl) countdownEl.textContent = currentSeconds;
        
        if (currentSeconds <= 0) {
            clearInterval(countdownInterval);
            triggerGlobalLogout();
        }
    }, 1000);
}

function hideInactivityModal() {
    const modal = document.getElementById('inactivity-modal');
    if (modal) {
        modal.style.display = 'none';
    }
    clearInterval(countdownInterval);
}

async function triggerGlobalLogout() {
    const inSubdir = window.location.pathname.includes('/staff/') || 
                     window.location.pathname.includes('/admin/') || 
                     window.location.pathname.includes('/superadmin/');
    const apiPath = inSubdir ? '../api/logout.php' : './api/logout.php';
    const loginPath = inSubdir ? '../login.html' : './login.html';
    
    try {
        await fetch(apiPath);
    } catch (err) {
        console.error('Logout error:', err);
    }
    sessionStorage.clear();

    // Replace current history entry with login, then push a clean login entry
    // to remove any forward history that may still point back to the portal.
    window.location.replace(loginPath);
}

// Expose logout handlers globally so that they can be invoked from any page
window.handleLogout = triggerGlobalLogout;
window.logout = triggerGlobalLogout;


// Premium Dark Theme Switcher & Persistence (Disabled)
function setupThemeToggle() {
    sessionStorage.removeItem('theme');
    document.body.classList.remove('dark-theme');
}

// Password Strength Meter Implementation
function setupPasswordStrength() {
    // Do not show password strength meter on the login page
    if (document.getElementById('loginForm')) return;

    const passwordInput = document.querySelector('input[type="password"][name="password"], input[type="password"]#new_password, input[type="password"][name="new_password"]');
    if (!passwordInput) return;
    
    // Create the strength container
    const container = document.createElement('div');
    container.className = 'password-strength-container';
    container.innerHTML = `
        <div class="password-strength-bar">
            <div id="password-strength-fill" class="password-strength-fill"></div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.25rem;">
            <span id="password-strength-text" class="password-strength-text">Kekuatan Kata Laluan: Belum diisi</span>
        </div>
        <ul class="password-requirements" style="margin-top: 0.5rem; padding-left: 0; list-style: none;">
            <li id="req-length" style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.35rem;">❌ Sekurang-kurangnya 8 aksara</li>
            <li id="req-case" style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.35rem;">❌ Mengandungi huruf besar & kecil</li>
            <li id="req-number" style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.35rem;">❌ Mengandungi sekurang-kurangnya 1 nombor</li>
            <li id="req-special" style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.35rem;">❌ Mengandungi 1 simbol khas (e.g. @, #, $, !)</li>
        </ul>
    `;
    
    // Insert after password field
    passwordInput.parentNode.insertBefore(container, passwordInput.nextSibling);
    
    // Listen for input events
    passwordInput.addEventListener('input', () => {
        const val = passwordInput.value;
        
        const hasLength = val.length >= 8;
        const hasCase = /[a-z]/.test(val) && /[A-Z]/.test(val);
        const hasNumber = /\d/.test(val);
        const hasSpecial = /[^A-Za-z0-9]/.test(val);
        
        // Update requirements indicator
        updateRequirement('req-length', hasLength);
        updateRequirement('req-case', hasCase);
        updateRequirement('req-number', hasNumber);
        updateRequirement('req-special', hasSpecial);
        
        // Calculate score
        let score = 0;
        if (val.length > 0) {
            if (hasLength) score += 1;
            if (hasCase) score += 1;
            if (hasNumber) score += 1;
            if (hasSpecial) score += 1;
            if (val.length >= 12 && score === 4) score += 1; // Bonus score for length
        }
        
        // Update bar and text
        const fill = document.getElementById('password-strength-fill');
        const txt = document.getElementById('password-strength-text');
        
        if (val.length === 0) {
            fill.style.width = '0';
            fill.style.backgroundColor = 'transparent';
            txt.textContent = 'Kekuatan Kata Laluan: Belum diisi';
            txt.style.color = 'var(--text-muted)';
        } else if (score <= 1) {
            fill.style.width = '25%';
            fill.style.backgroundColor = 'var(--danger)';
            txt.textContent = 'Kekuatan Kata Laluan: Lemah 🔴';
            txt.style.color = 'var(--danger)';
        } else if (score <= 3) {
            fill.style.width = '60%';
            fill.style.backgroundColor = 'var(--warning)';
            txt.textContent = 'Kekuatan Kata Laluan: Sederhana 🟡';
            txt.style.color = 'var(--warning)';
        } else if (score === 4) {
            fill.style.width = '85%';
            fill.style.backgroundColor = '#22c55e'; // emerald green
            txt.textContent = 'Kekuatan Kata Laluan: Kuat 🟢';
            txt.style.color = '#22c55e';
        } else {
            fill.style.width = '100%';
            fill.style.backgroundColor = 'var(--success)';
            txt.textContent = 'Kekuatan Kata Laluan: Sangat Kuat 🔥';
            txt.style.color = 'var(--success)';
        }
    });
}

function updateRequirement(id, isValid) {
    const el = document.getElementById(id);
    if (!el) return;
    const text = el.textContent.substring(2); // Strip icon
    if (isValid) {
        el.innerHTML = `<span style="color: var(--success);">✔</span> ${text}`;
        el.style.color = 'var(--success)';
    } else {
        el.innerHTML = `<span style="color: var(--danger);">❌</span> ${text}`;
        el.style.color = 'var(--text-muted)';
    }
}

function setupStaffSidebarProfile() {
    const isStaffPage = window.location.pathname.includes('/staff/');
    const isAdminPage = window.location.pathname.includes('/admin/');
    const isSuperAdminPage = window.location.pathname.includes('/superadmin/');
    const isPortalPage = isStaffPage || isAdminPage || isSuperAdminPage;
    if (!isPortalPage) return;

    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;

    const logoArea = sidebar.querySelector('.logo-area');
    if (!logoArea) return;

    // Get user info from sessionStorage first (instant render)
    const userStr = sessionStorage.getItem('user');
    let staffName = 'Pengguna';
    let profilePic = '';
    if (userStr) {
        try {
            const user = JSON.parse(userStr);
            if (user) {
                if (user.full_name) staffName = user.full_name;
                else if (user.name) staffName = user.name;
                if (user.profile_picture) profilePic = user.profile_picture;
            }
        } catch (e) {}
    }

    // Helper to build avatar HTML
    function avatarHtml(pic, prefix) {
        if (pic) return `<img src="${prefix}${pic}" style="width:100%;height:100%;object-fit:cover;">`;
        return `<span style="font-size:2rem;">👤</span>`;
    }

    // 1. Sidebar Profile Section (Size: 80px)
    let userProfileEl = sidebar.querySelector('.user-profile');
    if (userProfileEl) {
        let avatarContainer = userProfileEl.querySelector('.sidebar-avatar-container');
        if (!avatarContainer) {
            // Get existing name element or dean element
            const existingNameEl = userProfileEl.querySelector('#sidebarStaffName, #sidebarAdminName, #sidebarSuperadminName');
            const nameHtml = existingNameEl ? existingNameEl.outerHTML : `<p style="font-weight: 700; color: var(--primary); font-size: 0.95rem; line-height: 1.2;">${staffName}</p>`;
            const deanHtml = '';

            userProfileEl.style.display = 'flex';
            userProfileEl.style.alignItems = 'center';
            userProfileEl.style.gap = '1rem';
            userProfileEl.style.paddingBottom = '1rem';
            userProfileEl.style.borderBottom = '1px solid var(--border)';
            userProfileEl.style.marginTop = '-1rem';
            userProfileEl.style.marginBottom = '-1rem';

            userProfileEl.innerHTML = `
                <div class="sidebar-avatar-container" style="width: 80px; height: 80px; border-radius: 50%; border: 2.5px solid var(--primary); overflow: hidden; display: flex; justify-content: center; align-items: center; background: #e2e8f0; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    ${avatarHtml(profilePic, '../')}
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0 0 0.15rem 0; padding: 0;">Selamat kembali,</p>
                    ${nameHtml}
                    ${deanHtml}
                </div>
            `;
        } else {
            avatarContainer.style.width = '80px';
            avatarContainer.style.height = '80px';
            avatarContainer.style.border = '2.5px solid var(--primary)';
            avatarContainer.innerHTML = avatarHtml(profilePic, '../');
        }
    } else {
        const profileHtml = `
            <div class="user-profile" style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem;">
                <div class="sidebar-avatar-container" style="width: 80px; height: 80px; border-radius: 50%; border: 2.5px solid var(--primary); overflow: hidden; display: flex; justify-content: center; align-items: center; background: #e2e8f0; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    ${avatarHtml(profilePic, '../')}
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0 0 0.15rem 0; padding: 0;">Selamat kembali,</p>
                    <p id="sidebarStaffName" style="font-weight: 700; color: var(--primary); font-size: 0.95rem; line-height: 1.2;">${staffName}</p>
                </div>
            </div>
        `;
        logoArea.insertAdjacentHTML('afterend', profileHtml);
    }

    // 2. Header Profile Section (Size: 70px, top right next to date)
    const currentDateEl = document.getElementById('current-date') || document.getElementById('adminDate') || document.getElementById('superadminDate');
    if (currentDateEl) {
        let picContainer = document.getElementById('header-profile-pic-container');
        if (!picContainer) {
            const parent = currentDateEl.parentNode;
            const container = document.createElement('div');
            container.style.cssText = 'display:flex;align-items:center;gap:1.25rem;';
            parent.insertBefore(container, currentDateEl);
            container.appendChild(currentDateEl);

            picContainer = document.createElement('div');
            picContainer.id = 'header-profile-pic-container';
            picContainer.style.cssText = 'width:70px;height:70px;border-radius:50%;border:2.5px solid var(--primary);overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.15);display:flex;justify-content:center;align-items:center;background:#e2e8f0;flex-shrink:0;';
            
            if (isStaffPage || isAdminPage || isSuperAdminPage) {
                picContainer.style.cursor = 'pointer';
                picContainer.title = 'Profil Saya';
                picContainer.onclick = () => { window.location.href = 'profile.html'; };
            }
            container.appendChild(picContainer);
        }
        picContainer.innerHTML = avatarHtml(profilePic, '../');
    }

    // 3. Fetch FRESH profile from API to update picture (solves stale sessionStorage issue)
    fetch('../api/staff_get_profile.php')
        .then(r => r.json())
        .then(result => {
            if (result.status !== 'success') return;
            const freshName = result.data.full_name || staffName;
            const freshPic  = result.data.profile_picture || '';

            // Update sidebar name
            const nameEl = document.getElementById('sidebarStaffName') || document.getElementById('sidebarAdminName') || document.getElementById('sidebarSuperadminName');
            if (nameEl) nameEl.textContent = freshName;

            // Update sidebar avatar
            const avatarEl = document.querySelector('.sidebar-avatar-container');
            if (avatarEl) avatarEl.innerHTML = avatarHtml(freshPic, '../');

            // Update header avatar
            const headerPic = document.getElementById('header-profile-pic-container');
            if (headerPic) headerPic.innerHTML = avatarHtml(freshPic, '../');

            // Sync sessionStorage
            try {
                const stored = JSON.parse(sessionStorage.getItem('user') || '{}');
                stored.full_name = freshName;
                stored.profile_picture = freshPic;
                sessionStorage.setItem('user', JSON.stringify(stored));
            } catch(e) {}
        })
        .catch(e => console.error('Profile fetch error:', e));
}

// (setupBackButtonBlock removed: the navigation guard IIFE above already
//  redirects logged-in users away from guest pages, making pushState loops
//  unnecessary. Using replace() in the guard also keeps history clean so
//  the back button works naturally after logout.)

function setupDashboardBackGuard() {
    const path = window.location.pathname.toLowerCase();
    const isDashboardPage = path.endsWith('/dashboard.html');
    if (!isDashboardPage) return;

    // Push a state so that when user hits back, we can intercept it
    if (window.history && window.history.pushState) {
        window.history.pushState({ dashboardGuard: true }, '', window.location.href);
    }

    window.addEventListener('popstate', function (event) {
        // When back is pressed, log out and redirect
        fetch('../api/logout.php').finally(() => {
            sessionStorage.clear();
            window.history.back();
        });
    });
}

// Initialise everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    setupThemeToggle();
    initInactivityTimer();
    setupPasswordStrength();
    setupStaffSidebarProfile();
    setupDashboardBackGuard();
});
