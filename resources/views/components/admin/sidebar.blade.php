<aside class="bg-white border-end h-100 shadow-sm" id="sidebar" style="width: 250px;">
    <div class="sidebar-header text-center py-4">
        <h5 class="mb-0 fw-bold text-dark">Toko Alkes</h5>
    </div>

    <ul class="nav flex-column px-3 py-4">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/dashboard*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <span class="fw-semibold">Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.toko.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/toko*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-shop"></i>
                </div>
                <span class="fw-semibold">Toko</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.kategori-produk.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/kategori-produk*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-tags"></i>
                </div>
                <span class="fw-semibold">Kategori Produk</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.produk.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/produk*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-box-seam"></i>
                </div>
                <span class="fw-semibold">Produk</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.metode-pembayaran.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/metode-pembayaran*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-credit-card"></i>
                </div>
                <span class="fw-semibold">Metode Pembayaran</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="#"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/transaksi*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-credit-card"></i>
                </div>
                <span class="fw-semibold">Transaksi</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.jasa-pengiriman.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/jasa-pengiriman*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-truck"></i>
                </div>
                <span class="fw-semibold">Jasa Pengiriman</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.pengguna.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/pengguna*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-people"></i>
                </div>
                <span class="fw-semibold">Pengguna</span>
            </a>
        </li>
        
        <li class="nav-item mb-2">
            <a href="{{ route('admin.kota.index') }}"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/kota*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <span class="fw-semibold">Kota</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="#"
                class="nav-link d-flex align-items-center gap-3 px-3 py-2 {{ request()->is('admin/guestbook*') ? 'sidebar-active' : '' }}">
                <div class="icon-wrapper">
                    <i class="bi bi-journal-text"></i>
                </div>
                <span class="fw-semibold">Guest Book</span>
            </a>
        </li>
    </ul>
</aside>