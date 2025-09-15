<x-layouts.admin title="Data Toko">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Toko</h2>
            <p class="text-muted mb-0">Kelola data toko alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.toko.export-pdf') }}" class="btn btn-outline-success" target="_blank">
                <i class="bi bi-file-pdf me-2"></i>Export PDF
            </a>
            <a href="{{ route('admin.toko.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Toko
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
            <form method="GET" action="{{ route('admin.toko.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama toko..." id="searchInput">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="kota" id="kotaFilter">
                            <option value="">Semua Kota</option>
                            @php
                                $kotas = \App\Models\Kota::orderBy('nama_kota')->get();
                            @endphp
                            @foreach($kotas as $kota)
                                <option value="{{ $kota->id_kota }}" {{ request('kota') == $kota->id_kota ? 'selected' : '' }}>
                                    {{ $kota->nama_kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.toko.index') }}" class="btn btn-outline-secondary flex-fill">
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
                    <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $toko->where('status_toko', 'disetujui')->count() }}</h3>
                    <p class="mb-0 text-success fw-medium">Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning">{{ $toko->where('status_toko', 'menunggu')->count() }}</h3>
                    <p class="mb-0 text-warning fw-medium">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger bg-opacity-10 border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-danger">{{ $toko->where('status_toko', 'ditolak')->count() }}</h3>
                    <p class="mb-0 text-danger fw-medium">Ditolak</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-shop text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $toko->total() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Toko</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Toko --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tokoTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 20%">Nama Toko</th>
                            <th scope="col" style="width: 15%">Pemilik</th>
                            <th scope="col" style="width: 15%">Kota</th>
                            <th scope="col" style="width: 25%">Alamat</th>
                            <th scope="col" class="text-center" style="width: 10%">Status</th>
                            <th scope="col" class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($toko as $index => $item)
                            <tr>
                                <td class="text-center">{{ $toko->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-shop text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $item->nama_toko }}</h6>
                                            @if($item->deskripsi_toko)
                                                <small class="text-muted">{{ Str::limit($item->deskripsi_toko, 30) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($item->user)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person text-success" style="font-size: 14px;"></i>
                                            </div>
                                            <span class="fw-medium">{{ $item->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->kota)
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $item->kota->nama_kota }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->alamat_toko)
                                        <span class="text-muted small">{{ Str::limit($item->alamat_toko, 40) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = match($item->status_toko) {
                                            'disetujui' => 'bg-success',
                                            'ditolak' => 'bg-danger',
                                            'menunggu' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                        $statusText = ucfirst($item->status_toko);
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewToko('{{ $item->id_toko }}')" 
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.toko.edit', $item->id_toko) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteToko('{{ $item->id_toko }}')" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-shop" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Belum ada data toko</h5>
                                        <p>Silakan tambah data toko terlebih dahulu</p>
                                        <a href="{{ route('admin.toko.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Tambah Toko
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($toko->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $toko->firstItem() }} - {{ $toko->lastItem() }} dari {{ $toko->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $toko->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Toko --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-shop me-2"></i>Detail Toko</h5>
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
                    <p>Apakah Anda yakin ingin menghapus data toko ini?</p>
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
            const statusFilter = document.getElementById('statusFilter');
            const kotaFilter = document.getElementById('kotaFilter');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            statusFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            kotaFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        });

        // View Detail Toko
        function viewToko(id) {
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
            fetch(`/admin/toko/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const toko = data.toko;
                        const statusClass = toko.status_toko === 'disetujui' ? 'success' : 
                                          toko.status_toko === 'ditolak' ? 'danger' : 'warning';
                        
                        detailContent.innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Informasi Toko</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Nama Toko:</td>
                                            <td class="fw-semibold">${toko.nama_toko}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td><span class="badge bg-${statusClass}">${toko.status_toko.charAt(0).toUpperCase() + toko.status_toko.slice(1)}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Pemilik:</td>
                                            <td>${toko.user ? toko.user.name : '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kota:</td>
                                            <td>${toko.kota ? toko.kota.nama_kota : '-'}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Detail Lainnya</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Alamat:</td>
                                            <td>${toko.alamat_toko || '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Dibuat:</td>
                                            <td>${new Date(toko.created_at).toLocaleDateString('id-ID')}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Diperbarui:</td>
                                            <td>${new Date(toko.updated_at).toLocaleDateString('id-ID')}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${toko.deskripsi_toko ? `
                            <div class="mt-3">
                                <h6 class="text-muted mb-2">Deskripsi</h6>
                                <p class="text-muted">${toko.deskripsi_toko}</p>
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
                            <p class="text-muted">Gagal memuat detail toko</p>
                        </div>
                    `;
                });
        }

        // Delete Toko
        function deleteToko(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `/admin/toko/${id}`;
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