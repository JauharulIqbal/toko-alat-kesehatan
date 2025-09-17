<x-layouts.customer title="Checkout Berhasil - ALKES SHOP">
    <div class="container-fluid px-4 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <!-- Success Card -->
                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">
                        <!-- Success Icon -->
                        <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-check-circle text-white" style="font-size: 3rem;"></i>
                        </div>

                        <!-- Success Message -->
                        <h2 class="fw-bold text-success mb-3">Pesanan Berhasil Dibuat!</h2>
                        <p class="text-muted mb-4 lead">
                            Terima kasih atas pesanan Anda. Kami akan segera memproses pesanan ini.
                        </p>

                        <!-- Order Details -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">ID Pesanan</small>
                                    <strong class="text-primary">#{{ $pesanan->id_pesanan }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">Total Bayar</small>
                                    <strong class="text-success">Rp {{ number_format($pesanan->total_harga_checkout, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="{{ route('customer.pesanan.show', $pesanan->id_pesanan) }}"
                                class="btn btn-primary">
                                <i class="bi bi-eye me-2"></i>Lihat Detail Pesanan
                            </a>
                            <a href="{{ route('customer.dashboard') }}"
                                class="btn btn-outline-primary">
                                <i class="bi bi-house me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Items -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Item Pesanan ({{ $pesanan->items->count() }} produk)</h6>
                            @foreach($pesanan->items as $item)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-2">
                                    <img src="{{ $item->produk->gambar_produk ? asset('storage/produk/' . $item->produk->gambar_produk) : 'https://via.placeholder.com/60x60/f8f9fa/dee2e6?text=No+Image' }}"
                                        alt="{{ $item->produk->nama_produk }}"
                                        class="img-fluid rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-1">{{ $item->produk->nama_produk }}</h6>
                                    <small class="text-muted">{{ $item->jumlah }}x @ Rp {{ number_format($item->subtotal_checkout / $item->jumlah, 0, ',', '.') }}</small>
                                </div>
                                <div class="col-4 text-end">
                                    <span class="fw-semibold">Rp {{ number_format($item->subtotal_checkout, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Payment & Shipping Info -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-2">Informasi Pembayaran</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-credit-card me-2 text-primary"></i>
                                    <span>{{ $pesanan->pembayaran->metodePembayaran->metode_pembayaran }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill me-2"
                                        style="font-size: 0.5rem; color: 
                                       @if($pesanan->pembayaran->status_pembayaran === 'sukses') #198754
                                       @elseif($pesanan->pembayaran->status_pembayaran === 'menunggu') #ffc107
                                       @else #dc3545 @endif"></i>
                                    <span class="text-capitalize">{{ $pesanan->pembayaran->status_pembayaran }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-2">Informasi Pengiriman</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-truck me-2 text-primary"></i>
                                    <span>{{ $pesanan->jasaPengiriman->nama_jasa_pengiriman }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill me-2"
                                        style="font-size: 0.5rem; color: 
                                       @if($pesanan->status_pesanan === 'sukses') #198754
                                       @elseif($pesanan->status_pesanan === 'dikirim') #0dcaf0
                                       @elseif($pesanan->status_pesanan === 'menunggu') #ffc107
                                       @else #dc3545 @endif"></i>
                                    <span class="text-capitalize">{{ $pesanan->status_pesanan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-info-circle me-2"></i>Langkah Selanjutnya
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <i class="bi bi-clock-history fs-2 text-primary mb-3"></i>
                                    <h6 class="fw-semibold">1. Menunggu Konfirmasi</h6>
                                    <small class="text-muted">Pesanan sedang diverifikasi oleh penjual</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <i class="bi bi-box-seam fs-2 text-primary mb-3"></i>
                                    <h6 class="fw-semibold">2. Persiapan Pesanan</h6>
                                    <small class="text-muted">Pesanan dikemas dengan teliti</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <i class="bi bi-truck fs-2 text-primary mb-3"></i>
                                    <h6 class="fw-semibold">3. Pengiriman</h6>
                                    <small class="text-muted">Pesanan dikirim ke alamat tujuan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-2">Butuh bantuan dengan pesanan Anda?</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('customer.pesanan.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-list-ul me-1"></i>Riwayat Pesanan
                        </a>
                        <a href="mailto:support@alkesshop.com" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-envelope me-1"></i>Hubungi Support
                        </a>
                    </div>
                </div>
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
        }

        .bg-gradient {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        .card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Auto redirect after 30 seconds (optional)
            // setTimeout(function() {
            //     window.location.href = '{{ route("customer.dashboard") }}';
            // }, 30000);

            // Track order button click
            $('a[href*="pesanan.show"]').on('click', function() {
                // You can add analytics tracking here
                console.log('User viewed order details:', '{{ $pesanan->id_pesanan }}');
            });

            // Show success animation
            setTimeout(function() {
                $('.bi-check-circle').addClass('animate__animated animate__bounce');
            }, 500);
        });
    </script>
    @endpush
</x-layouts.customer>