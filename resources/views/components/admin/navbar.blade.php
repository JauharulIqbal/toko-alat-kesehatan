<nav class="navbar navbar-expand navbar-light bg-white shadow-sm px-4 py-3">
    <button class="btn btn-outline-secondary me-3" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <form class="d-none d-md-inline-block form-inline me-auto ms-md-3 my-2 my-md-0 w-30">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search here..." aria-label="Search">
            <button class="btn btn-primary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    <ul class="navbar-nav ms-auto align-items-center">
        {{-- Dropdown Profile --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <img src="{{ asset('images/foto-admin.jpg') }}" class="rounded-circle" width="36" height="36" alt="Admin">
                <span class="ms-2 fw-semibold text-dark">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 280px;">
                <li class="text-center p-3">
                    <img src="{{ asset('images/foto-admin.jpg') }}" class="rounded-circle mb-2" width="64" height="64" alt="Admin">
                    <h6 class="mb-0 fw-semibold py-2">Admin</h6>
                </li>
                <li><hr class="dropdown-divider py-2"></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-clock-history"></i> Posts & Activity</a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-gear"></i> Settings & Privacy</a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-question-circle"></i> Help Center</a></li>
                <li class="px-3 mt-2">
                    <form action="#" method="POST">
                        @csrf
                        <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
