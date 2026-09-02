// assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Menyemak...';
            
            const formData = new FormData(loginForm);
            
            try {
                const response = await fetch('api/login.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    // Simpan data user ke dalam sessionStorage supaya dashboard tidak tendang keluar
                    sessionStorage.setItem('user', JSON.stringify(data.data));

                    // Redirect based on role
                    const role = data.data.role.toLowerCase();
                    if (role === 'super admin' || role === 'superadmin') {
                        window.location.href = 'superadmin/dashboard.html';
                    } else if (role === 'admin') {
                        window.location.href = 'admin/dashboard.html';
                    } else {
                        window.location.href = 'staff/dashboard.html';
                    }
                } else {
                    alert(data.message || 'Log Masuk gagal.');
                    btn.disabled = false;
                    btn.textContent = 'Log Masuk';
                }
            } catch (error) {
                console.error(error);
                alert('Ralat sistem. Sila pastikan pangkalan data dan pelayan disambung dengan betul.');
                btn.disabled = false;
                btn.textContent = 'Log Masuk';
            }
        });
    }
});
