<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
            <div class="bg-primary rounded-3 p-2 me-3">
                <i class="bi bi-heart-pulse text-white fs-4"></i>
            </div>
            <div>
                <h5 class="mb-0 text-primary fw-bold">ALKES SHOP</h5>
                <small class="text-muted">Toko Alat Kesehatan</small>
            </div>
        </a>

        <!-- Search Bar - Center -->
        <div class="flex-grow-1 mx-4 d-none d-lg-block" style="max-width: 600px;">
            <form action="{{ route('customer.search') }}" method="GET" class="position-relative">
                <div class="input-group input-group-lg">
                    <input type="text" 
                           class="form-control border-primary" 
                           name="q" 
                           placeholder="Cari produk, kategori, atau toko..."
                           value="{{ request('q') }}"
                           style="border-top-right-radius: 0; border-bottom-right-radius: 0; padding-right: 50px;">
                    
                    <!-- Category Dropdown in Search -->
                    <div class="dropdown position-absolute" style="right: 50px; top: 0; bottom: 0; z-index: 10;">
                        <button class="btn btn-outline-primary dropdown-toggle h-100 border-0" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                style="border-radius: 0; padding: 0 15px;">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-category="">Semua Kategori</a></li>
                            @php
                                $categories = \App\Models\Kategori::orderBy('nama_kategori', 'asc')->get();
                            @endphp
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="#" data-category="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <input type="hidden" name="category" id="selectedCategory">
            </form>
        </div>

        <!-- Right Side Menu -->
        <div class="d-flex align-items-center gap-3">
            <!-- Mobile Search Toggle -->
            <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch">
                <i class="bi bi-search"></i>
            </button>

            <!-- Shopping Cart -->
            <div class="position-relative">
                <a href="{{ route('customer.keranjang.index') }}" class="btn btn-outline-primary position-relative">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">
                        @if(auth()->check() && auth()->user()->keranjang)
                            {{ auth()->user()->keranjang->items()->count() ?? 0 }}
                        @else
                            0
                        @endif
                    </span>
                </a>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2 px-3" 
                   href="#" 
                   role="button" 
                   data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        @if(auth()->user()->foto)
                            <img src="{{ asset('storage/users/' . auth()->user()->foto) }}" 
                                 class="rounded-circle" 
                                 width="32" 
                                 height="32" 
                                 alt="Profile">
                        @else
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 32px; height: 32px; font-size: 14px; font-weight: 600;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="ms-2 fw-semibold text-white d-none d-md-inline">
                            {{ Str::limit(auth()->user()->name, 15) }}
                        </span>
                    </div>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 280px;">
                    <!-- Profile Header -->
                    <li class="px-3 py-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            @if(auth()->user()->foto)
                                <img src="{{ asset('storage/users/' . auth()->user()->foto) }}" 
                                     class="rounded-circle" 
                                     width="48" 
                                     height="48" 
                                     alt="Profile">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px; font-size: 18px; font-weight: 600;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Items -->
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('customer.dashboard') }}">
                        <i class="bi bi-speedometer2 text-primary"></i> Dashboard
                    </a></li>
                    
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('customer.profil.show') }}">
                        <i class="bi bi-person text-primary"></i> Profil Saya
                    </a></li>
                    
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('customer.pesanan.index') }}">
                        <i class="bi bi-bag-check text-primary"></i> Pesanan Saya
                    </a></li>
                    
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('customer.profil.addresses') }}">
                        <i class="bi bi-geo-alt text-primary"></i> Alamat Saya
                    </a></li>
                    
                    <li><hr class="dropdown-divider"></li>
                    
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('site.contact') }}">
                        <i class="bi bi-headset text-primary"></i> Bantuan
                    </a></li>
                    
                    <li><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="#">
                        <i class="bi bi-gear text-primary"></i> Pengaturan
                    </a></li>
                    
                    <!-- Logout -->
                    <li class="px-3 pt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Search Bar -->
    <div class="collapse navbar-collapse d-lg-none" id="mobileSearch">
        <div class="container-fluid px-4 py-3">
            <form action="{{ route('customer.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           class="form-control" 
                           name="q" 
                           placeholder="Cari produk..."
                           value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>

<!-- Quick Navigation Bar -->
<div class="bg-light border-bottom py-2">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}" class="text-primary">Beranda</a></li>
                        @if(request()->routeIs('customer.produk.*'))
                            <li class="breadcrumb-item active">Produk</li>
                        @elseif(request()->routeIs('customer.keranjang.*'))
                            <li class="breadcrumb-item active">Keranjang</li>
                        @elseif(request()->routeIs('customer.pesanan.*'))
                            <li class="breadcrumb-item active">Pesanan</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('customer.produk.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-grid"></i> Semua Produk
                    </a>
                    <a href="{{ route('customer.toko.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-shop"></i> Toko
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar-brand:hover {
        transform: translateY(-2px);
        transition: transform 0.3s ease;
    }
    
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--bs-primary);
    }
    
    .input-group-lg .form-control {
        font-size: 1rem;
    }
    
    .badge {
        font-size: 0.6rem;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    // Category filter in search
    document.querySelectorAll('[data-category]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('selectedCategory').value = this.dataset.category;
            this.closest('form').submit();
        });
    });
</script>