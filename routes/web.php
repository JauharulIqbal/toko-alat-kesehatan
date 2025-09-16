<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KotaController;

// Import Site Controllers
use App\Http\Controllers\Admin\TokoController;

// Import Admin Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestBookController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Customer\ProfilController;

// Import Customer Controllers
use App\Http\Controllers\Customer\PesananController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Admin\JasaPengirimanController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Site\HomeController as SiteHomeController;
use App\Http\Controllers\Customer\TokoController as CustomerTokoController;
use App\Http\Controllers\Customer\ProdukController as CustomerProdukController;

/*
|--------------------------------------------------------------------------
| Public Routes (untuk user yang belum login)
|--------------------------------------------------------------------------
*/

// Halaman utama - hanya bisa diakses jika belum login
Route::middleware('guest')->group(function () {
    Route::get('/', [SiteHomeController::class, 'index'])->name('site.home');
    Route::get('/about', [SiteHomeController::class, 'about'])->name('site.about');
    Route::get('/contact', [SiteHomeController::class, 'contact'])->name('site.contact');
    Route::post('/contact', [SiteHomeController::class, 'contactStore'])->name('site.contact.store');
    
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset Routes (if you want to implement them later)
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password', ['title' => 'Lupa Password - ALKES SHOP']);
    })->name('password.request');
    
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Logout route - hanya bisa diakses jika sudah login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
*/

// Route untuk redirect ke dashboard sesuai role
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'penjual':
            return redirect()->route('seller.dashboard');
        case 'customer':
            return redirect()->route('customer.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak valid. Silakan login ulang.');
    }
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Redirect /admin ke /admin/dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Toko Management
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [TokoController::class, 'index'])->name('index');
        Route::get('/create', [TokoController::class, 'create'])->name('create');
        Route::post('/', [TokoController::class, 'store'])->name('store');
        Route::get('/{toko}', [TokoController::class, 'show'])->name('show');
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('update');
        Route::delete('/{toko}', [TokoController::class, 'destroy'])->name('destroy');
        Route::patch('/{toko}/status', [TokoController::class, 'changeStatus'])->name('change-status');
    });

    // Kategori Produk Management
    Route::prefix('kategori-produk')->name('kategori-produk.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategoriProduk}', [KategoriController::class, 'show'])->name('show');
        Route::get('/{kategoriProduk}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategoriProduk}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategoriProduk}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // Produk Management
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('/create', [ProdukController::class, 'create'])->name('create');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::get('/{produk}', [ProdukController::class, 'show'])->name('show');
        Route::get('/{produk}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{produk}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('destroy');
        Route::patch('/{produk}/status', [ProdukController::class, 'changeStatus'])->name('change-status');
    });

    // Resource routes untuk modul lainnya
    Route::resource('metode-pembayaran', MetodePembayaranController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('jasa-pengiriman', JasaPengirimanController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('kota', KotaController::class);
    Route::resource('guestbook', GuestBookController::class);
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    // Dashboard/Home
    Route::get('/', function () {
        return redirect()->route('customer.dashboard');
    });
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Search & Categories
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/category/{categoryId?}', [HomeController::class, 'getByCategory'])->name('kategori.show');
    
    // Products
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [CustomerProdukController::class, 'index'])->name('index');
        Route::get('/{id}', [CustomerProdukController::class, 'show'])->name('show');
    });
    
    // Stores
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [CustomerTokoController::class, 'index'])->name('index');
        Route::get('/{id}', [CustomerTokoController::class, 'show'])->name('show');
    });
    
    // Cart Management
    Route::prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', [KeranjangController::class, 'index'])->name('index');
        Route::post('/add', [KeranjangController::class, 'add'])->name('add');
        Route::put('/update/{itemId}', [KeranjangController::class, 'update'])->name('update');
        Route::delete('/remove/{itemId}', [KeranjangController::class, 'remove'])->name('remove');
        Route::delete('/clear', [KeranjangController::class, 'clear'])->name('clear');
    });
    
    // Orders
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [PesananController::class, 'index'])->name('index');
        Route::get('/{id}', [PesananController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [PesananController::class, 'cancel'])->name('cancel');
        Route::post('/{id}/confirm', [PesananController::class, 'confirm'])->name('confirm');
    });
    
    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
    });
    
    // Profile
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'show'])->name('show');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfilController::class, 'update'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

Route::prefix('seller')->name('seller.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('seller.dashboard', [
            'title' => 'Dashboard Penjual - ALKES SHOP'
        ]);
    })->name('dashboard');
    
    // Placeholder routes untuk seller
    Route::get('/produk', function () {
        return view('seller.produk.index');
    })->name('produk.index');
    
    Route::get('/pesanan', function () {
        return view('seller.pesanan.index');  
    })->name('pesanan.index');
});

Route::get('/test-middleware', function () {
    return 'Middleware role berfungsi!';
})->middleware(['auth', 'role:admin']);