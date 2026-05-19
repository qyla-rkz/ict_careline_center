/**
 * ICT Careline Center - Global Core Features Script
 * Handles:
 * 1. Premium Dark Theme Switcher & Persistence
 * 2. Inactivity Session Auto-Logout (15 mins)
 * 3. Dynamic Password Strength Meter
 */

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
    localStorage.clear();
    sessionStorage.clear();
    window.location.replace(loginPath);
}

// Premium Dark Theme Switcher & Persistence
function setupThemeToggle() {
    const isDark = localStorage.getItem('theme') === 'dark';
    if (isDark) {
        document.body.classList.add('dark-theme');
    }
    
    // Look for sidebar
    const sidebar = document.querySelector('.sidebar');
    
    const themeBtnHtml = `
        <button id="theme-toggle-btn" class="nav-link" style="background: none; border: none; cursor: pointer; width: 100%; text-align: left; display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1rem; border-radius: 12px; margin-top: 1rem; font-family: inherit; font-size: inherit; color: var(--text-muted); transition: var(--transition);">
            <span class="nav-icon" id="theme-toggle-icon" style="font-size: 1.25rem;">${isDark ? '☀️' : '🌙'}</span>
            <span id="theme-toggle-text" style="font-weight: 500;">${isDark ? 'Mod Terang' : 'Mod Gelap'}</span>
        </button>
    `;
    
    if (sidebar) {
        // Find logout container inside sidebar (usually at bottom)
        const logoutBtn = sidebar.querySelector('button[onclick*="handleLogout"], a[onclick*="handleLogout"], .nav-link[onclick*="handleLogout"]');
        if (logoutBtn) {
            logoutBtn.insertAdjacentHTML('beforebegin', themeBtnHtml);
        } else {
            // Find nav-links and append
            const navLinks = sidebar.querySelector('.nav-links');
            if (navLinks) {
                navLinks.insertAdjacentHTML('beforeend', themeBtnHtml);
            }
        }
    } else {
        // Floating Theme Button for landing/auth pages
        const floatingBtn = `
            <button id="theme-toggle-btn" style="position: fixed; bottom: 2rem; right: 2rem; width: 50px; height: 50px; border-radius: 50%; background: var(--bg-card); border: 1px solid var(--border); box-shadow: var(--shadow); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; z-index: 9999; transition: var(--transition);">
                ${isDark ? '☀️' : '🌙'}
            </button>
        `;
        document.body.insertAdjacentHTML('beforeend', floatingBtn);
    }
    
    // Add Event Listener
    const themeBtn = document.getElementById('theme-toggle-btn');
    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const body = document.body;
            body.classList.toggle('dark-theme');
            const isDarkNow = body.classList.contains('dark-theme');
            localStorage.setItem('theme', isDarkNow ? 'dark' : 'light');
            
            // Update icons/text
            const icon = document.getElementById('theme-toggle-icon');
            const text = document.getElementById('theme-toggle-text');
            const btnEl = document.getElementById('theme-toggle-btn');
            
            if (isDarkNow) {
                if (icon) icon.textContent = '☀️';
                if (text) text.textContent = 'Mod Terang';
                if (!sidebar && btnEl) btnEl.textContent = '☀️';
            } else {
                if (icon) icon.textContent = '🌙';
                if (text) text.textContent = 'Mod Gelap';
                if (!sidebar && btnEl) btnEl.textContent = '🌙';
            }
            
            // Trigger Chart.js themes if applicable
            if (window.updateChartsTheme) {
                window.updateChartsTheme(isDarkNow);
            }
        });
    }
}

// Password Strength Meter Implementation
function setupPasswordStrength() {
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
    if (!isStaffPage) return;

    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;

    const logoArea = sidebar.querySelector('.logo-area');
    if (!logoArea) return;

    // Check if user-profile already exists
    if (sidebar.querySelector('.user-profile')) return;

    // Get user info
    const userStr = localStorage.getItem('user');
    let staffName = 'Staf';
    if (userStr) {
        try {
            const user = JSON.parse(userStr);
            if (user && user.full_name) {
                staffName = user.full_name;
            }
        } catch (e) {
            console.error(e);
        }
    }

    const profileHtml = `
        <div class="user-profile" style="margin-top: -1rem; margin-bottom: -1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Selamat kembali,</p>
            <p id="sidebarStaffName" style="font-weight: 700; color: var(--primary); font-size: 1rem;">${staffName}</p>
        </div>
    `;

    logoArea.insertAdjacentHTML('afterend', profileHtml);
}

// Initialise everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    setupThemeToggle();
    initInactivityTimer();
    setupPasswordStrength();
    setupStaffSidebarProfile();
});
