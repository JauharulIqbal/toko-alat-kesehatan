<x-layouts.admin title="Tambah Kota">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Kota Baru</h2>
            <p class="text-muted mb-0">Tambahkan data kota untuk lokasi toko dan user</p>
        </div>
        <div>
            <a href="{{ route('admin.kota.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Informasi Kota</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kota.store') }}" method="POST" id="kotaForm">
                        @csrf
                        
                        {{-- Nama Kota --}}
                        <div class="mb-3">
                            <label for="nama_kota" class="form-label fw-semibold">
                                Nama Kota <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kota') is-invalid @enderror" 
                                   id="nama_kota" 
                                   name="nama_kota" 
                                   value="{{ old('nama_kota') }}" 
                                   placeholder="Masukkan nama kota"
                                   maxlength="100"
                                   required>
                            @error('nama_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter</div>
                            <div id="duplicateNameAlert" class="alert alert-warning d-none mt-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Nama kota sudah ada dalam database
                            </div>
                        </div>

                        {{-- Kode Kota --}}
                        <div class="mb-4">
                            <label for="kode_kota" class="form-label fw-semibold">
                                Kode Kota
                            </label>
                            <input type="text" 
                                   class="form-control @error('kode_kota') is-invalid @enderror" 
                                   id="kode_kota" 
                                   name="kode_kota" 
                                   value="{{ old('kode_kota') }}" 
                                   placeholder="Masukkan kode kota (opsional)"
                                   maxlength="20">
                            @error('kode_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 20 karakter, kosongkan jika tidak ada</div>
                            <div id="duplicateCodeAlert" class="alert alert-warning d-none mt-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Kode kota sudah ada dalam database
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kota.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Kota
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
                            <h6 class="text-primary mb-2">Nama Kota</h6>
                            <p class="text-muted mb-0">Masukkan nama kota yang jelas dan benar. Pastikan penulisan sesuai dengan nama resmi kota tersebut. Maksimal 100 karakter.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Kode Kota</h6>
                            <p class="text-muted mb-0">Kode kota bersifat opsional. Bisa berupa kode pos, kode wilayah, atau kode lainnya yang relevan. Maksimal 20 karakter.</p>
                        </div>
                        <div class="alert alert-warning p-2">
                            <small><i class="bi bi-exclamation-triangle me-1"></i><strong>Perhatian:</strong> Nama kota dan kode kota harus unik (tidak boleh sama dengan data yang sudah ada).</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Kota</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-geo-alt" style="font-size: 3rem;"></i>
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
            const form = document.getElementById('kotaForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            
            // Form inputs
            const namaKota = document.getElementById('nama_kota');
            const kodeKota = document.getElementById('kode_kota');
            
            // Duplicate alerts
            const duplicateNameAlert = document.getElementById('duplicateNameAlert');
            const duplicateCodeAlert = document.getElementById('duplicateCodeAlert');

            let checkTimeout;

            // Update preview function
            function updatePreview() {
                const nama = namaKota.value.trim() || 'Nama Kota';
                const kode = kodeKota.value.trim() || '-';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}</h6>
                            <small class="text-muted">Kode: ${kode}</small>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Nama:</div>
                            <div class="col-7">${nama}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Kode:</div>
                            <div class="col-7">${kode}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7"><span class="badge bg-info">Baru</span></div>
                        </div>
                    </div>
                `;
            }

            // Check for duplicates
            function checkDuplicates() {
                const nama = namaKota.value.trim();
                const kode = kodeKota.value.trim();

                // Reset alerts
                duplicateNameAlert.classList.add('d-none');
                duplicateCodeAlert.classList.add('d-none');

                if (!nama && !kode) {
                    updateSubmitButton();
                    return;
                }

                clearTimeout(checkTimeout);
                checkTimeout = setTimeout(() => {
                    // Check if we have CSRF token first
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                     document.querySelector('input[name="_token"]')?.value;

                    if (!csrfToken) {
                        console.warn('CSRF token not found');
                        updateSubmitButton();
                        return;
                    }

                    fetch('/admin/kota/check-duplicate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            nama_kota: nama,
                            kode_kota: kode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.has_duplicates) {
                                data.duplicates.forEach(duplicate => {
                                    if (duplicate.includes('Nama kota')) {
                                        duplicateNameAlert.classList.remove('d-none');
                                    }
                                    if (duplicate.includes('Kode kota')) {
                                        duplicateCodeAlert.classList.remove('d-none');
                                    }
                                });
                            }
                        }
                        updateSubmitButton();
                    })
                    .catch(error => {
                        console.error('Error checking duplicates:', error);
                        updateSubmitButton();
                    });
                }, 500);
            }

            // Update submit button state - FIXED VERSION
            function updateSubmitButton() {
                const hasDuplicates = !duplicateNameAlert.classList.contains('d-none') || 
                                    !duplicateCodeAlert.classList.contains('d-none');
                const hasRequiredFields = namaKota.value.trim() !== '';
                
                if (hasDuplicates) {
                    submitBtn.disabled = true;
                    submitBtn.className = 'btn btn-secondary';
                    submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Ada Duplikasi';
                } else if (!hasRequiredFields) {
                    submitBtn.disabled = true;
                    submitBtn.className = 'btn btn-secondary';
                    submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Lengkapi Data';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.className = 'btn btn-primary';
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Kota';
                }
            }

            // Add event listeners
            [namaKota, kodeKota].forEach(input => {
                input.addEventListener('input', function() {
                    updatePreview();
                    checkDuplicates();
                });
                input.addEventListener('change', function() {
                    updatePreview();
                    updateSubmitButton();
                });
            });

            // Handle duplicate data from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('nama_kota')) namaKota.value = urlParams.get('nama_kota');
                if (urlParams.get('kode_kota')) kodeKota.value = urlParams.get('kode_kota');
                
                // Show notification
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle me-2"></i>Data kota telah diduplikat. Silakan sesuaikan seperlunya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
                
                // Auto hide after 7 seconds
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 7000);
            }

            // Initial setup
            updatePreview();
            updateSubmitButton();

            // Form validation
            form.addEventListener('submit', function(e) {
                const hasDuplicates = !duplicateNameAlert.classList.contains('d-none') || 
                                    !duplicateCodeAlert.classList.contains('d-none');
                
                if (hasDuplicates) {
                    e.preventDefault();
                    alert('Tidak dapat menyimpan data karena ada duplikasi. Silakan perbaiki terlebih dahulu.');
                    return;
                }

                if (namaKota.value.trim() === '') {
                    e.preventDefault();
                    alert('Nama kota wajib diisi!');
                    namaKota.focus();
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                
                // Re-enable button after 10 seconds (in case of error)
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        updateSubmitButton();
                    }
                }, 10000);
            });

            // Character counter for nama kota
            const namaCounter = document.createElement('div');
            namaCounter.className = 'form-text text-end';
            namaCounter.id = 'namaCounter';
            namaKota.parentNode.appendChild(namaCounter);

            namaKota.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                namaCounter.textContent = `${this.value.length}/100 karakter`;
                namaCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Character counter for kode kota
            const kodeCounter = document.createElement('div');
            kodeCounter.className = 'form-text text-end';
            kodeCounter.id = 'kodeCounter';
            kodeKota.parentNode.appendChild(kodeCounter);

            kodeKota.addEventListener('input', function() {
                const remaining = 20 - this.value.length;
                kodeCounter.textContent = `${this.value.length}/20 karakter`;
                kodeCounter.className = remaining < 5 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Initial counter update
            namaKota.dispatchEvent(new Event('input'));
            kodeKota.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert:not(#duplicateNameAlert):not(#duplicateCodeAlert)');
                alerts.forEach(alert => {
                    if (alert.querySelector('.btn-close')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Reset form confirmation
            const resetBtn = form.querySelector('button[type="reset"]');
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Yakin ingin mereset semua data yang sudah diisi?')) {
                    form.reset();
                    updatePreview();
                    duplicateNameAlert.classList.add('d-none');
                    duplicateCodeAlert.classList.add('d-none');
                    updateSubmitButton();
                    namaKota.dispatchEvent(new Event('input'));
                    kodeKota.dispatchEvent(new Event('input'));
                }
            });
        });
    </script>
    @endpush

    <!-- Pastikan ada meta CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            opacity: 0.7;
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

        .alert {
            border-radius: 0.375rem;
        }

        .alert.p-2 {
            padding: 0.5rem !important;
        }
    </style>
</x-layouts.admin>