<x-layouts.admin :title="$title">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Penjual</h1>
        <div class="text-muted">
            <i class="bi bi-calendar3"></i>
            {{ now()->format('d F Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Produk Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">25</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pesanan Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">142</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pendapatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 15.250.000</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Rating Toko
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">4.8/5</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-star-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
                    <a href="{{ route('seller.pesanan.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD001</td>
                                    <td>John Doe</td>
                                    <td>Tensimeter Digital</td>
                                    <td>Rp 250.000</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
                                </tr>
                                <tr>
                                    <td>#ORD002</td>
                                    <td>Jane Smith</td>
                                    <td>Masker N95</td>
                                    <td>Rp 45.000</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('seller.produk.index') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                        </a>
                        <a href="#" class="btn btn-success">
                            <i class="bi bi-graph-up me-2"></i>Lihat Laporan
                        </a>
                        <a href="#" class="btn btn-info">
                            <i class="bi bi-gear me-2"></i>Pengaturan Toko
                        </a>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info Toko</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-shop text-white fs-2"></i>
                        </div>
                        <h5 class="font-weight-bold">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small">{{ auth()->user()->email }}</p>
                        <div class="row text-center">
                            <div class="col-6">
                                <h6 class="font-weight-bold text-primary">4.8</h6>
                                <small class="text-muted">Rating</small>
                            </div>
                            <div class="col-6">
                                <h6 class="font-weight-bold text-success">142</h6>
                                <small class="text-muted">Penjualan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>