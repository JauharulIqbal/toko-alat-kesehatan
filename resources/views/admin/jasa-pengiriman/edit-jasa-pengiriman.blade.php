<x-layouts.admin title="Edit Jasa Pengiriman">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Jasa Pengiriman</h2>
            <p class="text-muted mb-0">Perbarui data jasa pengiriman</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.jasa-pengiriman.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Jasa Pengiriman</h5>
                    <span class="badge bg-dark">ID: {{ $jasaPengiriman->id_jasa_pengiriman }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jasa-pengiriman.update', $jasaPengiriman->id_jasa_pengiriman) }}" method="POST" id="jasaPengirimanForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Jasa Pengiriman --}}
                        <div class="mb-3">
                            <label for="nama_jasa_pengiriman" class="form-label fw-semibold">
                                Nama Jasa Pengiriman <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_jasa_pengiriman') is-invalid @enderror" 
                                   id="nama_jasa_pengiriman" 
                                   name="nama_jasa_pengiriman" 
                                   value="{{ old('nama_jasa_pengiriman', $jasaPengiriman->nama_jasa_pengiriman) }}" 
                                   placeholder="Masukkan nama jasa pengiriman"
                                   maxlength="100"
                                   required>
                            @error('nama_jasa_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter</div>
                        </div>

                        {{-- Biaya Pengiriman --}}
                        <div class="mb-4">
                            <label for="biaya_pengiriman" class="form-label fw-semibold">
                                Biaya Pengiriman <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('biaya_pengiriman') is-invalid @enderror" 
                                               id="biaya_pengiriman" 
                                               name="biaya_pengiriman" 
                                               value="{{ old('biaya_pengiriman', $jasaPengiriman->biaya_pengiriman) }}" 
                                               placeholder="0"
                                               min="0"
                                               step="0.01"
                                               max="999999999999.99"
                                               required>
                                        @error('biaya_pengiriman')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center h-100">
                                        <span class="badge bg-info">
                                            Saat Ini: Rp {{ number_format($jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Masukkan biaya dalam rupiah (Rp)</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.jasa-pengiriman.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Jasa Pengiriman
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Jasa Pengiriman</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $jasaPengiriman->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $jasaPengiriman->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Nama Jasa:</div>
                            <div class="col-7 fw-semibold">{{ $jasaPengiriman->nama_jasa_pengiriman }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Biaya:</div>
                            <div class="col-7">
                                <span class="badge bg-success">Rp {{ number_format($jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}</span>
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
                            <i class="bi bi-truck" style="font-size: 3rem;"></i>
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
                        <button type="button" class="btn btn-info btn-sm" onclick="viewJasaPengiriman('{{ $jasaPengiriman->id_jasa_pengiriman }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="duplicateJasaPengiriman()">
                            <i class="bi bi-files me-2"></i>Duplikat Jasa Pengiriman
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteJasaPengiriman('{{ $jasaPengiriman->id_jasa_pengiriman }}')">
                            <i class="bi bi-trash me-2"></i>Hapus Jasa Pengiriman
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
                                <h6 class="mb-1">Jasa Pengiriman Dibuat</h6>
                                <p class="text-muted mb-1">{{ $jasaPengiriman->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Jasa pengiriman pertama kali ditambahkan ke sistem</small>
                            </div>
                        </div>
                        @if($jasaPengiriman->updated_at != $jasaPengiriman->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir Diperbarui</h6>
                                    <p class="text-muted mb-1">{{ $jasaPengiriman->updated_at->format('d M Y, H:i') }}</p>
                                    <small class="text-muted">Biaya: Rp {{ number_format($jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus jasa pengiriman <strong>{{ $jasaPengiriman->nama_jasa_pengiriman }}</strong>?</p>
                    <p class="text-muted"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="{{ route('admin.jasa-pengiriman.destroy', $jasaPengiriman->id_jasa_pengiriman) }}" style="display: inline;">
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
            nama_jasa_pengiriman: '{{ $jasaPengiriman->nama_jasa_pengiriman }}',
            biaya_pengiriman: '{{ $jasaPengiriman->biaya_pengiriman }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jasaPengirimanForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            
            // Form inputs
            const namaJasaPengiriman = document.getElementById('nama_jasa_pengiriman');
            const biayaPengiriman = document.getElementById('biaya_pengiriman');

            // Update preview function
            function updatePreview() {
                const nama = namaJasaPengiriman.value || 'Nama Jasa Pengiriman';
                const biaya = biayaPengiriman.value || 0;
                const formattedBiaya = new Intl.NumberFormat('id-ID').format(biaya);

                // Check for changes
                const hasChanges = nama !== originalValues.nama_jasa_pengiriman ||
                                 parseFloat(biaya) !== parseFloat(originalValues.biaya_pengiriman);

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-truck text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}${changesBadge}</h6>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Nama Jasa:</div>
                            <div class="col-7">${nama}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Biaya Baru:</div>
                            <div class="col-7">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    Rp ${formattedBiaya}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Biaya Lama:</div>
                            <div class="col-7">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    Rp ${new Intl.NumberFormat('id-ID').format(originalValues.biaya_pengiriman)}
                                </span>
                            </div>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Jasa Pengiriman';
                }
            }

            // Add event listeners for real-time preview
            [namaJasaPengiriman, biayaPengiriman].forEach(input => {
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

            // Character counter for nama jasa pengiriman
            const namaCounter = document.createElement('div');
            namaCounter.className = 'form-text text-end';
            namaCounter.id = 'namaCounter';
            namaJasaPengiriman.parentNode.appendChild(namaCounter);

            namaJasaPengiriman.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                namaCounter.textContent = `${this.value.length}/100 karakter`;
                namaCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            namaJasaPengiriman.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Format biaya input
            biayaPengiriman.addEventListener('blur', function() {
                if (this.value) {
                    const value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                }
            });
        });

        // Reset to original values
        function resetToOriginal() {
            if (confirm('Yakin ingin mereset semua perubahan ke nilai asli?')) {
                document.getElementById('nama_jasa_pengiriman').value = originalValues.nama_jasa_pengiriman;
                document.getElementById('biaya_pengiriman').value = originalValues.biaya_pengiriman;
                
                // Trigger preview update
                document.getElementById('nama_jasa_pengiriman').dispatchEvent(new Event('input'));
            }
        }

        // View history
        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        // View detail jasa pengiriman
        function viewJasaPengiriman(id) {
            alert('Fitur detail jasa pengiriman akan dibuka di modal');
            // Implementasi sama seperti di view-jasa-pengiriman.blade.php
        }

        // Duplicate jasa pengiriman
        function duplicateJasaPengiriman() {
            if (confirm('Yakin ingin menduplikat jasa pengiriman ini? Data akan disalin ke form tambah jasa pengiriman baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $jasaPengiriman->id_jasa_pengiriman }}',
                    nama_jasa_pengiriman: document.getElementById('nama_jasa_pengiriman').value + ' (Copy)',
                    biaya_pengiriman: document.getElementById('biaya_pengiriman').value
                });
                
                window.open(`{{ route('admin.jasa-pengiriman.create') }}?${params}`, '_blank');
            }
        }

        // Delete jasa pengiriman
        function deleteJasaPengiriman(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const hasChanges = document.getElementById('nama_jasa_pengiriman').value !== originalValues.nama_jasa_pengiriman ||
                             parseFloat(document.getElementById('biaya_pengiriman').value) !== parseFloat(originalValues.biaya_pengiriman);
            
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

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
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