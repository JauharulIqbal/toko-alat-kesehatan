<x-layouts.admin title="Edit Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Produk</h2>
            <p class="text-muted mb-0">Perbarui data produk alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Produk</h5>
                    <span class="badge bg-dark">ID: {{ $produk->id_produk }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" id="produkForm">
                        @csrf
                        @method('PUT')

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-semibold">
                                Nama Produk <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk', $produk->nama_produk) }}"
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
                                <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($produk->kategori)
                            <div class="form-text">Kategori saat ini: <strong>{{ $produk->kategori->nama_kategori }}</strong></div>
                            @endif
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
                                <option value="{{ $toko->id_toko }}" {{ old('id_toko', $produk->id_toko) == $toko->id_toko ? 'selected' : '' }}>
                                    {{ $toko->nama_toko }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($produk->toko)
                            <div class="form-text">Toko saat ini: <strong>{{ $produk->toko->nama_toko }}</strong></div>
                            @endif
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
                                            value="{{ old('harga', $produk->harga) }}"
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
                                        value="{{ old('stok', $produk->stok) }}"
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

                            {{-- Current Image Preview --}}
                            @if($produk->gambar_produk)
                            <div class="mt-3" id="currentImage">
                                <label class="form-label fw-semibold">Gambar Saat Ini:</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="img-thumbnail"
                                        style="max-width: 150px; max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCurrentImage()">
                                        <i class="bi bi-trash"></i> Hapus Gambar
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- New Image Preview --}}
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <label class="form-label fw-semibold">Preview Gambar Baru:</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeImage">
                                        <i class="bi bi-trash"></i> Hapus Preview
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi Produk --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
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
                            <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Produk
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7">{{ $produk->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Diperbarui:</div>
                            <div class="col-7">{{ $produk->updated_at->format('d M Y H:i') }}</div>
                        </div>
                        @php
                        $currentStokClass = $produk->stok == 0 ? 'bg-danger' : ($produk->stok <= 10 ? 'bg-warning' : 'bg-success' );
                            $currentStokText=$produk->stok == 0 ? 'Habis' : ($produk->stok <= 10 ? 'Menipis' : 'Tersedia' );
                                @endphp
                                <div class="row mb-2">
                                <div class="col-5 text-muted">Status Stok:</div>
                                <div class="col-7">
                                    <span class="badge {{ $currentStokClass }}">{{ $currentStokText }}</span>
                                </div>
                    </div>
                    @if($produk->kategori)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Kategori:</div>
                        <div class="col-7">{{ $produk->kategori->nama_kategori }}</div>
                    </div>
                    @endif
                    @if($produk->toko)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Toko:</div>
                        <div class="col-7">{{ $produk->toko->nama_toko }}</div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Harga:</div>
                        <div class="col-7 fw-bold text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
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
                        <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
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
                    @if($produk->stok == 0)
                    <button type="button" class="btn btn-warning btn-sm" onclick="restockProduct()">
                        <i class="bi bi-arrow-up-circle me-2"></i>Isi Ulang Stok
                    </button>
                    @endif
                    <button type="button" class="btn btn-info btn-sm" onclick="viewProduk('{{ $produk->id_produk }}')">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="duplicateProduk()">
                        <i class="bi bi-files me-2"></i>Duplikat Produk
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
                                <h6 class="mb-1">Produk Dibuat</h6>
                                <p class="text-muted mb-1">{{ $produk->created_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Produk pertama kali ditambahkan ke sistem</small>
                            </div>
                        </div>
                        @if($produk->updated_at != $produk->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Terakhir Diperbarui</h6>
                                <p class="text-muted mb-1">{{ $produk->updated_at->format('d M Y, H:i') }}</p>
                                <small class="text-muted">Stok: {{ $produk->stok }} | Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</small>
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
            nama_produk: '{{ $produk->nama_produk }}',
            id_kategori: '{{ $produk->id_kategori }}',
            id_toko: '{{ $produk->id_toko }}',
            harga: '{{ $produk->harga }}',
            stok: '{{ $produk->stok }}',
            deskripsi: '{{ $produk->deskripsi }}',
            gambar_produk: '{{ $produk->gambar_produk }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('produkForm');
            const submitBtn = document.getElementById('submitBtn');
            const previewCard = document.getElementById('previewCard');
            const imageInput = document.getElementById('gambar_produk');
            const imagePreview = document.getElementById('imagePreview');
            const preview = document.getElementById('preview');
            const removeImageBtn = document.getElementById('removeImage');
            const currentImage = document.getElementById('currentImage');

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

                // Check for changes
                const hasChanges = nama !== originalValues.nama_produk ||
                    idKategori.value !== originalValues.id_kategori ||
                    idToko.value !== originalValues.id_toko ||
                    harga.value !== originalValues.harga ||
                    stok.value !== originalValues.stok ||
                    deskripsi.value !== originalValues.deskripsi ||
                    imageInput.files.length > 0;

                const changesBadge = hasChanges ? '<span class="badge bg-warning ms-2">Ada Perubahan</span>' : '';

                // Determine which image to show
                let imageHtml;
                if (preview.src && preview.src !== window.location.href) {
                    imageHtml = `<img src="${preview.src}" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">`;
                } else if (originalValues.gambar_produk) {
                    imageHtml = `<img src="/storage/${originalValues.gambar_produk}" alt="Current" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">`;
                } else {
                    imageHtml = `<div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                    </div>`;
                }

                previewCard.innerHTML = `
                    <div class="text-center mb-3">
                        ${imageHtml}
                    </div>
                    <div class="small">
                        <h6 class="mb-2 fw-semibold text-center">${nama}${changesBadge}</h6>
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
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Perbarui Produk';
                }
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
                        if (currentImage) currentImage.style.display = 'none';
                        updatePreview();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove new image preview
            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    imageInput.value = '';
                    preview.src = '';
                    imagePreview.style.display = 'none';
                    if (currentImage) currentImage.style.display = 'block';
                    updatePreview();
                });
            }

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

            namaProduk.dispatchEvent(new Event('input'));

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

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

        // Reset to original values
        function resetToOriginal() {
            if (confirm('Yakin ingin mereset semua perubahan ke nilai asli?')) {
                document.getElementById('nama_produk').value = originalValues.nama_produk;
                document.getElementById('id_kategori').value = originalValues.id_kategori;
                document.getElementById('id_toko').value = originalValues.id_toko;
                document.getElementById('harga').value = originalValues.harga;
                document.getElementById('stok').value = originalValues.stok;
                document.getElementById('deskripsi').value = originalValues.deskripsi;

                // Reset image
                document.getElementById('gambar_produk').value = '';
                document.getElementById('preview').src = '';
                document.getElementById('imagePreview').style.display = 'none';
                const currentImage = document.getElementById('currentImage');
                if (currentImage) currentImage.style.display = 'block';

                // Trigger preview update
                document.getElementById('nama_produk').dispatchEvent(new Event('input'));
            }
        }

        // Remove current image
        function removeCurrentImage() {
            if (confirm('Yakin ingin menghapus gambar saat ini?')) {
                const currentImage = document.getElementById('currentImage');
                if (currentImage) {
                    currentImage.style.display = 'none';
                    // Add hidden input to indicate image removal
                    const removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = 'remove_image';
                    removeInput.value = '1';
                    document.getElementById('produkForm').appendChild(removeInput);
                }
            }
        }

        // Restock product
        function restockProduct() {
            const newStock = prompt('Masukkan jumlah stok baru:', '10');
            if (newStock !== null && !isNaN(newStock) && parseInt(newStock) >= 0) {
                document.getElementById('stok').value = parseInt(newStock);
                document.getElementById('stok').dispatchEvent(new Event('input'));
            }
        }

        // View history
        function viewHistory() {
            const modal = new bootstrap.Modal(document.getElementById('historyModal'));
            modal.show();
        }

        // View detail produk
        function viewProduk(id) {
            alert('Fitur detail produk akan dibuka di tab baru');
            window.open(`/admin/produk/${id}`, '_blank');
        }

        // Duplicate produk
        function duplicateProduk() {
            if (confirm('Yakin ingin menduplikat produk ini? Data akan disalin ke form tambah produk baru.')) {
                const params = new URLSearchParams({
                    duplicate: '{{ $produk->id_produk }}',
                    nama_produk: document.getElementById('nama_produk').value + ' (Copy)',
                    id_kategori: document.getElementById('id_kategori').value,
                    id_toko: document.getElementById('id_toko').value,
                    harga: document.getElementById('harga').value,
                    stok: document.getElementById('stok').value,
                    deskripsi: document.getElementById('deskripsi').value
                });

                window.open(`{{ route('admin.produk.create') }}?${params}`, '_blank');
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
            const hasChanges = document.getElementById('nama_produk').value !== originalValues.nama_produk ||
                document.getElementById('id_kategori').value !== originalValues.id_kategori ||
                document.getElementById('id_toko').value !== originalValues.id_toko ||
                document.getElementById('harga').value !== originalValues.harga ||
                document.getElementById('stok').value !== originalValues.stok ||
                document.getElementById('deskripsi').value !== originalValues.deskripsi ||
                document.getElementById('gambar_produk').files.length > 0;

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
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</x-layouts.admin>