<x-layouts.customer title="Pencarian: {{ $query }} - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Search Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                            <div>
                                <h4 class="fw-bold text-primary mb-1">
                                    <i class="bi bi-search me-2"></i>
                                    Hasil Pencarian
                                </h4>
                                @if($query)
                                <p class="text-muted mb-0">
                                    Menampilkan hasil untuk: <strong>"{{ $query }}"</strong>
                                    @if($categoryId)
                                    dalam kategori <strong>{{ $categories->find($categoryId)->nama_kategori ?? 'Kategori' }}</strong>
                                    @endif
                                    <span class="badge bg-primary ms-2">{{ $products->total() }} produk ditemukan</span>
                                </p>
                                @else
                                <p class="text-muted mb-0">Semua produk tersedia</p>
                                @endif
                            </div>

                            <!-- Filter & Sort -->
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                    <i class="bi bi-funnel me-1"></i>Filter
                                </button>

                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-sort-down me-1"></i>Urutkan
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item sort-option" href="#" data-sort="newest">Terbaru</a></li>
                                        <li><a class="dropdown-item sort-option" href="#" data-sort="price-low">Harga Terendah</a></li>
                                        <li><a class="dropdown-item sort-option" href="#" data-sort="price-high">Harga Tertinggi</a></li>
                                        <li><a class="dropdown-item sort-option" href="#" data-sort="name">Nama A-Z</a></li>
                                    </ul>
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
                <div class="collapse d-lg-block" id="filterCollapse">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 120px;">
                        <div class="card-header bg-light">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-sliders me-2"></i>Filter Pencarian
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Category Filter -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Kategori</h6>
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="radio" name="category" value=""
                                        id="categoryAll" {{ !$categoryId ? 'checked' : '' }}>
                                    <label class="form-check-label" for="categoryAll">
                                        Semua Kategori
                                    </label>
                                </div>
                                @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="radio" name="category"
                                        value="{{ $category->id_kategori }}" id="category{{ $category->id_kategori }}"
                                        {{ $categoryId == $category->id_kategori ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-between" for="category{{ $category->id_kategori }}">
                                        <span>{{ $category->nama_kategori }}</span>
                                        <small class="text-muted">({{ $category->produk_count }})</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <!-- Price Range Filter -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Range Harga</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" id="priceMin"
                                            placeholder="Min" min="0">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" id="priceMax"
                                            placeholder="Max" min="0">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2" id="applyPriceFilter">
                                    Terapkan
                                </button>
                            </div>

                            <!-- Stock Filter -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Ketersediaan</h6>
                                <div class="form-check">
                                    <input class="form-check-input stock-filter" type="checkbox" value="available" id="stockAvailable">
                                    <label class="form-check-label" for="stockAvailable">
                                        Tersedia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input stock-filter" type="checkbox" value="out-of-stock" id="stockOut">
                                    <label class="form-check-label" for="stockOut">
                                        Habis
                                    </label>
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            <button class="btn btn-outline-secondary w-100" id="clearFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div id="productsContainer">
                    @if($products->count() > 0)
                    <div class="row g-4" id="productGrid">
                        @foreach($products as $product)
                        <div class="col-xl-4 col-lg-6 col-md-6 product-item"
                            data-price="{{ $product->harga }}"
                            data-stock="{{ $product->stok }}"
                            data-category="{{ $product->id_kategori }}"
                            data-name="{{ strtolower($product->nama_produk) }}">
                            <div class="card product-card h-100 shadow-sm border-0 card-hover">
                                <div class="position-relative">
                                    <img src="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x200/f8f9fa/dee2e6?text=No+Image' }}"
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
                                    <small class="text-primary fw-semibold mb-2">
                                        {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                                    </small>

                                    <h6 class="card-title fw-bold mb-2">
                                        {{ Str::limit($product->nama_produk, 60) }}
                                    </h6>

                                    <p class="card-text text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                        {{ Str::limit($product->deskripsi, 80) }}
                                    </p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="text-primary fw-bold mb-0">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </h5>
                                            <small class="text-muted">
                                                <i class="bi bi-shop me-1"></i>{{ $product->toko->nama_toko ?? 'Toko' }}
                                            </small>
                                        </div>

                                        <small class="text-muted d-block mb-3">
                                            <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
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
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->withQueryString()->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted mb-3">Produk tidak ditemukan</h4>
                        <p class="text-muted mb-4">
                            Coba ubah kata kunci pencarian atau filter yang dipilih
                        </p>
                        <a href="{{ route('customer.produk.index') }}" class="btn btn-primary">
                            <i class="bi bi-grid me-1"></i>Lihat Semua Produk
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

        .wishlist-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover {
            background-color: var(--bs-danger) !important;
            color: white !important;
        }

        .wishlist-btn.active {
            background-color: var(--bs-danger);
            color: white;
        }

        .sort-option:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--bs-primary);
        }

        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        @media (max-width: 768px) {
            .sticky-top {
                position: relative !important;
                top: auto !important;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            let currentSort = 'newest';
            let currentFilters = {
                category: '{{ $categoryId }}',
                priceMin: null,
                priceMax: null,
                stock: []
            };

            // Sort functionality
            $('.sort-option').on('click', function(e) {
                e.preventDefault();
                currentSort = $(this).data('sort');
                sortProducts();

                // Update dropdown text
                $(this).closest('.dropdown').find('button').html(`
                    <i class="bi bi-sort-down me-1"></i>${$(this).text()}
                `);
            });

            // Category filter
            $('.category-filter').on('change', function() {
                currentFilters.category = $(this).val();
                applyFilters();
            });

            // Price filter
            $('#applyPriceFilter').on('click', function() {
                currentFilters.priceMin = $('#priceMin').val() ? parseInt($('#priceMin').val()) : null;
                currentFilters.priceMax = $('#priceMax').val() ? parseInt($('#priceMax').val()) : null;
                applyFilters();
            });

            // Stock filter
            $('.stock-filter').on('change', function() {
                currentFilters.stock = [];
                $('.stock-filter:checked').each(function() {
                    currentFilters.stock.push($(this).val());
                });
                applyFilters();
            });

            // Clear filters
            $('#clearFilters').on('click', function() {
                currentFilters = {
                    category: '',
                    priceMin: null,
                    priceMax: null,
                    stock: []
                };

                // Reset form
                $('input[name="category"]').prop('checked', false);
                $('#categoryAll').prop('checked', true);
                $('#priceMin, #priceMax').val('');
                $('.stock-filter').prop('checked', false);

                applyFilters();
            });

            function sortProducts() {
                const $products = $('.product-item').detach();

                $products.sort(function(a, b) {
                    const $a = $(a);
                    const $b = $(b);

                    switch (currentSort) {
                        case 'price-low':
                            return parseInt($a.data('price')) - parseInt($b.data('price'));
                        case 'price-high':
                            return parseInt($b.data('price')) - parseInt($a.data('price'));
                        case 'name':
                            return $a.data('name').localeCompare($b.data('name'));
                        case 'newest':
                        default:
                            return 0; // Keep original order for newest
                    }
                });

                $('#productGrid').append($products);
            }

            function applyFilters() {
                $('.product-item').each(function() {
                    const $item = $(this);
                    let show = true;

                    // Category filter
                    if (currentFilters.category && $item.data('category') != currentFilters.category) {
                        show = false;
                    }

                    // Price filter
                    const price = parseInt($item.data('price'));
                    if (currentFilters.priceMin && price < currentFilters.priceMin) {
                        show = false;
                    }
                    if (currentFilters.priceMax && price > currentFilters.priceMax) {
                        show = false;
                    }

                    // Stock filter
                    if (currentFilters.stock.length > 0) {
                        const stock = parseInt($item.data('stock'));
                        const hasAvailable = currentFilters.stock.includes('available') && stock > 0;
                        const hasOutOfStock = currentFilters.stock.includes('out-of-stock') && stock === 0;

                        if (!hasAvailable && !hasOutOfStock) {
                            show = false;
                        }
                    }

                    if (show) {
                        $item.removeClass('d-none').addClass('fade-in');
                    } else {
                        $item.addClass('d-none').removeClass('fade-in');
                    }
                });

                // Show no results message if all products are hidden
                const visibleProducts = $('.product-item:not(.d-none)').length;
                if (visibleProducts === 0) {
                    if ($('#noResults').length === 0) {
                        $('#productGrid').append(`
                            <div id="noResults" class="col-12 text-center py-5">
                                <i class="bi bi-funnel fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted mb-3">Tidak ada produk yang sesuai filter</h5>
                                <p class="text-muted">Coba ubah atau reset filter pencarian</p>
                            </div>
                        `);
                    }
                } else {
                    $('#noResults').remove();
                }
            }

            // Add to Cart functionality
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('product-id');
                const button = $(this);

                const originalText = button.html();
                button.html('<span class="loading-spinner me-1"></span>Loading...').prop('disabled', true);

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
        });
    </script>
    @endpush
</x-layouts.customer>