<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALKES SHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #00a8ff;
            --accent-color: #f8f9ff;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-opacity=".1"/><stop offset="100%" stop-opacity="0"/></radialGradient></defs><circle cx="10" cy="10" r="10" fill="url(%23a)"/><circle cx="30" cy="10" r="10" fill="url(%23a)"/><circle cx="50" cy="10" r="10" fill="url(%23a)"/><circle cx="70" cy="10" r="10" fill="url(%23a)"/><circle cx="90" cy="10" r="10" fill="url(%23a)"/></svg>') repeat;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        .login-container {
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 
                        0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .logo-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .logo-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-content {
            position: relative;
            z-index: 2;
        }

        .logo-img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            padding: 20px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .welcome-text {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 400;
        }

        .form-section {
            padding: 3rem;
            background: white;
        }

        .form-title {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .form-subtitle {
            color: var(--text-light);
            font-size: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.1rem;
            z-index: 3;
            transition: all 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.3);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1.5rem;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: var(--secondary-color);
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatUpDown 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 40px;
            height: 40px;
            top: 40%;
            left: 80%;
            animation-delay: 4s;
        }

        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            position: relative;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
            color: var(--success-color);
            border: 1px solid rgba(40, 167, 69, 0.2);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(231, 74, 59, 0.1));
            color: var(--danger-color);
            border: 1px solid rgba(220, 53, 69, 0.2);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.1);
        }

        .alert-dismissible .btn-close {
            position: absolute;
            top: 0.75rem;
            right: 1rem;
            padding: 0.25rem;
            color: inherit;
            opacity: 0.7;
            background: none;
            border: none;
            font-size: 1.2rem;
        }

        .alert-dismissible .btn-close:hover {
            opacity: 1;
        }

        .is-invalid {
            border-color: var(--danger-color) !important;
            animation: shake 0.5s ease-in-out;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 1rem;
                border-radius: 16px;
            }
            
            .logo-section {
                padding: 2rem 1rem;
            }
            
            .form-section {
                padding: 2rem;
            }
            
            .welcome-text {
                font-size: 1.5rem;
            }
            
            .form-title {
                font-size: 1.7rem;
            }

            .alert {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="login-container">
                    <div class="row g-0">
                        <!-- Logo Section -->
                        <div class="col-lg-5">
                            <div class="logo-section h-100 d-flex align-items-center">
                                <div class="logo-content w-100">
                                    <img src="/images/Logo_ALKES.png" alt="ALKES SHOP Logo" class="logo-img">
                                    <h1 class="welcome-text">Selamat datang di</h1>
                                    <h2 class="welcome-text mb-3">ALKES SHOP</h2>
                                    <p class="subtitle">Portal terpercaya untuk semua kebutuhan alat kesehatan Anda</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="col-lg-7">
                            <div class="form-section">
                                <h2 class="form-title">Masuk Akun</h2>
                                <p class="form-subtitle">Silakan masukkan kredensial Anda untuk melanjutkan</p>

                                <!-- Display Flash Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Registrasi Berhasil!</strong><br>
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Login Gagal!</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST" id="loginForm">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="position-relative">
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', session('registered_email')) }}"
                                                   placeholder="Masukkan email Anda"
                                                   required
                                                   autocomplete="email">
                                            <i class="fas fa-envelope input-icon"></i>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   placeholder="Masukkan password Anda"
                                                   required
                                                   autocomplete="current-password">
                                            <i class="fas fa-lock input-icon"></i>
                                            <button type="button" 
                                                    class="btn position-absolute end-0 top-50 translate-middle-y me-2 border-0 bg-transparent"
                                                    id="togglePassword"
                                                    tabindex="-1">
                                                <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-login" id="loginBtn">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Masuk Sekarang
                                    </button>
                                </form>

                                <div class="forgot-password">
                                    <a href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-1"></i>
                                        Lupa Password?
                                    </a>
                                </div>

                                <div class="register-link">
                                    <span class="text-muted">Belum punya akun? </span>
                                    <a href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i>
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Form Animation and Loading State
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginBtn');
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            button.disabled = true;
            
            // Re-enable button after 10 seconds as fallback (in case of network issues)
            setTimeout(function() {
                if (button.disabled) {
                    button.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang';
                    button.disabled = false;
                }
            }, 10000);
        });

        // Input Animation and Focus Effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.style.borderColor = 'var(--primary-color)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
                if (!this.matches(':focus')) {
                    this.style.borderColor = '';
                }
            });

            // Real-time validation feedback
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Auto-focus email field if it has value from session
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput.value) {
                // If email is pre-filled, focus on password field instead
                document.getElementById('password').focus();
                
                // Add a subtle highlight to show email is pre-filled
                emailInput.style.backgroundColor = 'rgba(40, 167, 69, 0.05)';
                emailInput.style.borderColor = 'var(--success-color)';
                
                setTimeout(function() {
                    emailInput.style.backgroundColor = '';
                    emailInput.style.borderColor = '';
                }, 3000);
            } else {
                emailInput.focus();
            }
        });

        // Enhanced Error Animation
        document.querySelectorAll('.is-invalid').forEach(input => {
            input.style.animation = 'shake 0.5s ease-in-out';
            
            // Remove animation after it completes
            setTimeout(() => {
                input.style.animation = '';
            }, 500);
        });

        // Auto-dismiss alerts after 8 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            // Don't auto-dismiss error alerts, only success ones
            if (alert.classList.contains('alert-success')) {
                setTimeout(() => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 8000);
            }
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + R to go to register
            if (e.altKey && e.key === 'r') {
                e.preventDefault();
                window.location.href = "{{ route('register') }}";
            }
            
            // Alt + F to focus on forgot password
            if (e.altKey && e.key === 'f') {
                e.preventDefault();
                document.querySelector('.forgot-password a').focus();
            }
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Show success message with animation if registration was successful
        <?php if(session('success')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                // Add extra emphasis for registration success
                successAlert.style.boxShadow = '0 8px 25px rgba(40, 167, 69, 0.2)';
                successAlert.style.transform = 'scale(1.02)';
                
                // Restore normal appearance after 2 seconds
                setTimeout(() => {
                    successAlert.style.boxShadow = '';
                    successAlert.style.transform = '';
                }, 2000);
            }
        });
        <?php endif; ?>

        // Add subtle hover effects to links
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });

        // Enhanced form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let isValid = true;

            // Reset previous validation states
            [email, password].forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Validate email
            if (!email.value || !email.validity.valid) {
                email.classList.add('is-invalid');
                isValid = false;
            }

            // Validate password
            if (!password.value || password.value.length < 6) {
                password.classList.add('is-invalid');
                isValid = false;
            }

            // If validation fails, prevent submission and restore button
            if (!isValid) {
                e.preventDefault();
                const button = document.getElementById('loginBtn');
                button.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang';
                button.disabled = false;
                
                // Focus first invalid field
                const firstInvalid = this.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });

        // Console log for debugging (remove in production)
        console.log('Login page loaded successfully');
        
        // Check if email was pre-filled from registration
        const preFilledEmail = "{{ session('registered_email') ?? '' }}";
        if (preFilledEmail) {
            console.log('Pre-filled email from registration:', preFilledEmail);
        }
    </script>
</body>
</html>