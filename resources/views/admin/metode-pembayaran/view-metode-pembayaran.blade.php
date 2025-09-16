<x-layouts.admin title="Data Metode Pembayaran">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Metode Pembayaran</h2>
            <p class="text-muted mb-0">Kelola metode pembayaran yang tersedia</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-success" onclick="exportData()">
                <i class="bi bi-file-excel me-2"></i>Export Excel
            </button>
            <a href="{{ route('admin.metode-pembayaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Metode
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
            <form method="GET" action="{{ route('admin.metode-pembayaran.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                               placeholder="Cari metode pembayaran..." id="searchInput">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipe" id="tipeFilter">
                            <option value="">Semua Tipe</option>
                            <option value="prepaid" {{ request('tipe') == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                            <option value="postpaid" {{ request('tipe') == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.metode-pembayaran.index') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger flex-fill" id="bulkDeleteBtn" disabled>
                                <i class="bi bi-trash"></i>
                            </button>
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
                    <i class="bi bi-credit-card text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $metodePembayaran->total() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Metode Pembayaran</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-up-circle text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">
                        {{ $metodePembayaran->where('tipe_pembayaran', 'prepaid')->count() }}
                    </h3>
                    <p class="mb-0 text-success fw-medium">Prepaid</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-down-circle text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-info">
                        {{ $metodePembayaran->where('tipe_pembayaran', 'postpaid')->count() }}
                    </h3>
                    <p class="mb-0 text-info fw-medium">Postpaid</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning" id="usedCount">-</h3>
                    <p class="mb-0 text-warning fw-medium">Digunakan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Metode Pembayaran --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="metodePembayaranTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 40%">Metode Pembayaran</th>
                            <th scope="col" class="text-center" style="width: 15%">Tipe</th>
                            <th scope="col" class="text-center" style="width: 15%">Status</th>
                            <th scope="col" class="text-center" style="width: 10%">Dibuat</th>
                            <th scope="col" class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($metodePembayaran as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" 
                                               value="{{ $item->id_metode_pembayaran }}" 
                                               id="check_{{ $item->id_metode_pembayaran }}">
                                    </div>
                                </td>
                                <td class="text-center">{{ $metodePembayaran->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-credit-card text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $item->metode_pembayaran }}</h6>
                                            <small class="text-muted">ID: {{ Str::limit($item->id_metode_pembayaran, 13) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $tipeClass = $item->tipe_pembayaran === 'prepaid' ? 'bg-success' : 'bg-info';
                                        $tipeIcon = $item->tipe_pembayaran === 'prepaid' ? 'arrow-up-circle' : 'arrow-down-circle';
                                    @endphp
                                    <span class="badge {{ $tipeClass }} bg-opacity-10 text-{{ $item->tipe_pembayaran === 'prepaid' ? 'success' : 'info' }}">
                                        <i class="bi bi-{{ $tipeIcon }} me-1"></i>{{ ucfirst($item->tipe_pembayaran) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($item->pembayarans()->exists())
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-circle me-1"></i>Belum Digunakan
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewMetodePembayaran('{{ $item->id_metode_pembayaran }}')" 
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.metode-pembayaran.edit', $item->id_metode_pembayaran) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteMetodePembayaran('{{ $item->id_metode_pembayaran }}')" 
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
                                        <i class="bi bi-credit-card" style="font-size: 48px;"></i>
                                        <h5 class="mt-3">Belum ada data metode pembayaran</h5>
                                        <p>Silakan tambah metode pembayaran terlebih dahulu</p>
                                        <a href="{{ route('admin.metode-pembayaran.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Tambah Metode Pembayaran
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($metodePembayaran->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $metodePembayaran->firstItem() }} - {{ $metodePembayaran->lastItem() }} dari {{ $metodePembayaran->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $metodePembayaran->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Metode Pembayaran --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-credit-card me-2"></i>Detail Metode Pembayaran</h5>
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
                    <p>Apakah Anda yakin ingin menghapus metode pembayaran ini?</p>
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

    {{-- Modal Bulk Delete --}}
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Multiple</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <strong><span id="selectedCount">0</span></strong> metode pembayaran yang dipilih?</p>
                    <p class="text-muted"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmBulkDelete">
                        <i class="bi bi-trash me-2"></i>Hapus Semua
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const tipeFilter = document.getElementById('tipeFilter');
            const searchInput = document.getElementById('searchInput');
            const selectAll = document.getElementById('selectAll');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            let searchTimeout;

            // Load statistics
            loadStatistics();

            tipeFilter.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });

            // Handle select all checkbox
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });

            // Handle individual checkboxes
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('row-checkbox')) {
                    updateBulkDeleteButton();
                    
                    // Update select all checkbox
                    const allCheckboxes = document.querySelectorAll('.row-checkbox');
                    const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                    selectAll.checked = allCheckboxes.length === checkedCheckboxes.length;
                    selectAll.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
                }
            });

            // Bulk delete button click
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {
                    document.getElementById('selectedCount').textContent = selectedIds.length;
                    const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
                    modal.show();
                }
            });

            // Confirm bulk delete
            document.getElementById('confirmBulkDelete').addEventListener('click', function() {
                const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {
                    bulkDelete(selectedIds);
                }
            });
        });

        function updateBulkDeleteButton() {
            const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            
            if (checkedCheckboxes.length > 0) {
                bulkDeleteBtn.disabled = false;
                bulkDeleteBtn.innerHTML = `<i class="bi bi-trash"></i> (${checkedCheckboxes.length})`;
            } else {
                bulkDeleteBtn.disabled = true;
                bulkDeleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
            }
        }

        function getSelectedIds() {
            const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
            return Array.from(checkedCheckboxes).map(cb => cb.value);
        }

        // Load statistics
        function loadStatistics() {
            fetch('{{ route("admin.metode-pembayaran.statistics") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('usedCount').textContent = data.stats.used;
                    }
                })
                .catch(error => console.error('Error loading statistics:', error));
        }

        // View Detail Metode Pembayaran
        function viewMetodePembayaran(id) {
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
            fetch(`{{ route('admin.metode-pembayaran.index') }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const metodePembayaran = data.metodePembayaran;
                        const tipeClass = metodePembayaran.tipe_pembayaran === 'prepaid' ? 'success' : 'info';
                        const tipeIcon = metodePembayaran.tipe_pembayaran === 'prepaid' ? 'arrow-up-circle' : 'arrow-down-circle';
                        
                        detailContent.innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Informasi Metode Pembayaran</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">ID:</td>
                                            <td class="fw-medium">${metodePembayaran.id_metode_pembayaran}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Nama:</td>
                                            <td class="fw-semibold">${metodePembayaran.metode_pembayaran}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tipe:</td>
                                            <td>
                                                <span class="badge bg-${tipeClass}">
                                                    <i class="bi bi-${tipeIcon} me-1"></i>
                                                    ${metodePembayaran.tipe_pembayaran.charAt(0).toUpperCase() + metodePembayaran.tipe_pembayaran.slice(1)}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td>
                                                ${metodePembayaran.pembayarans && metodePembayaran.pembayarans.length > 0 ? 
                                                    '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif Digunakan</span>' : 
                                                    '<span class="badge bg-secondary"><i class="bi bi-circle me-1"></i>Belum Digunakan</span>'
                                                }
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Detail Lainnya</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted" style="width: 40%">Dibuat:</td>
                                            <td>${new Date(metodePembayaran.created_at).toLocaleDateString('id-ID', {
                                                year: 'numeric', month: 'long', day: 'numeric'
                                            })}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Diperbarui:</td>
                                            <td>${new Date(metodePembayaran.updated_at).toLocaleDateString('id-ID', {
                                                year: 'numeric', month: 'long', day: 'numeric'
                                            })}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Total Penggunaan:</td>
                                            <td class="fw-semibold text-primary">
                                                ${metodePembayaran.pembayarans ? metodePembayaran.pembayarans.length : 0} transaksi
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${metodePembayaran.pembayarans && metodePembayaran.pembayarans.length > 0 ? `
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="text-muted mb-3">Riwayat Penggunaan (${metodePembayaran.pembayarans.length} transaksi terakhir)</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>ID Pembayaran</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${metodePembayaran.pembayarans.slice(0, 5).map(pembayaran => `
                                                <tr>
                                                    <td class="text-muted small">${new Date(pembayaran.created_at).toLocaleDateString('id-ID')}</td>
                                                    <td class="small">${pembayaran.id_pembayaran}</td>
                                                    <td><span class="badge bg-info small">Digunakan</span></td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
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
                            <p class="text-muted">Gagal memuat detail metode pembayaran</p>
                        </div>
                    `;
                });
        }

        // Delete Metode Pembayaran
        function deleteMetodePembayaran(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('admin.metode-pembayaran.index') }}/${id}`;
            modal.show();
        }

        // Bulk delete function
        function bulkDelete(ids) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('bulkDeleteModal'));
            
            fetch('{{ route("admin.metode-pembayaran.bulk-action") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    action: 'delete',
                    ids: ids
                })
            })
            .then(response => response.json())
            .then(data => {
                modal.hide();
                
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message);
                    // Reload page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                modal.hide();
                showAlert('danger', 'Terjadi kesalahan saat menghapus data');
                console.error('Error:', error);
            });
        }

        // Export data function
        function exportData() {
            // You can implement export functionality here
            showAlert('info', 'Fitur export sedang dalam pengembangan');
        }

        // Show alert function
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container-fluid');
            const firstCard = container.querySelector('.card');
            container.insertBefore(alertDiv, firstCard);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);
        }

        // Auto hide existing alerts
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

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-input:indeterminate {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</x-layouts.admin>