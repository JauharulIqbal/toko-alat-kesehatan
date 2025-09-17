<x-layouts.customer title="Profil Saya - ALKES SHOP">
    <div class="container-fluid px-4 py-4">
        <!-- Profile Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient bg-primary text-white">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($user->foto)
                                <img src="{{ asset('storage/users/' . $user->foto) }}" 
                                     class="rounded-circle border border-white border-3" 
                                     width="100" height="100" alt="Profile Photo">
                                @else
                                <div class="bg-white text-primary rounded-circle border border-white border-3 d-flex align-items-center justify-content-center"
                                     style="width: 100px; height: 100px; font-size: 2rem; font-weight: bold;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                @endif
                            </div>
                            <div class="col">
                                <h1 class="display-6 fw-bold mb-2">{{ $user->name }}</h1>
                                <p class="lead mb-1 opacity-90">{{ $user->email }}</p>
                                <small class="opacity-75">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Bergabung {{ $user->created_at->format('d F Y') }}
                                </small>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('customer.profil.edit') }}" class="btn btn-warning btn-lg">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>Informasi Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">NAMA LENGKAP</label>
                                <p class="fw-bold mb-0">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">EMAIL</label>
                                <p class="fw-bold mb-0">
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                    <i class="bi bi-patch-check-fill text-success ms-2" title="Email Terverifikasi"></i>
                                    @else
                                    <i class="bi bi-exclamation-triangle-fill text-warning ms-2" title="Email Belum Terverifikasi"></i>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">NOMOR HP</label>
                                <p class="fw-bold mb-0">{{ $user->no_hp ?: '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">STATUS AKUN</label>
                                <p class="mb-0">
                                    <span class="badge bg-success fs-6">{{ ucfirst($user->role) }}</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-semibold">ALAMAT</label>
                                <p class="fw-bold mb-0">{{ $user->alamat ?: 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Activity -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-activity me-2"></i>Aktivitas Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-4">
                            <div class="col-md-3">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2">
                                    <i class="bi bi-bag-check fs-2 text-primary"></i>
                                </div>
                                <h4 class="fw-bold text-primary mb-1">0</h4>
                                <small class="text-muted">Total Pesanan</small>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-2">
                                    <i class="bi bi-check-circle fs-2 text-success"></i>
                                </div>
                                <h4 class="fw-bold text-success mb-1">0</h4>
                                <small class="text-muted">Pesanan Selesai</small>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3 mb-2">
                                    <i class="bi bi-cart3 fs-2 text-info"></i>
                                </div>
                                <h4 class="fw-bold text-info mb-1">
                                    {{ auth()->user()->keranjang ? auth()->user()->keranjang->items->count() : 0 }}
                                </h4>
                                <small class="text-muted">Item di Keranjang</small>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-2">
                                    <i class="bi bi-heart fs-2 text-warning"></i>
                                </div>
                                <h4 class="fw-bold text-warning mb-1">0</h4>
                                <small class="text-muted">Wishlist</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.pesanan.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-bag-check me-2"></i>Lihat Pesanan
                            </a>
                            <a href="{{ route('customer.keranjang.index') }}" class="btn btn-outline-info">
                                <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
                            </a>
                            <a href="{{ route('customer.profil.addresses') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-geo-alt me-2"></i>Kelola Alamat
                            </a>
                            <a href="{{ route('site.contact') }}" class="btn btn-outline-warning">
                                <i class="bi bi-headset me-2"></i>Hubungi Support
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>Keamanan Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-lock-fill text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Password</h6>
                                <small class="text-muted">Terakhir diubah: -</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-{{ $user->email_verified_at ? 'success' : 'warning' }} bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-envelope-{{ $user->email_verified_at ? 'check' : 'exclamation' }}-fill text-{{ $user->email_verified_at ? 'success' : 'warning' }}"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email Verification</h6>
                                <small class="text-muted">
                                    {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi' }}
                                </small>
                            </div>
                        </div>

                        <a href="{{ route('customer.profil.edit') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-gear me-1"></i>Pengaturan Keamanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .bg-opacity-10 {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .bg-success.bg-opacity-10 {
            background-color: rgba(var(--bs-success-rgb), 0.1) !important;
        }

        .bg-info.bg-opacity-10 {
            background-color: rgba(var(--bs-info-rgb), 0.1) !important;
        }

        .bg-warning.bg-opacity-10 {
            background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
        }
    </style>
    @endpush
</x-layouts.customer>