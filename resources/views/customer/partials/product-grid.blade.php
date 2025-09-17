{{-- File: resources/views/customer/partials/product-grid.blade.php --}}
@if($products->count() > 0)
    @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 product-item"
             data-price="{{ $product->harga }}"
             data-stock="{{ $product->stok }}"
             data-category="{{ $product->id_kategori }}"
             data-name="{{ strtolower($product->nama_produk) }}">
            <div class="card product-card h-100 shadow-sm border-0">
                <div class="position-relative overflow-hidden">
                    <img src="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x250/f8f9fa/6c757d?text=No+Image' }}" 
                         class="card-img-top product-image w-100" 
                         alt="{{ $product->nama_produk }}"
                         style="height: 250px; object-fit: cover;">
                    
                    <!-- Product Status Badge -->
                    @if($product->stok > 0)
                        @if($product->stok <= 5)
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 badge-status">
                                <i class="bi bi-exclamation-triangle me-1"></i>Stok Terbatas
                            </span>
                        @else
                            <span class="badge bg-success position-absolute top-0 start-0 m-3 badge-status">
                                <i class="bi bi-check-circle me-1"></i>Tersedia
                            </span>
                        @endif
                    @else
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 badge-status">
                            <i class="bi bi-x-circle me-1"></i>Habis
                        </span>
                    @endif
                    
                    <!-- View Button -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <a href="{{ route('customer.produk.show', $product->id_produk) }}" 
                           class="btn btn-light btn-view shadow-sm" 
                           title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body d-flex flex-column p-4">
                    <!-- Product Category -->
                    <small class="text-primary fw-semibold mb-2">
                        {{ $product->kategori->nama_kategori ?? 'Kategori' }}
                    </small>

                    <!-- Product Name -->
                    <h6 class="card-title fw-bold mb-2 text-truncate" title="{{ $product->nama_produk }}">
                        {{ $product->nama_produk }}
                    </h6>

                    <!-- Product Description -->
                    <p class="card-text text-muted small mb-3" style="height: 45px; overflow: hidden;">
                        {{ Str::limit($product->deskripsi, 80) }}
                    </p>

                    <!-- Price and Store -->
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="price-display">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-shop me-1"></i>{{ Str::limit($product->toko->nama_toko ?? 'Toko', 10) }}
                            </small>
                        </div>

                        <!-- Stock Info and Rating -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="{{ $product->stok > 0 ? ($product->stok <= 5 ? 'text-warning' : 'text-success') : 'text-danger' }}">
                                <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
                            </small>
                            <div class="d-flex text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <small class="text-muted ms-1">(4.2)</small>
                            </div>
                        </div>

                        <!-- Action Button -->
                        @if($product->stok > 0)
                            <button class="btn btn-primary w-100 btn-add-to-cart" 
                                    data-product-id="{{ $product->id_produk }}"
                                    data-product-name="{{ $product->nama_produk }}"
                                    data-product-price="{{ $product->harga }}"
                                    data-product-stock="{{ $product->stok }}"
                                    data-product-image="{{ $product->gambar_produk ? asset('storage/produk/' . $product->gambar_produk) : 'https://via.placeholder.com/300x250/f8f9fa/6c757d?text=No+Image' }}"
                                    data-product-category="{{ $product->kategori->nama_kategori ?? 'Kategori' }}"
                                    data-product-store="{{ $product->toko->nama_toko ?? 'Toko' }}">
                                <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="bi bi-x-circle me-2"></i>Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12">
        <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                 style="width: 120px; height: 120px;">
                <i class="bi bi-box-seam fs-1 text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">Belum Ada Produk</h4>
            <p class="text-muted mb-4">Produk unggulan akan segera tersedia</p>
            <a href="{{ route('customer.produk.index') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Semua Produk
            </a>
        </div>
    </div>
@endif

@push('styles')
<style>
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