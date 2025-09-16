<x-layouts.admin title="Edit Metode Pembayaran">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Metode Pembayaran</h2>
            <p class="text-muted mb-0">Perbarui data metode pembayaran</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.metode-pembayaran.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Metode Pembayaran</h5>
                    <span class="badge bg-dark">ID: {{ Str::limit($metodePembayaran->id_metode_pembayaran, 13) }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.metode-pembayaran.update', $metodePembayaran->id_metode_pembayaran) }}" method="POST" id="metodePembayaranForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Metode Pembayaran --}}
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label fw-semibold">
                                Nama Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('metode_pembayaran') is-invalid @enderror" 
                                   id="metode_pembayaran" 
                                   name="metode_pembayaran" 
                                   value="{{ old('metode_pembayaran', $metodePembayaran->metode_pembayaran) }}" 
                                   placeholder="Masukkan nama metode pembayaran"
                                   maxlength="255"
                                   required>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 255 karakter</div>
                            <div class="form-text text-end" id="namaCounter"></div>
                        </div>

                        {{-- Tipe Pembayaran --}}
                        <div class="mb-4">
                            <label for="tipe_pembayaran" class="form-label fw-semibold">
                                Tipe Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-select @error('tipe_pembayaran') is-invalid @enderror" 
                                            id="tipe_pembayaran" 
                                            name="tipe_pembayaran" 
                                            required>
                                        <option value="">Pilih Tipe Pembayaran</option>
                                        <option value="prepaid" {{ old('tipe_pembayaran', $metodePembayaran->tipe_pembayaran) == 'prepaid' ? 'selected' : '' }}>
                                            Prepaid
                                        </option>
                                        <option value="postpaid" {{ old('tipe_pembayaran', $metodePembayaran->tipe_pembayaran) == 'postpaid' ? 'selected' : '' }}>
                                            Postpaid
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        $currentTipeClass = $metodePembayaran->tipe_pembayaran === 'prepaid' ? 'bg-success' : 'bg-info';
                                        $currentTipeIcon = $metodePembayaran->tipe_pembayaran === 'prepaid' ? 'arrow-up-circle' : 'arrow-down-circle';
                                    @endphp
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge {{ $currentTipeClass }}">
                                            <i class="bi bi-{{ $currentTipeIcon }} me-1"></i>
                                            Tipe Saat Ini: {{ ucfirst($metodePembayaran->tipe_pembayaran) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @error('tipe_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <strong>Prepaid:</strong> Pembayaran di muka (dibayar sebelum transaksi)<br>
                                <strong>Postpaid:</strong> Pembayaran setelah transaksi (tagihan)
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.metode-pembayaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="checkDuplicate()" id="checkBtn">
                                <i class="bi bi-search me-2"></i>Cek Duplikasi
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Metode
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Metode</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $metodePembayaran->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $metodePembayaran->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Tipe:</div>
                            <div class="col-7">
                                <span class="badge {{ $currentTipeClass }}">
                                    <i class="bi bi-{{ $currentTipeIcon }} me-1"></i>
                                    {{ ucfirst($metodePembayaran->tipe_pembayaran) }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7">
                                @if($metodePembayaran->pembayarans()->exists())
                                    <span class="badge bg-success">Aktif Digunakan</span>
                                @else
                                    <span class="badge bg-secondary">Belum Digunakan</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-muted">Penggunaan:</div>
                            <div class="col-7 fw-semibold text-primary">
                                {{ $metodePembayaran->pembayarans()->count() }} transaksi
                            </div>
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
                            <i class="bi bi-credit-card" style="font-size: 3rem;"></i>
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
                        <button type="button" class="btn btn-info btn-sm" onclick="viewDetail('{{ $metodePembayaran->id_metode_pembayaran }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="duplicateMetode()">
                            <i class="bi bi-files me-2"></i>Duplikat Metode
                        </button>
                        @if($metodePembayaran->pembayarans()->count() == 0)
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteMetode()">
                                <i class="bi bi-trash me-2"></i>Hapus Metode
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-danger btn-sm" disabled title="Tidak dapat dihapus karena sudah digunakan">
                                <i class="bi bi-shield-x me-2"></i>Tidak Dapat Dihapus
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
                                <h6 class="mb-1">Metode Pembayaran Dibuat</h6>
                                <p class="text-muted mb-1">{{ $metodePembayaran->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Metode pembayaran pertama kali ditambahkan ke sistem</small>
                            </div>
                        </div>
                        @if($metodePembayaran->updated_at != $metodePembayaran->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir Diperbarui</h6>
                                    <p class="text-muted mb-1">{{ $metodePembayaran->updated_at->format('d M Y, H:i') }}</p>
                                    <small class="text-muted">Tipe: {{ ucfirst($metodePembayaran->tipe_pembayaran) }}</small>
                                </div>
                            </div>
                        @endif
                        @if($metodePembayaran->pembayarans()->exists())
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Mulai Digunakan</h6>
                                    <p class="text-muted mb-1">{{ $metodePembayaran->pembayarans()->oldest()->first()->created_at->format('d M Y, H:i') }}</p>
                                    <small class="text-muted">Total {{ $metodePembayaran->pembayarans()->count() }} transaksi</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Duplicate Check Result --}}
    <div class="modal fade" id="duplicateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="duplicateModalHeader">
                    <h5 class="modal-title" id="duplicateModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="duplicateModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete Confirmation --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus metode pembayaran <strong>"{{ $metodePembayaran->metode_pembayaran }}"</strong>?</p>
                    <p class="text-muted"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.metode-pembayaran.destroy', $metodePembayaran->id_metode_pembayaran) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Store original values
        const originalValues = {
            metode_pembayaran: '{{ $metodePembayaran->metode_pembayaran }}',
            tipe_pembayaran: '{{ $metodePembayaran->tipe_pembayaran }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('metodePembayaranForm');
            const submitBtn = document.getElementById('submitBtn');
            const checkBtn = document.getElementById('checkBtn');
            const previewCard = document.getElementById('previewCard');
            
            // Form inputs
            const metodePembayaran = document.getElementById('metode_pembayaran');
            const tipePembayaran = document.getElementById('tipe_pembayaran');

            // Update preview function
            function updatePreview() {
                const nama = metodePembayaran.value || 'Nama Metode Pembayaran';
                const tipe = tipePembayaran.value || 'prepaid';
                
                const tipeClass = tipe === 'prepaid' ? 'success' : 'info';
                const tipeIcon = tipe === 'prepaid' ? 'arrow-up-circle' : 'arrow-down-circle';

                // Check for changes
                const hasChanges = nama !== originalValues.metode_pembayaran ||
                                 tipe !== originalValues.tipe_pembayaran;

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-credit-card text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}${changesBadge}</h6>
                            <span class="badge bg-${tipeClass} mt-1">
                                <i class="bi bi-${tipeIcon} me-1"></i>${tipe.charAt(0).toUpperCase() + tipe.slice(1)}
                            </span>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Tipe:</div>
                            <div class="col-8">${tipe === 'prepaid' ? 'Pembayaran Di Muka' : 'Pembayaran Setelah Transaksi'}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Status:</div>
                            <div class="col-8">
                                @if($metodePembayaran->pembayarans()->exists())
                                    <span class="badge bg-success">Aktif Digunakan</span>
                                @else
                                    <span class="badge bg-secondary">Belum Digunakan</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-muted">Penggunaan:</div>
                            <div class="col-8 text-primary fw-semibold">{{ $metodePembayaran->pembayarans()->count() }} transaksi</div>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Metode';
                }
            }

            // Add event listeners for real-time preview
            [metodePembayaran, tipePembayaran].forEach(input => {
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

            // Character counter for metode pembayaran
            const namaCounter = document.getElementById('namaCounter');

            metodePembayaran.addEventListener('input', function() {
                const remaining = 255 - this.value.length;
                namaCounter.textContent = `${this.value.length}/255 karakter`;
                namaCounter.className = remaining < 25 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            metodePembayaran.dispatchEvent(new Event('input'));

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
                document.getElementById('metode_pembayaran').value = originalValues.metode_pembayaran;
                document.getElementById('tipe_pembayaran').value = originalValues.tipe_pembayaran;
                
                // Trigger preview update
                document.getElementById('metode_pembayaran').dispatchEvent(new Event('input'));
            }
        }

        // Check for duplicate
        function checkDuplicate() {
            const metodePembayaran = document.getElementById('metode_pembayaran').value.trim();
            const checkBtn = document.getElementById('checkBtn');
            
            if (!metodePembayaran) {
                alert('Silakan masukkan nama metode pembayaran terlebih dahulu');
                return;
            }

            checkBtn.disabled = true;
            checkBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengecek...';

            fetch('{{ route("admin.metode-pembayaran.check-duplicate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    metode_pembayaran: metodePembayaran,
                    exclude_id: '{{ $metodePembayaran->id_metode_pembayaran }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                checkBtn.disabled = false;
                checkBtn.innerHTML = '<i class="bi bi-search me-2"></i>Cek Duplikasi';
                
                showDuplicateResult(data.exists, data.message);
            })
            .catch(error => {
                checkBtn.disabled = false;
                checkBtn.innerHTML = '<i class="bi bi-search me-2"></i>Cek Duplikasi';
                alert('Terjadi kesalahan saat mengecek duplikasi');
            });
        }

        // Show duplicate check result
        function showDuplicateResult(exists, message) {
            const modal = new bootstrap.Modal(document.getElementById('duplicateModal'));
            const header = document.getElementById('duplicateModalHeader');
            const title = document.getElementById('duplicateModalTitle');
            const body = document.getElementById('duplicateModalBody');
            
            if (exists) {
                header.className = 'modal-header bg-danger text-white';
                title.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Duplikasi Ditemukan';
                body.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Peringatan!</strong> ${message}
                    </div>
                    <p class="mb-0">Silakan gunakan nama yang berbeda untuk metode pembayaran ini.</p>
                `;
            } else {
                header.className = 'modal-header bg-success text-white';
                title.innerHTML = '<i class="bi bi-check-circle me-2"></i>Nama Tersedia';
                body.innerHTML = `
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Bagus!</strong> ${message}
                    </div>
                    <p class="mb-0">Nama metode pembayaran ini dapat digunakan.</p>
                `;
            }
            
            modal.show();
        }

        // View history
        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        // View detail
        function viewDetail(id) {
            window.open(`{{ route('admin.metode-pembayaran.index') }}`, '_blank');
        }

        // Duplicate metode
        function duplicateMetode() {
            if (confirm('Yakin ingin menduplikat metode pembayaran ini? Data akan disalin ke form tambah metode baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $metodePembayaran->id_metode_pembayaran }}',
                    metode_pembayaran: document.getElementById('metode_pembayaran').value + ' (Copy)',
                    tipe_pembayaran: document.getElementById('tipe_pembayaran').value
                });
                
                window.open(`{{ route('admin.metode-pembayaran.create') }}?${params}`, '_blank');
            }
        }

        // Delete metode
        function deleteMetode() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const hasChanges = document.getElementById('metode_pembayaran').value !== originalValues.metode_pembayaran ||
                             document.getElementById('tipe_pembayaran').value !== originalValues.tipe_pembayaran;
            
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
            min-height: 200px;
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



        /* Focus styles */
        .form-control:focus {
            transform: scale(1.01);
            transition: transform 0.2s ease;
        }

        /* Loading animation */
        .btn[disabled] {
            position: relative;
            overflow: hidden;
        }

        .btn[disabled]::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Custom scrollbar for modals */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Tooltip custom styles */
        .tooltip-inner {
            background-color: #343a40;
            font-size: 0.875rem;
        }

        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #343a40;
        }

        /* Form validation styles */
        .was-validated .form-control:valid {
            border-color: #198754;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 2.94 2.94L7.88 7 8 7.12l-3.44 3.44L2 8z'/%3e%3c/svg%3e");
        }

        .was-validated .form-select:valid {
            border-color: #198754;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 2.94 2.94L7.88 7 8 7.12l-3.44 3.44L2 8z'/%3e%3c/svg%3e");
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header h5 {
                font-size: 1rem;
            }
            
            .badge {
                font-size: 0.7rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }
            
            .timeline {
                padding-left: 1.5rem;
            }
            
            .timeline-marker {
                left: -1.5rem;
            }
            
            #previewCard {
                min-height: 150px;
            }
        }

        /* Print styles */
        @media print {
            .btn, .modal, .card-header {
                display: none !important;
            }
            
            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }
        }
    </style>
</x-layouts.admin>