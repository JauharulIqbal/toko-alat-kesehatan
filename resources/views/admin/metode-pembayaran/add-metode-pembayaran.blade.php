<x-layouts.admin title="Tambah Metode Pembayaran">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Metode Pembayaran Baru</h2>
            <p class="text-muted mb-0">Tambahkan metode pembayaran untuk sistem toko alat kesehatan</p>
        </div>
        <div>
            <a href="{{ route('admin.metode-pembayaran.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Informasi Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.metode-pembayaran.store') }}" method="POST" id="metodePembayaranForm">
                        @csrf
                        
                        {{-- Nama Metode Pembayaran --}}
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label fw-semibold">
                                Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('metode_pembayaran') is-invalid @enderror" 
                                   id="metode_pembayaran" 
                                   name="metode_pembayaran" 
                                   value="{{ old('metode_pembayaran') }}" 
                                   placeholder="Contoh: Bank BCA, OVO, DANA, Cash on Delivery"
                                   maxlength="255"
                                   required>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nama metode pembayaran yang akan ditampilkan ke customer</div>
                            <div class="form-text text-end" id="metodePembayaranCounter">0/255 karakter</div>
                        </div>

                        {{-- Tipe Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Tipe Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card h-100 tipe-card" data-value="prepaid">
                                        <div class="card-body text-center">
                                            <input type="radio" class="form-check-input d-none" 
                                                   id="prepaid" name="tipe_pembayaran" value="prepaid"
                                                   {{ old('tipe_pembayaran') == 'prepaid' ? 'checked' : '' }}>
                                            <label for="prepaid" class="w-100 cursor-pointer">
                                                <i class="bi bi-arrow-up-circle text-success mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="mb-2">Prepaid</h6>
                                                <p class="small text-muted mb-0">Pembayaran dilakukan di depan sebelum barang dikirim</p>
                                                <div class="mt-2">
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        Transfer Bank, E-Wallet
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 tipe-card" data-value="postpaid">
                                        <div class="card-body text-center">
                                            <input type="radio" class="form-check-input d-none" 
                                                   id="postpaid" name="tipe_pembayaran" value="postpaid"
                                                   {{ old('tipe_pembayaran') == 'postpaid' ? 'checked' : '' }}>
                                            <label for="postpaid" class="w-100 cursor-pointer">
                                                <i class="bi bi-arrow-down-circle text-info mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="mb-2">Postpaid</h6>
                                                <p class="small text-muted mb-0">Pembayaran dilakukan setelah barang diterima</p>
                                                <div class="mt-2">
                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                        Cash on Delivery (COD)
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('tipe_pembayaran')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Duplicate Check Alert --}}
                        <div id="duplicateAlert" class="alert alert-warning" style="display: none;">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <span id="duplicateMessage">Metode pembayaran sudah ada dalam sistem</span>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.metode-pembayaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Metode Pembayaran
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
                            <h6 class="text-primary mb-2">Metode Pembayaran</h6>
                            <p class="text-muted mb-0">Masukkan nama metode pembayaran yang mudah dipahami customer. Contoh: Bank BCA, OVO, DANA, GoPay, Cash on Delivery.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Tipe Pembayaran</h6>
                            <ul class="text-muted ps-3 mb-0">
                                <li><strong>Prepaid:</strong> Pembayaran di depan (Transfer Bank, E-Wallet, Virtual Account)</li>
                                <li><strong>Postpaid:</strong> Pembayaran belakang (Cash on Delivery/COD)</li>
                            </ul>
                        </div>
                        <div class="alert alert-light border-warning mb-0">
                            <small><i class="bi bi-lightbulb me-1"></i><strong>Tips:</strong> Gunakan nama yang konsisten untuk memudah pengelolaan sistem pembayaran.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-credit-card" style="font-size: 3rem;"></i>
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
            const form = document.getElementById('metodePembayaranForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            const duplicateAlert = document.getElementById('duplicateAlert');
            
            // Form inputs
            const metodePembayaran = document.getElementById('metode_pembayaran');
            const tipeCards = document.querySelectorAll('.tipe-card');
            const tipeRadios = document.querySelectorAll('input[name="tipe_pembayaran"]');
            
            let duplicateCheckTimeout;

            // Update preview function
            function updatePreview() {
                const metode = metodePembayaran.value || 'Metode Pembayaran';
                const selectedTipe = document.querySelector('input[name="tipe_pembayaran"]:checked');
                const tipe = selectedTipe ? selectedTipe.value : 'prepaid';

                const tipeClass = tipe === 'prepaid' ? 'success' : 'info';
                const tipeIcon = tipe === 'prepaid' ? 'arrow-up-circle' : 'arrow-down-circle';
                const tipeText = tipe === 'prepaid' ? 'Prepaid (Bayar di depan)' : 'Postpaid (Bayar belakang)';

                previewCard.innerHTML = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-credit-card text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">${metode}</h6>
                            <small class="text-muted">Metode Pembayaran Baru</small>
                        </div>
                    </div>
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Tipe:</div>
                            <div class="col-8">
                                <span class="badge bg-${tipeClass}">
                                    <i class="bi bi-${tipeIcon} me-1"></i>
                                    ${tipeText}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-muted">Status:</div>
                            <div class="col-8">
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock me-1"></i>Belum Disimpan
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="alert alert-info py-2 mb-0">
                                <small><i class="bi bi-info-circle me-1"></i>Metode pembayaran akan aktif setelah disimpan</small>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Handle tipe selection
            tipeCards.forEach(card => {
                card.addEventListener('click', function() {
                    const value = this.dataset.value;
                    const radio = document.getElementById(value);
                    
                    // Update radio button
                    radio.checked = true;
                    
                    // Update card appearance
                    updateTipeCards();
                    updatePreview();
                });
            });

            // Update tipe cards appearance
            function updateTipeCards() {
                const selected = document.querySelector('input[name="tipe_pembayaran"]:checked');
                
                tipeCards.forEach(card => {
                    if (selected && card.dataset.value === selected.value) {
                        card.classList.add('border-primary', 'shadow-sm');
                        card.classList.remove('border');
                    } else {
                        card.classList.remove('border-primary', 'shadow-sm');
                        card.classList.add('border');
                    }
                });
            }

            // Character counter for metode pembayaran
            const counter = document.getElementById('metodePembayaranCounter');
            metodePembayaran.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length}/255 karakter`;
                counter.className = length > 200 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
                
                // Update preview
                updatePreview();
                
                // Check for duplicates
                clearTimeout(duplicateCheckTimeout);
                if (length > 2) {
                    duplicateCheckTimeout = setTimeout(() => {
                        checkDuplicate();
                    }, 800);
                } else {
                    duplicateAlert.style.display = 'none';
                }
            });

            // Check duplicate function
            function checkDuplicate() {
                const metode = metodePembayaran.value.trim();
                
                if (metode.length < 3) return;

                fetch('{{ route("admin.metode-pembayaran.check-duplicate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        metode_pembayaran: metode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.exists) {
                            duplicateAlert.style.display = 'block';
                            document.getElementById('duplicateMessage').textContent = data.message;
                            metodePembayaran.classList.add('is-invalid');
                            submitBtn.disabled = true;
                        } else {
                            duplicateAlert.style.display = 'none';
                            metodePembayaran.classList.remove('is-invalid');
                            submitBtn.disabled = false;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking duplicate:', error);
                });
            }

            // Initial setup
            updateTipeCards();
            updatePreview();

            // Form validation
            form.addEventListener('submit', function(e) {
                const selectedTipe = document.querySelector('input[name="tipe_pembayaran"]:checked');
                
                if (!selectedTipe) {
                    e.preventDefault();
                    showAlert('danger', 'Silakan pilih tipe pembayaran');
                    return;
                }

                if (submitBtn.disabled) {
                    e.preventDefault();
                    showAlert('danger', 'Terdapat kesalahan dalam pengisian form');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                
                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Metode Pembayaran';
                }, 5000);
            });

            // Handle duplicate data from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('metode_pembayaran')) metodePembayaran.value = urlParams.get('metode_pembayaran');
                if (urlParams.get('tipe_pembayaran')) {
                    const tipeValue = urlParams.get('tipe_pembayaran');
                    document.getElementById(tipeValue).checked = true;
                }
                
                // Update UI
                updateTipeCards();
                updatePreview();
                metodePembayaran.dispatchEvent(new Event('input'));
                
                // Show notification
                showAlert('info', 'Data metode pembayaran telah diduplikat. Silakan sesuaikan seperlunya.');
            }

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.id !== 'duplicateAlert') {
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
                    duplicateAlert.style.display = 'none';
                    submitBtn.disabled = false;
                    updateTipeCards();
                    updatePreview();
                    metodePembayaran.dispatchEvent(new Event('input'));
                }
            });
        });

        // Show alert function
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container-fluid');
            const firstCard = container.querySelector('.row');
            container.insertBefore(alertDiv, firstCard);
            
            // Auto hide after 7 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 7000);
        }
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
            transition: all 0.2s ease;
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

        .tipe-card {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
        }

        .tipe-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .tipe-card.border-primary {
            border-width: 2px !important;
            transform: translateY(-2px);
        }

        .cursor-pointer {
            cursor: pointer;
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
            border-radius: 0.5rem;
        }

        /* Radio button styling */
        .form-check-input {
            display: none !important;
        }
    </style>
</x-layouts.admin>