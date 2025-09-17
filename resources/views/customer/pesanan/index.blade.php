<x-layouts.customer title="Riwayat Pesanan - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div>
                                <h2 class="fw-bold text-primary mb-1">
                                    <i class="bi bi-bag-check me-2"></i>Riwayat Pesanan
                                </h2>
                                <p class="text-muted mb-0">Kelola dan pantau status pesanan Anda</p>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-1"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <a href="{{ route('customer.pesanan.index') }}"
                                    class="btn {{ !$status ? 'btn-primary' : 'btn-outline-primary' }} w-100 position-relative">
                                    Semua
                                    <span class="badge {{ !$status ? 'bg-white text-primary' : 'bg-primary' }} position-absolute top-0 start-100 translate-middle">
                                        {{ $statusCounts['semua'] }}
                                    </span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <a href="{{ route('customer.pesanan.index', ['status' => 'menunggu']) }}"
                                    class="btn {{ $status === 'menunggu' ? 'btn-warning' : 'btn-outline-warning' }} w-100 position-relative">
                                    Menunggu
                                    <span class="badge {{ $status === 'menunggu' ? 'bg-white text-warning' : 'bg-warning' }} position-absolute top-0 start-100 translate-middle">
                                        {{ $statusCounts['menunggu'] }}
                                    </span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <a href="{{ route('customer.pesanan.index', ['status' => 'dikirim']) }}"
                                    class="btn {{ $status === 'dikirim' ? 'btn-info' : 'btn-outline-info' }} w-100 position-relative">
                                    Dikirim
                                    <span class="badge {{ $status === 'dikirim' ? 'bg-white text-info' : 'bg-info' }} position-absolute top-0 start-100 translate-middle">
                                        {{ $statusCounts['dikirim'] }}
                                    </span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <a href="{{ route('customer.pesanan.index', ['status' => 'sukses']) }}"
                                    class="btn {{ $status === 'sukses' ? 'btn-success' : 'btn-outline-success' }} w-100 position-relative">
                                    Selesai
                                    <span class="badge {{ $status === 'sukses' ? 'bg-white text-success' : 'bg-success' }} position-absolute top-0 start-100 translate-middle">
                                        {{ $statusCounts['sukses'] }}
                                    </span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <a href="{{ route('customer.pesanan.index', ['status' => 'gagal']) }}"
                                    class="btn {{ $status === 'gagal' ? 'btn-danger' : 'btn-outline-danger' }} w-100 position-relative">
                                    Dibatalkan
                                    <span class="badge {{ $status === 'gagal' ? 'bg-white text-danger' : 'bg-danger' }} position-absolute top-0 start-100 translate-middle">
                                        {{ $statusCounts['gagal'] }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row">
            <div class="col-12">
                @if($pesanan->count() > 0)
                @foreach($pesanan as $order)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-1">
                                    <i class="bi bi-receipt me-2"></i>
                                    Pesanan #{{ $order->id_pesanan }}
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                <span class="badge 
                                        @if($order->status_pesanan === 'sukses') bg-success
                                        @elseif($order->status_pesanan === 'dikirim') bg-info
                                        @elseif($order->status_pesanan === 'menunggu') bg-warning
                                        @else bg-danger @endif
                                        me-2">
                                    {{ ucfirst($order->status_pesanan) }}
                                </span>
                                <span class="fw-bold text-primary">
                                    Rp {{ number_format($order->total_harga_checkout, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Order Items -->
                        <div class="row g-3 mb-3">
                            @foreach($order->items->take(3) as $item)
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->produk->gambar_produk ? asset('storage/produk/' . $item->produk->gambar_produk) : 'https://via.placeholder.com/60x60/f8f9fa/dee2e6?text=No+Image' }}"
                                        alt="{{ $item->produk->nama_produk }}"
                                        class="me-3 rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-truncate">{{ $item->produk->nama_produk }}</h6>
                                        <small class="text-muted">{{ $item->jumlah }}x</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @if($order->items->count() > 3)
                            <div class="col-md-12">
                                <small class="text-muted">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    dan {{ $order->items->count() - 3 }} produk lainnya
                                </small>
                            </div>
                            @endif
                        </div>

                        <!-- Order Info -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Jasa Pengiriman</small>
                                <span class="fw-semibold">
                                    <i class="bi bi-truck me-1"></i>
                                    {{ $order->jasaPengiriman->nama_jasa_pengiriman }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <span class="fw-semibold">
                                    <i class="bi bi-credit-card me-1"></i>
                                    {{ $order->pembayaran->metodePembayaran->metode_pembayaran }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('customer.pesanan.show', $order->id_pesanan) }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>

                            @if($order->status_pesanan === 'menunggu')
                            <button class="btn btn-danger btn-sm cancel-order"
                                data-order-id="{{ $order->id_pesanan }}">
                                <i class="bi bi-x-circle me-1"></i>Batalkan
                            </button>
                            @endif

                            @if($order->status_pesanan === 'dikirim')
                            <button class="btn btn-success btn-sm confirm-order"
                                data-order-id="{{ $order->id_pesanan }}">
                                <i class="bi bi-check-circle me-1"></i>Terima Pesanan
                            </button>
                            @endif

                            <button class="btn btn-outline-secondary btn-sm"
                                onclick="navigator.share ? navigator.share({title: 'Pesanan #{{ $order->id_pesanan }}', text: 'Lihat pesanan saya', url: '{{ route('customer.pesanan.show', $order->id_pesanan) }}'}) : alert('Fitur share tidak didukung browser ini')">
                                <i class="bi bi-share me-1"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($pesanan->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $pesanan->withQueryString()->links() }}
                </div>
                @endif
                @else
                <!-- Empty State -->
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-bag-x fs-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">
                            @if($status)
                            Belum ada pesanan dengan status "{{ ucfirst($status) }}"
                            @else
                            Belum ada pesanan
                            @endif
                        </h4>
                        <p class="text-muted mb-4">
                            @if($status)
                            Pesanan dengan status {{ ucfirst($status) }} akan muncul di sini
                            @else
                            Mulai berbelanja untuk melihat riwayat pesanan Anda
                            @endif
                        </p>
                        <a href="{{ route('customer.produk.index') }}" class="btn btn-primary">
                            <i class="bi bi-shop me-1"></i>Mulai Berbelanja
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .position-relative .badge {
            font-size: 0.7rem;
        }

        @media (max-width: 768px) {
            .position-relative .badge {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                transform: none !important;
                margin-left: 0.5rem;
            }
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
                    button.html('<span class="spinner-border spinner-border-sm me-1" role="status"></span>Loading...').prop('disabled', true);

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
                    button.html('<span class="spinner-border spinner-border-sm me-1" role="status"></span>Loading...').prop('disabled', true);

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