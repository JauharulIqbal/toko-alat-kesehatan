<x-layouts.admin title="Data Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Produk</h2>
            <p class="text-muted mb-0">Kelola data produk alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.produk.exportPdf') }}" class="btn btn-outline-success" target="_blank">
                <i class="bi bi-file-pdf me-2"></i>Export PDF
            </a>
            <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter dan Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.produk.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama produk..." id="searchInput">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="kategori" id="kategoriFilter">
                            <option value="">Semua Kategori</option>
                            @php
                            $kategoris = \App\Models\Kategori::orderBy('nama_kategori')->get();
                            @endphp
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="toko" id="tokoFilter">
                            <option value="">Semua Toko</option>
                            @php
                            $tokos = \App\Models\Toko::orderBy('nama_toko')->get();
                            @endphp
                            @foreach($tokos as $toko)
                            <option value="{{ $toko->id_toko }}" {{ request('toko') == $toko->id_toko ? 'selected' : '' }}>
                                {{ $toko->nama_toko }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="stok" id="stokFilter">
                            <option value="">Semua Stok</option>
                            <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (>10)</option>
                            <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>Menipis (1-10)</option>
                            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $produk->where('stok', '>', 10)->count() }}</h3>
                    <p class="mb-0 text-success fw-medium">Tersedia</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning">{{ $produk->where('stok', '>', 0)->where('stok', '<=', 10)->count() }}</h3>
                    <p class="mb-0 text-warning fw-medium">Menipis</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger bg-opacity-10 border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-danger">{{ $produk->where('stok', 0)->count() }}</h3>
                    <p class="mb-0 text-danger fw-medium">Habis</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-boxes text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $produk->total() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Produk</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Produk --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="produkTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 8%">Gambar</th>
                            <th scope="col" style="width: 20%">Nama Produk</th>
                            <th scope="col" style="width: 12%">Kategori</th>
                            <th scope="col" style="width: 15%">Toko</th>
                            <th scope="col" class="text-center" style="width: 12%">Harga</th>
                            <th scope="col" class="text-center" style="width: 8%">Stok</th>
                            <th scope="col" class="text-center" style="width: 10%">Status</th>
                            <th scope="col" class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $index => $item)
                        <tr>
                            <td class="text-center">{{ $produk->firstItem() + $index }}</td>
                            <td class="text-center">
                                @if($item->gambar_produk)
                                <img src="{{ asset('storage/' . $item->gambar_produk) }}"
                                    alt="{{ $item->nama_produk }}"
                                    class="rounded"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $item->nama_produk }}</h6>
                                    @if($item->deskripsi)
                                    <small class="text-muted">{{ Str::limit($item->deskripsi, 40) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($item->kategori)
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-tag me-1"></i>{{ $item->kategori->nama_kategori }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->toko)
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="bi bi-shop text-primary" style="font-size: 14px;"></i>
                                    </div>
                                    <span class="fw-medium small">{{ Str::limit($item->toko->nama_toko, 20) }}</span>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                $stokClass = $item->stok == 0 ? 'danger' : ($item->stok <= 10 ? 'warning' : 'success' );
                                    @endphp
                                    <span class="badge bg-{{ $stokClass }}">{{ $item->stok }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                $statusClass = $item->stok == 0 ? 'danger' : ($item->stok <= 10 ? 'warning' : 'success' );
                                    $statusText=$item->stok == 0 ? 'Habis' : ($item->stok <= 10 ? 'Menipis' : 'Tersedia' );
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="viewProduk('{{ $item->id_produk }}')"
                                        title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.produk.edit', $item->id_produk) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="deleteProduk('{{ $item->id_produk }}')"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-box-seam" style="font-size: 48px;"></i>
                                    <h5 class="mt-3">Belum ada data produk</h5>
                                    <p>Silakan tambah data produk terlebih dahulu</p>
                                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($produk->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $produk->firstItem() }} - {{ $produk->lastItem() }} dari {{ $produk->total() }} data
                    </small>
                </div>
                <div>
                    {{ $produk->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Produk --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Detail Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                    <p class="text-muted"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriFilter = document.getElementById('kategoriFilter');
            const tokoFilter = document.getElementById('tokoFilter');
            const stokFilter = document.getElementById('stokFilter');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            kategoriFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            tokoFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            stokFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        });

        // View Detail Produk
        function viewProduk(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const detailContent = document.getElementById('detailContent');

            detailContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            modal.show();

            // AJAX call to get detail
            fetch(`/admin/produk/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const produk = data.produk;
                        const stokClass = produk.stok == 0 ? 'danger' : (produk.stok <= 10 ? 'warning' : 'success');
                        const stokText = produk.stok == 0 ? 'Habis' : (produk.stok <= 10 ? 'Menipis' : 'Tersedia');

                        detailContent.innerHTML = `
                            <div class="row">
                                <div class="col-md-4 text-center mb-3">
                                    ${produk.gambar_produk ? 
                                        `<img src="/storage/${produk.gambar_produk}" alt="${produk.nama_produk}" class="img-fluid rounded" style="max-height: 200px;">` :
                                        `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;"><i class="bi bi-image text-muted" style="font-size: 3rem;"></i></div>`
                                    }
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted mb-2">Informasi Produk</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Nama Produk:</td>
                                            <td class="fw-semibold">${produk.nama_produk}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kategori:</td>
                                            <td>${produk.kategori ? produk.kategori.nama_kategori : '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Toko:</td>
                                            <td>${produk.toko ? produk.toko.nama_toko : '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Harga:</td>
                                            <td class="fw-bold text-primary">Rp ${new Intl.NumberFormat('id-ID').format(produk.harga)}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Stok:</td>
                                            <td><span class="badge bg-${stokClass}">${produk.stok}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td><span class="badge bg-${stokClass}">${stokText}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Dibuat:</td>
                                            <td>${new Date(produk.created_at).toLocaleDateString('id-ID')}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Diperbarui:</td>
                                            <td>${new Date(produk.updated_at).toLocaleDateString('id-ID')}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${produk.deskripsi ? `
                            <div class="mt-3">
                                <h6 class="text-muted mb-2">Deskripsi Produk</h6>
                                <p class="text-muted">${produk.deskripsi}</p>
                            </div>
                            ` : ''}
                        `;
                    }
                })
                .catch(error => {
                    detailContent.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-danger">Error</h5>
                            <p class="text-muted">Gagal memuat detail produk</p>
                        </div>
                    `;
                });
        }

        // Delete Produk
        function deleteProduk(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `/admin/produk/${id}`;
            modal.show();
        }

        // Auto hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    @endpush

    <style>
        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6c757d;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .modal-content {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .pagination .page-link {
            border-radius: 0.375rem;
            margin: 0 2px;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</x-layouts.admin>