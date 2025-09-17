<x-layouts.customer title="Semua Toko - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient bg-success text-white">
                    <div class="card-body py-5">
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
                                            Semua Toko
                                        </li>
                                    </ol>
                                </nav>
                                <h1 class="display-5 fw-bold mb-3">
                                    <i class="bi bi-shop me-3"></i>Semua Toko
                                </h1>
                                <p class="lead mb-0 opacity-90">
                                    Temukan {{ $stores->total() }}+ toko terpercaya yang menyediakan alat kesehatan berkualitas
                                </p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="bg-white bg-opacity-20 rounded-4 p-4">
                                    <i class="bi bi-buildings fs-1 mb-3"></i>
                                    <h3 class="fw-bold">{{ $stores->total() }}+</h3>
                                    <p class="mb-0">Toko Partner</p>
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
                            <i class="bi bi-funnel me-2"></i>Filter Toko
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Search Store -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Cari Toko</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchStore" 
                                       placeholder="Nama toko..." value="{{ $search }}">
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
                                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="products" {{ $sort == 'products' ? 'selected' : '' }}>Produk Terbanyak</option>
                            </select>
                        </div>

                        <!-- City Filter -->
                        @if($cities->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Kota</h6>
                            <div class="form-check">
                                <input class="form-check-input city-filter" type="radio" name="city" value=""
                                    id="cityAll" {{ !$selectedCity ? 'checked' : '' }}>
                                <label class="form-check-label" for="cityAll">
                                    Semua Kota
                                </label>
                            </div>
                            @foreach($cities->take(8) as $city)
                            <div class="form-check">
                                <input class="form-check-input city-filter" type="radio" name="city"
                                    value="{{ $city->id_kota }}" id="city{{ $city->id_kota }}"
                                    {{ $selectedCity && $selectedCity->id_kota == $city->id_kota ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between align-items-center"
                                    for="city{{ $city->id_kota }}">
                                    <span class="text-truncate">{{ $city->nama_kota }}</span>
                                    <small class="text-muted">({{ $city->toko_count }})</small>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Clear Filter -->
                        <button class="btn btn-outline-secondary w-100" id="clearFilters">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stores Grid -->
            <div class="col-lg-9">
                <!-- Results Info -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <div>
                        <h5 class="mb-1">Menampilkan {{ $stores->count() }} dari {{ $stores->total() }} toko</h5>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if($selectedCity)
                            <span class="badge bg-success">
                                Kota: {{ $selectedCity->nama_kota }}
                                <button class="btn-close btn-close-white ms-2" onclick="clearCityFilter()"></button>
                            </span>
                            @endif
                            @if($search)
                            <span class="badge bg-info">
                                Pencarian: "{{ $search }}"
                                <button class="btn-close btn-close-white ms-2" onclick="clearSearch()"></button>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <button class="btn btn-outline-primary btn-sm d-lg-none" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Stores -->
                <div id="storesContainer">
                    @if($stores->count() > 0)
                    <div class="row g-4 mb-5">
                        @foreach($stores as $store)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card store-card h-100 shadow-sm border-0 card-hover">
                                <div class="card-body p-4">
                                    <!-- Store Header -->
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-shop fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="card-title fw-bold mb-1">{{ $store->nama_toko }}</h5>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $store->kota->nama_kota ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Store Description -->
                                    @if($store->deskripsi_toko)
                                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden;">
                                        {{ Str::limit($store->deskripsi_toko, 120) }}
                                    </p>
                                    @else
                                    <p class="card-text text-muted mb-3" style="height: 60px;">
                                        Toko menyediakan berbagai alat kesehatan berkualitas untuk kebutuhan medis Anda.
                                    </p>
                                    @endif

                                    <!-- Store Stats -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <h6 class="fw-bold mb-0 text-primary">{{ $store->produk_count }}</h6>
                                                <small class="text-muted">Produk</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <h6 class="fw-bold mb-0 text-success">
                                                    <i class="bi bi-star-fill"></i> 4.8
                                                </h6>
                                                <small class="text-muted">Rating</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Store Owner Info -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 30px; height: 30px;">
                                            <i class="bi bi-person fs-6"></i>
                                        </div>
                                        <small class="text-muted">
                                            Owner: {{ $store->user->name ?? 'N/A' }}
                                        </small>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="d-grid">
                                        <a href="{{ route('customer.toko.show', $store->id_toko) }}" 
                                           class="btn btn-success">
                                            <i class="bi bi-shop me-2"></i>Kunjungi Toko
                                        </a>
                                    </div>
                                </div>

                                <!-- Store Features -->
                                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                    <div class="row g-2 text-center">
                                        <div class="col-4">
                                            <small class="text-success">
                                                <i class="bi bi-shield-check me-1"></i>Terpercaya
                                            </small>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-primary">
                                                <i class="bi bi-truck me-1"></i>Fast Ship
                                            </small>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-info">
                                                <i class="bi bi-chat-dots me-1"></i>Chat
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($stores->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $stores->withQueryString()->links() }}
                    </div>
                    @endif
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="bi bi-shop fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted mb-3">Tidak ada toko ditemukan</h4>
                        <p class="text-muted mb-4">Coba ubah filter pencarian atau kota yang dipilih</p>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <button class="btn btn-success" id="resetAllFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Semua Filter
                            </button>
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-success">
                                <i class="bi bi-house me-1"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .store-card {
            transition: all 0.3s ease;
        }

        .store-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
        }

        .sticky-top {
            max-height: calc(100vh - 140px);
            overflow-y: auto;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #198754 0%, #157347 100%) !important;
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
            background-color: var(--bs-success);
            border-color: var(--bs-success);
        }

        .card-hover:hover .bg-success {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Filter functions
            $('#sortSelect, .city-filter').on('change', function() {
                applyFilters();
            });

            // Search functionality
            $('#searchBtn').on('click', function() {
                applyFilters();
            });

            $('#searchStore').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            $('#clearFilters, #resetAllFilters').on('click', function() {
                $('#searchStore').val('');
                $('#cityAll').prop('checked', true);
                $('#sortSelect').val('newest');
                applyFilters();
            });

            function applyFilters() {
                const params = new URLSearchParams();
                
                const search = $('#searchStore').val();
                const sort = $('#sortSelect').val();
                const city = $('.city-filter:checked').val();

                if (search) params.append('search', search);
                if (sort) params.append('sort', sort);
                if (city) params.append('city', city);

                window.location.search = params.toString();
            }

            // Clear specific filters
            window.clearCityFilter = function() {
                $('#cityAll').prop('checked', true);
                applyFilters();
            };

            window.clearSearch = function() {
                $('#searchStore').val('');
                applyFilters();
            };

            // Animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all store cards
            document.querySelectorAll('.store-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
    @endpush
</x-layouts.customer>