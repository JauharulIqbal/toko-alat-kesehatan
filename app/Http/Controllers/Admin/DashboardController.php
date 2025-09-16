<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'totalToko' => Toko::count(),
            'totalProduk' => Produk::count(),
            'totalPesanan' => Pesanan::count(),
            'totalPembayaran' => Pembayaran::count(),
        ]);
    }
}