<x-layouts.admin title="Data Kota">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Kota</h2>
            <p class="text-muted mb-0">Kelola data kota untuk lokasi toko dan user</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kota.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kota
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
            <form method="GET" action="{{ route('admin.kota.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama kota atau kode kota..." id="searchInput">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="sort" id="sortFilter">
                            <option value="nama_kota_asc" {{ request('sort') == 'nama_kota_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="nama_kota_desc" {{ request('sort') == 'nama_kota_desc' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.kota.index') }}" class="btn btn-outline-secondary flex-fill">
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
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-geo-alt text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $kota->total() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Kota</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $kota->sum(function($item) { return $item->users->count(); }) }}</h3>
                    <p class="mb-0 text-success fw-medium">Total User</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body text-center">
                    <i class="bi bi-shop text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-info">{{ $kota->sum(function($item) { return $item->tokos->count(); }) }}</h3>
                    <p class="mb-0 text-info fw-medium">Total Toko</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-calendar text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning">{{ $kota->where('created_at', '>=', now()->subMonth())->count() }}</h3>
                    <p class="mb-0 text-warning fw-medium">Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Kota --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="kotaTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 30%">Nama Kota</th>
                            <th scope="col" style="width: 15%">Kode Kota</th>
                            <th scope="col" class="text-center" style="width: 10%">User</th>
                            <th scope="col" class="text-center" style="width: 10%">Toko</th>
                            <th scope="col" class="text-center" style="width: 15%">Dibuat</th>
                            <th scope="col" class="text-center" style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kota as $index => $item)
                        <tr>
                            <td class="text-center">{{ $kota->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-geo-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $item->nama_kota }}</h6>
                                        <small class="text-muted">ID: {{ Str::limit($item->id_kota, 8) }}...</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->kode_kota)
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="bi bi-tag me-1"></i>{{ $item->kode_kota }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->users->count() > 0)
                                <span class="badge bg-success">{{ $item->users->count() }}</span>
                                @else
                                <span class="badge bg-secondary">0</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->tokos->count() > 0)
                                <span class="badge bg-info">{{ $item->tokos->count() }}</span>
                                @else
                                <span class="badge bg-secondary">0</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="viewKota('{{ $item->id_kota }}')"
                                        title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.kota.edit', $item->id_kota) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="deleteKota('{{ $item->id_kota }}')"
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
                                    <i class="bi bi-geo-alt" style="font-size: 48px;"></i>
                                    <h5 class="mt-3">Belum ada data kota</h5>
                                    <p>Silakan tambah data kota terlebih dahulu</p>
                                    <a href="{{ route('admin.kota.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Kota
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($kota->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $kota->firstItem() }} - {{ $kota->lastItem() }} dari {{ $kota->total() }} data
                    </small>
                </div>
                <div>
                    {{ $kota->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Kota --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-geo-alt me-2"></i>Detail Kota</h5>
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
                    <p>Apakah Anda yakin ingin menghapus data kota ini?</p>
                    <p class="text-muted"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                    <div id="deleteWarning" class="alert alert-warning d-none">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Kota ini memiliki data terkait yang akan terpengaruh.
                    </div>
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
            const sortFilter = document.getElementById('sortFilter');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            sortFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        });

        // View Detail Kota - FIXED VERSION
        function viewKota(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const detailContent = document.getElementById('detailContent');

            // Show loading state
            detailContent.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat data kota...</p>
        </div>
    `;

            modal.show();

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.querySelector('input[name="_token"]')?.value;

            // AJAX call to get detail - FIXED
            fetch(`/admin/kota/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken && {
                            'X-CSRF-TOKEN': csrfToken
                        })
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.kota) {
                        const kota = data.kota;

                        detailContent.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>Informasi Kota
                        </h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted fw-medium" style="width: 40%">Nama Kota:</td>
                                <td class="fw-semibold text-dark">${kota.nama_kota || '-'}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Kode Kota:</td>
                                <td class="text-dark">${kota.kode_kota || '<span class="text-muted">Tidak ada</span>'}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">ID Kota:</td>
                                <td><small class="font-monospace text-secondary">${kota.id_kota || '-'}</small></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-bar-chart me-2"></i>Statistik
                        </h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted fw-medium" style="width: 40%">Jumlah User:</td>
                                <td>
                                    <span class="badge ${(kota.users_count || 0) > 0 ? 'bg-success' : 'bg-secondary'}">
                                        ${kota.users_count || 0}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Jumlah Toko:</td>
                                <td>
                                    <span class="badge ${(kota.tokos_count || 0) > 0 ? 'bg-info' : 'bg-secondary'}">
                                        ${kota.tokos_count || 0}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Dibuat:</td>
                                <td class="text-dark">${formatDate(kota.created_at)}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Diperbarui:</td>
                                <td class="text-dark">${formatDate(kota.updated_at)}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex gap-2 justify-content-end">
                    <a href="/admin/kota/${kota.id_kota}/edit" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit Kota
                    </a>
                    ${(kota.users_count || 0) > 0 ? `
                        <button class="btn btn-success btn-sm" onclick="viewRelatedUsers('${kota.id_kota}')">
                            <i class="bi bi-people me-1"></i>Lihat User (${kota.users_count})
                        </button>
                    ` : ''}
                    ${(kota.tokos_count || 0) > 0 ? `
                        <button class="btn btn-info btn-sm" onclick="viewRelatedTokos('${kota.id_kota}')">
                            <i class="bi bi-shop me-1"></i>Lihat Toko (${kota.tokos_count})
                        </button>
                    ` : ''}
                    <button class="btn btn-outline-danger btn-sm" onclick="modal.hide(); deleteKota('${kota.id_kota}')">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </div>
            `;
                    } else {
                        throw new Error(data.message || 'Data tidak valid');
                    }
                })
                .catch(error => {
                    console.error('Error fetching kota detail:', error);
                    detailContent.innerHTML = `
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-danger mb-2">Gagal Memuat Data</h5>
                <p class="text-muted mb-3">
                    ${error.message || 'Terjadi kesalahan saat mengambil detail kota'}
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-outline-primary btn-sm" onclick="viewKota('${id}')">
                        <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                    </button>
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>Tutup
                    </button>
                </div>
            </div>
        `;
                });
        }

        // Helper function to format date
        function formatDate(dateString) {
            if (!dateString) return '-';

            try {
                const date = new Date(dateString);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return date.toLocaleDateString('id-ID', options);
            } catch (error) {
                return dateString; // fallback to original string
            }
        }

        // Delete Kota
        function deleteKota(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            const deleteWarning = document.getElementById('deleteWarning');

            form.action = `/admin/kota/${id}`;

            // Get kota info first to show warning if has related data
            fetch(`/admin/kota/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && (data.kota.users_count > 0 || data.kota.tokos_count > 0)) {
                        deleteWarning.classList.remove('d-none');
                        deleteWarning.innerHTML = `
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Peringatan:</strong> Kota ini memiliki ${data.kota.users_count} user dan ${data.kota.tokos_count} toko yang terkait.
                        `;
                    } else {
                        deleteWarning.classList.add('d-none');
                    }
                })
                .catch(() => {
                    deleteWarning.classList.add('d-none');
                });

            modal.show();
        }

        // View related users
        function viewRelatedUsers(id) {
            window.open(`/admin/user?kota=${id}`, '_blank');
        }

        // View related tokos
        function viewRelatedTokos(id) {
            window.open(`/admin/toko?kota=${id}`, '_blank');
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

        .font-monospace {
            font-family: 'Courier New', monospace;
            font-size: 0.8em;
        }
    </style>
</x-layouts.admin>