<x-layouts.admin title="Tambah Kategori Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Kategori Produk</h2>
            <p class="text-muted mb-0">Tambahkan kategori produk alat kesehatan baru</p>
        </div>
        <div>
            <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-tag me-2"></i>Informasi Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori-produk.store') }}" method="POST" id="kategoriForm">
                        @csrf
                        
                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}" 
                                   placeholder="Masukkan nama kategori produk"
                                   maxlength="100"
                                   required
                                   autocomplete="off">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter. Contoh: Alat Kesehatan Umum, Peralatan Medis, dll.</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Kategori
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
                            <h6 class="text-primary mb-2">Nama Kategori</h6>
                            <p class="text-muted mb-0">Masukkan nama kategori yang jelas dan deskriptif. Nama kategori harus unik dan belum ada dalam sistem.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Contoh Kategori</h6>
                            <ul class="text-muted ps-3 mb-0">
                                <li>Alat Kesehatan Umum</li>
                                <li>Peralatan Medis</li>
                                <li>Obat-obatan</li>
                                <li>Vitamin & Suplemen</li>
                                <li>Peralatan Olahraga</li>
                                <li>Alat Bantu Terapi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Kategori</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-tag" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Preview akan muncul saat mengisi form</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Templates --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Template Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="setTemplate('Alat Kesehatan Umum')">
                            Alat Kesehatan Umum
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="setTemplate('Peralatan Medis')">
                            Peralatan Medis
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="setTemplate('Obat-obatan')">
                            Obat-obatan
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="setTemplate('Vitamin & Suplemen')">
                            Vitamin & Suplemen
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="setTemplate('Alat Bantu Terapi')">
                            Alat Bantu Terapi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const form = document.getElementById('kategoriForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            const namaKategori = document.getElementById('nama_kategori');

            // Update preview function
            function updatePreview() {
                const nama = namaKategori.value || 'Nama Kategori';
                const now = new Date();
                const formattedDate = now.toLocaleDateString('id-ID');

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-tag text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}</h6>
                            <span class="badge bg-success mt-1">Kategori Baru</span>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7"><span class="badge bg-primary">Aktif</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Produk:</div>
                            <div class="col-7"><span class="badge bg-secondary">0 Produk</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">${formattedDate}</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted small">
                                ${nama.length > 50 ? 
                                    '<div class="alert alert-warning py-1 mb-0"><small><i class="bi bi-exclamation-triangle me-1"></i>Nama kategori terlalu panjang</small></div>' : 
                                    '<div class="alert alert-success py-1 mb-0"><small><i class="bi bi-check-circle me-1"></i>Nama kategori sudah sesuai</small></div>'
                                }
                            </div>
                        </div>
                    </div>
                `;

                // Update submit button
                if (nama.trim() && nama !== 'Nama Kategori') {
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Kategori';
                } else {
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Kategori';
                }
            }

            // Add event listener for real-time preview
            namaKategori.addEventListener('input', updatePreview);

            // Initial preview update
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                
                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Kategori';
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

            // Initial counter update
            namaKategori.dispatchEvent(new Event('input'));

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
                if (confirm('Yakin ingin mereset form?')) {
                    form.reset();
                    updatePreview();
                    namaKategori.dispatchEvent(new Event('input'));
                    namaKategori.focus();
                }
            });

            // Focus on input when page loads
            namaKategori.focus();
        });

        // Set template function
        function setTemplate(templateName) {
            const namaKategori = document.getElementById('nama_kategori');
            namaKategori.value = templateName;
            namaKategori.dispatchEvent(new Event('input'));
            namaKategori.focus();
        }

        // Check for duplicate name
        let checkTimeout;
        document.getElementById('nama_kategori').addEventListener('input', function() {
            const input = this;
            clearTimeout(checkTimeout);
            
            checkTimeout = setTimeout(() => {
                if (input.value.length > 2) {
                    // Here you can add AJAX call to check for duplicate names
                    // For now, we'll just show a visual indication
                    checkDuplicateName(input.value);
                }
            }, 500);
        });

        function checkDuplicateName(name) {
            // This would be an AJAX call in a real implementation
            // fetch('/admin/kategori-produk/check-duplicate', { ... })
            
            // For demo purposes, we'll simulate some common duplicates
            const commonNames = ['Alat Kesehatan', 'Peralatan Medis', 'Obat', 'Vitamin'];
            const isDuplicate = commonNames.some(common => 
                name.toLowerCase().includes(common.toLowerCase())
            );
            
            const namaKategori = document.getElementById('nama_kategori');
            const existingFeedback = namaKategori.parentNode.querySelector('.duplicate-feedback');
            
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            if (isDuplicate && name.length > 5) {
                const feedback = document.createElement('div');
                feedback.className = 'form-text text-warning duplicate-feedback';
                feedback.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Pastikan nama kategori tidak duplikat dengan yang sudah ada';
                namaKategori.parentNode.appendChild(feedback);
            }
        }
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

        .btn-outline-primary:hover {
            transform: translateY(-1px);
            transition: transform 0.2s ease;
        }

        .alert {
            border-radius: 0.375rem;
        }

        .duplicate-feedback {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-layouts.admin>