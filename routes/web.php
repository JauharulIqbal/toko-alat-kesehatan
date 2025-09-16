<?php

use Illuminate\Support\Facades\Route;
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

// Route untuk visitor (public)
Route::get('/', function () {
    return view('welcome'); // atau landing page
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect /admin ke /admin/dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Dashboard (hilangkan nama duplikat)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Toko
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [TokoController::class, 'index'])->name('index');
        Route::get('/create', [TokoController::class, 'create'])->name('create');
        Route::post('/', [TokoController::class, 'store'])->name('store');
        Route::get('/{toko}', [TokoController::class, 'show'])->name('show');
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('update');
        Route::delete('/{toko}', [TokoController::class, 'destroy'])->name('destroy');

        // Export PDF
        Route::get('/export/pdf', [TokoController::class, 'exportPdf'])->name('export-pdf');

        // Additional Routes
        Route::get('/statistics/data', [TokoController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [TokoController::class, 'bulkAction'])->name('bulk-action');
        Route::patch('/{toko}/status', [TokoController::class, 'changeStatus'])->name('change-status');
    });

    // Kategori Produk
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

    // Produk
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('/create', [ProdukController::class, 'create'])->name('create');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::get('/{produk}', [ProdukController::class, 'show'])->name('show');
        Route::get('/{produk}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{produk}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('destroy');

        // Export PDF
        Route::get('/export/pdf', [ProdukController::class, 'exportPdf'])->name('export-pdf');

        // Additional Routes
        Route::get('/statistics/data', [ProdukController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [ProdukController::class, 'bulkAction'])->name('bulk-action');
        Route::patch('/{produk}/status', [ProdukController::class, 'changeStatus'])->name('change-status');
    });

    // Metode Pembayaran
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

    // Transaksi
    Route::resource('transaksi', TransaksiController::class);

    // Jasa Pengiriman
    Route::prefix('jasa-pengiriman')->name('jasa-pengiriman.')->group(function () {
        Route::get('/', [JasaPengirimanController::class, 'index'])->name('index');
        Route::get('/create', [JasaPengirimanController::class, 'create'])->name('create');
        Route::post('/', [JasaPengirimanController::class, 'store'])->name('store');
        Route::get('/{jasaPengiriman}', [JasaPengirimanController::class, 'show'])->name('show');
        Route::get('/{jasaPengiriman}/edit', [JasaPengirimanController::class, 'edit'])->name('edit');
        Route::put('/{jasaPengiriman}', [JasaPengirimanController::class, 'update'])->name('update');
        Route::delete('/{jasaPengiriman}', [JasaPengirimanController::class, 'destroy'])->name('destroy');

        // Additional Routes untuk Jasa Pengiriman
        Route::get('/statistics/data', [JasaPengirimanController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [JasaPengirimanController::class, 'bulkAction'])->name('bulk-action');
    });

    // Pengguna 
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('create');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{pengguna}', [PenggunaController::class, 'show'])->name('show');
        Route::get('/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{pengguna}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{pengguna}', [PenggunaController::class, 'destroy'])->name('destroy');

        // Export PDF
        Route::get('/export/pdf', [PenggunaController::class, 'exportPdf'])->name('export-pdf');

        // Additional Routes untuk Pengguna
        Route::get('/statistics/data', [PenggunaController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [PenggunaController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [PenggunaController::class, 'checkDuplicate'])->name('check-duplicate');
    });

    // Kota
    Route::prefix('kota')->name('kota.')->group(function () {
        Route::get('/', [KotaController::class, 'index'])->name('index');
        Route::get('/create', [KotaController::class, 'create'])->name('create');
        Route::post('/', [KotaController::class, 'store'])->name('store');
        Route::get('/{kota}', [KotaController::class, 'show'])->name('show');
        Route::get('/{kota}/edit', [KotaController::class, 'edit'])->name('edit');
        Route::put('/{kota}', [KotaController::class, 'update'])->name('update');
        Route::delete('/{kota}', [KotaController::class, 'destroy'])->name('destroy');

        // Additional Routes for Kota
        Route::get('/statistics/data', [KotaController::class, 'getStatistics'])->name('statistics');
        Route::post('/bulk-action', [KotaController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/check-duplicate', [KotaController::class, 'checkDuplicate'])->name('check-duplicate');
    });

    // Guestbook
    Route::resource('guestbook', GuestBookController::class);
});

// Penjual Routes (untuk ke depan)
Route::prefix('seller')->name('seller.')->group(function () {
    // Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    // dst...
});

// Customer Routes (untuk ke depan)
Route::prefix('customer')->name('customer.')->group(function () {
    // Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    // dst...
});
