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
                
                <!-- Authentication Links -->
                @guest
                <li class="nav-item ms-2">
                    <a class="btn btn-outline-light px-4 py-2 fw-semibold rounded-pill" 
                       href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Login
                    </a>
                </li>
                @else
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2 fs-5"></i>
                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        @if(Auth::user()->role === 'admin')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2 text-primary"></i>
                                Dashboard Admin
                            </a>
                        </li>
                        @elseif(Auth::user()->role === 'penjual')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" 
                               href="{{ route('penjual.dashboard') }}">
                                <i class="bi bi-shop me-2 text-success"></i>
                                Dashboard Penjual
                            </a>
                        </li>
                        @else
                        <li>
                            <a class="dropdown-item d-flex align-items-center" 
                               href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-person me-2 text-info"></i>
                                Dashboard
                            </a>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
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

.dropdown-menu {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    padding: 10px 20px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .navbar-nav .nav-link {
        text-align: center;
        margin: 5px 0;
    }
    
    .btn-outline-light {
        margin-top: 10px;
    }
}
</style>