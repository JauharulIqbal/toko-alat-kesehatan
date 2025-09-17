<x-layouts.customer title="Edit Profil - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold text-primary mb-1">Edit Profil</h1>
                        <p class="text-muted mb-0">Perbarui informasi personal Anda</p>
                    </div>
                    <a href="{{ route('customer.profil.show') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('customer.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Profile Information -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-person-circle me-2"></i>Informasi Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label fw-semibold">Nomor HP</label>
                                    <input type="tel" class="form-control @error('no_hp') is-invalid @enderror"
                                        id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                        id="alamat" name="alamat" rows="3"
                                        placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Photo & Security -->
                <div class="col-lg-4">
                    <!-- Profile Photo -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-image me-2"></i>Foto Profil
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if($user->foto)
                                <img src="{{ asset('storage/users/' . $user->foto) }}"
                                    class="rounded-circle mb-3" width="120" height="120"
                                    alt="Current Profile Photo" id="currentPhoto">
                                @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 120px; height: 120px; font-size: 3rem; font-weight: bold;" id="currentPhoto">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                @endif
                            </div>

                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted d-block mt-2">
                                Format: JPG, PNG, JPEG. Maksimal 2MB
                            </small>
                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Ubah Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="changePassword">
                                <label class="form-check-label" for="changePassword">
                                    Saya ingin mengubah password
                                </label>
                            </div>

                            <div id="passwordFields" style="display: none;">
                                <!-- Current Password -->
                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-semibold">
                                        Password Saat Ini
                                    </label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password">
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        Password Baru
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" class="form-control"
                                        id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('customer.profil.show') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Toggle password fields
        document.getElementById('changePassword').addEventListener('change', function() {
            const passwordFields = document.getElementById('passwordFields');
            const passwordInputs = passwordFields.querySelectorAll('input');

            if (this.checked) {
                passwordFields.style.display = 'block';
                passwordInputs.forEach(input => input.required = true);
            } else {
                passwordFields.style.display = 'none';
                passwordInputs.forEach(input => {
                    input.required = false;
                    input.value = '';
                });
            }
        });

        // Preview uploaded image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentPhoto = document.getElementById('currentPhoto');
                    currentPhoto.innerHTML = `<img src="${e.target.result}" class="rounded-circle" width="120" height="120" alt="Preview">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const changePassword = document.getElementById('changePassword').checked;

            if (changePassword) {
                const currentPassword = document.getElementById('current_password').value;
                const newPassword = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (!currentPassword) {
                    e.preventDefault();
                    showToast('Password saat ini harus diisi', 'error');
                    return;
                }

                if (newPassword.length < 8) {
                    e.preventDefault();
                    showToast('Password baru minimal 8 karakter', 'error');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    showToast('Konfirmasi password tidak sesuai', 'error');
                    return;
                }
            }
        });

        function showToast(message, type = 'info') {
            if (!document.getElementById('toastContainer')) {
                document.body.insertAdjacentHTML('beforeend', `
                    <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
                `);
            }

            const toastId = 'toast_' + Date.now();
            const bgClass = type === 'success' ? 'bg-success' :
                type === 'error' ? 'bg-danger' :
                type === 'warning' ? 'bg-warning' : 'bg-info';

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `toast ${bgClass} text-white`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="toast-body">
                    ${message}
                    <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast"></button>
                </div>
            `;

            document.getElementById('toastContainer').appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    </script>
    @endpush
</x-layouts.customer>