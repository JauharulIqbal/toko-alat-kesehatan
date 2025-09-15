<x-layouts.admin title="Tambah Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Tambah Produk Baru</h2>
            <p class="text-muted mb-0">Tambahkan data produk alat kesehatan baru</p>
        </div>
        <div>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Informasi Produk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="produkForm">
                        @csrf

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-semibold">
                                Nama Produk <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk') }}"
                                placeholder="Masukkan nama produk"
                                maxlength="100"
                                required>
                            @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 100 karakter</div>
                        </div>

                        {{-- Kategori Produk --}}
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label fw-semibold">
                                Kategori Produk <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('id_kategori') is-invalid @enderror"
                                id="id_kategori"
                                name="id_kategori"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Toko --}}
                        <div class="mb-3">
                            <label for="id_toko" class="form-label fw-semibold">
                                Toko <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('id_toko') is-invalid @enderror"
                                id="id_toko"
                                name="id_toko"
                                required>
                                <option value="">Pilih Toko</option>
                                @foreach($tokos as $toko)
                                <option value="{{ $toko->id_toko }}" {{ old('id_toko') == $toko->id_toko ? 'selected' : '' }}>
                                    {{ $toko->nama_toko }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Row untuk Harga dan Stok --}}
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Harga --}}
                                <div class="mb-3">
                                    <label for="harga" class="form-label fw-semibold">
                                        Harga <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                            class="form-control @error('harga') is-invalid @enderror"
                                            id="harga"
                                            name="harga"
                                            value="{{ old('harga') }}"
                                            placeholder="0"
                                            min="0"
                                            step="100"
                                            required>
                                    </div>
                                    @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Stok --}}
                                <div class="mb-3">
                                    <label for="stok" class="form-label fw-semibold">
                                        Stok <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        class="form-control @error('stok') is-invalid @enderror"
                                        id="stok"
                                        name="stok"
                                        value="{{ old('stok') }}"
                                        placeholder="0"
                                        min="0"
                                        required>
                                    @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label fw-semibold">Gambar Produk</label>
                            <input type="file"
                                class="form-control @error('gambar_produk') is-invalid @enderror"
                                id="gambar_produk"
                                name="gambar_produk"
                                accept="image/*">
                            @error('gambar_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB</div>

                            {{-- Image Preview --}}
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="removeImage">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Deskripsi Produk --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Deskripsi detail tentang produk</div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Produk
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
                            <h6 class="text-primary mb-2">Nama Produk</h6>
                            <p class="text-muted mb-0">Masukkan nama produk yang jelas dan deskriptif. Maksimal 100 karakter.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Kategori & Toko</h6>
                            <p class="text-muted mb-0">Pilih kategori yang sesuai dengan produk dan toko yang akan menjual produk ini.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Harga & Stok</h6>
                            <p class="text-muted mb-0">Masukkan harga dalam rupiah dan jumlah stok yang tersedia.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">Gambar Produk</h6>
                            <p class="text-muted mb-0">Upload gambar produk untuk menarik perhatian pembeli. Opsional.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Produk</h6>
                </div>
                <div class="card-body">
                    <div id="previewCard">
                        <div class="text-center text-muted">
                            <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
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
            const form = document.getElementById('produkForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            const imageInput = document.getElementById('gambar_produk');
            const imagePreview = document.getElementById('imagePreview');
            const preview = document.getElementById('preview');
            const removeImageBtn = document.getElementById('removeImage');

            // Form inputs
            const namaProduk = document.getElementById('nama_produk');
            const idKategori = document.getElementById('id_kategori');
            const idToko = document.getElementById('id_toko');
            const harga = document.getElementById('harga');
            const stok = document.getElementById('stok');
            const deskripsi = document.getElementById('deskripsi');

            // Update preview function
            function updatePreview() {
                const nama = namaProduk.value || 'Nama Produk';
                const kategori = idKategori.options[idKategori.selectedIndex]?.text || '-';
                const toko = idToko.options[idToko.selectedIndex]?.text || '-';
                const hargaValue = harga.value ? parseInt(harga.value) : 0;
                const stokValue = stok.value ? parseInt(stok.value) : 0;
                const deskripsiValue = deskripsi.value || 'Tidak ada deskripsi';

                const stokClass = stokValue == 0 ? 'danger' : (stokValue <= 10 ? 'warning' : 'success');
                const stokText = stokValue == 0 ? 'Habis' : (stokValue <= 10 ? 'Menipis' : 'Tersedia');

                previewCard.innerHTML = `
                    <div class="text-center mb-3">
                        ${preview.src && preview.src !== window.location.href ? 
                            `<img src="${preview.src}" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">` :
                            `<div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>`
                        }
                    </div>
                    <div class="small">
                        <h6 class="mb-2 fw-semibold text-center">${nama}</h6>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Kategori:</div>
                            <div class="col-7">${kategori !== 'Pilih Kategori' ? kategori : '-'}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Toko:</div>
                            <div class="col-7">${toko !== 'Pilih Toko' ? toko : '-'}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Harga:</div>
                            <div class="col-7 fw-bold text-primary">Rp ${new Intl.NumberFormat('id-ID').format(hargaValue)}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Stok:</div>
                            <div class="col-7"><span class="badge bg-${stokClass}">${stokValue}</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Status:</div>
                            <div class="col-7"><span class="badge bg-${stokClass}">${stokText}</span></div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted mb-1">Deskripsi:</div>
                            <div class="text-muted small">${deskripsiValue.substring(0, 80)}${deskripsiValue.length > 80 ? '...' : ''}</div>
                        </div>
                    </div>
                `;
            }

            // Add event listeners for real-time preview
            [namaProduk, idKategori, idToko, harga, stok, deskripsi].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Handle image upload preview
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2048000) { // 2MB
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        e.target.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        updatePreview();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove image
            removeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                preview.src = '';
                imagePreview.style.display = 'none';
                updatePreview();
            });

            // Initial preview update
            updatePreview();

            // Handle duplicate data from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('duplicate')) {
                if (urlParams.get('nama_produk')) namaProduk.value = urlParams.get('nama_produk');
                if (urlParams.get('id_kategori')) idKategori.value = urlParams.get('id_kategori');
                if (urlParams.get('id_toko')) idToko.value = urlParams.get('id_toko');
                if (urlParams.get('harga')) harga.value = urlParams.get('harga');
                if (urlParams.get('stok')) stok.value = urlParams.get('stok');
                if (urlParams.get('deskripsi')) deskripsi.value = urlParams.get('deskripsi');

                // Show notification
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle me-2"></i>Data produk telah diduplikat. Silakan sesuaikan seperlunya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));

                // Auto hide after 7 seconds
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 7000);
            }

            // Form validation
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';

                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Produk';
                }, 5000);
            });

            // Character counter for nama produk
            const namaCounter = document.createElement('div');
            namaCounter.className = 'form-text text-end';
            namaCounter.id = 'namaCounter';
            namaProduk.parentNode.appendChild(namaCounter);

            namaProduk.addEventListener('input', function() {
                const remaining = 100 - this.value.length;
                namaCounter.textContent = `${this.value.length}/100 karakter`;
                namaCounter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            });

            // Initial counter update
            namaProduk.dispatchEvent(new Event('input'));

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
                    preview.src = '';
                    imagePreview.style.display = 'none';
                    updatePreview();
                    namaProduk.dispatchEvent(new Event('input'));
                }
            });

            // Format number input for harga
            harga.addEventListener('input', function() {
                // Remove non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                updatePreview();
            });

            // Validate stok input
            stok.addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
                updatePreview();
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
            min-height: 300px;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .img-thumbnail {
            border: 2px solid #e9ecef;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
        }
    </style>
</x-layouts.admin>