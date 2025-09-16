<footer class="bg-dark text-white py-5 mt-5">
    <div class="container-fluid px-4">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-3 p-2 me-3">
                        <i class="bi bi-heart-pulse text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 text-primary fw-bold">ALKES SHOP</h5>
                        <small class="text-muted">Toko Alat Kesehatan</small>
                    </div>
                </div>
                <p class="text-muted mb-3">
                    Platform terpercaya untuk kebutuhan alat kesehatan dengan kualitas terbaik dan harga kompetitif. 
                    Melayani seluruh Indonesia dengan pengiriman cepat dan aman.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-white fw-bold mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('customer.dashboard') }}" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('customer.produk.index') }}" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Semua Produk
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('customer.toko.index') }}" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Toko
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.about') }}" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Tentang Kami
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.contact') }}" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-white fw-bold mb-3">Kategori Populer</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Alat Medis
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Obat-obatan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Peralatan Rumah Sakit
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Alat Terapi
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Suplemen
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-white fw-bold mb-3">Layanan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Bantuan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Kebijakan Privasi
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Syarat & Ketentuan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> Panduan Belanja
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none hover-primary">
                            <i class="bi bi-chevron-right me-1"></i> FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-12 mb-4">
                <h6 class="text-white fw-bold mb-3">Hubungi Kami</h6>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        <span class="text-muted small">
                            Jl. Kesehatan No. 123, Surabaya, Jawa Timur 60111
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <span class="text-muted small">+62 31 1234 5678</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-whatsapp text-primary me-2"></i>
                        <span class="text-muted small">+62 812 3456 7890</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-envelope text-primary me-2"></i>
                        <span class="text-muted small">info@alkesshop.com</span>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="bg-secondary bg-opacity-25 rounded p-3">
                    <h6 class="text-white fw-bold mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>Jam Operasional
                    </h6>
                    <div class="text-muted small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Senin - Jumat:</span>
                            <span>08:00 - 17:00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Sabtu:</span>
                            <span>08:00 - 15:00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Minggu:</span>
                            <span class="text-danger">Tutup</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & Shipping Partners -->
        <div class="row mt-4 pt-4 border-top border-secondary">
            <div class="col-md-6 mb-3">
                <h6 class="text-white fw-bold mb-3">Metode Pembayaran</h6>
                <div class="d-flex flex-wrap gap-2">
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">BCA</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">MANDIRI</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">BRI</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">BNI</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">GOPAY</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">OVO</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="text-white fw-bold mb-3">Jasa Pengiriman</h6>
                <div class="d-flex flex-wrap gap-2">
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">JNE</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">J&T</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">TIKI</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">POS</small>
                    </div>
                    <div class="bg-white rounded px-2 py-1">
                        <small class="text-dark fw-bold">SICEPAT</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-secondary bg-opacity-50 py-3 mt-4">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-muted">
                        &copy; {{ date('Y') }} ALKES SHOP. Semua hak cipta dilindungi undang-undang.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-muted">
                        Dibuat dengan <i class="bi bi-heart text-danger"></i> untuk kesehatan Indonesia
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-primary position-fixed bottom-0 end-0 me-4 mb-4 rounded-circle shadow d-none" style="z-index: 1000; width: 50px; height: 50px;">
        <i class="bi bi-arrow-up"></i>
    </button>
</footer>

<style>
    .hover-primary:hover {
        color: var(--bs-primary) !important;
        transition: color 0.3s ease;
    }
    
    .bg-secondary.bg-opacity-25 {
        background-color: rgba(108, 117, 125, 0.25) !important;
    }
    
    .bg-secondary.bg-opacity-50 {
        background-color: rgba(108, 117, 125, 0.5) !important;
    }
    
    #backToTop {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    #backToTop.show {
        opacity: 1;
        visibility: visible;
    }
    
    #backToTop:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3) !important;
    }
</style>

<script>
    // Back to Top functionality
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');
        
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('d-none');
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.add('d-none');
                backToTopButton.classList.remove('show');
            }
        });
        
        // Smooth scroll to top when clicked
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>