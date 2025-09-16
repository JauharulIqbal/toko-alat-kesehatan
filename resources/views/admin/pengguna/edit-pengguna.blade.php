<x-layouts.admin title="Edit Pengguna">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Pengguna</h2>
            <p class="text-muted mb-0">Perbarui data penjual dan customer</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button type="button" class="btn btn-outline-info" onclick="viewHistory()">
                <i class="bi bi-clock-history me-2"></i>Riwayat
            </button>
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
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Pengguna</h5>
                    <span class="badge bg-dark">ID: {{ $pengguna->id_user }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengguna.update', $pengguna->id_user) }}" method="POST" id="penggunaForm">
                        @csrf
                        @method('PUT')

                        {{-- Nama Pengguna --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $pengguna->name) }}"
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
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $pengguna->email) }}"
                                        placeholder="Masukkan alamat email"
                                        required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    @if($pengguna->email_verified_at)
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge bg-success">
                                            <i class="bi bi-patch-check-fill me-1"></i>Terverifikasi
                                        </span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Belum Verifikasi
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">
                                Role Pengguna <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-select @error('role') is-invalid @enderror"
                                        id="role"
                                        name="role"
                                        required>
                                        <option value="">Pilih Role</option>
                                        <option value="penjual" {{ old('role', $pengguna->role) == 'penjual' ? 'selected' : '' }}>
                                            Penjual
                                        </option>
                                        <option value="customer" {{ old('role', $pengguna->role) == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    @php
                                    $currentRoleClass = $pengguna->role === 'penjual' ? 'bg-primary' : 'bg-success';
                                    @endphp
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge {{ $currentRoleClass }}">
                                            Role Saat Ini: {{ ucfirst($pengguna->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-semibold">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki" {{ old('gender', $pengguna->gender) == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="perempuan" {{ old('gender', $pengguna->gender) == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    @php
                                    $currentGenderClass = $pengguna->gender === 'laki-laki' ? 'bg-info' : 'bg-warning';
                                    $currentGenderIcon = $pengguna->gender === 'laki-laki' ? 'gender-male' : 'gender-female';
                                    @endphp
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge {{ $currentGenderClass }} bg-opacity-20 text-dark">
                                            <i class="bi bi-{{ $currentGenderIcon }} me-1"></i>{{ ucfirst($pengguna->gender) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kontak --}}
                        <div class="mb-3">
                            <label for="kontak" class="form-label fw-semibold">Nomor Kontak</label>
                            <input type="text"
                                class="form-control @error('kontak') is-invalid @enderror"
                                id="kontak"
                                name="kontak"
                                value="{{ old('kontak', $pengguna->kontak) }}"
                                placeholder="Masukkan nomor kontak (opsional)"
                                maxlength="20">
                            @error('kontak')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: 081234567890 (maksimal 20 karakter)</div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date"
                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                id="date_of_birth"
                                name="date_of_birth"
                                value="{{ old('date_of_birth', $pengguna->date_of_birth ? (method_exists($pengguna->date_of_birth, 'format') ? $pengguna->date_of_birth->format('Y-m-d') : $pengguna->date_of_birth) : '') }}"
                                max="{{ date('Y-m-d', strtotime('-1 day')) }}">
                            @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Tanggal lahir harus sebelum hari ini</div>
                        </div>

                        {{-- Kota --}}
                        <div class="mb-3">
                            <label for="id_kota" class="form-label fw-semibold">Kota</label>
                            <select class="form-select @error('id_kota') is-invalid @enderror"
                                id="id_kota"
                                name="id_kota">
                                <option value="">Pilih Kota</option>
                                @foreach($kota as $kotaItem)
                                <option value="{{ $kotaItem->id_kota }}" {{ old('id_kota', $pengguna->id_kota) == $kotaItem->id_kota ? 'selected' : '' }}>
                                    {{ $kotaItem->nama_kota }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pengguna->kota)
                            <div class="form-text">Kota saat ini: <strong>{{ $pengguna->kota->nama_kota }}</strong></div>
                            @endif
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                rows="3"
                                placeholder="Masukkan alamat lengkap (opsional)">{{ old('alamat', $pengguna->alamat) }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                                minlength="8">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password</div>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password baru">
                            <div class="form-text">Harus sama dengan password baru</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            {{-- Current Info Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Terdaftar:</div>
                            <div class="col-7">{{ $pengguna->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $pengguna->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Role:</div>
                            <div class="col-7">
                                <span class="badge {{ $currentRoleClass }}">{{ ucfirst($pengguna->role) }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Gender:</div>
                            <div class="col-7">
                                <span class="badge {{ $currentGenderClass }} bg-opacity-20 text-dark">
                                    <i class="bi bi-{{ $currentGenderIcon }} me-1"></i>{{ ucfirst($pengguna->gender) }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status Email:</div>
                            <div class="col-7">
                                @if($pengguna->email_verified_at)
                                <span class="badge bg-success">Terverifikasi</span>
                                @else
                                <span class="badge bg-warning">Belum Verifikasi</span>
                                @endif
                            </div>
                        </div>
                        @if($pengguna->kota)
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Kota:</div>
                            <div class="col-7">{{ $pengguna->kota->nama_kota }}</div>
                        </div>
                        @endif
                        @if($pengguna->date_of_birth)
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Umur:</div>
                            <div class="col-7">
                                @php
                                try {
                                $birthDate = $pengguna->date_of_birth;
                                if (method_exists($birthDate, 'age')) {
                                echo $birthDate->age . ' tahun';
                                } else {
                                // Fallback calculation
                                $birth = is_string($birthDate) ? strtotime($birthDate) : (is_object($birthDate) ? $birthDate->timestamp : $birthDate);
                                $age = floor((time() - $birth) / (365.25 * 24 * 60 * 60));
                                echo $age . ' tahun';
                                }
                                } catch (Exception $e) {
                                echo '-';
                                }
                                @endphp
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Preview Changes Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Perubahan</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-person-gear" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Preview akan update saat mengubah form</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$pengguna->email_verified_at)
                        <button type="button" class="btn btn-success btn-sm" onclick="verifyEmail()">
                            <i class="bi bi-check-circle me-2"></i>Verifikasi Email
                        </button>
                        @endif
                        <button type="button" class="btn btn-info btn-sm" onclick="viewPengguna('{{ $pengguna->id_user }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="resetPassword()">
                            <i class="bi bi-key me-2"></i>Reset Password
                        </button>
                        @if($pengguna->role === 'penjual')
                        <button type="button" class="btn btn-primary btn-sm" onclick="viewToko()">
                            <i class="bi bi-shop me-2"></i>Lihat Toko
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal History --}}
    <div class="modal fade" id="historyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-clock-history me-2"></i>Riwayat Perubahan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pengguna Terdaftar</h6>
                                <p class="text-muted mb-1">{{ $pengguna->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Pengguna pertama kali mendaftar</small>
                            </div>
                        </div>
                        @if($pengguna->email_verified_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Email Terverifikasi</h6>
                                <p class="text-muted mb-1">{{ $pengguna->email_verified_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Email berhasil diverifikasi</small>
                            </div>
                        </div>
                        @endif
                        @if($pengguna->updated_at != $pengguna->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Terakhir Diperbarui</h6>
                                <p class="text-muted mb-1">{{ $pengguna->updated_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Data pengguna diperbarui</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Store original values
        const originalValues = {
            name: '{{ $pengguna->name }}',
            email: '{{ $pengguna->email }}',
            role: '{{ $pengguna->role }}',
            gender: '{{ $pengguna->gender }}',
            kontak: '{{ $pengguna->kontak ?? '
            ' }}',
            date_of_birth: '{{ $pengguna->date_of_birth ? (method_exists($pengguna->date_of_birth, '
            format ') ? $pengguna->date_of_birth->format('
            Y - m - d ') : $pengguna->date_of_birth) : '
            ' }}',
            id_kota: '{{ $pengguna->id_kota ?? '
            ' }}',
            alamat: '{{ $pengguna->alamat ?? '
            ' }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
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
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');

            // Update preview function
            function updatePreview() {
                const nameValue = name.value || 'Nama Pengguna';
                const emailValue = email.value || 'email@example.com';
                const roleValue = role.value || 'customer';
                const genderValue = gender.value || 'laki-laki';
                const kontakValue = kontak.value || '-';
                const kotaValue = idKota.options[idKota.selectedIndex]?.text || '-';
                const alamatValue = alamat.value || 'Tidak ada alamat';
                const birthValue = dateOfBirth.value ? (() => {
                    try {
                        return new Date(dateOfBirth.value).toLocaleDateString('id-ID');
                    } catch (e) {
                        return dateOfBirth.value;
                    }
                })() : '-';

                const roleClass = roleValue === 'penjual' ? 'primary' : 'success';
                const genderClass = genderValue === 'laki-laki' ? 'info' : 'warning';
                const genderIcon = genderValue === 'laki-laki' ? 'gender-male' : 'gender-female';

                // Check for changes
                const hasChanges = nameValue !== originalValues.name ||
                    emailValue !== originalValues.email ||
                    roleValue !== originalValues.role ||
                    genderValue !== originalValues.gender ||
                    kontakValue !== originalValues.kontak ||
                    dateOfBirth.value !== originalValues.date_of_birth ||
                    idKota.value !== originalValues.id_kota ||
                    alamatValue !== originalValues.alamat ||
                    password.value.length > 0;

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-${roleClass} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-${genderIcon} text-${roleClass}"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nameValue}${changesBadge}</h6>
                            <div class="mt-1">
                                <span class="badge bg-${roleClass}">${roleValue.charAt(0).toUpperCase() + roleValue.slice(1)}</span>
                                <span class="badge bg-${genderClass} bg-opacity-20 text-dark ms-1">
                                    <i class="bi bi-${genderIcon} me-1"></i>${genderValue.charAt(0).toUpperCase()}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Email:</div>
                            <div class="col-8">${emailValue}</div>
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
                            <div class="col-4 text-muted">Lahir:</div>
                            <div class="col-8">${birthValue}</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted mb-1">Alamat:</div>
                            <div class="text-muted small">${alamatValue.substring(0, 80)}${alamatValue.length > 80 ? '...' : ''}</div>
                        </div>
                        ${password.value.length > 0 ? '<div class="alert alert-warning mt-3 py-2"><small><i class="bi bi-key me-1"></i>Password akan diubah</small></div>' : ''}
                        ${hasChanges ? '<div class="alert alert-info mt-3 py-2"><small><i class="bi bi-info-circle me-1"></i>Form memiliki perubahan yang belum disimpan</small></div>' : ''}
                    </div>
                `;

                // Update submit button
                if (hasChanges) {
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Perubahan';
                } else {
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Pengguna';
                }
            }

            // Add event listeners for real-time preview
            [name, email, role, gender, kontak, dateOfBirth, idKota, alamat, password].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Password confirmation validation
            passwordConfirmation.addEventListener('input', function() {
                if (password.value !== this.value && this.value.length > 0) {
                    this.setCustomValidity('Password tidak cocok');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });

            password.addEventListener('input', function() {
                if (passwordConfirmation.value.length > 0) {
                    passwordConfirmation.dispatchEvent(new Event('input'));
                }
            });

            // Initial preview update
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memperbarui...';

                setTimeout(() => {
                    submitBtn.disabled = false;
                    updatePreview();
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

            name.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Reset to original values
        function resetToOriginal() {
            if (confirm('Yakin ingin mereset semua perubahan ke nilai asli?')) {
                document.getElementById('name').value = originalValues.name;
                document.getElementById('email').value = originalValues.email;
                document.getElementById('role').value = originalValues.role;
                document.getElementById('gender').value = originalValues.gender;
                document.getElementById('kontak').value = originalValues.kontak;
                document.getElementById('date_of_birth').value = originalValues.date_of_birth;
                document.getElementById('id_kota').value = originalValues.id_kota;
                document.getElementById('alamat').value = originalValues.alamat;
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';

                // Trigger preview update
                document.getElementById('name').dispatchEvent(new Event('input'));
            }
        }

        // Quick actions
        function verifyEmail() {
            if (confirm('Yakin ingin memverifikasi email pengguna ini?')) {
                // Add AJAX call to verify email
                fetch(`/admin/pengguna/{{ $pengguna->id_user }}/verify-email`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Gagal memverifikasi email');
                        }
                    })
                    .catch(() => {
                        alert('Terjadi kesalahan');
                    });
            }
        }

        function resetPassword() {
            if (confirm('Yakin ingin mereset password pengguna ini? Password baru akan dikirim ke email pengguna.')) {
                // Focus on password field
                document.getElementById('password').focus();
                alert('Silakan isi password baru pada form atau hubungi pengguna untuk reset password via email.');
            }
        }

        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        function viewPengguna(id) {
            // Similar to view-pengguna.blade.php
            window.open(`/admin/pengguna/${id}`, '_blank');
        }

        function viewToko() {
            @if($pengguna - > role === 'penjual' && $pengguna - > tokos - > count() > 0)
            const tokoId = '{{ $pengguna->tokos->first()->id_toko ?? '
            ' }}';
            if (tokoId) {
                window.open(`/admin/toko/${tokoId}`, '_blank');
            } else {
                alert('Pengguna belum memiliki toko');
            }
            @else
            alert('Pengguna bukan penjual atau belum memiliki toko');
            @endif
        }

        // Auto-resize textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const hasChanges = document.getElementById('name').value !== originalValues.name ||
                document.getElementById('email').value !== originalValues.email ||
                document.getElementById('role').value !== originalValues.role ||
                document.getElementById('gender').value !== originalValues.gender ||
                document.getElementById('kontak').value !== originalValues.kontak ||
                document.getElementById('date_of_birth').value !== originalValues.date_of_birth ||
                document.getElementById('id_kota').value !== originalValues.id_kota ||
                document.getElementById('alamat').value !== originalValues.alamat ||
                document.getElementById('password').value.length > 0;

            if (hasChanges) {
                e.preventDefault();
                e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Email validation
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.length > 0 && !emailRegex.test(email)) {
                this.setCustomValidity('Format email tidak valid');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });

        // Phone number formatting
        document.getElementById('kontak').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, ''); // Remove non-digits

            // Limit to 20 characters
            if (value.length > 20) {
                value = value.substring(0, 20);
            }

            this.value = value;
        });

        // Age calculation and validation
        document.getElementById('date_of_birth').addEventListener('change', function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            const age = Math.floor((today - birthDate) / (365.25 * 24 * 60 * 60 * 1000));

            if (age < 13) {
                this.setCustomValidity('Umur minimal 13 tahun');
                this.classList.add('is-invalid');
            } else if (age > 100) {
                this.setCustomValidity('Umur maksimal 100 tahun');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
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
            min-height: 300px;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Timeline styles */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }

        .timeline-content {
            padding-left: 1rem;
        }

        .timeline-content h6 {
            margin-bottom: 0.5rem;
            color: #495057;
        }

        /* Animation for changes */
        .badge.bg-warning {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 0.25rem;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
        }

        .password-weak {
            background-color: #dc3545;
            width: 25%;
        }

        .password-fair {
            background-color: #fd7e14;
            width: 50%;
        }

        .password-good {
            background-color: #ffc107;
            width: 75%;
        }

        .password-strong {
            background-color: #198754;
            width: 100%;
        }

        /* Form validation styles */
        .was-validated .form-control:valid,
        .form-control.is-valid {
            border-color: #198754;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.79-.79L4.8 4.2 7.54 1.46l.79.79-4.8 4.8z'/%3e%3c/svg%3e");
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 5.8 2.4 2.4m-2.4 0 2.4-2.4'/%3e%3c/svg%3e");
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-lg-4 {
                margin-top: 2rem;
            }

            #previewCard {
                min-height: 200px;
            }
        }
    </style>
</x-layouts.admin>