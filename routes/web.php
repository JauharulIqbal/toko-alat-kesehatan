<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KotaController;
use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestBookController;
use App\Http\Controllers\Admin\PembayaranController;
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

    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class);

    // Jasa Pengiriman
    Route::resource('jasa-pengiriman', JasaPengirimanController::class);

    // Customer (jika admin bisa kelola customer)
    Route::resource('customer', CustomerController::class);

    // Kota
    Route::resource('kota', KotaController::class);

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
