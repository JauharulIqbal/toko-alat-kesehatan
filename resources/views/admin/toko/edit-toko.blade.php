<x-layouts.admin title="Edit Toko">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Toko</h2>
            <p class="text-muted mb-0">Perbarui data toko alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.toko.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Toko</h5>
                    <span class="badge bg-dark">ID: {{ $toko->id_toko }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.toko.update', $toko->id_toko) }}" method="POST" id="tokoForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Toko --}}
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label fw-semibold">
                                Nama Toko <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_toko') is-invalid @enderror" 
                                   id="nama_toko" 
                                   name="nama_toko" 
                                   value="{{ old('nama_toko', $toko->nama_toko) }}" 
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
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-select @error('status_toko') is-invalid @enderror" 
                                            id="status_toko" 
                                            name="status_toko" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="menunggu" {{ old('status_toko', $toko->status_toko) == 'menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="disetujui" {{ old('status_toko', $toko->status_toko) == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        <option value="ditolak" {{ old('status_toko', $toko->status_toko) == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        $currentStatusClass = match($toko->status_toko) {
                                            'disetujui' => 'bg-success',
                                            'ditolak' => 'bg-danger',
                                            'menunggu' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge {{ $currentStatusClass }}">
                                            Status Saat Ini: {{ ucfirst($toko->status_toko) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                    <option value="{{ $user->id_user }}" {{ old('id_user', $toko->id_user) == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($toko->user)
                                <div class="form-text">Pemilik saat ini: <strong>{{ $toko->user->name }}</strong></div>
                            @endif
                        </div>

                        {{-- Kota --}}
                        <div class="mb-3">
                            <label for="id_kota" class="form-label fw-semibold">Kota</label>
                            <select class="form-select @error('id_kota') is-invalid @enderror" 
                                    id="id_kota" 
                                    name="id_kota">
                                <option value="">Pilih Kota</option>
                                @foreach($kota as $kotaItem)
                                    <option value="{{ $kotaItem->id_kota }}" {{ old('id_kota', $toko->id_kota) == $kotaItem->id_kota ? 'selected' : '' }}>
                                        {{ $kotaItem->nama_kota }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($toko->kota)
                                <div class="form-text">Kota saat ini: <strong>{{ $toko->kota->nama_kota }}</strong></div>
                            @endif
                        </div>

                        {{-- Alamat Toko --}}
                        <div class="mb-3">
                            <label for="alamat_toko" class="form-label fw-semibold">Alamat Toko</label>
                            <textarea class="form-control @error('alamat_toko') is-invalid @enderror" 
                                      id="alamat_toko" 
                                      name="alamat_toko" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap toko">{{ old('alamat_toko', $toko->alamat_toko) }}</textarea>
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
                                      placeholder="Masukkan deskripsi toko (opsional)">{{ old('deskripsi_toko', $toko->deskripsi_toko) }}</textarea>
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
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Toko
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Toko</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $toko->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $toko->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7">
                                <span class="badge {{ $currentStatusClass }}">{{ ucfirst($toko->status_toko) }}</span>
                            </div>
                        </div>
                        @if($toko->user)
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Pemilik:</div>
                                <div class="col-7">{{ $toko->user->name }}</div>
                            </div>
                        @endif
                        @if($toko->kota)
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Kota:</div>
                                <div class="col-7">{{ $toko->kota->nama_kota }}</div>
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
                            <i class="bi bi-shop" style="font-size: 3rem;"></i>
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
                        @if($toko->status_toko === 'menunggu')
                            <button type="button" class="btn btn-success btn-sm" onclick="quickApprove()">
                                <i class="bi bi-check-circle me-2"></i>Setujui Langsung
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="quickReject()">
                                <i class="bi bi-x-circle me-2"></i>Tolak Langsung
                            </button>
                        @endif
                        <button type="button" class="btn btn-info btn-sm" onclick="viewToko('{{ $toko->id_toko }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="duplicateToko()">
                            <i class="bi bi-files me-2"></i>Duplikat Toko
                        </button>
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
                                <h6 class="mb-1">Toko Dibuat</h6>
                                <p class="text-muted mb-1">{{ $toko->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Toko pertama kali ditambahkan ke sistem</small>
                            </div>
                        </div>
                        @if($toko->updated_at != $toko->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir Diperbarui</h6>
                                    <p class="text-muted mb-1">{{ $toko->updated_at->format('d M Y, H:i') }}</p>
                                    <small class="text-muted">Status: {{ ucfirst($toko->status_toko) }}</small>
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
            nama_toko: '{{ $toko->nama_toko }}',
            status_toko: '{{ $toko->status_toko }}',
            id_user: '{{ $toko->id_user }}',
            id_kota: '{{ $toko->id_kota }}',
            alamat_toko: '{{ $toko->alamat_toko }}',
            deskripsi_toko: '{{ $toko->deskripsi_toko }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
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

                // Check for changes
                const hasChanges = nama !== originalValues.nama_toko ||
                                 status !== originalValues.status_toko ||
                                 idUser.value !== originalValues.id_user ||
                                 idKota.value !== originalValues.id_kota ||
                                 alamat !== originalValues.alamat_toko ||
                                 deskripsi !== originalValues.deskripsi_toko;

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-shop text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}${changesBadge}</h6>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Toko';
                }
            }

            // Add event listeners for real-time preview
            [namaToko, statusToko, idUser, idKota, alamatToko, deskripsiToko].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
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

            namaToko.dispatchEvent(new Event('input'));

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
                document.getElementById('nama_toko').value = originalValues.nama_toko;
                document.getElementById('status_toko').value = originalValues.status_toko;
                document.getElementById('id_user').value = originalValues.id_user;
                document.getElementById('id_kota').value = originalValues.id_kota;
                document.getElementById('alamat_toko').value = originalValues.alamat_toko;
                document.getElementById('deskripsi_toko').value = originalValues.deskripsi_toko;
                
                // Trigger preview update
                document.getElementById('nama_toko').dispatchEvent(new Event('input'));
            }
        }

        // Quick approve
        function quickApprove() {
            if (confirm('Yakin ingin menyetujui toko ini langsung?')) {
                document.getElementById('status_toko').value = 'disetujui';
                document.getElementById('status_toko').dispatchEvent(new Event('change'));
            }
        }

        // Quick reject
        function quickReject() {
            if (confirm('Yakin ingin menolak toko ini langsung?')) {
                document.getElementById('status_toko').value = 'ditolak';
                document.getElementById('status_toko').dispatchEvent(new Event('change'));
            }
        }

        // View history
        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        // View detail toko
        function viewToko(id) {
            // Implementasi sama seperti di view-toko.blade.php
            alert('Fitur detail toko akan dibuka di tab baru');
            window.open(`/admin/toko/${id}`, '_blank');
        }

        // Duplicate toko
        function duplicateToko() {
            if (confirm('Yakin ingin menduplikat toko ini? Data akan disalin ke form tambah toko baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $toko->id_toko }}',
                    nama_toko: document.getElementById('nama_toko').value + ' (Copy)',
                    status_toko: 'menunggu',
                    id_user: document.getElementById('id_user').value,
                    id_kota: document.getElementById('id_kota').value,
                    alamat_toko: document.getElementById('alamat_toko').value,
                    deskripsi_toko: document.getElementById('deskripsi_toko').value
                });
                
                window.open(`{{ route('admin.toko.create') }}?${params}`, '_blank');
            }
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
            const hasChanges = document.getElementById('nama_toko').value !== originalValues.nama_toko ||
                             document.getElementById('status_toko').value !== originalValues.status_toko ||
                             document.getElementById('id_user').value !== originalValues.id_user ||
                             document.getElementById('id_kota').value !== originalValues.id_kota ||
                             document.getElementById('alamat_toko').value !== originalValues.alamat_toko ||
                             document.getElementById('deskripsi_toko').value !== originalValues.deskripsi_toko;
            
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
            min-height: 250px;
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
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</x-layouts.admin>