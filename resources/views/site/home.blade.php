<x-layouts.site :title="$title">
    <!-- Hero Section -->
    <section class="hero-section bg-gradient-primary text-white py-5" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-1 fw-bold mb-4 text-white">
                        Solusi Lengkap
                        <span class="text-warning">Alat Kesehatan</span>
                        Anda
                    </h1>
                    <p class="lead mb-4 text-white-50">
                        Dapatkan peralatan medis berkualitas tinggi dengan harga terjangkau.
                        Terpercaya lebih dari 10 tahun melayani kebutuhan kesehatan Anda.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="#products" class="btn btn-light btn-lg px-5 py-3 fw-semibold rounded-pill">
                            <i class="bi bi-bag-check me-2"></i>
                            Belanja Sekarang
                        </a>
                        <a href="#about" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold rounded-pill">
                            <i class="bi bi-info-circle me-2"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <h3 class="fw-bold text-warning">500+</h3>
                            <small class="text-white-50">Produk Tersedia</small>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold text-warning">10K+</h3>
                            <small class="text-white-50">Pelanggan Puas</small>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold text-warning">99%</h3>
                            <small class="text-white-50">Tingkat Kepuasan</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="position-relative">
                        <img src="{{ asset('images/hero-medical-equipment.png') }}"
                            alt="Medical Equipment"
                            class="img-fluid rounded-3 shadow-lg"
                            style="max-height: 500px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10 rounded-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating elements -->
        <div class="position-absolute" style="top: 10%; left: 10%; animation: float 3s ease-in-out infinite;">
            <i class="bi bi-heart-pulse text-warning fs-1 opacity-50"></i>
        </div>
        <div class="position-absolute" style="top: 20%; right: 15%; animation: float 2s ease-in-out infinite reverse;">
            <i class="bi bi-shield-check text-success fs-2 opacity-50"></i>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center" data-aos="fade-up">
                <div class="col-12 text-center mb-4">
                    <h5 class="text-muted mb-0">Dipercaya oleh berbagai instansi</h5>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">RS Umum</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">Puskesmas</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">Klinik</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">Apotek</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">Praktek Dokter</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center mb-3">
                    <div class="bg-white p-4 rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                        <span class="fw-bold text-muted">Home Care</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Categories -->
    <section id="categories" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-gradient mb-4">Kategori Produk Kami</h2>
                    <p class="lead text-muted">
                        Temukan berbagai macam peralatan medis berkualitas tinggi untuk memenuhi kebutuhan kesehatan Anda
                    </p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($categories as $index => $category)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="card border-0 shadow-sm h-100 card-hover text-center">
                        <div class="card-body p-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="{{ $category['icon'] }} text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">{{ $category['name'] }}</h5>
                            <p class="text-muted mb-3">{{ $category['description'] }}</p>
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ $category['count'] }} Produk
                                </span>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-gradient mb-4">Produk Unggulan</h2>
                    <p class="lead text-muted">
                        Produk-produk terpopuler dan terlaris dengan kualitas terbaik dan harga kompetitif
                    </p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $index => $product)
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('images/products/' . $product['image']) }}"
                                class="card-img-top"
                                alt="{{ $product['name'] }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success rounded-pill">
                                    <i class="bi bi-star-fill me-1"></i>{{ $product['rating'] }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">{{ $product['name'] }}</h6>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="h5 fw-bold text-primary mb-0">{{ $product['price'] }}</span>
                                <small class="text-muted">{{ $product['sold'] }} terjual</small>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-sm rounded-pill">
                                    <i class="bi bi-cart-plus me-1"></i>
                                    Tambah ke Keranjang
                                </button>
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill">
                                    <i class="bi bi-eye me-1"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center" data-aos="fade-up">
                    <a href="#" class="btn btn-custom-primary btn-lg px-5">
                        <i class="bi bi-grid me-2"></i>
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="{{ asset('images/why-choose-us.png') }}"
                        alt="Why Choose Us"
                        class="img-fluid rounded-3 shadow-lg">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h2 class="display-4 fw-bold text-gradient mb-4">Mengapa Memilih Kami?</h2>
                    <p class="lead text-muted mb-4">
                        Kami berkomitmen memberikan pelayanan terbaik dan produk berkualitas tinggi
                        untuk mendukung kebutuhan kesehatan Anda.
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-shield-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Kualitas Terjamin</h6>
                                    <p class="text-muted small mb-0">Produk berstandar internasional dengan sertifikat resmi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-truck text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Pengiriman Cepat</h6>
                                    <p class="text-muted small mb-0">Pengiriman ke seluruh Indonesia dengan packaging aman</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-headset text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Layanan 24/7</h6>
                                    <p class="text-muted small mb-0">Customer service siap membantu kapan saja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-award text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Berpengalaman</h6>
                                    <p class="text-muted small mb-0">Lebih dari 10 tahun pengalaman di bidang alat kesehatan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-gradient mb-4">Keunggulan Layanan Kami</h2>
                    <p class="lead text-muted">
                        Nikmati berbagai kemudahan dan keuntungan berbelanja di Toko Alkes
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle text-primary fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Produk Original</h5>
                        <p class="text-muted">Semua produk dijamin 100% original dari distributor resmi dengan garansi kualitas</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-lightning text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Proses Cepat</h5>
                        <p class="text-muted">Proses pesanan dalam 24 jam dan pengiriman cepat ke seluruh Indonesia</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-credit-card text-info fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Pembayaran Aman</h5>
                        <p class="text-muted">Berbagai pilihan metode pembayaran yang aman dan terpercaya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-gradient mb-4">Testimoni Pelanggan</h2>
                    <p class="lead text-muted">
                        Apa kata pelanggan kami tentang produk dan layanan yang kami berikan
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                            </div>
                            <p class="text-muted mb-4">
                                "Produknya berkualitas tinggi dan pengirimannya cepat.
                                Pelayanan customer service juga sangat ramah dan responsif."
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonial-1.jpg') }}"
                                    alt="Customer"
                                    class="rounded-circle me-3"
                                    width="50" height="50"
                                    style="background: linear-gradient(45deg, #007bff, #0056b3); object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">Dr. Sarah Putri</h6>
                                    <small class="text-muted">Dokter Umum</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                            </div>
                            <p class="text-muted mb-4">
                                "Sudah berlangganan lebih dari 2 tahun. Harga kompetitif
                                dan kualitas produk selalu konsisten. Sangat merekomendasikan!"
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonial-2.jpg') }}"
                                    alt="Customer"
                                    class="rounded-circle me-3"
                                    width="50" height="50"
                                    style="background: linear-gradient(45deg, #28a745, #1e7e34); object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">Ahmad Fauzi</h6>
                                    <small class="text-muted">Pemilik Apotek</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                            </div>
                            <p class="text-muted mb-4">
                                "Website mudah digunakan, proses pemesanan simple,
                                dan barang sampai dengan packaging yang rapi dan aman."
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonial-3.jpg') }}"
                                    alt="Customer"
                                    class="rounded-circle me-3"
                                    width="50" height="50"
                                    style="background: linear-gradient(45deg, #dc3545, #c82333); object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">Siti Nurhaliza</h6>
                                    <small class="text-muted">Perawat</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="counter-item">
                        <h2 class="display-4 fw-bold text-warning mb-2" data-count="500">0</h2>
                        <h5 class="fw-semibold">Produk Tersedia</h5>
                        <p class="mb-0 opacity-75">Berbagai macam alat kesehatan berkualitas</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="counter-item">
                        <h2 class="display-4 fw-bold text-warning mb-2" data-count="10000">0</h2>
                        <h5 class="fw-semibold">Pelanggan Puas</h5>
                        <p class="mb-0 opacity-75">Tersebar di seluruh Indonesia</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-item">
                        <h2 class="display-4 fw-bold text-warning mb-2" data-count="99">0</h2>
                        <h5 class="fw-semibold">Tingkat Kepuasan (%)</h5>
                        <p class="mb-0 opacity-75">Berdasarkan review pelanggan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="counter-item">
                        <h2 class="display-4 fw-bold text-warning mb-2" data-count="10">0</h2>
                        <h5 class="fw-semibold">Tahun Pengalaman</h5>
                        <p class="mb-0 opacity-75">Melayani kebutuhan alat kesehatan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h3 class="fw-bold mb-3">Dapatkan Update Terbaru</h3>
                    <p class="text-muted mb-0">
                        Berlangganan newsletter kami untuk mendapatkan informasi produk terbaru,
                        promo menarik, dan tips kesehatan.
                    </p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <form class="d-flex gap-3">
                        <input type="email" class="form-control form-control-lg rounded-pill"
                            placeholder="Masukkan email Anda" required>
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 flex-shrink-0">
                            <i class="bi bi-send me-2"></i>Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h2 class="display-5 fw-bold mb-4">Siap Berbelanja Alat Kesehatan?</h2>
                    <p class="lead mb-0">
                        Dapatkan penawaran terbaik dan konsultasi gratis dari tim ahli kami.
                        Hubungi kami sekarang juga!
                    </p>
                </div>
                <div class="col-lg-4 text-center" data-aos="fade-left">
                    <div class="d-grid gap-3">
                        <a href="https://wa.me/6231123456789" class="btn btn-light btn-lg px-5 py-3 fw-semibold rounded-pill">
                            <i class="bi bi-whatsapp me-2"></i>
                            Chat WhatsApp
                        </a>
                        <a href="{{ route('site.contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold rounded-pill">
                            <i class="bi bi-envelope me-2"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 50%, #004085 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            opacity: 0.1;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #0056b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-custom-primary {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #0056b3 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, #0056b3 0%, var(--bs-primary) 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .counter-item h2 {
            font-size: 3.5rem;
        }

        @media (max-width: 768px) {
            .display-1 {
                font-size: 2.5rem !important;
            }

            .display-4 {
                font-size: 1.8rem !important;
            }

            .counter-item h2 {
                font-size: 2.5rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const counter = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(counter);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Intersection Observer for counters
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target.querySelector('[data-count]');
                    if (counter && !counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        animateCounter(counter);
                    }
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelectorAll('.counter-item').forEach(item => {
            counterObserver.observe(item);
        });
    </script>
    @endpush
</x-layouts.site>