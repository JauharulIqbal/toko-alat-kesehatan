<x-layouts.admin title="Tambah Pengguna">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Pengguna Baru</h2>
            <p class="text-muted mb-0">Tambahkan data penjual atau customer baru</p>
        </div>
        <div>
            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Informasi Pengguna</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengguna.store') }}" method="POST" id="penggunaForm">
                        @csrf
                        
                        {{-- Nama Pengguna --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Pengguna <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap"
                                   maxlength="50"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 50 karakter</div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan alamat email"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password"
                                           minlength="8"
                                           required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="password-icon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Minimal 8 karakter</div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi password"
                                           required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Role dan Gender --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role" class="form-label fw-semibold">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>
                                        Penjual
                                    </option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                                        Customer
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label fw-semibold">
                                    Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender" 
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kontak dan Tanggal Lahir --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kontak" class="form-label fw-semibold">Nomor Kontak</label>
                                <input type="text" 
                                       class="form-control @error('kontak') is-invalid @enderror" 
                                       id="kontak" 
                                       name="kontak" 
                                       value="{{ old('kontak') }}" 
                                       placeholder="Masukkan nomor HP/telepon"
                                       maxlength="20">
                                @error('kontak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth') }}" 
                                       max="{{ date('Y-m-d') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kota --}}
                        <div class="mb-3">
                            <label for="id_kota" class="form-label fw-semibold">Kota</label>
                            <select class="form-select @error('id_kota') is-invalid @enderror" 
                                    id="id_kota" 
                                    name="id_kota">
                                <option value="">Pilih Kota</option>
                                @foreach($kota as $kotaItem)
                                    <option value="{{ $kotaItem->id_kota }}" {{ old('id_kota') == $kotaItem->id_kota ? 'selected' : '' }}>
                                        {{ $kotaItem->nama_kota }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap (opsional)">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Petunjuk Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Data Wajib</h6>
                            <ul class="text-muted ps-3 mb-0">
                                <li>Nama pengguna (maks. 50 karakter)</li>
                                <li>Email (harus valid dan unik)</li>
                                <li>Password (minimal 8 karakter)</li>
                                <li>Role (Penjual atau Customer)</li>
                                <li>Jenis kelamin</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Data Opsional</h6>
                            <ul class="text-muted ps-3 mb-0">
                                <li>Nomor kontak</li>
                                <li>Tanggal lahir</li>
                                <li>Kota</li>
                                <li>Alamat lengkap</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Perbedaan Role</h6>
                            <p class="text-muted mb-2"><strong>Penjual:</strong> Dapat mengelola toko dan produk</p>
                            <p class="text-muted mb-0"><strong>Customer:</strong> Dapat melakukan pembelian</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Pengguna</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-person" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Preview akan muncul saat mengisi form</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const form = document.getElementById('penggunaForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            
            // Form inputs
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const role = document.getElementById('role');
            const gender = document.getElementById('gender');
            const kontak = document.getElementById('kontak');
            const dateOfBirth = document.getElementById('date_of_birth');
            const idKota = document.getElementById('id_kota');
            const alamat = document.getElementById('alamat');

            // Update preview function
            function updatePreview() {
                const nameValue = name.value || 'Nama Pengguna';
                const emailValue = email.value || 'email@example.com';
                const roleValue = role.value || 'customer';
                const genderValue = gender.value || 'laki-laki';
                const kontakValue = kontak.value || '-';
                const kotaValue = idKota.options[idKota.selectedIndex]?.text || '-';
                const alamatValue = alamat.value || '-';

                const roleClass = roleValue === 'penjual' ? 'primary' : 'success';
                const genderClass = genderValue === 'laki-laki' ? 'info' : 'warning';
                const genderIcon = genderValue === 'laki-laki' ? 'gender-male' : 'gender-female';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-${roleClass} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-${roleClass}"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nameValue}</h6>
                            <small class="text-muted">${emailValue}</small>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Role:</div>
                            <div class="col-8">
                                <span class="badge bg-${roleClass}">${roleValue.charAt(0).toUpperCase() + roleValue.slice(1)}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Gender:</div>
                            <div class="col-8">
                                <span class="badge bg-${genderClass} bg-opacity-20 text-${genderClass}">
                                    <i class="bi bi-${genderIcon} me-1"></i>${genderValue.charAt(0).toUpperCase() + genderValue.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Kontak:</div>
                            <div class="col-8">${kontakValue}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Kota:</div>
                            <div class="col-8">${kotaValue}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Alamat:</div>
                            <div class="col-8">${alamatValue.substring(0, 25)}${alamatValue.length > 25 ? '...' : ''}</div>
                        </div>
                    </div>
                `;
            }

            // Add event listeners for real-time preview
            [name, email, role, gender, kontak, dateOfBirth, idKota, alamat].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Initial preview update
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Pengguna';
                }, 5000);
            });

            // Character counter for name
            const nameCounter = document.createElement('div');
            nameCounter.className = 'form-text text-end';
            nameCounter.id = 'nameCounter';
            name.parentNode.appendChild(nameCounter);

            name.addEventListener('input', function() {
                const remaining = 50 - this.value.length;
                nameCounter.textContent = `${this.value.length}/50 karakter`;
                nameCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Initial counter update
            name.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Reset form confirmation
            const resetBtn = form.querySelector('button[type="reset"]');
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Yakin ingin mereset semua data yang sudah diisi?')) {
                    form.reset();
                    updatePreview();
                    name.dispatchEvent(new Event('input'));
                }
            });

            // Password strength indicator
            const password = document.getElementById('password');
            const strengthIndicator = document.createElement('div');
            strengthIndicator.className = 'form-text';
            strengthIndicator.id = 'passwordStrength';
            password.parentNode.parentNode.appendChild(strengthIndicator);

            password.addEventListener('input', function() {
                const value = this.value;
                let strength = 0;
                let feedback = [];

                if (value.length >= 8) strength++;
                else feedback.push('minimal 8 karakter');

                if (/[a-z]/.test(value)) strength++;
                else feedback.push('huruf kecil');

                if (/[A-Z]/.test(value)) strength++;
                else feedback.push('huruf besar');

                if (/[0-9]/.test(value)) strength++;
                else feedback.push('angka');

                if (/[^A-Za-z0-9]/.test(value)) strength++;

                let strengthText = '';
                let strengthClass = '';

                switch (strength) {
                    case 0:
                    case 1:
                        strengthText = 'Lemah';
                        strengthClass = 'text-danger';
                        break;
                    case 2:
                    case 3:
                        strengthText = 'Sedang';
                        strengthClass = 'text-warning';
                        break;
                    case 4:
                    case 5:
                        strengthText = 'Kuat';
                        strengthClass = 'text-success';
                        break;
                }

                if (value.length > 0) {
                    strengthIndicator.innerHTML = `Kekuatan password: <span class="${strengthClass}">${strengthText}</span>`;
                    if (feedback.length > 0) {
                        strengthIndicator.innerHTML += ` (perlu: ${feedback.join(', ')})`;
                    }
                } else {
                    strengthIndicator.innerHTML = '';
                }
            });
        });

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Auto-resize textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            if (this.value) {
                // Simple email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                    if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'Format email tidak valid';
                        this.parentNode.appendChild(feedback);
                    }
                } else {
                    this.classList.remove('is-invalid');
                    const feedback = this.parentNode.querySelector('.invalid-feedback');
                    if (feedback) feedback.remove();
                }
            }
        });

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value && this.value !== password) {
                this.classList.add('is-invalid');
                if (!this.parentNode.nextElementSibling || !this.parentNode.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Konfirmasi password tidak cocok';
                    this.parentNode.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent === 'Konfirmasi password tidak cocok') {
                    feedback.remove();
                }
            }
        });
    </script>
    @endpush

    <style>
        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-weight: 500;
        }

        .btn {
            font-weight: 500;
            border-radius: 0.375rem;
        }

        .btn:disabled {
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        #previewCard {
            min-height: 200px;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .input-group .btn {
            border-left: 0;
        }

        .input-group .form-control:focus + .btn {
            border-color: #0d6efd;
        }
    </style>
</x-layouts.admin>