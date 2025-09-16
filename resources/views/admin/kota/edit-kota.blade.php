<x-layouts.admin title="Edit Kota">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Kota</h2>
            <p class="text-muted mb-0">Perbarui data kota</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kota.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button type="button" class="btn btn-outline-info" onclick="viewRelatedData()">
                <i class="bi bi-link-45deg me-2"></i>Data Terkait
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Kota</h5>
                    <span class="badge bg-dark">ID: {{ Str::limit($kota->id_kota, 8) }}...</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kota.update', $kota->id_kota) }}" method="POST" id="kotaForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Kota --}}
                        <div class="mb-3">
                            <label for="nama_kota" class="form-label fw-semibold">
                                Nama Kota <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kota') is-invalid @enderror" 
                                   id="nama_kota" 
                                   name="nama_kota" 
                                   value="{{ old('nama_kota', $kota->nama_kota) }}" 
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
                                   value="{{ old('kode_kota', $kota->kode_kota) }}" 
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
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Kota
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Kota</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $kota->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $kota->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Jumlah User:</div>
                            <div class="col-7">
                                <span class="badge bg-success">{{ $kota->users->count() }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Jumlah Toko:</div>
                            <div class="col-7">
                                <span class="badge bg-info">{{ $kota->tokos->count() }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-muted">Full ID:</div>
                            <div class="col-7"><small class="font-monospace">{{ $kota->id_kota }}</small></div>
                        </div>
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
                            <i class="bi bi-geo-alt" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Preview akan update saat mengubah form</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Data Warning --}}
            @if($kota->users->count() > 0 || $kota->tokos->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Peringatan</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <p class="text-warning mb-2"><strong>Kota ini memiliki data terkait:</strong></p>
                            <ul class="mb-3">
                                @if($kota->users->count() > 0)
                                    <li>{{ $kota->users->count() }} User</li>
                                @endif
                                @if($kota->tokos->count() > 0)
                                    <li>{{ $kota->tokos->count() }} Toko</li>
                                @endif
                            </ul>
                            <p class="text-muted mb-0">Perubahan nama kota akan mempengaruhi semua data terkait. Pastikan perubahan sudah benar sebelum menyimpan.</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Quick Actions Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-info btn-sm" onclick="viewKota('{{ $kota->id_kota }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        @if($kota->users->count() > 0)
                            <button type="button" class="btn btn-success btn-sm" onclick="viewUsers()">
                                <i class="bi bi-people me-2"></i>Lihat User ({{ $kota->users->count() }})
                            </button>
                        @endif
                        @if($kota->tokos->count() > 0)
                            <button type="button" class="btn btn-primary btn-sm" onclick="viewTokos()">
                                <i class="bi bi-shop me-2"></i>Lihat Toko ({{ $kota->tokos->count() }})
                            </button>
                        @endif
                        <button type="button" class="btn btn-warning btn-sm" onclick="duplicateKota()">
                            <i class="bi bi-files me-2"></i>Duplikat Kota
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Related Data --}}
    <div class="modal fade" id="relatedDataModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-link-45deg me-2"></i>Data Terkait</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">User di {{ $kota->nama_kota }}</h6>
                            @if($kota->users->count() > 0)
                                <div class="list-group">
                                    @foreach($kota->users->take(5) as $user)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-person text-success" style="font-size: 14px;"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($kota->users->count() > 5)
                                        <div class="text-center mt-2">
                                            <small class="text-muted">Dan {{ $kota->users->count() - 5 }} user lainnya...</small>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted">Tidak ada user di kota ini</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">Toko di {{ $kota->nama_kota }}</h6>
                            @if($kota->tokos->count() > 0)
                                <div class="list-group">
                                    @foreach($kota->tokos->take(5) as $toko)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-shop text-info" style="font-size: 14px;"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $toko->nama_toko }}</h6>
                                                    <small class="badge bg-{{ $toko->status_toko === 'disetujui' ? 'success' : ($toko->status_toko === 'ditolak' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($toko->status_toko) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($kota->tokos->count() > 5)
                                        <div class="text-center mt-2">
                                            <small class="text-muted">Dan {{ $kota->tokos->count() - 5 }} toko lainnya...</small>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted">Tidak ada toko di kota ini</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Store original values
        const originalValues = {
            nama_kota: '{{ $kota->nama_kota }}',
            kode_kota: '{{ $kota->kode_kota }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
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
                const nama = namaKota.value || 'Nama Kota';
                const kode = kodeKota.value || '-';

                // Check for changes
                const hasChanges = nama !== originalValues.nama_kota ||
                                 kode !== originalValues.kode_kota;

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}${changesBadge}</h6>
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
                            <div class="col-5 text-muted">User:</div>
                            <div class="col-7"><span class="badge bg-success">{{ $kota->users->count() }}</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Toko:</div>
                            <div class="col-7"><span class="badge bg-info">{{ $kota->tokos->count() }}</span></div>
                        </div>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Kota';
                }
            }

            // Check for duplicates
            function checkDuplicates() {
                const nama = namaKota.value.trim();
                const kode = kodeKota.value.trim();

                clearTimeout(checkTimeout);
                checkTimeout = setTimeout(() => {
                    fetch('/admin/kota/check-duplicate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            nama_kota: nama,
                            kode_kota: kode,
                            exclude_id: '{{ $kota->id_kota }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset alerts
                            duplicateNameAlert.classList.add('d-none');
                            duplicateCodeAlert.classList.add('d-none');
                            
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
                            
                            // Update submit button state
                            updateSubmitButton();
                        }
                    })
                    .catch(error => {
                        console.error('Error checking duplicates:', error);
                    });
                }, 500);
            }

            // Update submit button state
            function updateSubmitButton() {
                const hasDuplicates = !duplicateNameAlert.classList.contains('d-none') || 
                                    !duplicateCodeAlert.classList.contains('d-none');
                const hasRequiredFields = namaKota.value.trim() !== '';
                
                if (hasDuplicates || !hasRequiredFields) {
                    submitBtn.disabled = true;
                    submitBtn.classList.remove('btn-primary', 'btn-success');
                    submitBtn.classList.add('btn-secondary');
                    if (hasDuplicates) {
                        submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Ada Duplikasi';
                    } else if (!hasRequiredFields) {
                        submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Lengkapi Data';
                    }
                } else {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-secondary');
                    updatePreview(); // This will set the correct button class and text
                }
            }

            // Add event listeners
            [namaKota, kodeKota].forEach(input => {
                input.addEventListener('input', function() {
                    updatePreview();
                    checkDuplicates();
                });
                input.addEventListener('change', updatePreview);
            });

            // Initial preview update
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                const hasDuplicates = !duplicateNameAlert.classList.contains('d-none') || 
                                    !duplicateCodeAlert.classList.contains('d-none');
                
                if (hasDuplicates) {
                    e.preventDefault();
                    alert('Tidak dapat menyimpan data karena ada duplikasi. Silakan perbaiki terlebih dahulu.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memperbarui...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    updatePreview();
                }, 5000);
            });

            // Character counters
            const namaCounter = document.createElement('div');
            namaCounter.className = 'form-text text-end';
            namaKota.parentNode.appendChild(namaCounter);

            const kodeCounter = document.createElement('div');
            kodeCounter.className = 'form-text text-end';
            kodeKota.parentNode.appendChild(kodeCounter);

            namaKota.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                namaCounter.textContent = `${this.value.length}/100 karakter`;
                namaCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            kodeKota.addEventListener('input', function() {
                const remaining = 20 - this.value.length;
                kodeCounter.textContent = `${this.value.length}/20 karakter`;
                kodeCounter.className = remaining < 5 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Trigger initial counters
            namaKota.dispatchEvent(new Event('input'));
            kodeKota.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert:not(#duplicateNameAlert):not(#duplicateCodeAlert)');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Reset to original values
        function resetToOriginal() {
            if (confirm('Yakin ingin mereset semua perubahan ke nilai asli?')) {
                document.getElementById('nama_kota').value = originalValues.nama_kota;
                document.getElementById('kode_kota').value = originalValues.kode_kota;
                
                // Trigger events
                document.getElementById('nama_kota').dispatchEvent(new Event('input'));
                document.getElementById('kode_kota').dispatchEvent(new Event('input'));
            }
        }

        // View related data
        function viewRelatedData() {
            const modal = new bootstrap.Modal(document.getElementById('relatedDataModal'));
            modal.show();
        }

        // View detail kota
        function viewKota(id) {
            alert('Fitur detail kota akan dibuka di tab baru');
            window.open(`/admin/kota/${id}`, '_blank');
        }

        // View users
        function viewUsers() {
            window.open('/admin/user?kota={{ $kota->id_kota }}', '_blank');
        }

        // View tokos
        function viewTokos() {
            window.open('/admin/toko?kota={{ $kota->id_kota }}', '_blank');
        }

        // Duplicate kota
        function duplicateKota() {
            if (confirm('Yakin ingin menduplikat kota ini? Data akan disalin ke form tambah kota baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $kota->id_kota }}',
                    nama_kota: document.getElementById('nama_kota').value + ' (Copy)',
                    kode_kota: document.getElementById('kode_kota').value
                });
                
                window.open(`{{ route('admin.kota.create') }}?${params}`, '_blank');
            }
        }

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const hasChanges = document.getElementById('nama_kota').value !== originalValues.nama_kota ||
                             document.getElementById('kode_kota').value !== originalValues.kode_kota;
            
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
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

        .invalid-feedback {
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        #previewCard {
            min-height: 250px;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .font-monospace {
            font-family: 'Courier New', monospace;
            font-size: 0.8em;
        }

        .list-group-item {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }

        /* Animation for changes */
        .badge.bg-warning {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</x-layouts.admin>