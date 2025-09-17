<x-layouts.customer title="Semua Produk - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient bg-primary text-white">
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
                                        <li class="breadcrumb-item active text-white" aria-current="page">
                                            Semua Produk
                                        </li>
                                    </ol>
                                </nav>
                                <h1 class="display-6 fw-bold mb-2">
                                    <i class="bi bi-grid-3x3-gap me-3"></i>Semua Produk
                                </h1>
                                <p class="lead mb-0 opacity-90">
                                    {{ $products->total() }} produk alat kesehatan tersedia untuk Anda
                                </p>
                            </div>
                            <div class="col-lg-4 text-end">
                                <div class="bg-white bg-opacity-20 rounded-3 p-3 d-inline-block">
                                    <i class="bi bi-box-seam fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 sticky-top" style="top: 120px;">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-sliders me-2"></i>Filter Produk
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Search -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Pencarian</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari produk..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="button" id="searchBtn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

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

                        <!-- Category Filter -->
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

                        <!-- Store Filter -->
                        @if($stores->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Toko</h6>
                            <div class="form-check">
                                <input class="form-check-input store-filter" type="radio" name="store" value=""
                                    id="storeAll" {{ !$selectedStore ? 'checked' : '' }}>
                                <label class="form-check-label" for="storeAll">
                                    Semua Toko
                                </label>
                            </div>
                            @foreach($stores->take(8) as $store)
                            <div class="form-check">
                                <input class="form-check-input store-filter" type="radio" name="store"
                                    value="{{ $store->id_toko }}" id="store{{ $store->id_toko }}"
                                    {{ $selectedStore && $selectedStore->id_toko == $store->id_toko ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between align-items-center"
                                    for="store{{ $store->id_toko }}">
                                    <span class="text-truncate">{{ $store->nama_toko }}</span>
                                    <small class="text-muted">({{ $store->produk_count }})</small>
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
                            <button class="btn btn-primary btn-sm w-100 mt-2" id="applyPriceFilter">
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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <div>
                        <h5 class="mb-1">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</h5>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if($selectedCategory)
                            <span class="badge bg-primary">
                                Kategori: {{ $selectedCategory->nama_kategori }}
                                <button class="btn-close btn-close-white ms-2" onclick="clearCategoryFilter()"></button>
                            </span>
                            @endif
                            @if($selectedStore)
                            <span class="badge bg-success">
                                Toko: {{ $selectedStore->nama_toko }}
                                <button class="btn-close btn-close-white ms-2" onclick="clearStoreFilter()"></button>
                            </span>
                            @endif
                            @if(request('search'))
                            <span class="badge bg-info">
                                Pencarian: "{{ request('search') }}"
                                <button class="btn-close btn-close-white ms-2" onclick="clearSearch()"></button>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <button class="btn btn-outline-primary btn-sm d-lg-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterCollapse">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
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

                                    <!-- Quick View Button -->
                                    <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 quick-view"
                                        data-product-id="{{ $product->id_produk }}" 
                                        data-bs-toggle="tooltip" 
                                        title="Lihat Cepat">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <small class="text-primary fw-semibold mb-2">
                                        {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                                    </small>

                                    <h6 class="card-title fw-bold mb-2">
                                        {{ Str::limit($product->nama_produk, 50) }}
                                    </h6>

                                    <p class="card-text text-muted small mb-3" style="height: 60px; overflow: hidden;">
                                        {{ Str::limit($product->deskripsi, 100) }}
                                    </p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="text-primary fw-bold mb-0">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </h5>
                                            <div class="text-end">
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-shop me-1"></i>{{ $product->toko->nama_toko }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $product->toko->kota->nama_kota ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>

                                        <small class="text-muted d-block mb-3">
                                            <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }} unit
                                        </small>

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
                        <h4 class="text-muted mb-3">Tidak ada produk ditemukan</h4>
                        <p class="text-muted mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <button class="btn btn-primary" id="resetAllFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Semua Filter
                            </button>
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-house me-1"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lihat Cepat Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickViewContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
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
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        }

        .badge {
            font-size: 0.75rem;
        }

        @media (max-width: 992px) {
            .sticky-top {
                position: relative !important;
                top: auto !important;
                max-height: none;
            }
        }

        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .quick-view {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .quick-view {
            opacity: 1;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Filter functions
            $('#sortSelect, .category-filter, .store-filter').on('change', function() {
                applyFilters();
            });

            $('#applyPriceFilter').on('click', function() {
                applyFilters();
            });

            $('#clearFilters, #resetAllFilters').on('click', function() {
                $('#priceMin, #priceMax, #searchInput').val('');
                $('#categoryAll, #storeAll').prop('checked', true);
                $('#sortSelect').val('newest');
                applyFilters();
            });

            // Search functionality
            $('#searchBtn').on('click', function() {
                applyFilters();
            });

            $('#searchInput').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            function applyFilters() {
                const params = new URLSearchParams();
                
                const search = $('#searchInput').val();
                const sort = $('#sortSelect').val();
                const category = $('.category-filter:checked').val();
                const store = $('.store-filter:checked').val();
                const priceMin = $('#priceMin').val();
                const priceMax = $('#priceMax').val();

                if (search) params.append('search', search);
                if (sort) params.append('sort', sort);
                if (category) params.append('category', category);
                if (store) params.append('store', store);
                if (priceMin) params.append('min_price', priceMin);
                if (priceMax) params.append('max_price', priceMax);

                window.location.search = params.toString();
            }

            // Clear specific filters
            window.clearCategoryFilter = function() {
                $('#categoryAll').prop('checked', true);
                applyFilters();
            };

            window.clearStoreFilter = function() {
                $('#storeAll').prop('checked', true);
                applyFilters();
            };

            window.clearSearch = function() {
                $('#searchInput').val('');
                applyFilters();
            };

            // Quick View functionality
            $('.quick-view').on('click', function() {
                const productId = $(this).data('product-id');
                
                $.ajax({
                    url: `{{ route('customer.produk.index') }}/${productId}/quick-view`,
                    method: 'GET',
                    beforeSend: function() {
                        $('#quickViewContent').html(`
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        `);
                        $('#quickViewModal').modal('show');
                    },
                    success: function(response) {
                        if (response.success) {
                            const product = response.product;
                            $('#quickViewContent').html(`
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="${product.image}" 
                                             class="img-fluid rounded" 
                                             alt="${product.name}"
                                             style="width: 100%; height: 300px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="fw-bold mb-2">${product.name}</h4>
                                        <p class="text-primary mb-2">
                                            <i class="bi bi-tag me-1"></i>${product.category}
                                        </p>
                                        <h3 class="text-primary fw-bold mb-3">Rp ${product.formatted_price}</h3>
                                        <p class="text-muted mb-3">${product.description || 'Tidak ada deskripsi'}</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Stok tersedia</small>
                                            <span class="fw-bold">${product.stock} unit</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Toko</small>
                                            <span class="fw-bold">${product.store} ${product.store_location ? '- ' + product.store_location : ''}</span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            ${product.stock > 0 ? 
                                                `<button class="btn btn-primary flex-grow-1 add-to-cart" data-product-id="${product.id}">
                                                    <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                                                </button>` :
                                                `<button class="btn btn-secondary flex-grow-1" disabled>
                                                    <i class="bi bi-x-circle me-1"></i>Stok Habis
                                                </button>`
                                            }
                                            <a href="{{ route('customer.produk.show', '') }}/${product.id}" class="btn btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `);
                        } else {
                            $('#quickViewContent').html(`
                                <div class="text-center py-5">
                                    <i class="bi bi-exclamation-circle fs-1 text-danger mb-3"></i>
                                    <h5 class="text-danger">Gagal memuat produk</h5>
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $('#quickViewContent').html(`
                            <div class="text-center py-5">
                                <i class="bi bi-exclamation-circle fs-1 text-danger mb-3"></i>
                                <h5 class="text-danger">Terjadi kesalahan</h5>
                                <button class="btn btn-primary" onclick="location.reload()">Coba Lagi</button>
                            </div>
                        `);
                    }
                });
            });

            // Add to Cart functionality
            $(document).on('click', '.add-to-cart', function() {
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