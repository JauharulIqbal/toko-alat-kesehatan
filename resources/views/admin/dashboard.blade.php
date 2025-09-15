<x-layouts.admin :title="$title">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Total Toko</h6>
                    <h3>{{ $totalToko }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Total Produk</h6>
                    <h3>{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Total Pesanan</h6>
                    <h3>{{ $totalPesanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Total Pembayaran</h6>
                    <h3>{{ $totalPembayaran }}</h3>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
