<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ALKES SHOP - Toko Alat Kesehatan Terpercaya dengan produk berkualitas dan harga kompetitif">
    <meta name="keywords" content="alat kesehatan, medical equipment, obat, farmasi, rumah sakit">
    <meta name="author" content="ALKES SHOP">
    <title>{{ $title ?? 'ALKES SHOP - Toko Alat Kesehatan Terpercaya' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #0d6efd;
            --bs-primary-rgb: 13, 110, 253;
            --bs-secondary: #6c757d;
            --bs-success: #198754;
            --bs-danger: #dc3545;
            --bs-warning: #ffc107;
            --bs-info: #0dcaf0;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--bs-dark);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--bs-primary);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #0b5ed7;
        }
        
        /* Enhanced animations */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Card enhancements */
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            border-color: var(--bs-primary);
        }
        
        /* Button enhancements */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .btn-primary {
            background: var(--bs-primary);
            border-color: var(--bs-primary);
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }
        
        .btn-primary:hover {
            background: #0b5ed7;
            border-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
        
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6b4190 100%);
            transform: translateY(-2px);
        }
        
        /* Form controls */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }
        
        /* Badge enhancements */
        .badge {
            font-weight: 500;
            border-radius: 6px;
            padding: 0.4em 0.8em;
        }
        
        /* Alert enhancements */
        .alert {
            border-radius: 8px;
            border-width: 2px;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Product grid responsive */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
        }
        
        /* Toast notifications */
        .toast {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Enhanced shadows */
        .shadow-soft {
            box-shadow: 0 2px 4px rgba(0,0,0,0.04), 0 8px 16px rgba(0,0,0,0.06);
        }
        
        .shadow-medium {
            box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .shadow-strong {
            box-shadow: 0 10px 25px rgba(0,0,0,0.15), 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Navbar sticky enhancement */
        .navbar.sticky-top {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        
        /* Responsive utilities */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            h1 { font-size: 1.75rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
                line-height: 1.4;
            }
        }
    </style>
    
    <!-- Additional Page Styles -->
    @stack('styles')
</head>

<body class="bg-light">
    <!-- Preloader -->
    <div id="preloader" class="position-fixed top-0 start-0 w-100 h-100 bg-white d-flex align-items-center justify-content-center" style="z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h6 class="text-primary fw-bold">ALKES SHOP</h6>
            <small class="text-muted">Memuat halaman...</small>
        </div>
    </div>

    <!-- Navigation -->
    <x-customer.navbar />

    <!-- Main Content -->
    <main id="main-content">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        <div class="fade-in">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <x-customer.footer />

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Preloader
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            
            // Hide preloader after page loads
            window.addEventListener('load', function() {
                setTimeout(() => {
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 300);
                }, 500);
            });
        });

        // Toast Notification Function
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { delay: 4000 });
            toast.show();
            
            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }

        // AJAX Setup for CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global error handler for AJAX
        $(document).ajaxError(function(event, xhr, settings, thrownError) {
            if (xhr.status === 419) {
                showToast('Sesi telah berakhir. Silakan refresh halaman.', 'warning');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else if (xhr.status >= 500) {
                showToast('Terjadi kesalahan server. Silakan coba lagi.', 'danger');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert:not(.alert-permanent)').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Cart functions (will be enhanced by specific page scripts)
        window.cartFunctions = {
            updateCount: function(count) {
                document.getElementById('cartCount').textContent = count;
            },
            
            addToCart: function(productId, quantity = 1) {
                // This will be implemented in the product pages
                console.log('Add to cart:', productId, quantity);
            }
        };

        // Search enhancement
        const searchForm = document.querySelector('form[action*="search"]');
        if (searchForm) {
            const searchInput = searchForm.querySelector('input[name="q"]');
            let searchTimeout;
            
            searchInput?.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3) {
                        // Implement live search suggestions here
                        console.log('Search suggestions for:', this.value);
                    }
                }, 300);
            });
        }
    </script>

    <!-- Page-specific JavaScript -->
    @stack('scripts')
</body>
</html>