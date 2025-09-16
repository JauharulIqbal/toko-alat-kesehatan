<x-layouts.admin title="Data Pengguna">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Pengguna</h2>
            <p class="text-muted mb-0">Kelola data penjual dan customer</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengguna.export-pdf') }}" class="btn btn-outline-success" target="_blank">
                <i class="bi bi-file-pdf me-2"></i>Export PDF
            </a>
            <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
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
            <form method="GET" action="{{ route('admin.pengguna.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama atau email..." id="searchInput">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="role" id="roleFilter">
                            <option value="">Semua Role</option>
                            <option value="penjual" {{ request('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="gender" id="genderFilter">
                            <option value="">Semua Gender</option>
                            <option value="laki-laki" {{ request('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ request('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary flex-fill">
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
                    <i class="bi bi-person-gear text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $pengguna->where('role', 'penjual')->count() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Penjual</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-person-check text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $pengguna->where('role', 'customer')->count() }}</h3>
                    <p class="mb-0 text-success fw-medium">Customer</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-info">{{ $pengguna->whereNotNull('email_verified_at')->count() }}</h3>
                    <p class="mb-0 text-info fw-medium">Terverifikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary bg-opacity-10 border-secondary">
                <div class="card-body text-center">
                    <i class="bi bi-people text-secondary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-secondary">{{ $pengguna->total() }}</h3>
                    <p class="mb-0 text-secondary fw-medium">Total Pengguna</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Pengguna --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="penggunaTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 20%">Nama</th>
                            <th scope="col" style="width: 20%">Email</th>
                            <th scope="col" style="width: 15%">Kontak</th>
                            <th scope="col" class="text-center" style="width: 10%">Role</th>
                            <th scope="col" class="text-center" style="width: 10%">Gender</th>
                            <th scope="col" style="width: 10%">Kota</th>
                            <th scope="col" class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna as $index => $item)
                            <tr>
                                <td class="text-center">{{ $pengguna->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $roleColor = $item->role === 'penjual' ? 'primary' : 'success';
                                            $genderIcon = $item->gender === 'laki-laki' ? 'person' : 'person-hearts';
                                        @endphp
                                        <div class="bg-{{ $roleColor }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-{{ $genderIcon }} text-{{ $roleColor }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $item->name }}</h6>
                                            @if($item->date_of_birth)
                                                <small class="text-muted">{{ $item->date_of_birth->format('d M Y') }}</small>
                                            @endif
                                            @if($item->email_verified_at)
                                                <i class="bi bi-patch-check-fill text-success ms-1" title="Email Terverifikasi"></i>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $item->email }}</div>
                                    @if($item->email_verified_at)
                                        <small class="text-success">
                                            <i class="bi bi-check-circle me-1"></i>Terverifikasi
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="bi bi-clock me-1"></i>Belum verifikasi
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->kontak)
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-telephone text-info me-2"></i>
                                            <span>{{ $item->kontak }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $roleClass = $item->role === 'penjual' ? 'bg-primary' : 'bg-success';
                                        $roleText = ucfirst($item->role);
                                    @endphp
                                    <span class="badge {{ $roleClass }}">{{ $roleText }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $genderClass = $item->gender === 'laki-laki' ? 'bg-info' : 'bg-warning';
                                        $genderIcon = $item->gender === 'laki-laki' ? 'gender-male' : 'gender-female';
                                        $genderText = $item->gender === 'laki-laki' ? 'L' : 'P';
                                    @endphp
                                    <span class="badge {{ $genderClass }} bg-opacity-20 text-dark" title="{{ ucfirst($item->gender) }}">
                                        <i class="bi bi-{{ $genderIcon }} me-1"></i>{{ $genderText }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->kota)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $item->kota->nama_kota }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewPengguna('{{ $item->id_user }}')" 
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.pengguna.edit', $item->id_user) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deletePengguna('{{ $item->id_user }}')" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Belum ada data pengguna</h5>
                                        <p>Silakan tambah data pengguna terlebih dahulu</p>
                                        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pengguna->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $pengguna->firstItem() }} - {{ $pengguna->lastItem() }} dari {{ $pengguna->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $pengguna->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Pengguna --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person me-2"></i>Detail Pengguna</h5>
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
                    <p>Apakah Anda yakin ingin menghapus data pengguna ini?</p>
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
            const roleFilter = document.getElementById('roleFilter');
            const genderFilter = document.getElementById('genderFilter');
            const kotaFilter = document.getElementById('kotaFilter');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            roleFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            genderFilter.addEventListener('change', function() {
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

        // View Detail Pengguna
        function viewPengguna(id) {
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
            fetch(`/admin/pengguna/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const pengguna = data.pengguna;
                        const roleClass = pengguna.role === 'penjual' ? 'primary' : 'success';
                        const genderClass = pengguna.gender === 'laki-laki' ? 'info' : 'warning';
                        const genderIcon = pengguna.gender === 'laki-laki' ? 'gender-male' : 'gender-female';
                        
                        detailContent.innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Informasi Pribadi</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Nama Lengkap:</td>
                                            <td class="fw-semibold">${pengguna.name}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Email:</td>
                                            <td>${pengguna.email} ${pengguna.email_verified_at ? '<i class="bi bi-patch-check-fill text-success" title="Terverifikasi"></i>' : '<i class="bi bi-clock text-warning" title="Belum verifikasi"></i>'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Role:</td>
                                            <td><span class="badge bg-${roleClass}">${pengguna.role.charAt(0).toUpperCase() + pengguna.role.slice(1)}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Gender:</td>
                                            <td><span class="badge bg-${genderClass} bg-opacity-20 text-dark"><i class="bi bi-${genderIcon} me-1"></i>${pengguna.gender.charAt(0).toUpperCase() + pengguna.gender.slice(1)}</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Informasi Kontak</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Kontak:</td>
                                            <td>${pengguna.kontak || '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kota:</td>
                                            <td>${pengguna.kota ? pengguna.kota.nama_kota : '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tgl Lahir:</td>
                                            <td>${pengguna.date_of_birth ? new Date(pengguna.date_of_birth).toLocaleDateString('id-ID') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Terdaftar:</td>
                                            <td>${new Date(pengguna.created_at).toLocaleDateString('id-ID')}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${pengguna.alamat ? `
                            <div class="mt-3">
                                <h6 class="text-muted mb-2">Alamat Lengkap</h6>
                                <p class="text-muted">${pengguna.alamat}</p>
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
                            <p class="text-muted">Gagal memuat detail pengguna</p>
                        </div>
                    `;
                });
        }

        // Delete Pengguna
        function deletePengguna(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `/admin/pengguna/${id}`;
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