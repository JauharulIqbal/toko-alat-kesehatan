<x-layouts.customer title="Detail Pesanan #{{ $pesanan->id_pesanan }} - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('customer.dashboard') }}" class="text-decoration-none">
                                        <i class="bi bi-house"></i> Beranda
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('customer.pesanan.index') }}" class="text-decoration-none">
                                        Riwayat Pesanan
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Pesanan
                                </li>
                            </ol>
                        </nav>
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div>
                                <h2 class="fw-bold text-primary mb-1">
                                    <i class="bi bi-receipt me-2"></i>Detail Pesanan #{{ $pesanan->id_pesanan }}
                                </h2>
                                <p class="text-muted mb-0">
                                    Dipesan pada {{ $pesanan->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <span class="badge 
                                    @if($pesanan->status_pesanan === 'sukses') bg-success
                                    @elseif($pesanan->status_pesanan === 'dikirim') bg-info
                                    @elseif($pesanan->status_pesanan === 'menunggu') bg-warning
                                    @else bg-danger @endif
                                    fs-6 px-3 py-2">
                                    {{ ucfirst($pesanan->status_pesanan) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Order Items -->
            <div class="col-lg-8">
                <!-- Items List -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-bag-check me-2"></i>Produk Pesanan ({{ $pesanan->items->count() }} item)
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($pesanan->items as $item)
                        <div class="border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <img src="{{ $item->produk->gambar_produk ? asset('storage/produk/' . $item->produk->gambar_produk) : 'https://via.placeholder.com/100x100/f8f9fa/dee2e6?text=No+Image' }}"
                                        alt="{{ $item->produk->nama_produk }}"
                                        class="img-fluid rounded shadow-sm"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="fw-bold mb-2">{{ $item->produk->nama_produk }}</h6>
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-shop me-1"></i>{{ $item->produk->toko->nama_toko }}
                                    </div>
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $item->produk->toko->kota->nama_kota ?? 'Lokasi tidak tersedia' }}
                                    </div>
                                    <div class="text-primary small">
                                        <i class="bi bi-tag me-1"></i>{{ $item->produk->kategori->nama_kategori ?? 'Kategori' }}
                                    </div>
                                </div>
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <small class="text-muted d-block">Jumlah</small>
                                    <span class="fw-bold">{{ $item->jumlah }}x</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <small class="text-muted d-block">Subtotal</small>
                                    <span class="fw-bold text-primary">
                                        Rp {{ number_format($item->subtotal_checkout, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Information -->
                <div class="row g-4">
                    <!-- Shipping Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-truck me-2"></i>Informasi Pengiriman
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Jasa Pengiriman</small>
                                    <div class="fw-semibold">{{ $pesanan->jasaPengiriman->nama_jasa_pengiriman }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Alamat Pengiriman</small>
                                    <div class="fw-semibold">{{ $pesanan->alamat_pengiriman ?? 'Alamat tidak tersedia' }}</div>
                                </div>
                                @if($pesanan->catatan)
                                <div class="mb-0">
                                    <small class="text-muted">Catatan</small>
                                    <div class="fw-semibold">{{ $pesanan->catatan }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Metode Pembayaran</small>
                                    <div class="fw-semibold">{{ $pesanan->pembayaran->metodePembayaran->metode_pembayaran }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Status Pembayaran</small>
                                    <div>
                                        <span class="badge 
                                            @if($pesanan->pembayaran->status_pembayaran === 'sukses') bg-success
                                            @elseif($pesanan->pembayaran->status_pembayaran === 'menunggu') bg-warning
                                            @else bg-danger @endif">
                                            {{ ucfirst($pesanan->pembayaran->status_pembayaran) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="text-muted">Jumlah Pembayaran</small>
                                    <div class="fw-bold text-success fs-5">
                                        Rp {{ number_format($pesanan->pembayaran->jumlah_pembayaran, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Actions -->
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-calculator me-2"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal Produk</span>
                            <span class="fw-semibold">
                                Rp {{ number_format($pesanan->items->sum('subtotal_checkout'), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Biaya Pengiriman</span>
                            <span class="fw-semibold">
                                Rp {{ number_format($pesanan->jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5 text-primary">
                                Rp {{ number_format($pesanan->total_harga_checkout, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-gear me-2"></i>Aksi Pesanan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($pesanan->status_pesanan === 'menunggu')
                                <button class="btn btn-danger cancel-order" 
                                        data-order-id="{{ $pesanan->id_pesanan }}">
                                    <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                                </button>
                            @endif

                            @if($pesanan->status_pesanan === 'dikirim')
                                <button class="btn btn-success confirm-order" 
                                        data-order-id="{{ $pesanan->id_pesanan }}">
                                    <i class="bi bi-check-circle me-2"></i>Terima Pesanan
                                </button>
                            @endif

                            <a href="{{ route('customer.pesanan.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
                            </a>

                            <button class="btn btn-outline-secondary" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Cetak Invoice
                            </button>

                            <button class="btn btn-outline-info" id="shareOrder">
                                <i class="bi bi-share me-2"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-clock-history me-2"></i>Timeline Pesanan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <!-- Order Created -->
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-success">
                                    <i class="bi bi-check text-white"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold text-success">Pesanan Dibuat</h6>
                                    <small class="text-muted">{{ $pesanan->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>

                            <!-- Processing -->
                            <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['dikirim', 'sukses']) ? 'completed' : ($pesanan->status_pesanan === 'menunggu' ? 'active' : 'cancelled') }}">
                                <div class="timeline-marker {{ in_array($pesanan->status_pesanan, ['dikirim', 'sukses']) ? 'bg-success' : ($pesanan->status_pesanan === 'menunggu' ? 'bg-warning' : 'bg-danger') }}">
                                    <i class="bi {{ in_array($pesanan->status_pesanan, ['dikirim', 'sukses']) ? 'bi-check' : ($pesanan->status_pesanan === 'menunggu' ? 'bi-clock' : 'bi-x') }} text-white"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">Sedang Diproses</h6>
                                    <small class="text-muted">
                                        @if($pesanan->status_pesanan === 'menunggu') Sedang dalam proses
                                        @elseif(in_array($pesanan->status_pesanan, ['dikirim', 'sukses'])) Selesai diproses
                                        @else Dibatalkan
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <!-- Shipped -->
                            <div class="timeline-item {{ $pesanan->status_pesanan === 'sukses' ? 'completed' : ($pesanan->status_pesanan === 'dikirim' ? 'active' : '') }}">
                                <div class="timeline-marker {{ $pesanan->status_pesanan === 'sukses' ? 'bg-success' : ($pesanan->status_pesanan === 'dikirim' ? 'bg-info' : 'bg-light') }}">
                                    <i class="bi {{ $pesanan->status_pesanan === 'sukses' ? 'bi-check' : ($pesanan->status_pesanan === 'dikirim' ? 'bi-truck' : 'bi-truck') }} {{ in_array($pesanan->status_pesanan, ['dikirim', 'sukses']) ? 'text-white' : 'text-muted' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">Dikirim</h6>
                                    <small class="text-muted">
                                        @if($pesanan->status_pesanan === 'sukses') Berhasil dikirim
                                        @elseif($pesanan->status_pesanan === 'dikirim') Sedang dalam pengiriman
                                        @else Menunggu pengiriman
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="timeline-item {{ $pesanan->status_pesanan === 'sukses' ? 'completed' : '' }}">
                                <div class="timeline-marker {{ $pesanan->status_pesanan === 'sukses' ? 'bg-success' : 'bg-light' }}">
                                    <i class="bi bi-house-door {{ $pesanan->status_pesanan === 'sukses' ? 'text-white' : 'text-muted' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">Diterima</h6>
                                    <small class="text-muted">
                                        @if($pesanan->status_pesanan === 'sukses') Pesanan telah diterima
                                        @else Menunggu konfirmasi penerimaan
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -22.5px;
            top: 2px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .timeline-content {
            padding-left: 20px;
        }

        .timeline-item.completed .timeline-marker {
            background-color: #198754 !important;
        }

        .timeline-item.active .timeline-marker {
            background-color: #0dcaf0 !important;
            animation: pulse 2s infinite;
        }

        .timeline-item.cancelled .timeline-marker {
            background-color: #dc3545 !important;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(13, 202, 240, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(13, 202, 240, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 202, 240, 0); }
        }

        @media print {
            .card-header, .btn, nav {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }

        .badge {
            font-size: 0.9rem;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Cancel order functionality
            $('.cancel-order').on('click', function() {
                const orderId = $(this).data('order-id');
                const button = $(this);

                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                    const originalText = button.html();
                    button.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...').prop('disabled', true);

                    $.ajax({
                        url: `{{ route('customer.pesanan.index') }}/${orderId}/cancel`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showToast('Pesanan berhasil dibatalkan', 'success');
                                setTimeout(() => window.location.reload(), 1500);
                            } else {
                                showToast(response.message || 'Gagal membatalkan pesanan', 'error');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan. Silakan coba lagi.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            showToast(message, 'error');
                        },
                        complete: function() {
                            button.html(originalText).prop('disabled', false);
                        }
                    });
                }
            });

            // Confirm order functionality
            $('.confirm-order').on('click', function() {
                const orderId = $(this).data('order-id');
                const button = $(this);

                if (confirm('Konfirmasi bahwa Anda telah menerima pesanan ini?')) {
                    const originalText = button.html();
                    button.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...').prop('disabled', true);

                    $.ajax({
                        url: `{{ route('customer.pesanan.index') }}/${orderId}/confirm`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showToast('Pesanan dikonfirmasi telah diterima', 'success');
                                setTimeout(() => window.location.reload(), 1500);
                            } else {
                                showToast(response.message || 'Gagal mengkonfirmasi pesanan', 'error');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan. Silakan coba lagi.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            showToast(message, 'error');
                        },
                        complete: function() {
                            button.html(originalText).prop('disabled', false);
                        }
                    });
                }
            });

            // Share functionality
            $('#shareOrder').on('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Pesanan #{{ $pesanan->id_pesanan }}',
                        text: 'Lihat detail pesanan saya di ALKES SHOP',
                        url: window.location.href
                    }).catch(err => console.log('Error sharing:', err));
                } else {
                    // Fallback - copy to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        showToast('Link berhasil disalin ke clipboard', 'success');
                    }).catch(() => {
                        showToast('Gagal menyalin link', 'error');
                    });
                }
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
                    delay: 4000
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