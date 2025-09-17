<x-layouts.customer title="Beranda - ALKES SHOP">
    <!-- Hero Section -->
    <section class="hero-section bg-gradient-to-r from-blue-600 to-blue-800 text-white py-5">
        <div class="container-fluid px-4">
            <!-- Main Banner Carousel -->
            <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($banners as $index => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner rounded-4 overflow-hidden">
                    @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row align-items-center min-vh-50">
                            <div class="col-lg-6">
                                <div class="hero-content p-5">
                                    <h1 class="display-4 fw-bold mb-4">{{ $banner['title'] }}</h1>
                                    <p class="lead mb-4">{{ $banner['subtitle'] }}</p>
                                    <a href="{{ $banner['link'] }}" class="btn btn-warning btn-lg px-5 py-3 fw-semibold">
                                        Belanja Sekarang
                                        <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <img src="{{ asset('images/banners/' . $banner['image']) }}"
                                        class="img-fluid"
                                        alt="{{ $banner['title'] }}"
                                        onerror="this.src='https://via.placeholder.com/600x400/0d6efd/ffffff?text=ALKES+SHOP'">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <!-- Quick Stats -->
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-white bg-opacity-10 border-0 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-shield-check fs-1 text-warning mb-3"></i>
                            <h5 class="fw-bold">Produk Terpercaya</h5>
                            <p class="mb-0 opacity-75">100% Original</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-white bg-opacity-10 border-0 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-truck fs-1 text-warning mb-3"></i>
                            <h5 class="fw-bold">Pengiriman Cepat</h5>
                            <p class="mb-0 opacity-75">Ke Seluruh Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-white bg-opacity-10 border-0 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-headset fs-1 text-warning mb-3"></i>
                            <h5 class="fw-bold">Customer Service</h5>
                            <p class="mb-0 opacity-75">24/7 Siap Membantu</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-white bg-opacity-10 border-0 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-award fs-1 text-warning mb-3"></i>
                            <h5 class="fw-bold">Bergaransi</h5>
                            <p class="mb-0 opacity-75">Jaminan Kualitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Sidebar Categories -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar-sticky">
                    <!-- Categories Filter -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-grid-3x3-gap me-2"></i>
                                Kategori Produk
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('customer.produk.index') }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-grid me-2"></i>Semua Produk</span>
                                    <span class="badge bg-primary rounded-pill">{{ $featuredProducts->count() }}+</span>
                                </a>
                                @forelse($categories as $category)
                                <a href="{{ route('customer.kategori.show', $category->id_kategori) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-filter"
                                    data-category="{{ $category->id_kategori }}">
                                    <span>{{ $category->nama_kategori }}</span>
                                    <span class="badge bg-light text-dark rounded-pill">{{ $category->produk_count }}</span>
                                </a>
                                @empty
                                <div class="list-group-item text-muted text-center py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    Belum ada kategori
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Popular Stores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-shop me-2"></i>
                                Toko Populer
                            </h5>
                        </div>
                        <div class="card-body">
                            @forelse($popularStores as $store)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $store->nama_toko }}</h6>
                                    <small class="text-muted">{{ $store->produk_count }} produk</small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-shop fs-4 d-block mb-2"></i>
                                Belum ada toko
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-8">
                <!-- Featured Products Section -->
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-primary mb-1">Produk Unggulan</h2>
                        <p class="text-muted mb-0">Alat kesehatan terbaru dan terpopuler</p>
                    </div>
                    <a href="{{ route('customer.produk.index') }}" class="btn btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <!-- Product Grid -->
                <div class="row g-4 mb-5" id="productGrid">
                    @include('customer.partials.product-grid', ['products' => $featuredProducts])
                </div>

                <!-- Recent Products Section -->
                @if($recentProducts->count() > 0)
                <div class="section-header mb-4">
                    <h3 class="fw-bold text-primary mb-1">Produk Terbaru</h3>
                    <p class="text-muted mb-0">Produk yang baru saja ditambahkan</p>
                </div>

                <div class="row g-4">
                    @include('customer.partials.product-grid', ['products' => $recentProducts])
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add to Cart Modal -->
    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary text-white" style="border-bottom: 1px solid rgba(0,0,0,0.1); border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold" id="addToCartModalLabel">
                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="text-center">
                                <img id="modalProductImage" src="" alt="Product Image"
                                     class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 300px; width: 100%; object-fit: cover;">
                                <div class="badge bg-success fs-6 px-3 py-2">
                                    <i class="bi bi-shield-check me-1"></i>Produk Original
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="product-details">
                                <h4 id="modalProductName" class="fw-bold text-primary mb-2"></h4>
                                <small id="modalProductCategory" class="text-muted d-block mb-3"></small>
                                
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-3 text-center">
                                            <small class="text-muted d-block">Harga Satuan</small>
                                            <h5 id="modalProductPrice" class="text-primary fw-bold mb-0"></h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-3 text-center">
                                            <small class="text-muted d-block">Stok Tersedia</small>
                                            <h5 id="modalProductStock" class="text-success fw-bold mb-0"></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold mb-3">
                                        <i class="bi bi-cart-plus me-2"></i>Jumlah Pembelian
                                    </label>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="btn btn-outline-primary" id="decreaseQty"
                                                style="border-radius: 8px; width: 40px; height: 40px;">
                                            <i class="bi bi-dash fw-bold"></i>
                                        </button>
                                        <input type="number" class="form-control text-center fw-bold"
                                               id="productQuantity" value="1" min="1"
                                               style="width: 100px; border-radius: 10px; border: 2px solid #e9ecef;">
                                        <button type="button" class="btn btn-outline-primary" id="increaseQty"
                                                style="border-radius: 8px; width: 40px; height: 40px;">
                                            <i class="bi bi-plus fw-bold"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Maksimal pembelian sesuai stok tersedia</small>
                                </div>

                                <div class="border-top pt-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold fs-5">Total Harga:</span>
                                        <h4 id="totalPrice" class="text-primary fw-bold mb-0"></h4>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary btn-lg" id="confirmAddToCart"
                                            style="border-radius: 15px; padding: 12px;">
                                        <i class="bi bi-cart-check me-2"></i>Konfirmasi Tambah ke Keranjang
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            style="border-radius: 15px;">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <p class="fw-semibold text-primary mb-0">Menambahkan ke keranjang...</p>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 50%, #0a58ca 100%);
            min-height: 60vh;
        }

        .min-vh-50 {
            min-height: 50vh;
        }

        .product-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
        }

        .product-image {
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .sidebar-sticky {
            position: sticky;
            top: 100px;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .category-filter:hover {
            background-color: rgba(13, 110, 253, 0.1) !important;
            color: var(--bs-primary) !important;
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .btn-add-to-cart {
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add-to-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-view {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-view:hover {
            transform: rotate(360deg) scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .price-display {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0d6efd;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: auto;
            }

            .hero-content {
                padding: 2rem !important;
            }

            .sidebar-sticky {
                position: relative;
                top: auto;
                max-height: none;
            }

            .product-image {
                height: 200px !important;
            }
            
            .btn-view {
                width: 40px;
                height: 40px;
            }
            
            .price-display {
                font-size: 1.1rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            let currentProduct = {};

            // Add to cart modal functionality
            $(document).on('click', '.btn-add-to-cart', function() {
                // Extract product data
                currentProduct = {
                    id: $(this).data('product-id'),
                    name: $(this).data('product-name'),
                    price: parseInt($(this).data('product-price')),
                    stock: parseInt($(this).data('product-stock')),
                    image: $(this).data('product-image'),
                    category: $(this).data('product-category') || 'Kategori',
                    store: $(this).data('product-store') || 'Toko'
                };

                // Populate modal
                $('#modalProductName').text(currentProduct.name);
                $('#modalProductCategory').text(currentProduct.category + ' • ' + currentProduct.store);
                $('#modalProductPrice').text('Rp ' + currentProduct.price.toLocaleString('id-ID'));
                $('#modalProductStock').text(currentProduct.stock + ' unit');
                $('#modalProductImage').attr('src', currentProduct.image).attr('alt', currentProduct.name);

                // Reset quantity
                $('#productQuantity').val(1).attr('max', currentProduct.stock);
                
                updateTotalPrice();

                // Show modal
                $('#addToCartModal').modal('show');
            });

            // Quantity controls
            $('#increaseQty').on('click', function() {
                let currentQty = parseInt($('#productQuantity').val());
                if (currentQty < currentProduct.stock) {
                    $('#productQuantity').val(currentQty + 1);
                    updateTotalPrice();
                } else {
                    showToast(`Maksimal pembelian ${currentProduct.stock} unit`, 'warning');
                }
            });

            $('#decreaseQty').on('click', function() {
                let currentQty = parseInt($('#productQuantity').val());
                if (currentQty > 1) {
                    $('#productQuantity').val(currentQty - 1);
                    updateTotalPrice();
                }
            });

            // Quantity input validation
            $('#productQuantity').on('input change', function() {
                let qty = parseInt($(this).val());
                
                if (isNaN(qty) || qty < 1) {
                    qty = 1;
                } else if (qty > currentProduct.stock) {
                    qty = currentProduct.stock;
                    showToast(`Maksimal pembelian ${currentProduct.stock} unit`, 'warning');
                }
                
                $(this).val(qty);
                updateTotalPrice();
            });

            // Confirm add to cart
            $('#confirmAddToCart').on('click', function() {
                const quantity = parseInt($('#productQuantity').val());
                
                // Show loading
                $('#loadingOverlay').removeClass('d-none');
                $(this).prop('disabled', true);

                $.ajax({
                    url: '{{ route("customer.keranjang.add") }}',
                    method: 'POST',
                    data: {
                        id_produk: currentProduct.id,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Hide loading
                            $('#loadingOverlay').addClass('d-none');
                            $('#confirmAddToCart').prop('disabled', false);
                            
                            // Close modal
                            $('#addToCartModal').modal('hide');
                            
                            // Show success message
                            showToast(
                                `${quantity} unit ${currentProduct.name} berhasil ditambahkan ke keranjang!`,
                                'success'
                            );
                            
                            // Update cart count if element exists
                            if (response.cart_count && $('#cartCount').length) {
                                $('#cartCount').text(response.cart_count);
                                
                                // Add bounce animation
                                $('#cartCount').addClass('animate__animated animate__bounce');
                                setTimeout(() => {
                                    $('#cartCount').removeClass('animate__animated animate__bounce');
                                }, 1000);
                            }
                        } else {
                            $('#loadingOverlay').addClass('d-none');
                            $('#confirmAddToCart').prop('disabled', false);
                            showToast(response.message || 'Gagal menambahkan ke keranjang', 'error');
                        }
                    },
                    error: function(xhr) {
                        $('#loadingOverlay').addClass('d-none');
                        $('#confirmAddToCart').prop('disabled', false);
                        
                        if (xhr.status === 401) {
                            showToast('Silakan login terlebih dahulu', 'warning');
                            setTimeout(() => {
                                window.location.href = '{{ route("login") }}';
                            }, 2000);
                        } else {
                            const response = xhr.responseJSON;
                            showToast(response?.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                        }
                    }
                });
            });

            function updateTotalPrice() {
                const quantity = parseInt($('#productQuantity').val());
                const total = currentProduct.price * quantity;
                $('#totalPrice').text('Rp ' + total.toLocaleString('id-ID'));
            }

            // Category filter
            $('.category-filter').on('click', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('category');

                // Show loading
                $('#productGrid').html(`
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted">Memuat produk...</p>
                    </div>
                `);

                $.ajax({
                    url: '{{ route("customer.kategori.products") }}',
                    method: 'GET',
                    data: {
                        category: categoryId
                    },
                    success: function(response) {
                        $('#productGrid').html(response.products);
                    },
                    error: function() {
                        $('#productGrid').html(`
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-exclamation-circle fs-1 text-danger mb-3"></i>
                                <h5 class="text-danger">Gagal memuat produk</h5>
                                <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                            </div>
                        `);
                    }
                });
            });

            // Toast notification function  
            function showToast(message, type = 'info') {
                // Create toast container if it doesn't exist
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

            // Lazy loading for images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('loading');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
    @endpush
</x-layouts.customer>