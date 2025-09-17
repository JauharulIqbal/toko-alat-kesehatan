<x-layouts.customer title="Keranjang Belanja - ALKES SHOP">
    <div class="container-fluid px-4 py-5">
        <div class="row">
            <!-- Cart Items Section -->
            <div class="col-lg-8 col-md-7 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between"
                        style="border-radius: 20px 20px 0 0;">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
                        </h4>
                        <span class="badge bg-light text-primary fs-6" id="cartItemCount">
                            {{ $items->count() }} item{{ $items->count() != 1 ? 's' : '' }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        @if($items->count() > 0)
                        <div id="cartItemsContainer">
                            @foreach($items as $item)
                            <div class="cart-item border-bottom p-4" data-item-id="{{ $item->id_item_keranjang }}" data-price="{{ $item->harga }}">
                                <div class="row align-items-center g-3">
                                    <!-- Product Image -->
                                    <div class="col-md-2 col-3">
                                        <div class="product-image-container">
                                            <img src="{{ $item->produk->gambar_produk ? asset('storage/produk/' . $item->produk->gambar_produk) : 'https://via.placeholder.com/150x150/0d6efd/ffffff?text=No+Image' }}"
                                                class="img-fluid rounded-3 shadow-sm"
                                                alt="{{ $item->nama_produk }}"
                                                style="aspect-ratio: 1; object-fit: cover;">
                                        </div>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-4 col-9">
                                        <h5 class="product-name fw-bold text-primary mb-2">{{ $item->nama_produk }}</h5>
                                        <div class="product-meta">
                                            <p class="text-muted mb-1">
                                                <i class="bi bi-tag me-1"></i>
                                                {{ $item->produk->kategori->nama_kategori ?? 'Kategori tidak tersedia' }}
                                            </p>
                                            <p class="text-muted mb-1">
                                                <i class="bi bi-shop me-1"></i>
                                                {{ $item->produk->toko->nama_toko ?? 'Toko tidak tersedia' }}
                                            </p>
                                            <p class="text-success mb-0">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Stok: {{ $item->produk->stok }} unit
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-2 col-6 text-center">
                                        <div class="price-section">
                                            <small class="text-muted d-block">Harga Satuan</small>
                                            <h6 class="text-primary fw-bold mb-0">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="col-md-2 col-6">
                                        <div class="quantity-controls d-flex align-items-center justify-content-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm quantity-btn"
                                                data-action="decrease" data-item-id="{{ $item->id_item_keranjang }}"
                                                style="border-radius: 8px; width: 35px; height: 35px;">
                                                <i class="bi bi-dash fw-bold"></i>
                                            </button>
                                            <input type="number"
                                                class="form-control text-center fw-bold mx-2 quantity-input"
                                                value="{{ $item->jumlah }}"
                                                min="1"
                                                max="{{ $item->produk->stok }}"
                                                data-item-id="{{ $item->id_item_keranjang }}"
                                                style="width: 70px; border-radius: 8px;">
                                            <button type="button" class="btn btn-outline-primary btn-sm quantity-btn"
                                                data-action="increase" data-item-id="{{ $item->id_item_keranjang }}"
                                                style="border-radius: 8px; width: 35px; height: 35px;">
                                                <i class="bi bi-plus fw-bold"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block text-center mt-1">
                                            Max: {{ $item->produk->stok }}
                                        </small>
                                    </div>

                                    <!-- Item Total & Actions -->
                                    <div class="col-md-2 col-12 text-center">
                                        <div class="item-total mb-2">
                                            <small class="text-muted d-block">Total</small>
                                            <h5 class="text-success fw-bold mb-0 item-subtotal">
                                                Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn"
                                            data-item-id="{{ $item->id_item_keranjang }}"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Cart Actions -->
                        <div class="card-footer bg-light p-4" style="border-radius: 0 0 20px 20px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('customer.produk.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                                </a>
                                <button type="button" class="btn btn-outline-danger" id="clearCartBtn">
                                    <i class="bi bi-trash me-2"></i>Kosongkan Keranjang
                                </button>
                            </div>
                        </div>
                        @else
                        <!-- Empty Cart State -->
                        <div class="empty-cart text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                            </div>
                            <h4 class="text-muted mb-3">Keranjang Anda Kosong</h4>
                            <p class="text-muted mb-4">
                                Sepertinya Anda belum menambahkan produk ke keranjang.<br>
                                Ayo mulai berbelanja dan temukan produk kesehatan terbaik!
                            </p>
                            <a href="{{ route('customer.produk.index') }}" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-grid me-2"></i>Mulai Berbelanja
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="col-lg-4 col-md-5">
                <div class="sticky-summary">
                    <div class="card shadow-sm border-0" style="border-radius: 20px;">
                        <div class="card-header bg-success text-white" style="border-radius: 20px 20px 0 0;">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if($items->count() > 0)
                            <!-- Order Details -->
                            <div class="order-summary">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="fw-semibold">Subtotal ({{ $items->count() }} item)</span>
                                    <span class="fw-bold text-primary" id="cartSubtotal">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="text-muted">Estimasi Ongkos Kirim</span>
                                    <span class="text-muted">Dihitung saat checkout</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Total</h5>
                                    <h4 class="text-success fw-bold mb-0" id="cartTotal">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </h4>
                                </div>

                                <!-- Checkout Button -->
                                <div class="d-grid gap-2 mb-3">
                                    <a href="{{ route('customer.checkout.index') }}" class="btn btn-success btn-lg fw-semibold"
                                        style="border-radius: 15px; padding: 15px;">
                                        <i class="bi bi-credit-card me-2"></i>Checkout Sekarang
                                    </a>
                                </div>

                                <!-- Security Info -->
                                <div class="security-info bg-light rounded-3 p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-shield-check text-success me-2"></i>
                                        <small class="fw-semibold">Belanja Aman</small>
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        <li class="small text-muted mb-1">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                            Transaksi aman dan terpercaya
                                        </li>
                                        <li class="small text-muted mb-1">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                            Garansi kualitas produk
                                        </li>
                                        <li class="small text-muted">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                            Customer service 24/7
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-calculator text-muted fs-1 mb-3"></i>
                                <p class="text-muted">
                                    Ringkasan pesanan akan muncul<br>
                                    setelah Anda menambahkan produk
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recommendations -->
                    @if($items->count() > 0)
                    <div class="card shadow-sm border-0 mt-4" style="border-radius: 20px;">
                        <div class="card-header bg-warning text-dark" style="border-radius: 20px 20px 0 0;">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-lightbulb me-2"></i>Rekomendasi untuk Anda
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="small-product-list">
                                <!-- You can add recommended products here -->
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Produk rekomendasi berdasarkan item di keranjang Anda
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
        style="background: rgba(0,0,0,0.5); z-index: 9999;">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="text-center bg-white p-4 rounded-4 shadow">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="fw-semibold text-primary mb-0">Memperbarui keranjang...</p>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .cart-item {
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background-color: rgba(13, 110, 253, 0.02);
        }

        .quantity-controls .btn {
            transition: all 0.2s ease;
        }

        .quantity-controls .btn:hover {
            transform: scale(1.1);
        }

        .quantity-input {
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }

        .quantity-input:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        .product-image-container img {
            transition: transform 0.3s ease;
        }

        .cart-item:hover .product-image-container img {
            transform: scale(1.05);
        }

        .sticky-summary {
            position: sticky;
            top: 100px;
        }

        .remove-item-btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .sticky-summary {
                position: relative;
                top: auto;
            }

            .cart-item .row>div {
                margin-bottom: 1rem;
            }

            .quantity-controls {
                justify-content: center;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Quantity update handlers
            $('.quantity-btn').on('click', function() {
                const action = $(this).data('action');
                const itemId = $(this).data('item-id');
                const input = $(`.quantity-input[data-item-id="${itemId}"]`);
                let currentValue = parseInt(input.val());
                const maxStock = parseInt(input.attr('max'));

                if (action === 'increase' && currentValue < maxStock) {
                    input.val(currentValue + 1);
                } else if (action === 'decrease' && currentValue > 1) {
                    input.val(currentValue - 1);
                } else if (action === 'increase' && currentValue >= maxStock) {
                    showToast('Jumlah melebihi stok yang tersedia', 'warning');
                    return;
                }

                updateCartItem(itemId, input.val());
            });

            // Direct quantity input
            $('.quantity-input').on('change', function() {
                const itemId = $(this).data('item-id');
                let quantity = parseInt($(this).val());
                const maxStock = parseInt($(this).attr('max'));

                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    $(this).val(1);
                } else if (quantity > maxStock) {
                    quantity = maxStock;
                    $(this).val(maxStock);
                    showToast('Jumlah melebihi stok yang tersedia', 'warning');
                }

                updateCartItem(itemId, quantity);
            });

            // Remove item
            $('.remove-item-btn').on('click', function() {
                const itemId = $(this).data('item-id');
                const productName = $(this).closest('.cart-item').find('.product-name').text();

                if (confirm(`Apakah Anda yakin ingin menghapus "${productName}" dari keranjang?`)) {
                    removeCartItem(itemId);
                }
            });

            // Clear entire cart
            $('#clearCartBtn').on('click', function() {
                if (confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
                    clearCart();
                }
            });

            // Update cart item function - FIXED VERSION
            function updateCartItem(itemId, quantity) {
                $('#loadingOverlay').removeClass('d-none');

                $.ajax({
                    url: "{{ url('customer/keranjang/update') }}/" + itemId,
                    method: 'PUT',
                    data: {
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update item subtotal
                            $(`.cart-item[data-item-id="${itemId}"] .item-subtotal`).text(
                                'Rp ' + response.item_subtotal
                            );

                            // Update cart totals
                            $('#cartSubtotal, #cartTotal').text('Rp ' + response.cart_subtotal);

                            showToast(response.message, 'success');
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response?.message || 'Terjadi kesalahan', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').addClass('d-none');
                    }
                });
            }

            // Remove cart item function - FIXED VERSION
            function removeCartItem(itemId) {
                $('#loadingOverlay').removeClass('d-none');

                $.ajax({
                    url: "{{ url('customer/keranjang/remove') }}/" + itemId,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove item from DOM
                            $(`.cart-item[data-item-id="${itemId}"]`).fadeOut(300, function() {
                                $(this).remove();

                                // Check if cart is empty
                                if ($('.cart-item').length === 0) {
                                    location.reload(); // Reload to show empty cart state
                                } else {
                                    // Update totals
                                    $('#cartSubtotal, #cartTotal').text('Rp ' + response.cart_subtotal);
                                    $('#cartItemCount').text(response.cart_count + ' item' + (response.cart_count != 1 ? 's' : ''));
                                }
                            });

                            // Update cart badge
                            $('#cartCount').text(response.cart_count);

                            showToast(response.message, 'success');
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response?.message || 'Terjadi kesalahan', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').addClass('d-none');
                    }
                });
            }

            // Clear cart function
            function clearCart() {
                $('#loadingOverlay').removeClass('d-none');

                $.ajax({
                    url: '{{ route("customer.keranjang.clear") }}',
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Reload to show empty cart state
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response?.message || 'Terjadi kesalahan', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').addClass('d-none');
                    }
                });
            }

            // Toast notification function
            function showToast(message, type = 'info') {
                if (!$('#toastContainer').length) {
                    $('body').append(`
                <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
            `);
                }

                const toastId = 'toast_' + Date.now();
                const iconMap = {
                    success: 'bi-check-circle-fill',
                    error: 'bi-x-circle-fill',
                    warning: 'bi-exclamation-triangle-fill',
                    info: 'bi-info-circle-fill'
                };

                const colorMap = {
                    success: 'text-bg-success',
                    error: 'text-bg-danger',
                    warning: 'text-bg-warning',
                    info: 'text-bg-primary'
                };

                const toast = $(`
            <div id="${toastId}" class="toast ${colorMap[type]}" role="alert">
                <div class="toast-body d-flex align-items-center">
                    <i class="bi ${iconMap[type]} me-2 fs-5"></i>
                    <div class="flex-grow-1">${message}</div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast"></button>
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

            // Make showToast available globally
            window.showToast = showToast;
        });
    </script>
    @endpush
</x-layouts.customer>