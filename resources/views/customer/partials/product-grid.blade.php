{{-- File: resources/views/customer/partials/product-grid.blade.php --}}
@if($products->count() > 0)
@foreach($products as $product)
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 product-item"
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
@else
<div class="col-12">
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">Tidak ada produk ditemukan</h5>
        <p class="text-muted">Coba ubah filter pencarian atau kategori</p>
        <a href="{{ route('customer.produk.index') }}" class="btn btn-primary">
            <i class="bi bi-grid me-1"></i>Lihat Semua Produk
        </a>
    </div>
</div>
@endif