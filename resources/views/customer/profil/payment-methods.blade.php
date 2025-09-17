<x-layouts.customer title="Metode Pembayaran - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold text-primary mb-1">Metode Pembayaran</h1>
                        <p class="text-muted mb-0">Kelola metode pembayaran dan nomor rekening Anda</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Metode
                        </button>
                        <a href="{{ route('customer.profil.show') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods List -->
        <div class="row g-4">
            @forelse($userPaymentMethods as $paymentMethod)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-credit-card text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $paymentMethod->metodePembayaran->metode_pembayaran }}</h6>
                                    <span class="badge bg-{{ $paymentMethod->metodePembayaran->tipe_pembayaran === 'prepaid' ? 'primary' : 'success' }}">
                                        {{ strtoupper($paymentMethod->metodePembayaran->tipe_pembayaran) }}
                                    </span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item edit-payment-method" href="#" 
                                           data-id="{{ $paymentMethod->id_nrp }}"
                                           data-account="{{ $paymentMethod->nomor_rekening }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-payment-method" href="#"
                                           data-id="{{ $paymentMethod->id_nrp }}">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="bg-light rounded-3 p-3 mb-3">
                            <label class="form-label text-muted small fw-semibold mb-1">NOMOR REKENING/AKUN</label>
                            <div class="d-flex align-items-center">
                                <code class="bg-white px-2 py-1 rounded border flex-grow-1 text-center">
                                    {{ $paymentMethod->nomor_rekening }}
                                </code>
                                <button class="btn btn-sm btn-outline-secondary ms-2 copy-account" 
                                        data-account="{{ $paymentMethod->nomor_rekening }}"
                                        title="Copy nomor rekening">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>
                            Ditambahkan {{ $paymentMethod->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-credit-card text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-muted mb-3">Belum Ada Metode Pembayaran</h5>
                        <p class="text-muted mb-4">Tambahkan metode pembayaran untuk memudahkan proses checkout</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Metode Pembayaran
                        </button>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Available Payment Methods Info -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Metode Pembayaran yang Tersedia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($metodePembayaran as $metode)
                            <div class="col-md-6 col-lg-4">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <div class="bg-{{ $metode->tipe_pembayaran === 'prepaid' ? 'primary' : 'success' }} bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-credit-card text-{{ $metode->tipe_pembayaran === 'prepaid' ? 'primary' : 'success' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $metode->metode_pembayaran }}</h6>
                                        <small class="text-muted">
                                            {{ $metode->tipe_pembayaran === 'prepaid' ? 'Transfer/E-Money' : 'Bayar di Tempat' }}
                                        </small>
                                    </div>
                                    @if($userPaymentMethods->where('id_metode_pembayaran', $metode->id_metode_pembayaran)->isEmpty())
                                    <button class="btn btn-outline-primary btn-sm add-specific-method" 
                                            data-id="{{ $metode->id_metode_pembayaran }}"
                                            data-name="{{ $metode->metode_pembayaran }}"
                                            data-type="{{ $metode->tipe_pembayaran }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    @else
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Method Modal -->
    <div class="modal fade" id="addPaymentMethodModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPaymentMethodForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_metode_pembayaran" class="form-label fw-semibold">
                                Pilih Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="id_metode_pembayaran" name="id_metode_pembayaran" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                @foreach($metodePembayaran as $metode)
                                    @if($userPaymentMethods->where('id_metode_pembayaran', $metode->id_metode_pembayaran)->isEmpty())
                                    <option value="{{ $metode->id_metode_pembayaran }}" data-type="{{ $metode->tipe_pembayaran }}">
                                        {{ $metode->metode_pembayaran }} ({{ strtoupper($metode->tipe_pembayaran) }})
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3" id="accountNumberField">
                            <label for="nomor_rekening" class="form-label fw-semibold">
                                <span id="accountLabel">Nomor Rekening</span> <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" 
                                   placeholder="Masukkan nomor rekening" required>
                            <small class="text-muted" id="accountHelp">
                                Masukkan nomor rekening atau ID akun yang valid
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Metode
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Payment Method Modal -->
    <div class="modal fade" id="editPaymentMethodModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Nomor Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPaymentMethodForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_payment_id" name="payment_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nomor_rekening" class="form-label fw-semibold">
                                Nomor Rekening <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_nomor_rekening" name="nomor_rekening" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Update account label based on payment method selection
            $('#id_metode_pembayaran').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const methodType = selectedOption.data('type');
                const methodName = selectedOption.text().split(' (')[0];

                if (methodType === 'prepaid') {
                    $('#accountLabel').text('Nomor Rekening/ID Akun');
                    $('#accountHelp').text('Masukkan nomor rekening bank atau ID akun e-money');
                    $('#nomor_rekening').attr('placeholder', 'Contoh: 1234567890 atau 081234567890');
                } else {
                    $('#accountLabel').text('Nomor Telepon');
                    $('#accountHelp').text('Nomor telepon untuk koordinasi COD');
                    $('#nomor_rekening').attr('placeholder', 'Contoh: 081234567890');
                }
            });

            // Add specific method
            $('.add-specific-method').on('click', function() {
                const methodId = $(this).data('id');
                const methodName = $(this).data('name');
                const methodType = $(this).data('type');

                $('#id_metode_pembayaran').val(methodId).trigger('change');
                $('#addPaymentMethodModal').modal('show');
            });

            // Add payment method form
            $('#addPaymentMethodForm').on('submit', function(e) {
                e.preventDefault();

                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: '{{ route("customer.profil.payment-methods.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#addPaymentMethodModal').modal('hide');
                            showToast(response.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showToast(message, 'error');
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Edit payment method
            $('.edit-payment-method').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const account = $(this).data('account');

                $('#edit_payment_id').val(id);
                $('#edit_nomor_rekening').val(account);
                $('#editPaymentMethodModal').modal('show');
            });

            // Edit payment method form
            $('#editPaymentMethodForm').on('submit', function(e) {
                e.preventDefault();

                const id = $('#edit_payment_id').val();
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: `{{ route("customer.profil.payment-methods.update", "") }}/${id}`,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editPaymentMethodModal').modal('hide');
                            showToast(response.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showToast(message, 'error');
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Delete payment method
            $('.delete-payment-method').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                if (confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?')) {
                    $.ajax({
                        url: `{{ route("customer.profil.payment-methods.destroy", "") }}/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showToast(response.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                showToast(response.message, 'error');
                            }
                        },
                        error: function() {
                            showToast('Terjadi kesalahan saat menghapus', 'error');
                        }
                    });
                }
            });

            // Copy account number
            $('.copy-account').on('click', function() {
                const account = $(this).data('account');
                navigator.clipboard.writeText(account).then(function() {
                    showToast('Nomor rekening berhasil disalin', 'success');
                });
            });

            function showToast(message, type = 'info') {
                if (!$('#toastContainer').length) {
                    $('body').append('<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
                }

                const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
                const toast = $(`
                    <div class="toast ${bgClass} text-white" role="alert">
                        <div class="toast-body">
                            ${message}
                            <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `);

                $('#toastContainer').append(toast);
                const bsToast = new bootstrap.Toast(toast[0], { autohide: true, delay: 3000 });
                bsToast.show();

                toast[0].addEventListener('hidden.bs.toast', () => toast.remove());
            }
        });
    </script>
    @endpush
</x-layouts.customer>