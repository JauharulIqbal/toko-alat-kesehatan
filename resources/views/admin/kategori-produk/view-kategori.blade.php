<x-layouts.admin title="Data Kategori Produk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Data Kategori Produk</h2>
            <p class="text-muted mb-0">Kelola kategori produk alat kesehatan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kategori-produk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
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
            <form method="GET" action="{{ route('admin.kategori-produk.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama kategori..." id="searchInput">
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Cari
                            </button>
                            <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </a>
                            <button type="button" class="btn btn-outline-danger" onclick="toggleBulkActions()">
                                <i class="bi bi-check2-square me-2"></i>Pilih
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Bulk Actions --}}
            <div id="bulkActionsRow" class="row mt-3" style="display: none;">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body py-3">
                            <form id="bulkForm" method="POST" action="{{ route('admin.kategori-produk.bulk-action') }}">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <span class="text-muted">
                                            <span id="selectedCount">0</span> kategori dipilih
                                        </span>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <select name="action" class="form-select form-select-sm" style="width: auto;">
                                                <option value="">Pilih Aksi</option>
                                                <option value="delete">Hapus yang Dipilih</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmBulkAction()">
                                                <i class="bi bi-check-circle me-1"></i>Jalankan
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="toggleBulkActions()">
                                                <i class="bi bi-x-circle me-1"></i>Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-tags text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $kategori->total() }}</h3>
                    <p class="mb-0 text-primary fw-medium">Total Kategori</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $kategori->where('produk_count', '>', 0)->count() }}</h3>
                    <p class="mb-0 text-success fw-medium">Ada Produk</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-inbox text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-warning">{{ $kategori->where('produk_count', 0)->count() }}</h3>
                    <p class="mb-0 text-warning fw-medium">Kosong</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-plus text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2 mb-1 text-info">{{ $kategori->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                    <p class="mb-0 text-info fw-medium">Terbaru (7 Hari)</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Kategori --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="kategoriTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">
                                <input type="checkbox" id="selectAll" class="form-check-input bulk-checkbox" style="display: none;">
                                <span class="row-number">No</span>
                            </th>
                            <th scope="col" style="width: 40%">Nama Kategori</th>
                            <th scope="col" class="text-center" style="width: 15%">Jumlah Produk</th>
                            <th scope="col" class="text-center" style="width: 20%">Dibuat</th>
                            <th scope="col" class="text-center" style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="kategori_ids[]" value="{{ $item->id_kategori }}"
                                    class="form-check-input item-checkbox bulk-checkbox" style="display: none;"
                                    form="bulkForm">
                                <span class="row-number">{{ $kategori->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-tag text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $item->nama_kategori }}</h6>
                                        <small class="text-muted">ID: {{ Str::limit($item->id_kategori, 8) }}...</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                $produkCount = $item->produk_count ?? 0;
                                @endphp
                                @if($produkCount > 0)
                                <span class="badge bg-success">
                                    <i class="bi bi-box-seam me-1"></i>{{ $produkCount }} Produk
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-inbox me-1"></i>Kosong
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <small class="text-muted">
                                    {{ $item->created_at->format('d M Y') }}<br>
                                    {{ $item->created_at->format('H:i') }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="viewKategori('{{ $item->id_kategori }}')"
                                        title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.kategori-produk.edit', $item->id_kategori) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="deleteKategori('{{ $item->id_kategori }}')"
                                        title="Hapus"
                                        @if($produkCount> 0) disabled @endif>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-tags" style="font-size: 48px;"></i>
                                    <h5 class="mt-3">Belum ada data kategori</h5>
                                    <p>Silakan tambah kategori produk terlebih dahulu</p>
                                    <a href="{{ route('admin.kategori-produk.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($kategori->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $kategori->firstItem() }} - {{ $kategori->lastItem() }} dari {{ $kategori->total() }} data
                    </small>
                </div>
                <div>
                    {{ $kategori->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal Detail Kategori --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-tag me-2"></i>Detail Kategori</h5>
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
                    <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
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
        let isBulkMode = false;

        // Auto submit form on search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });

            // Auto hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Toggle bulk actions
        function toggleBulkActions() {
            isBulkMode = !isBulkMode;
            const bulkCheckboxes = document.querySelectorAll('.bulk-checkbox');
            const bulkActionsRow = document.getElementById('bulkActionsRow');
            const rowNumbers = document.querySelectorAll('.row-number');

            if (isBulkMode) {
                bulkCheckboxes.forEach(cb => cb.style.display = 'block');
                rowNumbers.forEach(rn => rn.style.display = 'none');
                bulkActionsRow.style.display = 'block';
            } else {
                bulkCheckboxes.forEach(cb => {
                    cb.style.display = 'none';
                    cb.checked = false;
                });
                rowNumbers.forEach(rn => rn.style.display = 'inline');
                bulkActionsRow.style.display = 'none';
                updateSelectedCount();
            }
        }

        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedCount();
        });

        // Update selected count
        function updateSelectedCount() {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked');
            document.getElementById('selectedCount').textContent = selectedItems.length;

            // Update select all checkbox
            const allItems = document.querySelectorAll('.item-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');
            selectAllCheckbox.checked = selectedItems.length === allItems.length;
            selectAllCheckbox.indeterminate = selectedItems.length > 0 && selectedItems.length < allItems.length;
        }

        // Add change listeners to item checkboxes
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });

        // Confirm bulk action
        function confirmBulkAction() {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (selectedCount === 0) {
                alert('Pilih minimal satu kategori terlebih dahulu.');
                return false;
            }

            const action = document.querySelector('select[name="action"]').value;
            if (!action) {
                alert('Pilih aksi yang akan dilakukan.');
                return false;
            }

            return confirm(`Yakin ingin ${action === 'delete' ? 'menghapus' : 'melakukan aksi pada'} ${selectedCount} kategori yang dipilih?`);
        }

        // View Detail Kategori
        function viewKategori(id) {
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
            fetch(`/admin/kategori-produk/${id}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const kategori = data.kategori;
                        const produkList = kategori.produk || [];

                        detailContent.innerHTML = `
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                            <i class="bi bi-tag text-primary" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 fw-bold">${kategori.nama_kategori}</h4>
                                            <span class="badge bg-success">Aktif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <h6 class="text-muted mb-2">ID Kategori</h6>
                                        <p class="mb-0 fw-semibold">${kategori.id_kategori}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="text-muted mb-2">Dibuat Pada</h6>
                                        <p class="mb-0">${new Date(kategori.created_at).toLocaleDateString('id-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        })}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="text-muted mb-2">Terakhir Update</h6>
                                        <p class="mb-0">${new Date(kategori.updated_at).toLocaleDateString('id-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        })}</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-semibold mb-3">Produk dalam Kategori (${produkList.length})</h6>
                                    ${produkList.length > 0 ? `
                                        <div class="list-group">
                                            ${produkList.map(produk => `
                                                <div class="list-group-item d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-box text-success" style="font-size: 14px;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">${produk.nama_produk || 'Nama Produk'}</h6>
                                                        <small class="text-muted">Kode: ${produk.kode_produk || '-'}</small>
                                                    </div>
                                                    <div>
                                                        <span class="badge bg-primary">${produk.status || 'Aktif'}</span>
                                                    </div>
                                                </div>
                                            `).join('')}
                                        </div>
                                    ` : `
                                        <div class="text-center py-4">
                                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                            <h6 class="mt-2 text-muted">Belum ada produk dalam kategori ini</h6>
                                        </div>
                                    `}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-semibold mb-3">Statistik</h6>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">Total Produk:</span>
                                                <span class="fw-semibold">${produkList.length}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">Status:</span>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">Dapat Dihapus:</span>
                                                <span class="badge ${produkList.length === 0 ? 'bg-success' : 'bg-danger'}">
                                                    ${produkList.length === 0 ? 'Ya' : 'Tidak'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <a href="/admin/kategori-produk/${kategori.id_kategori}/edit" class="btn btn-warning">
                                        <i class="bi bi-pencil me-2"></i>Edit Kategori
                                    </a>
                                    ${produkList.length === 0 ? `
                                        <button type="button" class="btn btn-danger" onclick="deleteKategoriFromModal('${kategori.id_kategori}')">
                                            <i class="bi bi-trash me-2"></i>Hapus Kategori
                                        </button>
                                    ` : `
                                        <button type="button" class="btn btn-outline-danger" disabled>
                                            <i class="bi bi-trash me-2"></i>Tidak Dapat Dihapus
                                        </button>
                                    `}
                                </div>
                            </div>
                        </div>
                    `;
                    } else {
                        detailContent.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Gagal memuat data</h5>
                            <p class="text-muted">Terjadi kesalahan saat mengambil data kategori.</p>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    detailContent.innerHTML = `
                    <div class="text-center py-4">
                        <i class="bi bi-wifi-off text-danger" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Koneksi Bermasalah</h5>
                        <p class="text-muted">Periksa koneksi internet Anda dan coba lagi.</p>
                    </div>
                `;
                });
        }

        // Delete kategori
        function deleteKategori(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/kategori-produk/${id}`;
            modal.show();
        }

        // Delete kategori from detail modal
        function deleteKategoriFromModal(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                // Close detail modal first
                const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
                detailModal.hide();

                // Then show delete confirmation
                setTimeout(() => {
                    deleteKategori(id);
                }, 300);
            }
        }
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