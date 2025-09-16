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
                    @forelse($featuredProducts as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card product-card h-100 shadow-sm border-0 card-hover">
                                <div class="position-relative">
                                    <img src="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x200/f8f9fa/dee2e6?text=No+Image' }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->nama_produk }}"
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <!-- Product Status Badge -->
                                    @if($product->stok > 0)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                            <i class="bi bi-check-circle me-1"></i>Tersedia
                                        </span>
                                    @else
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                            <i class="bi bi-x-circle me-1"></i>Habis
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <!-- Product Category -->
                                    <small class="text-primary fw-semibold mb-2">
                                        {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                                    </small>

                                    <!-- Product Name -->
                                    <h6 class="card-title fw-bold mb-2 text-truncate" title="{{ $product->nama_produk }}">
                                        {{ $product->nama_produk }}
                                    </h6>

                                    <!-- Product Description -->
                                    <p class="card-text text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                        {{ Str::limit($product->deskripsi, 80) }}
                                    </p>

                                    <!-- Price and Store -->
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="price">
                                                <h5 class="text-primary fw-bold mb-0">
                                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                </h5>
                                            </div>
                                            <small class="text-muted">
                                                <i class="bi bi-shop me-1"></i>{{ $product->toko->nama_toko ?? 'Toko' }}
                                            </small>
                                        </div>

                                        <!-- Stock Info -->
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
                                            </small>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex gap-2">
                                            @if($product->stok > 0)
                                                <button class="btn btn-primary btn-sm flex-grow-1 add-to-cart"
                                                        data-product-id="{{ $product->id_produk }}">
                                                    <i class="bi bi-cart-plus me-1"></i>Keranjang
                                                </button>
                                                <a href="{{ route('customer.produk.show', $product->id_produk) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                                    <i class="bi bi-x-circle me-1"></i>Stok Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada produk</h5>
                                <p class="text-muted">Produk akan segera tersedia</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Recent Products Section -->
                @if($recentProducts->count() > 0)
                    <div class="section-header mb-4">
                        <h3 class="fw-bold text-primary mb-1">Produk Terbaru</h3>
                        <p class="text-muted mb-0">Produk yang baru saja ditambahkan</p>
                    </div>

                    <div class="row g-4">
                        @foreach($recentProducts as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="card product-card h-100 shadow-sm border-0 card-hover">
                                    <div class="position-relative">
                                        <img src="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x200/f8f9fa/dee2e6?text=No+Image' }}" 
                                             class="card-img-top" 
                                             alt="{{ $product->nama_produk }}"
                                             style="height: 200px; object-fit: cover;">
                                        
                                        <span class="badge bg-info position-absolute top-0 start-0 m-2">
                                            <i class="bi bi-star me-1"></i>Baru
                                        </span>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <small class="text-primary fw-semibold mb-2">
                                            {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                                        </small>

                                        <h6 class="card-title fw-bold mb-2">
                                            {{ Str::limit($product->nama_produk, 50) }}
                                        </h6>

                                        <div class="mt-auto">
                                            <h5 class="text-primary fw-bold mb-3">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </h5>

                                            <div class="d-flex gap-2">
                                                @if($product->stok > 0)
                                                    <button class="btn btn-primary btn-sm flex-grow-1 add-to-cart"
                                                            data-product-id="{{ $product->id_produk }}">
                                                        <i class="bi bi-cart-plus me-1"></i>Keranjang
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                                        Habis
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
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
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Add to Cart functionality
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('product-id');
                const button = $(this);
                
                // Show loading state
                const originalText = button.html();
                button.html('<span class="spinner-border spinner-border-sm me-1" role="status"></span>Loading...').prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("customer.keranjang.add") }}',
                    method: 'POST',
                    data: {
                        id_produk: productId,
                        quantity: 1,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('Produk berhasil ditambahkan ke keranjang', 'success');
                            
                            // Update cart count if element exists
                            if (response.cart_count && $('#cartCount').length) {
                                $('#cartCount').text(response.cart_count);
                            }
                        } else {
                            showToast(response.message || 'Gagal menambahkan ke keranjang', 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            showToast('Silakan login terlebih dahulu', 'warning');
                            window.location.href = '{{ route("login") }}';
                        } else {
                            showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                        }
                    },
                    complete: function() {
                        // Reset button state
                        button.html(originalText).prop('disabled', false);
                    }
                });
            });

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
                    data: { category: categoryId },
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
                
                // Initialize and show toast
                const bsToast = new bootstrap.Toast(toast[0], {
                    autohide: true,
                    delay: 3000
                });
                bsToast.show();

                // Remove toast element after it's hidden
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