// assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('ICT Careline Center - Premium Experience Loaded');

    // Simple observer for scroll animations if we add more sections later
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Login Form Handling
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Signing in...';

                const response = await fetch('api/login.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    localStorage.setItem('user', JSON.stringify(result.data));
                    alert(`Welcome back ${result.data.role} ${result.data.full_name}!`);
                    // Redirect based on role
                    if (result.data.role === 'Staff') {
                        window.location.replace('staff/dashboard.html');
                    } else {
                        window.location.replace('admin/dashboard.html');
                    }
                } else {
                    alert(result.message || 'Invalid credentials');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (err) {
                console.error('Login error:', err);
                alert('Connection error. Please check your server.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

    // Register Form Handling
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            const submitBtn = registerForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Registering...';

                const response = await fetch('api/register.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    alert('Registration successful! Redirecting to login...');
                    window.location.href = 'login.html';
                } else {
                    alert(result.message || 'Registration failed');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (err) {
                console.error('Registration error:', err);
                alert('Connection error. Please check your server.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});
