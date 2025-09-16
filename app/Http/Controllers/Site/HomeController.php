<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $title = 'Toko Alat Kesehatan - Solusi Lengkap Peralatan Medis Anda';
        
        // Data dummy untuk featured products (nanti bisa diganti dengan data dari database)
        $featuredProducts = [
            [
                'name' => 'Tensimeter Digital',
                'price' => 'Rp 250.000',
                'image' => 'tensimeter.jpg',
                'rating' => 4.8,
                'sold' => 120
            ],
            [
                'name' => 'Masker Medis N95',
                'price' => 'Rp 45.000',
                'image' => 'masker-n95.jpg',
                'rating' => 4.9,
                'sold' => 350
            ],
            [
                'name' => 'Thermometer Infrared',
                'price' => 'Rp 175.000',
                'image' => 'thermometer.jpg',
                'rating' => 4.7,
                'sold' => 89
            ],
            [
                'name' => 'Sarung Tangan Medis',
                'price' => 'Rp 25.000',
                'image' => 'sarung-tangan.jpg',
                'rating' => 4.6,
                'sold' => 200
            ]
        ];

        $categories = [
            [
                'name' => 'Alat Diagnostik',
                'icon' => 'bi-heart-pulse',
                'count' => 45,
                'description' => 'Tensimeter, Stetoskop, Thermometer'
            ],
            [
                'name' => 'Peralatan Medis',
                'icon' => 'bi-bandaid',
                'count' => 78,
                'description' => 'Peralatan operasi dan medis'
            ],
            [
                'name' => 'Alat Pelindung',
                'icon' => 'bi-shield-check',
                'count' => 32,
                'description' => 'Masker, Sarung tangan, APD'
            ],
            [
                'name' => 'Obat-obatan',
                'icon' => 'bi-capsule',
                'count' => 156,
                'description' => 'Vitamin, Suplemen, Obat bebas'
            ]
        ];

        return view('site.home', compact('title', 'featuredProducts', 'categories'));
    }

    /**
     * Display about page.
     */
    public function about()
    {
        $title = 'Tentang Kami - Toko Alat Kesehatan';
        return view('site.about', compact('title'));
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        $title = 'Hubungi Kami - Toko Alat Kesehatan';
        return view('site.contact', compact('title'));
    }

    /**
     * Handle contact form submission.
     */
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Di sini nanti bisa ditambahkan logic untuk menyimpan pesan ke database
        // atau mengirim email

        return redirect()->route('site.contact')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}