<x-layouts.admin title="Tambah Toko">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Toko Baru</h2>
            <p class="text-muted mb-0">Tambahkan data toko alat kesehatan baru</p>
        </div>
        <div>
            <a href="{{ route('admin.toko.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-shop me-2"></i>Informasi Toko</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.toko.store') }}" method="POST" id="tokoForm">
                        @csrf
                        
                        {{-- Nama Toko --}}
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label fw-semibold">
                                Nama Toko <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_toko') is-invalid @enderror" 
                                   id="nama_toko" 
                                   name="nama_toko" 
                                   value="{{ old('nama_toko') }}" 
                                   placeholder="Masukkan nama toko"
                                   maxlength="100"
                                   required>
                            @error('nama_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter</div>
                        </div>

                        {{-- Status Toko --}}
                        <div class="mb-3">
                            <label for="status_toko" class="form-label fw-semibold">
                                Status Toko <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status_toko') is-invalid @enderror" 
                                    id="status_toko" 
                                    name="status_toko" 
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="menunggu" {{ old('status_toko') == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu
                                </option>
                                <option value="disetujui" {{ old('status_toko') == 'disetujui' ? 'selected' : '' }}>
                                    Disetujui
                                </option>
                                <option value="ditolak" {{ old('status_toko') == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                            @error('status_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pemilik Toko --}}
                        <div class="mb-3">
                            <label for="id_user" class="form-label fw-semibold">Pemilik Toko</label>
                            <select class="form-select @error('id_user') is-invalid @enderror" 
                                    id="id_user" 
                                    name="id_user">
                                <option value="">Pilih Pemilik</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                        {{-- Alamat Toko --}}
                        <div class="mb-3">
                            <label for="alamat_toko" class="form-label fw-semibold">Alamat Toko</label>
                            <textarea class="form-control @error('alamat_toko') is-invalid @enderror" 
                                      id="alamat_toko" 
                                      name="alamat_toko" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap toko">{{ old('alamat_toko') }}</textarea>
                            @error('alamat_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi Toko --}}
                        <div class="mb-4">
                            <label for="deskripsi_toko" class="form-label fw-semibold">Deskripsi Toko</label>
                            <textarea class="form-control @error('deskripsi_toko') is-invalid @enderror" 
                                      id="deskripsi_toko" 
                                      name="deskripsi_toko" 
                                      rows="4" 
                                      placeholder="Masukkan deskripsi toko (opsional)">{{ old('deskripsi_toko') }}</textarea>
                            @error('deskripsi_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Deskripsi singkat tentang toko</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.toko.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Toko
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
                            <h6 class="text-primary mb-2">Nama Toko</h6>
                            <p class="text-muted mb-0">Masukkan nama toko yang jelas dan mudah diingat. Maksimal 100 karakter.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Status Toko</h6>
                            <ul class="text-muted ps-3 mb-0">
                                <li><strong>Menunggu:</strong> Toko baru menunggu persetujuan</li>
                                <li><strong>Disetujui:</strong> Toko telah disetujui dan aktif</li>
                                <li><strong>Ditolak:</strong> Toko ditolak dengan alasan tertentu</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Pemilik & Lokasi</h6>
                            <p class="text-muted mb-0">Pilih pemilik toko dan kota lokasi toko berada. Field ini opsional.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Toko</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-shop" style="font-size: 3rem;"></i>
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
            const form = document.getElementById('tokoForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            
            // Form inputs
            const namaToko = document.getElementById('nama_toko');
            const statusToko = document.getElementById('status_toko');
            const idUser = document.getElementById('id_user');
            const idKota = document.getElementById('id_kota');
            const alamatToko = document.getElementById('alamat_toko');
            const deskripsiToko = document.getElementById('deskripsi_toko');

            // Update preview function
            function updatePreview() {
                const nama = namaToko.value || 'Nama Toko';
                const status = statusToko.value || 'menunggu';
                const pemilik = idUser.options[idUser.selectedIndex]?.text.split(' (')[0] || '-';
                const kota = idKota.options[idKota.selectedIndex]?.text || '-';
                const alamat = alamatToko.value || '-';
                const deskripsi = deskripsiToko.value || 'Tidak ada deskripsi';

                const statusClass = status === 'disetujui' ? 'success' : 
                                  status === 'ditolak' ? 'danger' : 'warning';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-shop text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}</h6>
                            <span class="badge bg-${statusClass} mt-1">${status.charAt(0).toUpperCase() + status.slice(1)}</span>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Pemilik:</div>
                            <div class="col-8">${pemilik}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Kota:</div>
                            <div class="col-8">${kota}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Alamat:</div>
                            <div class="col-8">${alamat.substring(0, 30)}${alamat.length > 30 ? '...' : ''}</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted mb-1">Deskripsi:</div>
                            <div class="text-muted small">${deskripsi.substring(0, 80)}${deskripsi.length > 80 ? '...' : ''}</div>
                        </div>
                    </div>
                `;
            }

            // Add event listeners for real-time preview
            [namaToko, statusToko, idUser, idKota, alamatToko, deskripsiToko].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Handle duplicate data from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('nama_toko')) namaToko.value = urlParams.get('nama_toko');
                if (urlParams.get('status_toko')) statusToko.value = urlParams.get('status_toko');
                if (urlParams.get('id_user')) idUser.value = urlParams.get('id_user');
                if (urlParams.get('id_kota')) idKota.value = urlParams.get('id_kota');
                if (urlParams.get('alamat_toko')) alamatToko.value = urlParams.get('alamat_toko');
                if (urlParams.get('deskripsi_toko')) deskripsiToko.value = urlParams.get('deskripsi_toko');
                
                // Show notification
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle me-2"></i>Data toko telah diduplikat. Silakan sesuaikan seperlunya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
                
                // Auto hide after 7 seconds
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 7000);
            }

            // Initial preview update
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                
                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Toko';
                }, 5000);
            });

            // Character counter for nama toko
            const namaCounter = document.createElement('div');
            namaCounter.className = 'form-text text-end';
            namaCounter.id = 'namaCounter';
            namaToko.parentNode.appendChild(namaCounter);

            namaToko.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                namaCounter.textContent = `${this.value.length}/100 karakter`;
                namaCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Initial counter update
            namaToko.dispatchEvent(new Event('input'));

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
                    namaToko.dispatchEvent(new Event('input'));
                }
            });
        });

        // Auto-resize textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
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
    </style>
</x-layouts.admin>