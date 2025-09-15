<x-layouts.admin title="Edit Kategori Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Kategori Produk</h2>
            <p class="text-muted mb-0">Perbarui data kategori produk alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Kategori</h5>
                    <span class="badge bg-dark">ID: {{ Str::limit($kategoriProduk->id_kategori, 8) }}...</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori-produk.update', $kategoriProduk->id_kategori) }}" method="POST" id="kategoriForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori', $kategoriProduk->nama_kategori) }}" 
                                   placeholder="Masukkan nama kategori produk"
                                   maxlength="100"
                                   required
                                   autocomplete="off">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter. Nama saat ini: <strong>{{ $kategoriProduk->nama_kategori }}</strong></div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Kategori
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Nama:</div>
                            <div class="col-7 fw-semibold">{{ $kategoriProduk->nama_kategori }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $kategoriProduk->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $kategoriProduk->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        @php
                            $produkCount = $kategoriProduk->produk()->count();
                        @endphp
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Produk:</div>
                            <div class="col-7">
                                <span class="badge {{ $produkCount > 0 ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $produkCount }} Produk
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7"><span class="badge bg-success">Aktif</span></div>
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
                            <i class="bi bi-tag" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Preview akan update saat mengubah form</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products in Category --}}
            @if($produkCount > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk dalam Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        @forelse($kategoriProduk->produk()->take(5)->get() as $produk)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-box text-success" style="font-size: 14px;"></i>
                                </div>
                                <span>{{ $produk->nama_produk ?? 'Produk' }}</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada produk</p>
                        @endforelse
                        
                        @if($produkCount > 5)
                            <div class="mt-2">
                                <small class="text-muted">Dan {{ $produkCount - 5 }} produk lainnya...</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Quick Actions Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-info btn-sm" onclick="viewKategori('{{ $kategoriProduk->id_kategori }}')">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                        <button type="button" class="btn btn-success btn-sm" onclick="duplicateKategori()">
                            <i class="bi bi-files me-2"></i>Duplikat Kategori
                        </button>
                        @if($produkCount === 0)
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteKategori()">
                                <i class="bi bi-trash me-2"></i>Hapus Kategori
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-danger btn-sm" disabled title="Tidak dapat dihapus karena memiliki produk">
                                <i class="bi bi-trash me-2"></i>Tidak Dapat Dihapus
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
                                <h6 class="mb-1">Kategori Dibuat</h6>
                                <p class="text-muted mb-1">{{ $kategoriProduk->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Kategori pertama kali ditambahkan ke sistem</small>
                            </div>
                        </div>
                        @if($kategoriProduk->updated_at != $kategoriProduk->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir Diperbarui</h6>
                                    <p class="text-muted mb-1">{{ $kategoriProduk->updated_at->format('d M Y, H:i') }}</p>
                                    <small class="text-muted">Nama: {{ $kategoriProduk->nama_kategori }}</small>
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
            nama_kategori: '{{ $kategoriProduk->nama_kategori }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kategoriForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            const namaKategori = document.getElementById('nama_kategori');

            // Update preview function
            function updatePreview() {
                const nama = namaKategori.value || 'Nama Kategori';
                const hasChanges = nama !== originalValues.nama_kategori;
                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-tag text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}${changesBadge}</h6>
                            <span class="badge bg-success mt-1">Aktif</span>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7"><span class="badge bg-primary">Aktif</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Produk:</div>
                            <div class="col-7"><span class="badge bg-success">{{ $produkCount }} Produk</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">${new Date().toLocaleDateString('id-ID')}</div>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Kategori';
                }
            }

            // Add event listener for real-time preview
            namaKategori.addEventListener('input', updatePreview);

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

            // Character counter
            const characterCounter = document.createElement('div');
            characterCounter.className = 'form-text text-end';
            characterCounter.id = 'characterCounter';
            namaKategori.parentNode.appendChild(characterCounter);

            namaKategori.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                characterCounter.textContent = `${this.value.length}/100 karakter`;
                
                if (remaining < 10) {
                    characterCounter.className = 'form-text text-end text-warning';
                } else if (remaining < 0) {
                    characterCounter.className = 'form-text text-end text-danger';
                } else {
                    characterCounter.className = 'form-text text-end text-muted';
                }
            });

            namaKategori.dispatchEvent(new Event('input'));

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
                document.getElementById('nama_kategori').value = originalValues.nama_kategori;
                document.getElementById('nama_kategori').dispatchEvent(new Event('input'));
            }
        }

        // View history
        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        // View detail kategori
        function viewKategori(id) {
            alert('Fitur detail kategori akan dibuka di tab baru');
            window.open(`/admin/kategori-produk/${id}`, '_blank');
        }

        // Duplicate kategori
        function duplicateKategori() {
            if (confirm('Yakin ingin menduplikat kategori ini? Data akan disalin ke form tambah kategori baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $kategoriProduk->id_kategori }}',
                    nama_kategori: document.getElementById('nama_kategori').value + ' (Copy)'
                });
                
                window.open(`{{ route('admin.kategori-produk.create') }}?${params}`, '_blank');
            }
        }

        // Delete kategori
        function deleteKategori() {
            if (confirm('Yakin ingin menghapus kategori ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('admin.kategori-produk.destroy', $kategoriProduk->id_kategori) }}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const hasChanges = document.getElementById('nama_kategori').value !== originalValues.nama_kategori;
            
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Check for duplicate data from URL parameters
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('nama_kategori')) {
                    document.getElementById('nama_kategori').value = urlParams.get('nama_kategori');
                }
                
                // Show notification
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle me-2"></i>Data kategori telah diduplikat. Silakan sesuaikan seperlunya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
                
                // Auto hide after 7 seconds
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 7000);
                
                // Trigger preview update
                document.getElementById('nama_kategori').dispatchEvent(new Event('input'));
            }
        });
    </script>
    @endpush

    <style>
        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
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
    </style>
</x-layouts.admin>