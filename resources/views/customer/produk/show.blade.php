<x-layouts.customer title="{{ $produk->nama_produk }} - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}" class="text-decoration-none">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.produk.index') }}" class="text-decoration-none">
                                Produk
                            </a>
                        </li>
                        @if($produk->kategori)
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.kategori.show', $produk->kategori->id_kategori) }}" class="text-decoration-none">
                                {{ $produk->kategori->nama_kategori }}
                            </a>
                        </li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Str::limit($produk->nama_produk, 30) }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Detail -->
        <div class="row g-4 mb-5">
            <!-- Product Images -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="position-relative">
                            <img src="{{ $produk->gambar_produk ? asset('storage/produk/' . $produk->gambar_produk) : 'https://via.placeholder.com/500x400/f8f9fa/dee2e6?text=No+Image' }}"
                                class="img-fluid w-100 rounded"
                                alt="{{ $produk->nama_produk }}"
                                style="height: 400px; object-fit: cover;"
                                id="mainProductImage">

                            <!-- Stock Badge -->
                            @if($produk->stok > 0)
                            <span class="badge bg-success position-absolute top-0 start-0 m-3 fs-6">
                                <i class="bi bi-check-circle me-1"></i>Tersedia
                            </span>
                            @else
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6">
                                <i class="bi bi-x-circle me-1"></i>Stok Habis
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <!-- Category -->
                        <div class="mb-3">
                            @if($produk->kategori)
                            <a href="{{ route('customer.kategori.show', $produk->kategori->id_kategori) }}" 
                               class="badge bg-primary text-decoration-none fs-6 px-3 py-2">
                                <i class="bi bi-tag me-1"></i>{{ $produk->kategori->nama_kategori }}
                            </a>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <h1 class="fw-bold mb-3 text-dark">{{ $produk->nama_produk }}</h1>

                        <!-- Price -->
                        <div class="mb-4">
                            <h2 class="text-primary fw-bold mb-0">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </h2>
                            <small class="text-muted">Harga sudah termasuk pajak</small>
                        </div>

                        <!-- Store Info -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-shop fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $produk->toko->nama_toko }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ $produk->toko->kota->nama_kota ?? 'Lokasi tidak tersedia' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('customer.toko.show', $produk->toko->id_toko) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-shop me-1"></i>Kunjungi Toko
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Info -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Stok Tersedia</small>
                                    <span class="fw-bold fs-5">{{ $produk->stok }} unit</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                                        {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Selector & Add to Cart -->
                        @if($produk->stok > 0)
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label class="form-label fw-semibold">Jumlah</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" class="form-control text-center" id="quantity" 
                                               value="1" min="1" max="{{ $produk->stok }}" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <label class="form-label fw-semibold opacity-0">Action</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary flex-grow-1 add-to-cart" 
                                                data-product-id="{{ $produk->id_produk }}">
                                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                        <button class="btn btn-outline-primary" id="buyNow">
                                            <i class="bi bi-lightning me-1"></i>Beli Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="mb-4">
                            <button class="btn btn-secondary w-100 btn-lg" disabled>
                                <i class="bi bi-x-circle me-2"></i>Produk Habis
                            </button>
                        </div>
                        @endif

                        <!-- Product Features -->
                        <div class="row g-3 text-center">
                            <div class="col-4">
                                <div class="p-3 border rounded">
                                    <i class="bi bi-shield-check text-success fs-4 d-block mb-2"></i>
                                    <small class="fw-semibold">Original</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 border rounded">
                                    <i class="bi bi-truck text-primary fs-4 d-block mb-2"></i>
                                    <small class="fw-semibold">Fast Delivery</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 border rounded">
                                    <i class="bi bi-headset text-info fs-4 d-block mb-2"></i>
                                    <small class="fw-semibold">24/7 Support</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description & Details -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button">
                                    <i class="bi bi-file-text me-1"></i>Deskripsi
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specifications" type="button">
                                    <i class="bi bi-list-ul me-1"></i>Spesifikasi
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping" type="button">
                                    <i class="bi bi-truck me-1"></i>Pengiriman
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="description">
                                <div class="prose">
                                    @if($produk->deskripsi)
                                        <p class="lead text-muted mb-4">{{ $produk->deskripsi }}</p>
                                    @else
                                        <p class="text-muted">Belum ada deskripsi untuk produk ini.</p>
                                    @endif
                                    
                                    <h6 class="fw-bold mb-3">Keunggulan Produk:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Produk original dan bergaransi</li>
                                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Kualitas terjamin sesuai standar</li>
                                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Pengiriman aman dan terpercaya</li>
                                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Customer service responsif</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Specifications Tab -->
                            <div class="tab-pane fade" id="specifications">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-semibold">Nama Produk</td>
                                                <td>{{ $produk->nama_produk }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Kategori</td>
                                                <td>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Stok</td>
                                                <td>{{ $produk->stok }} unit</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Harga</td>
                                                <td class="text-primary fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-semibold">Toko</td>
                                                <td>{{ $produk->toko->nama_toko }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Lokasi Toko</td>
                                                <td>{{ $produk->toko->kota->nama_kota ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ditambahkan</td>
                                                <td>{{ $produk->created_at->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Status</td>
                                                <td>
                                                    <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Tab -->
                            <div class="tab-pane fade" id="shipping">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Informasi Pengiriman</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-3">
                                                <i class="bi bi-truck text-primary me-2"></i>
                                                <strong>Pengiriman Regular:</strong><br>
                                                <small class="text-muted ms-4">Estimasi 3-7 hari kerja</small>
                                            </li>
                                            <li class="mb-3">
                                                <i class="bi bi-lightning text-warning me-2"></i>
                                                <strong>Pengiriman Express:</strong><br>
                                                <small class="text-muted ms-4">Estimasi 1-2 hari kerja</small>
                                            </li>
                                            <li class="mb-3">
                                                <i class="bi bi-geo-alt text-info me-2"></i>
                                                <strong>Pengiriman dari:</strong><br>
                                                <small class="text-muted ms-4">{{ $produk->toko->kota->nama_kota ?? 'Lokasi toko' }}</small>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Layanan Tersedia</h6>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="border rounded p-2 text-center">
                                                    <i class="bi bi-shield-check text-success"></i>
                                                    <small class="d-block">Asuransi</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="border rounded p-2 text-center">
                                                    <i class="bi bi-arrow-repeat text-primary"></i>
                                                    <small class="d-block">Retur</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="border rounded p-2 text-center">
                                                    <i class="bi bi-chat-dots text-info"></i>
                                                    <small class="d-block">Chat Support</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="border rounded p-2 text-center">
                                                    <i class="bi bi-patch-check text-success"></i>
                                                    <small class="d-block">Tracking</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">
                    <i class="bi bi-grid me-2"></i>Produk Terkait
                </h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card h-100 shadow-sm border-0 card-hover">
                            <div class="position-relative">
                                <img src="{{ $related->gambar_produk ? asset('storage/produk/' . $related->gambar_produk) : 'https://via.placeholder.com/300x200/f8f9fa/dee2e6?text=No+Image' }}"
                                    class="card-img-top"
                                    alt="{{ $related->nama_produk }}"
                                    style="height: 200px; object-fit: cover;">
                                @if($related->stok > 0)
                                <span class="badge bg-success position-absolute top-0 start-0 m-2">Tersedia</span>
                                @else
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Habis</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">{{ Str::limit($related->nama_produk, 40) }}</h6>
                                <div class="mt-auto">
                                    <h5 class="text-primary fw-bold mb-3">
                                        Rp {{ number_format($related->harga, 0, ',', '.') }}
                                    </h5>
                                    <div class="d-flex gap-2">
                                        @if($related->stok > 0)
                                        <button class="btn btn-primary btn-sm flex-grow-1 add-to-cart"
                                                data-product-id="{{ $related->id_produk }}">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-secondary btn-sm flex-grow-1" disabled>Habis</button>
                                        @endif
                                        <a href="{{ route('customer.produk.show', $related->id_produk) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Store Products -->
        @if($storeProducts->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">
                        <i class="bi bi-shop me-2"></i>Produk Lain dari {{ $produk->toko->nama_toko }}
                    </h3>
                    <a href="{{ route('customer.toko.show', $produk->toko->id_toko) }}" 
                       class="btn btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($storeProducts as $storeProduct)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <div class="card product-card h-100 shadow-sm border-0 card-hover">
                            <div class="position-relative">
                                <img src="{{ $storeProduct->gambar_produk ? asset('storage/produk/' . $storeProduct->gambar_produk) : 'https://via.placeholder.com/200x150/f8f9fa/dee2e6?text=No+Image' }}"
                                    class="card-img-top"
                                    alt="{{ $storeProduct->nama_produk }}"
                                    style="height: 150px; object-fit: cover;">
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title small mb-2">{{ Str::limit($storeProduct->nama_produk, 30) }}</h6>
                                <div class="text-primary fw-bold small">
                                    Rp {{ number_format($storeProduct->harga, 0, ',', '.') }}
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('customer.produk.show', $storeProduct->id_produk) }}"
                                        class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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

        .prose p {
            line-height: 1.8;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: none;
        }

        #mainProductImage {
            transition: transform 0.3s ease;
        }

        #mainProductImage:hover {
            transform: scale(1.05);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Quantity controls
            $('#increaseQty').on('click', function() {
                const qty = parseInt($('#quantity').val());
                const maxQty = parseInt($('#quantity').attr('max'));
                if (qty < maxQty) {
                    $('#quantity').val(qty + 1);
                }
            });

            $('#decreaseQty').on('click', function() {
                const qty = parseInt($('#quantity').val());
                if (qty > 1) {
                    $('#quantity').val(qty - 1);
                }
            });

            // Add to Cart
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('product-id');
                const quantity = parseInt($('#quantity').val()) || 1;
                const button = $(this);

                const originalText = button.html();
                button.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...').prop('disabled', true);

                $.ajax({
                    url: '{{ route("customer.keranjang.add") }}',
                    method: 'POST',
                    data: {
                        id_produk: productId,
                        quantity: quantity,
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

            // Buy Now
            $('#buyNow').on('click', function() {
                const quantity = parseInt($('#quantity').val()) || 1;
                const productId = {{ $produk->id_produk }};
                
                // Add to cart first, then redirect to checkout
                $.ajax({
                    url: '{{ route("customer.keranjang.add") }}',
                    method: 'POST',
                    data: {
                        id_produk: productId,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '{{ route("customer.checkout.index") }}';
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