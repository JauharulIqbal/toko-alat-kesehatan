<x-layouts.customer title="Semua Kategori - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient bg-primary text-white">
                    <div class="card-body py-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h1 class="display-5 fw-bold mb-3">
                                    <i class="bi bi-grid-3x3-gap me-3"></i>Kategori Produk
                                </h1>
                                <p class="lead mb-0 opacity-90">
                                    Temukan produk alat kesehatan berdasarkan kategori yang Anda butuhkan
                                </p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="bg-white bg-opacity-20 rounded-4 p-4">
                                    <i class="bi bi-collection fs-1 mb-3"></i>
                                    <h3 class="fw-bold">{{ $categories->total() }}+</h3>
                                    <p class="mb-0">Kategori Tersedia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card category-card h-100 shadow-sm border-0 card-hover">
                    <div class="card-body text-center p-4">
                        <!-- Category Icon -->
                        <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-heart-pulse text-white fs-1"></i>
                        </div>

                        <!-- Category Name -->
                        <h5 class="card-title fw-bold mb-3">{{ $category->nama_kategori }}</h5>

                        <!-- Product Count -->
                        <p class="text-muted mb-4">
                            <i class="bi bi-box me-2"></i>
                            {{ $category->produk_count }} produk tersedia
                        </p>

                        <!-- Action Button -->
                        <a href="{{ route('customer.kategori.show', $category->id_kategori) }}" 
                           class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-arrow-right-circle me-2"></i>Lihat Produk
                        </a>
                    </div>

                    <!-- Hover Effect -->
                    <div class="card-footer bg-transparent border-0 p-0">
                        <div class="bg-primary bg-gradient" style="height: 4px; border-radius: 0 0 8px 8px;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                        style="width: 120px; height: 120px;">
                        <i class="bi bi-folder2-open fs-1 text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Kategori</h4>
                    <p class="text-muted mb-4">Kategori produk akan segera tersedia</p>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('styles')
    <style>
        .category-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-card .card-body {
            position: relative;
            z-index: 2;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        }

        .card-hover:hover .bg-primary {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Add smooth animations when cards come into view
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

        // Observe all category cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
    @endpush
</x-layouts.customer>