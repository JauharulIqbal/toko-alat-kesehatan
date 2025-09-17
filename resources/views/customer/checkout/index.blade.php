<x-layouts.customer title="Checkout - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Checkout Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('customer.dashboard') }}" class="text-decoration-none">
                                        <i class="bi bi-house"></i> Beranda
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('customer.keranjang.index') }}" class="text-decoration-none">
                                        Keranjang
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="bi bi-credit-card me-2"></i>Checkout Pesanan
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <form id="checkoutForm" method="POST" action="{{ route('customer.checkout.process') }}">
            @csrf
            <div class="row g-4">
                <!-- Order Items -->
                <div class="col-lg-8">
                    <!-- Items Review -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-bag-check me-2"></i>Review Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($items as $item)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-2">
                                    <img src="{{ $item->produk->gambar_produk ? asset('storage/produk/' . $item->produk->gambar_produk) : 'https://via.placeholder.com/80x80/f8f9fa/dee2e6?text=No+Image' }}"
                                        alt="{{ $item->nama_produk }}"
                                        class="img-fluid rounded"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-1">{{ $item->nama_produk }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-shop me-1"></i>{{ $item->produk->toko->nama_toko }}
                                    </small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="fw-semibold">{{ $item->jumlah }}x</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <h6 class="text-primary fw-bold mb-0">
                                        Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                    </h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-geo-alt me-2"></i>Informasi Pengiriman
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror"
                                    id="alamat_pengiriman"
                                    name="alamat_pengiriman"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap pengiriman"
                                    required>{{ old('alamat_pengiriman', Auth::user()->alamat) }}</textarea>
                                @error('alamat_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_jasa_pengiriman" class="form-label fw-semibold">Jasa Pengiriman <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_jasa_pengiriman') is-invalid @enderror"
                                    id="id_jasa_pengiriman"
                                    name="id_jasa_pengiriman"
                                    required>
                                    <option value="">Pilih jasa pengiriman</option>
                                    @foreach($jasaPengiriman as $jasa)
                                    <option value="{{ $jasa->id_jasa_pengiriman }}"
                                        data-cost="{{ $jasa->biaya_pengiriman }}"
                                        {{ old('id_jasa_pengiriman') == $jasa->id_jasa_pengiriman ? 'selected' : '' }}>
                                        {{ $jasa->nama_jasa_pengiriman }} - Rp {{ number_format($jasa->biaya_pengiriman, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jasa_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label for="catatan" class="form-label fw-semibold">Catatan (Opsional)</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror"
                                    id="catatan"
                                    name="catatan"
                                    rows="2"
                                    placeholder="Catatan untuk penjual atau kurir">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-credit-card me-2"></i>Metode Pembayaran
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($metodePembayaran as $metode)
                            <div class="form-check border rounded p-3 mb-3">
                                <input class="form-check-input" type="radio" name="id_metode_pembayaran"
                                    id="metode{{ $metode->id_metode_pembayaran }}"
                                    value="{{ $metode->id_metode_pembayaran }}"
                                    {{ old('id_metode_pembayaran') == $metode->id_metode_pembayaran ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label w-100" for="metode{{ $metode->id_metode_pembayaran }}">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-credit-card-2-front fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $metode->metode_pembayaran }}</h6>
                                            <small class="text-muted">{{ $metode->deskripsi ?? 'Pembayaran melalui ' . $metode->metode_pembayaran }}</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            @error('id_metode_pembayaran')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 120px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal ({{ $items->count() }} item)</span>
                                <span class="fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Biaya Pengiriman</span>
                                <span class="fw-semibold" id="shippingCost">Rp 0</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total</span>
                                <h5 class="text-primary fw-bold" id="totalAmount">Rp {{ number_format($subtotal, 0, ',', '.') }}</h5>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg" id="submitCheckout">
                                <i class="bi bi-lock me-2"></i>Bayar Sekarang
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Transaksi aman dan terjamin
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        .form-check:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .form-check-input:checked+.form-check-label {
            color: var(--bs-primary);
        }

        .sticky-top {
            max-height: calc(100vh - 140px);
            overflow-y: auto;
        }

        @media (max-width: 992px) {
            .sticky-top {
                position: relative !important;
                top: auto !important;
                max-height: none;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            const subtotal = {
                
                    $subtotal
                
            };

            // Update shipping cost when service is selected
            $('#id_jasa_pengiriman').on('change', function() {
                const shippingCost = $(this).find(':selected').data('cost') || 0;
                const total = subtotal + shippingCost;

                $('#shippingCost').text('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost));
                $('#totalAmount').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
            });

            // Form submission
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                const submitBtn = $('#submitCheckout');
                const originalText = submitBtn.html();

                // Show loading
                submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...').prop('disabled', true);

                // Submit form
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            showToast('Pesanan berhasil dibuat!', 'success');

                            // Redirect to success page
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                window.location.href = '{{ route("customer.pesanan.index") }}';
                            }
                        } else {
                            showToast(response.message || 'Terjadi kesalahan', 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan. Silakan coba lagi.';

                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            if (errors) {
                                message = Object.values(errors).flat().join(', ');
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        showToast(message, 'error');
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            function showToast(message, type = 'info') {
                if (!$('#toastContainer').length) {
                    $('body').append(`
                        <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
                    `);
                }

                const toastId = 'toast_' + Date.now();
                const bgClass = type === 'success' ? 'bg-success' :
                    type === 'error' ? 'bg-danger' :
                    type === 'warning' ? 'bg-warning' : 'bg-info';

                const toast = $(`
                    <div id="${toastId}" class="toast ${bgClass} text-white" role="alert">
                        <div class="toast-body">
                            ${message}
                            <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `);

                $('#toastContainer').append(toast);

                const bsToast = new bootstrap.Toast(toast[0], {
                    autohide: true,
                    delay: 4000
                });
                bsToast.show();

                toast[0].addEventListener('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }
        });
    </script>
    @endpush
</x-layouts.customer>