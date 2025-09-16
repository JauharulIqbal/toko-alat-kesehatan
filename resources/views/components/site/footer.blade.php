<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/Logo_ALKES.png') }}" alt="Logo Alkes" width="50" height="50" class="me-3">
                    <h5 class="mb-0 fw-bold text-white">Toko Alkes</h5>
                </div>
                <p class="text-light-emphasis mb-3">
                    Toko Alat Kesehatan terpercaya dengan pengalaman lebih dari 10 tahun melayani kebutuhan peralatan medis berkualitas tinggi dengan harga terjangkau.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light-emphasis hover-text-primary">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-light-emphasis hover-text-primary">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="#" class="text-light-emphasis hover-text-primary">
                        <i class="bi bi-twitter fs-5"></i>
                    </a>
                    <a href="#" class="text-light-emphasis hover-text-primary">
                        <i class="bi bi-whatsapp fs-5"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('site.home') }}" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-chevron-right me-1"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.about') }}" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-chevron-right me-1"></i>About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-chevron-right me-1"></i>Products
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.contact') }}" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-chevron-right me-1"></i>Contact
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-chevron-right me-1"></i>FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Categories</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-heart-pulse me-1 text-danger"></i>Alat Diagnostik
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-bandaid me-1 text-success"></i>Peralatan Medis
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-shield-check me-1 text-info"></i>Alat Pelindung
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary">
                            <i class="bi bi-capsule me-1 text-warning"></i>Obat-obatan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Contact Info</h6>
                <div class="contact-info">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <div>
                            <small class="text-light-emphasis">Address:</small><br>
                            <span class="text-white">Jl. Kesehatan No. 123, Surabaya, Jawa Timur</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                        <div>
                            <small class="text-light-emphasis">Phone:</small><br>
                            <span class="text-white">+62 31 1234 5678</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                        <div>
                            <small class="text-light-emphasis">Email:</small><br>
                            <span class="text-white">info@tokoalkes.com</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-fill text-primary me-3 fs-5"></i>
                        <div>
                            <small class="text-light-emphasis">Working Hours:</small><br>
                            <span class="text-white">Mon - Sat: 8:00 - 20:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Subscription -->
        <div class="row mt-4 pt-4 border-top border-secondary">
            <div class="col-lg-6">
                <h6 class="text-white fw-semibold mb-3">Subscribe to Our Newsletter</h6>
                <p class="text-light-emphasis mb-3">Get latest updates on new products and special offers</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-send me-1"></i>Subscribe
                    </button>
                </div>
            </div>
            <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                <h6 class="text-white fw-semibold mb-3">Payment Methods</h6>
                <div class="d-flex gap-2 justify-content-lg-end">
                    <span class="badge bg-light text-dark p-2">
                        <i class="bi bi-credit-card"></i> VISA
                    </span>
                    <span class="badge bg-light text-dark p-2">
                        <i class="bi bi-credit-card"></i> MasterCard
                    </span>
                    <span class="badge bg-light text-dark p-2">
                        <i class="bi bi-phone"></i> OVO
                    </span>
                    <span class="badge bg-light text-dark p-2">
                        <i class="bi bi-phone"></i> GoPay
                    </span>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row mt-4 pt-4 border-top border-secondary">
            <div class="col-md-6">
                <p class="text-light-emphasis mb-0">
                    &copy; {{ date('Y') }} Toko Alkes. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex gap-3 justify-content-md-end mt-2 mt-md-0">
                    <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary small">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary small">
                        Terms of Service
                    </a>
                    <a href="#" class="text-light-emphasis text-decoration-none hover-text-primary small">
                        Shipping Info
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.hover-text-primary:hover {
    color: var(--bs-primary) !important;
    transition: color 0.3s ease;
}

.contact-info i {
    width: 20px;
}

.input-group .form-control {
    border-radius: 8px 0 0 8px;
}

.input-group .btn {
    border-radius: 0 8px 8px 0;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        justify-content: center !important;
    }
}
</style>