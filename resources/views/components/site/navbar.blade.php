{{-- NAVBAR INI HANYA UNTUK HALAMAN SITE DAN GUEST USER --}}
@guest
<nav class="navbar navbar-expand-lg navbar-light bg-primary shadow-lg fixed-top">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="{{ route('site.home') }}">
            <img src="{{ asset('images/Logo_ALKES.png') }}" alt="Logo Alkes" width="50" height="50" class="me-2">
            <span class="fs-4">Toko Alkes</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link text-white fw-semibold px-3 py-2 rounded-pill {{ request()->routeIs('site.home') ? 'bg-white text-primary' : 'hover-bg-light' }}"
                        href="{{ route('site.home') }}">
                        <i class="bi bi-house-door me-1"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-white fw-semibold px-3 py-2 rounded-pill {{ request()->routeIs('site.about') ? 'bg-white text-primary' : 'hover-bg-light' }}"
                        href="{{ route('site.about') }}">
                        <i class="bi bi-info-circle me-1"></i>
                        About
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-white fw-semibold px-3 py-2 rounded-pill {{ request()->routeIs('site.contact') ? 'bg-white text-primary' : 'hover-bg-light' }}"
                        href="{{ route('site.contact') }}">
                        <i class="bi bi-telephone me-1"></i>
                        Contact
                    </a>
                </li>

                <!-- Show Login Button for Guest Users ONLY -->
                <li class="nav-item ms-2">
                    <a class="btn btn-outline-light px-4 py-2 fw-semibold rounded-pill"
                        href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Custom hover effects */
    .hover-bg-light:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link {
        transition: all 0.3s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .navbar-nav .nav-link {
            text-align: center;
            margin: 5px 0;
        }

        .btn-outline-light {
            margin-top: 10px;
            width: 100%;
        }
    }
</style>
@endguest

{{-- TIDAK ADA NAVBAR UNTUK USER YANG SUDAH LOGIN --}}
{{-- User yang sudah login akan diarahkan ke dashboard masing-masing dan tidak bisa akses site --}}