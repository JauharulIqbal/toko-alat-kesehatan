<x-layouts.admin title="Data Jasa Pengiriman">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Jasa Pengiriman</h2>
            <p class="text-muted mb-0">Kelola data jasa pengiriman untuk toko alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.jasa-pengiriman.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Jasa Pengiriman
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
            <form method="GET" action="{{ route('admin.jasa-pengiriman.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama jasa pengiriman..." id="searchInput">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="biaya_min" value="{{ request('biaya_min') }}"
                            placeholder="Biaya minimum" step="0.01" id="biayaMinFilter">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="biaya_max" value="{{ request('biaya_max') }}"
                            placeholder="Biaya maksimum" step="0.01" id="biayaMaxFilter">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.jasa-pengiriman.index') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Statistics Cards --}}
    @php
    $totalJasa = $jasaPengiriman->total();
    $avgBiaya = $jasaPengiriman->avg('biaya_pengiriman') ?: 0;
    $minBiaya = $jasaPengiriman->min('biaya_pengiriman') ?: 0;
    $maxBiaya = $jasaPengiriman->max('biaya_pengiriman') ?: 0;
    @endphp
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-truck text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $totalJasa }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Jasa Pengiriman</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-calculator text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">Rp {{ number_format($avgBiaya, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-success fw-medium">Rata-rata Biaya</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-down-circle text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-info">Rp {{ number_format($minBiaya, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-info fw-medium">Biaya Terendah</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-up-circle text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning">Rp {{ number_format($maxBiaya, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-warning fw-medium">Biaya Tertinggi</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Jasa Pengiriman --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="jasaPengirimanTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 40%">Nama Jasa Pengiriman</th>
                            <th scope="col" style="width: 25%">Biaya Pengiriman</th>
                            <th scope="col" class="text-center" style="width: 15%">Tanggal Dibuat</th>
                            <th scope="col" class="text-center" style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jasaPengiriman as $index => $item)
                        <tr>
                            <td class="text-center">{{ $jasaPengiriman->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-truck text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $item->nama_jasa_pengiriman }}</h6>
                                        <small class="text-muted">ID: {{ $item->id_jasa_pengiriman }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success fs-6 py-2 px-3">
                                    <i class="bi bi-currency-dollar me-1"></i>
                                    Rp {{ number_format($item->biaya_pengiriman, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted small">{{ $item->created_at->format('d M Y') }}</span>
                                <br>
                                <span class="text-muted" style="font-size: 0.75rem;">{{ $item->created_at->format('H:i') }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="viewJasaPengiriman('{{ $item->id_jasa_pengiriman }}')"
                                        title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.jasa-pengiriman.edit', $item->id_jasa_pengiriman) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="deleteJasaPengiriman('{{ $item->id_jasa_pengiriman }}')"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-truck" style="font-size: 48px;"></i>
                                    <h5 class="mt-3">Belum ada data jasa pengiriman</h5>
                                    <p>Silakan tambah data jasa pengiriman terlebih dahulu</p>
                                    <a href="{{ route('admin.jasa-pengiriman.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Jasa Pengiriman
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($jasaPengiriman->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $jasaPengiriman->firstItem() }} - {{ $jasaPengiriman->lastItem() }} dari {{ $jasaPengiriman->total() }} data
                    </small>
                </div>
                <div>
                    {{ $jasaPengiriman->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Jasa Pengiriman --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Detail Jasa Pengiriman</h5>
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
                    <p>Apakah Anda yakin ingin menghapus data jasa pengiriman ini?</p>
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
            const biayaMinFilter = document.getElementById('biayaMinFilter');
            const biayaMaxFilter = document.getElementById('biayaMaxFilter');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            biayaMinFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            biayaMaxFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        });

        // View Detail Jasa Pengiriman
        function viewJasaPengiriman(id) {
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
            fetch(`/admin/jasa-pengiriman/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const jasa = data.jasa_pengiriman;

                        detailContent.innerHTML = `
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                                <i class="bi bi-truck text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <h4 class="fw-bold mb-2">${jasa.nama_jasa_pengiriman}</h4>
                                            <h3 class="text-success mb-3">
                                                <span class="badge bg-success bg-opacity-10 text-success fs-5 py-2 px-3">
                                                    Rp ${new Intl.NumberFormat('id-ID').format(jasa.biaya_pengiriman)}
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Informasi Umum</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">ID:</td>
                                            <td class="fw-semibold">${jasa.id_jasa_pengiriman}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Nama Jasa:</td>
                                            <td class="fw-semibold">${jasa.nama_jasa_pengiriman}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Biaya:</td>
                                            <td class="fw-semibold text-success">Rp ${new Intl.NumberFormat('id-ID').format(jasa.biaya_pengiriman)}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Detail Waktu</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Dibuat:</td>
                                            <td>${new Date(jasa.created_at).toLocaleDateString('id-ID')} ${new Date(jasa.created_at).toLocaleTimeString('id-ID')}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Diperbarui:</td>
                                            <td>${new Date(jasa.updated_at).toLocaleDateString('id-ID')} ${new Date(jasa.updated_at).toLocaleTimeString('id-ID')}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    detailContent.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-danger">Error</h5>
                            <p class="text-muted">Gagal memuat detail jasa pengiriman</p>
                        </div>
                    `;
                });
        }

        // Delete Jasa Pengiriman
        function deleteJasaPengiriman(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `/admin/jasa-pengiriman/${id}`;
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