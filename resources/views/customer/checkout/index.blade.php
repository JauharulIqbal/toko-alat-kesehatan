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

        @if(!$hasRequiredPaymentMethods)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-2">Metode Pembayaran Belum Lengkap</h6>
                            <p class="mb-2">Anda belum menambahkan nomor rekening untuk metode pembayaran berikut:</p>
                            <ul class="mb-2">
                                @foreach($missingPaymentMethods as $method)
                                <li>{{ $method }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('customer.profil.payment-methods') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>Tambahkan Metode Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
                            <div class="form-check border rounded p-3 mb-3 payment-method-option" data-type="{{ $metode->tipe_pembayaran }}">
                                <input class="form-check-input payment-method-radio" type="radio" name="id_metode_pembayaran"
                                    id="metode{{ $metode->id_metode_pembayaran }}"
                                    value="{{ $metode->id_metode_pembayaran }}"
                                    data-type="{{ $metode->tipe_pembayaran }}"
                                    {{ old('id_metode_pembayaran') == $metode->id_metode_pembayaran ? 'checked' : '' }}
                                    @if($metode->tipe_pembayaran === 'prepaid' && $metode->nomorRekeningPengguna->isEmpty()) disabled @endif
                                    required>
                                <label class="form-check-label w-100" for="metode{{ $metode->id_metode_pembayaran }}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="bi bi-credit-card-2-front fs-3 text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $metode->metode_pembayaran }}</h6>
                                                <small class="text-muted">
                                                    {{ $metode->tipe_pembayaran === 'prepaid' ? 'Pembayaran di muka' : 'Bayar di tempat (COD)' }}
                                                </small>
                                                @if($metode->tipe_pembayaran === 'prepaid' && $metode->nomorRekeningPengguna->isEmpty())
                                                <div class="mt-1">
                                                    <span class="badge bg-warning text-dark">Nomor rekening belum ditambahkan</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $metode->tipe_pembayaran === 'prepaid' ? 'primary' : 'success' }}">
                                                {{ strtoupper($metode->tipe_pembayaran) }}
                                            </span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Account Number Selection for Prepaid -->
                                @if($metode->tipe_pembayaran === 'prepaid' && $metode->nomorRekeningPengguna->isNotEmpty())
                                <div class="account-selection mt-3" id="account{{ $metode->id_metode_pembayaran }}" style="display: none;">
                                    <label class="form-label fw-semibold small text-muted">PILIH NOMOR REKENING:</label>
                                    @foreach($metode->nomorRekeningPengguna as $account)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input account-radio" type="radio" 
                                            name="id_nrp" 
                                            id="account{{ $account->id_nrp }}"
                                            value="{{ $account->id_nrp }}">
                                        <label class="form-check-label" for="account{{ $account->id_nrp }}">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-credit-card me-2 text-muted"></i>
                                                <div>
                                                    <span class="fw-semibold">{{ $account->nomor_rekening }}</span>
                                                    <small class="text-muted d-block">{{ $metode->metode_pembayaran }}</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Manual Input for COD -->
                                <div class="manual-input mt-3" id="manual{{ $metode->id_metode_pembayaran }}" style="display: none;">
                                    <label class="form-label fw-semibold small text-muted">NOMOR TELEPON UNTUK KONFIRMASI COD:</label>
                                    <input type="text" class="form-control" name="nomor_rekening_input" 
                                        placeholder="Masukkan nomor telepon" maxlength="15">
                                    <small class="text-muted">Nomor telepon akan digunakan untuk koordinasi pengiriman COD</small>
                                </div>
                            </div>
                            @endforeach
                            @error('id_metode_pembayaran')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            @error('id_nrp')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            @error('nomor_rekening_input')
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
                                <span class="fw-semibold" id="shippingCost">Pilih jasa pengiriman</span>
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
        .payment-method-option:hover {
            background-color: rgba(13, 110, 253, 0.05);
            border-color: #0d6efd !important;
        }

        .payment-method-option.selected {
            border-color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .form-check-input:checked+.form-check-label {
            color: var(--bs-primary);
        }

        .account-selection {
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1rem;
        }

        .manual-input {
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1rem;
        }

        .payment-method-option:has(.form-check-input:disabled) {
            opacity: 0.6;
            background-color: #f8f9fa;
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
            const subtotal = {{ $subtotal }};
            let currentShippingCost = 0;

            // Update shipping cost when service is selected
            $('#id_jasa_pengiriman').on('change', function() {
                const shippingCost = parseInt($(this).find(':selected').data('cost') || 0);
                currentShippingCost = shippingCost;
                const total = subtotal + shippingCost;

                if (shippingCost > 0) {
                    $('#shippingCost').text('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost));
                } else {
                    $('#shippingCost').text('Rp 0');
                }
                $('#totalAmount').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
            });

            // Handle payment method selection
            $('.payment-method-radio').on('change', function() {
                const selectedMethod = $(this);
                const methodType = selectedMethod.data('type');
                const methodId = selectedMethod.val();

                // Reset all selections
                $('.payment-method-option').removeClass('selected');
                $('.account-selection, .manual-input').hide();
                $('.account-radio').prop('required', false);
                $('input[name="nomor_rekening_input"]').prop('required', false);

                // Highlight selected method
                selectedMethod.closest('.payment-method-option').addClass('selected');

                if (methodType === 'prepaid') {
                    // Show account selection for prepaid
                    $('#account' + methodId).show();
                    $('#account' + methodId + ' .account-radio').prop('required', true);
                } else {
                    // Show manual input for postpaid (COD)
                    $('#manual' + methodId).show();
                    $('#manual' + methodId + ' input[name="nomor_rekening_input"]').prop('required', true);
                }
            });

            // Handle account selection for prepaid methods
            $('.account-radio').on('change', function() {
                // Remove required from other account radios
                $('.account-radio').not(this).prop('required', false);
            });

            // Form submission
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                // Validate shipping selection
                if (!$('#id_jasa_pengiriman').val()) {
                    showToast('Silakan pilih jasa pengiriman', 'error');
                    return;
                }

                // Validate payment method selection
                if (!$('input[name="id_metode_pembayaran"]:checked').length) {
                    showToast('Silakan pilih metode pembayaran', 'error');
                    return;
                }

                const selectedPaymentType = $('input[name="id_metode_pembayaran"]:checked').data('type');
                
                // Validate account selection for prepaid
                if (selectedPaymentType === 'prepaid') {
                    if (!$('input[name="id_nrp"]:checked').length) {
                        showToast('Silakan pilih nomor rekening', 'error');
                        return;
                    }
                } else {
                    // Validate phone number for COD
                    const phoneNumber = $('input[name="nomor_rekening_input"]').val();
                    if (!phoneNumber || phoneNumber.trim() === '') {
                        showToast('Silakan masukkan nomor telepon untuk koordinasi COD', 'error');
                        return;
                    }
                }

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
                            setTimeout(function() {
                                if (response.redirect_url) {
                                    window.location.href = response.redirect_url;
                                } else {
                                    window.location.href = '{{ route("customer.pesanan.index") }}';
                                }
                            }, 1500);
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
                                const firstError = Object.values(errors)[0];
                                message = Array.isArray(firstError) ? firstError[0] : firstError;
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

            // Initialize on page load
            const checkedPaymentMethod = $('input[name="id_metode_pembayaran"]:checked');
            if (checkedPaymentMethod.length) {
                checkedPaymentMethod.trigger('change');
            }

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