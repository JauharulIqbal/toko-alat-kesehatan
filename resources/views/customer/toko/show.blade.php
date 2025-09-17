<x-layouts.customer title="{{ $toko->nama_toko }} - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Store Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient bg-success text-white">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb text-white mb-2">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('customer.dashboard') }}" class="text-white text-decoration-none">
                                                <i class="bi bi-house"></i> Beranda
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('customer.toko.index') }}" class="text-white text-decoration-none">
                                                Semua Toko
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">
                                            {{ $toko->nama_toko }}
                                        </li>
                                    </ol>
                                </nav>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-4"
                                         style="width: 80px; height: 80px;">
                                        <i class="bi bi-shop fs-2"></i>
                                    </div>
                                    <div>
                                        <h1 class="display-6 fw-bold mb-2">{{ $toko->nama_toko }}</h1>
                                        <p class="lead mb-0 opacity-90">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            {{ $toko->kota->nama_kota ?? 'Lokasi tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <div class="bg-white bg-opacity-20 rounded-3 p-3 d-inline-block">
                                    <div class="text-center">
                                        <i class="bi bi-star-fill fs-2 mb-2"></i>
                                        <h4 class="fw-bold mb-0">4.8</h4>
                                        <small>Rating Toko</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Store Info & Stats -->
        <div class="row g-4 mb-5">
            <!-- Store Description -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-info-circle me-2"></i>Tentang Toko
                        </h5>
                        @if($toko->deskripsi_toko)
                            <p class="text-muted mb-4">{{ $toko->deskripsi_toko }}</p>
                        @else
                            <p class="text-muted mb-4">Toko ini menyediakan berbagai alat kesehatan berkualitas untuk memenuhi kebutuhan medis Anda.</p>
                        @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Informasi Toko</h6>
                                <div class="mb-2">
                                    <i class="bi bi-person text-primary me-2"></i>
                                    <strong>Pemilik:</strong> {{ $toko->user->name ?? 'N/A' }}
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-geo-alt text-success me-2"></i>
                                    <strong>Lokasi:</strong> {{ $toko->kota->nama_kota ?? 'Tidak tersedia' }}
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-calendar text-info me-2"></i>
                                    <strong>Bergabung:</strong> {{ $toko->created_at->format('M Y') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Layanan</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <i class="bi bi-shield-check text-success"></i>
                                            <small class="d-block">Produk Original</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <i class="bi bi-truck text-primary"></i>
                                            <small class="d-block">Pengiriman Cepat</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <i class="bi bi-chat-dots text-info"></i>
                                            <small class="d-block">Chat Support</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2 text-center">
                                            <i class="bi bi-arrow-repeat text-warning"></i>
                                            <small class="d-block">Return Policy</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Statistics -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-bar-chart me-2"></i>Statistik Toko
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                    <i class="bi bi-box-seam text-primary fs-3 mb-2"></i>
                                    <h4 class="fw-bold text-primary mb-0">{{ $stats['total_products'] }}</h4>
                                    <small class="text-muted">Total Produk</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                    <i class="bi bi-check-circle text-success fs-3 mb-2"></i>
                                    <h4 class="fw-bold text-success mb-0">{{ $stats['available_products'] }}</h4>
                                    <small class="text-muted">Tersedia</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                    <i class="bi bi-grid text-info fs-3 mb-2"></i>
                                    <h4 class="fw-bold text-info mb-0">{{ $stats['categories_count'] }}</h4>
                                    <small class="text-muted">Kategori</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                    <i class="bi bi-currency-dollar text-warning fs-3 mb-2"></i>
                                    <div class="fw-bold text-warning mb-0">
                                        <small>Rp</small>{{ number_format($stats['avg_price'] ?? 0, 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted">Rata-rata Harga</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Categories -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 sticky-top" style="top: 120px;">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-funnel me-2"></i>Filter Produk
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Sort Options -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Urutkan</h6>
                            <select class="form-select" id="sortSelect">
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price-low" {{ $sort == 'price-low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price-high" {{ $sort == 'price-high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="stock" {{ $sort == 'stock' ? 'selected' : '' }}>Stok Terbanyak</option>
                            </select>
                        </div>

                        <!-- Categories -->
                        @if($categories->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Kategori</h6>
                            <div class="form-check">
                                <input class="form-check-input category-filter" type="radio" name="category" value=""
                                    id="categoryAll" {{ !$selectedCategory ? 'checked' : '' }}>
                                <label class="form-check-label" for="categoryAll">
                                    Semua Kategori
                                </label>
                            </div>
                            @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input category-filter" type="radio" name="category"
                                    value="{{ $category->id_kategori }}" id="category{{ $category->id_kategori }}"
                                    {{ $selectedCategory && $selectedCategory->id_kategori == $category->id_kategori ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between align-items-center"
                                    for="category{{ $category->id_kategori }}">
                                    <span class="text-truncate">{{ $category->nama_kategori }}</span>
                                    <small class="text-muted">({{ $category->produk_count }})</small>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Range Harga</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="priceMin"
                                        placeholder="Min" value="{{ $minPrice }}" min="0">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="priceMax"
                                        placeholder="Max" value="{{ $maxPrice }}" min="0">
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm w-100 mt-2" id="applyPriceFilter">
                                <i class="bi bi-funnel me-1"></i>Terapkan
                            </button>
                        </div>

                        <!-- Clear Filter -->
                        <button class="btn btn-outline-secondary w-100" id="clearFilters">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Results Info -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Produk Toko {{ $toko->nama_toko }}</h4>
                        <p class="text-muted mb-0">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
                        @if($selectedCategory)
                        <small class="text-muted">
                            Kategori: <strong>{{ $selectedCategory->nama_kategori }}</strong>
                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="clearCategoryFilter()">
                                <i class="bi bi-x"></i>
                            </button>
                        </small>
                        @endif
                    </div>
                </div>

                <!-- Products -->
                <div id="productsContainer">
                    @if($products->count() > 0)
                    <div class="row g-4 mb-5">
                        @foreach($products as $product)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card product-card h-100 shadow-sm border-0 card-hover">
                                <div class="position-relative">
                                    <img src="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x250/f8f9fa/dee2e6?text=No+Image' }}"
                                        class="card-img-top"
                                        alt="{{ $product->nama_produk }}"
                                        style="height: 200px; object-fit: cover;">

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
                                    <small class="text-success fw-semibold mb-2">
                                        {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                                    </small>

                                    <h6 class="card-title fw-bold mb-2">
                                        {{ Str::limit($product->nama_produk, 50) }}
                                    </h6>

                                    <p class="card-text text-muted small mb-3" style="height: 60px; overflow: hidden;">
                                        {{ Str::limit($product->deskripsi, 100) }}
                                    </p>

                                    <div class="mt-auto">
                                        <h5 class="text-success fw-bold mb-3">
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </h5>

                                        <small class="text-muted d-block mb-3">
                                            <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
                                        </small>

                                        <div class="d-flex gap-2">
                                            @if($product->stok > 0)
                                            <button class="btn btn-success btn-sm flex-grow-1 add-to-cart"
                                                data-product-id="{{ $product->id_produk }}">
                                                <i class="bi bi-cart-plus me-1"></i>Keranjang
                                            </button>
                                            <a href="{{ route('customer.produk.show', $product->id_produk) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @else
                                            <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                                <i class="bi bi-x-circle me-1"></i>Stok Habis
                                            </button>
                                            <a href="{{ route('customer.produk.show', $product->id_produk) }}"
                                                class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $products->withQueryString()->links() }}
                    </div>
                    @endif
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted mb-3">Tidak ada produk</h4>
                        <p class="text-muted mb-4">Toko ini belum memiliki produk atau semua produk sedang habis</p>
                        <a href="{{ route('customer.toko.index') }}" class="btn btn-success">
                            <i class="bi bi-arrow-left me-1"></i>Lihat Toko Lain
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .sticky-top {
            max-height: calc(100vh - 140px);
            overflow-y: auto;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #198754 0%, #157347 100%) !important;
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
            // Filter functionality
            $('#sortSelect, .category-filter').on('change', function() {
                applyFilters();
            });

            $('#applyPriceFilter').on('click', function() {
                applyFilters();
            });

            $('#clearFilters').on('click', function() {
                $('#priceMin, #priceMax').val('');
                $('#categoryAll').prop('checked', true);
                $('#sortSelect').val('newest');
                applyFilters();
            });

            function applyFilters() {
                const sort = $('#sortSelect').val();
                const category = $('.category-filter:checked').val();
                const priceMin = $('#priceMin').val();
                const priceMax = $('#priceMax').val();

                const params = new URLSearchParams();
                if (sort) params.append('sort', sort);
                if (category) params.append('category', category);
                if (priceMin) params.append('min_price', priceMin);
                if (priceMax) params.append('max_price', priceMax);

                window.location.search = params.toString();
            }

            window.clearCategoryFilter = function() {
                $('#categoryAll').prop('checked', true);
                applyFilters();
            };

            // Add to Cart functionality
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('product-id');
                const button = $(this);

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
                            if (response.cart_count) {
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
                        button.html(originalText).prop('disabled', false);
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
                    delay: 3000
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