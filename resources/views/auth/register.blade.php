<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Daftar - ALKES SHOP' }}</title>
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
            --warning-color: #ffc107;
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
            padding: 2rem 0;
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

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(2deg);
            }
        }

        .register-container {
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

        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .logo-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem;
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
            background: conic-gradient(from 0deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .logo-content {
            position: relative;
            z-index: 2;
        }

        .logo-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            padding: 18px;
            margin-bottom: 1rem;
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
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            font-weight: 400;
        }

        .form-section {
            padding: 2.5rem;
            background: white;
        }

        .form-title {
            color: var(--text-dark);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .form-subtitle {
            color: var(--text-light);
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.8rem 0.8rem 0.8rem 3rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1rem;
            z-index: 3;
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-icon,
        .form-select:focus+.input-icon {
            color: var(--primary-color);
        }

        .password-toggle {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--text-light);
            font-size: 0.9rem;
            cursor: pointer;
            z-index: 4;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            border: none;
            border-radius: 10px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        }

        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary-color);
        }

        .terms-check {
            background: rgba(0, 102, 204, 0.05);
            border: 1px solid rgba(0, 102, 204, 0.2);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
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

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .is-invalid {
            border-color: var(--danger-color) !important;
            animation: shake 0.5s ease-in-out;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: block !important;
        }

        .is-valid {
            border-color: var(--success-color) !important;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-3px);
            }

            75% {
                transform: translateX(3px);
            }
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-dismissible .btn-close {
            position: absolute;
            top: 0.75rem;
            right: 1rem;
            padding: 0.25rem;
            color: inherit;
            opacity: 0.7;
        }

        .alert-dismissible .btn-close:hover {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .register-container {
                margin: 1rem;
                border-radius: 16px;
            }

            .logo-section {
                padding: 1.5rem 1rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .welcome-text {
                font-size: 1.3rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .alert {
                padding: 0.8rem 1rem;
                font-size: 0.85rem;
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
            <div class="col-lg-11 col-xl-10">
                <div class="register-container">
                    <div class="row g-0">
                        <!-- Logo Section -->
                        <div class="col-lg-4">
                            <div class="logo-section h-100 d-flex align-items-center">
                                <div class="logo-content w-100">
                                    <img src="/images/Logo_ALKES.png" alt="ALKES SHOP Logo" class="logo-img">
                                    <h1 class="welcome-text">Bergabung dengan</h1>
                                    <h2 class="welcome-text mb-3">ALKES SHOP</h2>
                                    <p class="subtitle">Daftar sekarang dan dapatkan akses ke ribuan produk alat kesehatan berkualitas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="col-lg-8">
                            <div class="form-section">
                                <h2 class="form-title">Buat Akun Baru</h2>
                                <p class="form-subtitle">Lengkapi form dibawah untuk membuat akun ALKES SHOP</p>

                                <!-- Display Flash Messages -->
                                @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Ada kesalahan dalam form:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                <form action="{{ route('register') }}" method="POST" id="registerForm">
                                    @csrf

                                    <!-- Nama dan Email -->
                                    <div class="form-row">
                                        <div class="form-group flex-fill">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <div class="position-relative">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name"
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                    placeholder="Masukkan nama lengkap"
                                                    required>
                                                <i class="fas fa-user input-icon"></i>
                                            </div>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group flex-fill">
                                            <label for="email" class="form-label">Email Address</label>
                                            <div class="position-relative">
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email"
                                                    name="email"
                                                    value="{{ old('email') }}"
                                                    placeholder="email@example.com"
                                                    required>
                                                <i class="fas fa-envelope input-icon"></i>
                                            </div>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-row">
                                        <div class="form-group flex-fill">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="position-relative">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password"
                                                    name="password"
                                                    placeholder="Minimal 6 karakter (huruf + angka)"
                                                    required>
                                                <i class="fas fa-lock input-icon"></i>
                                                <button type="button" class="password-toggle" data-target="password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Password harus minimal 6 karakter dengan kombinasi huruf dan angka</small>
                                        </div>

                                        <div class="form-group flex-fill">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <div class="position-relative">
                                                <input type="password"
                                                    class="form-control"
                                                    id="password_confirmation"
                                                    name="password_confirmation"
                                                    placeholder="Ulangi password"
                                                    required>
                                                <i class="fas fa-lock input-icon"></i>
                                                <button type="button" class="password-toggle" data-target="password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div id="password-match-error" class="invalid-feedback" style="display: none;">
                                                <!-- Password tidak cocok -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kontak dan Tanggal Lahir -->
                                    <div class="form-row">
                                        <div class="form-group flex-fill">
                                            <label for="kontak" class="form-label">Nomor Kontak</label>
                                            <div class="position-relative">
                                                <input type="text"
                                                    class="form-control @error('kontak') is-invalid @enderror"
                                                    id="kontak"
                                                    name="kontak"
                                                    value="{{ old('kontak') }}"
                                                    placeholder="08xxxxxxxxxx"
                                                    required>
                                                <i class="fas fa-phone input-icon"></i>
                                            </div>
                                            @error('kontak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group flex-fill">
                                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                            <div class="position-relative">
                                                <input type="date"
                                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                                    id="date_of_birth"
                                                    name="date_of_birth"
                                                    value="{{ old('date_of_birth') }}"
                                                    max="{{ date('Y-m-d') }}"
                                                    required>
                                                <i class="fas fa-calendar input-icon"></i>
                                            </div>
                                            @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Gender dan Kota -->
                                    <div class="form-row">
                                        <div class="form-group flex-fill">
                                            <label for="gender" class="form-label">Jenis Kelamin</label>
                                            <div class="position-relative">
                                                <select class="form-select @error('gender') is-invalid @enderror"
                                                    id="gender"
                                                    name="gender"
                                                    required>
                                                    <option value="">Pilih jenis kelamin</option>
                                                    <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                <i class="fas fa-venus-mars input-icon"></i>
                                            </div>
                                            @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group flex-fill">
                                            <label for="id_kota" class="form-label">Kota</label>
                                            <div class="position-relative">
                                                <select class="form-select @error('id_kota') is-invalid @enderror"
                                                    id="id_kota"
                                                    name="id_kota"
                                                    required>
                                                    <option value="">Pilih kota</option>
                                                    @if(isset($kotas) && $kotas->count() > 0)
                                                    @foreach($kotas as $kota)
                                                    <option value="{{ $kota->id_kota }}"
                                                        {{ old('id_kota') == $kota->id_kota ? 'selected' : '' }}>
                                                        {{ $kota->nama_kota }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option value="" disabled>Data kota tidak tersedia</option>
                                                    @endif
                                                </select>
                                                <i class="fas fa-map-marker-alt input-icon"></i>
                                            </div>
                                            @error('id_kota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="form-group">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <div class="position-relative">
                                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                id="alamat"
                                                name="alamat"
                                                rows="3"
                                                placeholder="Masukkan alamat lengkap"
                                                style="padding-left: 3rem;"
                                                required>{{ old('alamat') }}</textarea>
                                            <i class="fas fa-map-marker-alt input-icon" style="top: 1.2rem;"></i>
                                        </div>
                                        @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Terms & Conditions -->
                                    <div class="terms-check">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                                type="checkbox"
                                                name="terms"
                                                id="terms"
                                                {{ old('terms') ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="terms">
                                                Saya menyetujui <a href="#" class="text-primary">Syarat & Ketentuan</a>
                                                dan <a href="#" class="text-primary">Kebijakan Privasi</a> ALKES SHOP
                                            </label>
                                            @error('terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-register" id="submitBtn">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Buat Akun Sekarang
                                    </button>
                                </form>

                                <div class="login-link">
                                    <span class="text-muted">Sudah punya akun? </span>
                                    <a href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        Masuk Sekarang
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
        // Debug: Log form submission
        console.log('Register page loaded');

        // Toggle Password Visibility
        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetInput = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    targetInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password Confirmation Validation - FIXED
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('password-match-error');

        function validatePasswordMatch() {
            // Only show error if both fields have values and they don't match
            if (confirmPassword.value && password.value && password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Password tidak cocok');
                confirmPassword.classList.add('is-invalid');
                passwordMatchError.style.display = 'block';
            } else if (confirmPassword.value && password.value && password.value === confirmPassword.value) {
                // Passwords match - remove error
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
                confirmPassword.classList.add('is-valid');
                passwordMatchError.style.display = 'none';
            } else if (!confirmPassword.value) {
                // Field is empty - clear all validation states
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid', 'is-valid');
                passwordMatchError.style.display = 'none';
            }
        }

        password.addEventListener('input', validatePasswordMatch);
        confirmPassword.addEventListener('input', validatePasswordMatch);

        // Password Strength Indicator
        password.addEventListener('input', function() {
            const value = this.value;
            const hasLetter = /[a-zA-Z]/.test(value);
            const hasNumber = /\d/.test(value);
            const isLongEnough = value.length >= 6;

            if (value.length > 0) {
                if (hasLetter && hasNumber && isLongEnough) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        // Form Submission Handler
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            console.log('Form submission started');

            const button = document.getElementById('submitBtn');
            const formData = new FormData(this);

            // Debug: Log form data
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Disable button and show loading
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat Akun...';
            button.disabled = true;
        });

        // Input Animation
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Phone Number Formatting
        document.getElementById('kontak').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Auto-add 0 prefix for Indonesian numbers
            if (value.length > 0 && !value.startsWith('0')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                }
            }

            // Limit to reasonable phone number length
            if (value.length > 15) {
                value = value.substring(0, 15);
            }

            e.target.value = value;

            // Basic validation feedback
            if (value.length >= 10 && value.length <= 15 && value.startsWith('0')) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else if (value.length > 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        // Date of Birth Validation
        document.getElementById('date_of_birth').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            const age = today.getFullYear() - selectedDate.getFullYear();
            const monthDiff = today.getMonth() - selectedDate.getMonth();

            // More precise age calculation
            const actualAge = monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate()) ?
                age - 1 :
                age;

            if (actualAge < 13) {
                this.setCustomValidity('Usia minimal 13 tahun');
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (actualAge > 120) {
                this.setCustomValidity('Tanggal lahir tidak valid');
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        // Real-time validation feedback
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
            field.addEventListener('blur', function() {
                // Skip password confirmation as it has custom validation
                if (this.id === 'password_confirmation') {
                    return;
                }

                if (this.validity.valid && this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else if (!this.validity.valid || this.value.trim() === '') {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });

        // Name validation - only letters and spaces
        document.getElementById('name').addEventListener('input', function() {
            const value = this.value;
            const isValid = /^[a-zA-Z\s]*$/.test(value);

            if (!isValid && value.length > 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (value.length >= 2) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        // Email validation
        document.getElementById('email').addEventListener('input', function() {
            const value = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (value.length > 0) {
                if (emailRegex.test(value)) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if (alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 5000);
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Debug: Check if kotas data is available
        const kotaSelect = document.getElementById('id_kota');
        console.log('Kota options count:', kotaSelect.options.length - 1); // -1 for placeholder option

        if (kotaSelect.options.length <= 1) {
            console.error('No city data available - check database or controller');
        }

        // Form validation before submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });

            // Check password match
            if (password.value !== confirmPassword.value) {
                isValid = false;
                confirmPassword.classList.add('is-invalid');
            }

            if (!isValid) {
                e.preventDefault();
                console.log('Form validation failed');

                // Re-enable submit button
                const button = document.getElementById('submitBtn');
                button.innerHTML = '<i class="fas fa-user-plus me-2"></i>Buat Akun Sekarang';
                button.disabled = false;

                // Scroll to first error
                const firstError = this.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });
    </script>
</body>

</html>