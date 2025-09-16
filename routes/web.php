<?php

use Illuminate\Support\Facades\Route;

// Authentication Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Site Controllers (untuk yang belum login)
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProductController as SiteProductController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\KotaController;
use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestBookController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\JasaPengirimanController;

// Seller Controllers
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Penjual\ProductController as PenjualProductController;
use App\Http\Controllers\Penjual\OrderController as PenjualOrderController;
use App\Http\Controllers\Penjual\StoreController as PenjualStoreController;

// Customer Controllers
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Site Routes - HARUS ADA UNTUK FALLBACK
|--------------------------------------------------------------------------
*/

// Home route - WAJIB ADA
Route::get('/', [HomeController::class, 'index'])->name('site.home');

Route::prefix('site')->name('site.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/products', function () {
        return view('site.products', ['title' => 'Produk - ALKES SHOP']);
    })->name('products');

    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes - HARUS DIATAS SEMUA ROUTE LAIN
|--------------------------------------------------------------------------
*/

// Login Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    
    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    
    // Password Reset Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout Route (Authenticated Users)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes - Role: admin - DEFINISIKAN SEBELUM ROLE LAIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Redirect /admin ke dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Dashboard - ROUTE INI HARUS ADA DAN ACCESSIBLE
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

        // Additional Routes
        Route::get('/export/pdf', [TokoController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/statistics/data', [TokoController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [TokoController::class, 'bulkAction'])->name('bulk-action');
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

        // Additional Routes
        Route::get('/statistics/data', [KategoriController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [KategoriController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [KategoriController::class, 'checkDuplicate'])->name('check-duplicate');
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

        // Additional Routes
        Route::get('/export/pdf', [ProdukController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/statistics/data', [ProdukController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [ProdukController::class, 'bulkAction'])->name('bulk-action');
        Route::patch('/{produk}/status', [ProdukController::class, 'changeStatus'])->name('change-status');
    });

    // Metode Pembayaran Management
    Route::prefix('metode-pembayaran')->name('metode-pembayaran.')->group(function () {
        Route::get('/', [MetodePembayaranController::class, 'index'])->name('index');
        Route::get('/create', [MetodePembayaranController::class, 'create'])->name('create');
        Route::post('/', [MetodePembayaranController::class, 'store'])->name('store');
        Route::get('/{metodePembayaran}', [MetodePembayaranController::class, 'show'])->name('show');
        Route::get('/{metodePembayaran}/edit', [MetodePembayaranController::class, 'edit'])->name('edit');
        Route::put('/{metodePembayaran}', [MetodePembayaranController::class, 'update'])->name('update');
        Route::delete('/{metodePembayaran}', [MetodePembayaranController::class, 'destroy'])->name('destroy');

        // Additional Routes
        Route::get('/statistics/data', [MetodePembayaranController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [MetodePembayaranController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [MetodePembayaranController::class, 'checkDuplicate'])->name('check-duplicate');
    });

    // Transaksi Management
    Route::resource('transaksi', TransaksiController::class);

    // Jasa Pengiriman Management
    Route::prefix('jasa-pengiriman')->name('jasa-pengiriman.')->group(function () {
        Route::get('/', [JasaPengirimanController::class, 'index'])->name('index');
        Route::get('/create', [JasaPengirimanController::class, 'create'])->name('create');
        Route::post('/', [JasaPengirimanController::class, 'store'])->name('store');
        Route::get('/{jasaPengiriman}', [JasaPengirimanController::class, 'show'])->name('show');
        Route::get('/{jasaPengiriman}/edit', [JasaPengirimanController::class, 'edit'])->name('edit');
        Route::put('/{jasaPengiriman}', [JasaPengirimanController::class, 'update'])->name('update');
        Route::delete('/{jasaPengiriman}', [JasaPengirimanController::class, 'destroy'])->name('destroy');

        // Additional Routes
        Route::get('/statistics/data', [JasaPengirimanController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [JasaPengirimanController::class, 'bulkAction'])->name('bulk-action');
    });

    // Pengguna Management
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('create');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{pengguna}', [PenggunaController::class, 'show'])->name('show');
        Route::get('/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{pengguna}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{pengguna}', [PenggunaController::class, 'destroy'])->name('destroy');

        // Additional Routes
        Route::get('/export/pdf', [PenggunaController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/statistics/data', [PenggunaController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [PenggunaController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [PenggunaController::class, 'checkDuplicate'])->name('check-duplicate');
    });

    // Kota Management
    Route::prefix('kota')->name('kota.')->group(function () {
        Route::get('/', [KotaController::class, 'index'])->name('index');
        Route::get('/create', [KotaController::class, 'create'])->name('create');
        Route::post('/', [KotaController::class, 'store'])->name('store');
        Route::get('/{kota}', [KotaController::class, 'show'])->name('show');
        Route::get('/{kota}/edit', [KotaController::class, 'edit'])->name('edit');
        Route::put('/{kota}', [KotaController::class, 'update'])->name('update');
        Route::delete('/{kota}', [KotaController::class, 'destroy'])->name('destroy');

        // Additional Routes
        Route::get('/statistics/data', [KotaController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [KotaController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [KotaController::class, 'checkDuplicate'])->name('check-duplicate');
    });

    // Guestbook Management
    Route::resource('guestbook', GuestBookController::class);
});

/*
|--------------------------------------------------------------------------
| Penjual Routes - Role: penjual
|--------------------------------------------------------------------------
*/
Route::prefix('penjual')->name('penjual.')->middleware(['auth', 'role:penjual'])->group(function () {
    // Redirect /seller ke dashboard
    Route::get('/', function () {
        return redirect()->route('penjual.dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');

    // Store Management (Penjual hanya bisa manage toko sendiri)
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [PenjualStoreController::class, 'index'])->name('index');
        Route::get('/create', [PenjualStoreController::class, 'create'])->name('create');
        Route::post('/', [PenjualStoreController::class, 'store'])->name('store');
        Route::get('/my-store', [PenjualStoreController::class, 'myStore'])->name('my-store');
        Route::get('/{toko}/edit', [PenjualStoreController::class, 'edit'])->name('edit');
        Route::put('/{toko}', [PenjualStoreController::class, 'update'])->name('update');
        
        // Store Statistics
        Route::get('/statistics', [PenjualStoreController::class, 'statistics'])->name('statistics');
    });

    // Product Management (Penjual hanya bisa manage produk toko sendiri)
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [PenjualProductController::class, 'index'])->name('index');
        Route::get('/create', [PenjualProductController::class, 'create'])->name('create');
        Route::post('/', [PenjualProductController::class, 'store'])->name('store');
        Route::get('/{produk}', [PenjualProductController::class, 'show'])->name('show');
        Route::get('/{produk}/edit', [PenjualProductController::class, 'edit'])->name('edit');
        Route::put('/{produk}', [PenjualProductController::class, 'update'])->name('update');
        Route::delete('/{produk}', [PenjualProductController::class, 'destroy'])->name('destroy');
        
        // Product Status Management
        Route::patch('/{produk}/status', [PenjualProductController::class, 'changeStatus'])->name('change-status');
        Route::post('/bulk-action', [PenjualProductController::class, 'bulkAction'])->name('bulk-action');
    });

    // Order Management (pesanan untuk produk Penjual)
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [PenjualOrderController::class, 'index'])->name('index');
        Route::get('/{pesanan}', [PenjualOrderController::class, 'show'])->name('show');
        Route::patch('/{pesanan}/status', [PenjualOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{pesanan}/confirm', [PenjualOrderController::class, 'confirm'])->name('confirm');
        Route::post('/{pesanan}/ship', [PenjualOrderController::class, 'ship'])->name('ship');
        
        // Order Reports
        Route::get('/laporan/penjualan', [PenjualOrderController::class, 'salesReport'])->name('sales-report');
        Route::get('/export/pdf', [PenjualOrderController::class, 'exportPdf'])->name('export-pdf');
    });

    // Profile Management
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [PenjualDashboardController::class, 'profile'])->name('show');
        Route::get('/edit', [PenjualDashboardController::class, 'editProfile'])->name('edit');
        Route::put('/', [PenjualDashboardController::class, 'updateProfile'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Customer Routes - Role: customer
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    // Redirect /customer ke dashboard
    Route::get('/', function () {
        return redirect()->route('customer.dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Product Browsing (enhanced untuk customer)
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [CustomerProductController::class, 'index'])->name('index');
        Route::get('/kategori/{kategori}', [CustomerProductController::class, 'byCategory'])->name('kategori');
        Route::get('/{produk}', [CustomerProductController::class, 'show'])->name('show');
        Route::get('/search', [CustomerProductController::class, 'search'])->name('search');
        Route::post('/{produk}/review', [CustomerProductController::class, 'addReview'])->name('review');
    });

    // Shopping Cart Management
    Route::prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/{keranjang}', [CartController::class, 'update'])->name('update');
        Route::delete('/{keranjang}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        
        // Checkout Process
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('process-checkout');
    });

    // Order Management (customer's orders)
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{pesanan}', [CustomerOrderController::class, 'show'])->name('show');
        Route::post('/{pesanan}/cancel', [CustomerOrderController::class, 'cancel'])->name('cancel');
        Route::post('/{pesanan}/confirm-received', [CustomerOrderController::class, 'confirmReceived'])->name('confirm-received');
        
        // Order Tracking
        Route::get('/{pesanan}/track', [CustomerOrderController::class, 'track'])->name('track');
        
        // Reorder
        Route::post('/{pesanan}/reorder', [CustomerOrderController::class, 'reorder'])->name('reorder');
    });

    // Wishlist Management
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [CustomerDashboardController::class, 'wishlist'])->name('index');
        Route::post('/add', [CustomerDashboardController::class, 'addToWishlist'])->name('add');
        Route::delete('/{produk}', [CustomerDashboardController::class, 'removeFromWishlist'])->name('remove');
    });

    // Profile Management
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/alamat', [ProfileController::class, 'addresses'])->name('addresses');
        Route::post('/alamat', [ProfileController::class, 'addAddress'])->name('add-address');
        Route::put('/alamat/{alamat}', [ProfileController::class, 'updateAddress'])->name('update-address');
        Route::delete('/alamat/{alamat}', [ProfileController::class, 'deleteAddress'])->name('delete-address');
    });

    // Store Directory (customer view)
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [CustomerProductController::class, 'stores'])->name('index');
        Route::get('/{toko}', [CustomerProductController::class, 'storeDetail'])->name('show');
        Route::post('/{toko}/follow', [CustomerProductController::class, 'followStore'])->name('follow');
        Route::delete('/{toko}/unfollow', [CustomerProductController::class, 'unfollowStore'])->name('unfollow');
    });
});

/*
|--------------------------------------------------------------------------
| Testing & Debug Routes - HAPUS DI PRODUCTION
|--------------------------------------------------------------------------
*/
Route::get('/test-admin', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'authenticated' => true,
            'user_id' => $user->id_user ?? $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'can_access_admin' => $user->role === 'admin'
        ]);
    }
    return response()->json(['authenticated' => false]);
});

Route::get('/debug-routes', function () {
    $routes = collect(\Route::getRoutes())->map(function ($route) {
        return [
            'method' => $route->methods(),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'middleware' => $route->gatherMiddleware()
        ];
    });
    
    return response()->json($routes);
});