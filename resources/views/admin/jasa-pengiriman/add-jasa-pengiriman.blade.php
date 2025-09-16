<x-layouts.admin title="Tambah Jasa Pengiriman">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Jasa Pengiriman Baru</h2>
            <p class="text-muted mb-0">Tambahkan data jasa pengiriman untuk toko alat kesehatan</p>
        </div>
        <div>
            <a href="{{ route('admin.jasa-pengiriman.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Informasi Jasa Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jasa-pengiriman.store') }}" method="POST" id="jasaPengirimanForm">
                        @csrf
                        
                        {{-- Nama Jasa Pengiriman --}}
                        <div class="mb-3">
                            <label for="nama_jasa_pengiriman" class="form-label fw-semibold">
                                Nama Jasa Pengiriman <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_jasa_pengiriman') is-invalid @enderror" 
                                   id="nama_jasa_pengiriman" 
                                   name="nama_jasa_pengiriman" 
                                   value="{{ old('nama_jasa_pengiriman') }}" 
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
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('biaya_pengiriman') is-invalid @enderror" 
                                       id="biaya_pengiriman" 
                                       name="biaya_pengiriman" 
                                       value="{{ old('biaya_pengiriman') }}" 
                                       placeholder="0"
                                       min="0"
                                       step="0.01"
                                       max="999999999999.99"
                                       required>
                                @error('biaya_pengiriman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Masukkan biaya dalam rupiah (Rp)</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.jasa-pengiriman.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Jasa Pengiriman
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
                            <h6 class="text-primary mb-2">Nama Jasa Pengiriman</h6>
                            <p class="text-muted mb-0">Masukkan nama jasa pengiriman yang jelas dan mudah diingat. Contoh: JNE Regular, Pos Indonesia, Gojek Same Day, dll. Maksimal 100 karakter.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Biaya Pengiriman</h6>
                            <p class="text-muted mb-0">Masukkan biaya pengiriman dalam rupiah. Sistem akan otomatis memformat angka. Biaya harus berupa angka positif.</p>
                        </div>
                        <div class="alert alert-warning py-2 px-3">
                            <small class="mb-0">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Jasa Pengiriman</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-truck" style="font-size: 3rem;"></i>
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

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-truck text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${nama}</h6>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Nama Jasa:</div>
                            <div class="col-7">${nama}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Biaya:</div>
                            <div class="col-7">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    Rp ${formattedBiaya}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="alert alert-info py-2 px-3">
                                <small class="mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Data siap disimpan
                                </small>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Add event listeners for real-time preview
            [namaJasaPengiriman, biayaPengiriman].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Handle duplicate data from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('nama_jasa_pengiriman')) namaJasaPengiriman.value = urlParams.get('nama_jasa_pengiriman');
                if (urlParams.get('biaya_pengiriman')) biayaPengiriman.value = urlParams.get('biaya_pengiriman');
                
                // Show notification
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle me-2"></i>Data jasa pengiriman telah diduplikat. Silakan sesuaikan seperlunya.
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Jasa Pengiriman';
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

            // Initial counter update
            namaJasaPengiriman.dispatchEvent(new Event('input'));

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
                    namaJasaPengiriman.dispatchEvent(new Event('input'));
                }
            });

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

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }
    </style>
</x-layouts.admin>