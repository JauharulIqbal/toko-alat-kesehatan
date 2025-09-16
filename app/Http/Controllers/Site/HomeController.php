<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'ALKES SHOP - Solusi Lengkap Alat Kesehatan Anda';

        // Data dummy untuk kategori
        $categories = [
            [
                'name' => 'Alat Diagnostik',
                'icon' => 'bi-heart-pulse',
                'description' => 'Tensimeter, termometer, stetoskop dan alat diagnostik lainnya',
                'count' => 45
            ],
            [
                'name' => 'Alat Terapi',
                'icon' => 'bi-bandaid',
                'description' => 'Nebulizer, alat fisioterapi dan peralatan terapi medis',
                'count' => 32
            ],
            [
                'name' => 'Consumables',
                'icon' => 'bi-capsule',
                'description' => 'Masker, sarung tangan, jarum suntik dan alat habis pakai',
                'count' => 78
            ],
            [
                'name' => 'Peralatan Rumah Sakit',
                'icon' => 'bi-hospital',
                'description' => 'Tempat tidur pasien, kursi roda dan peralatan RS',
                'count' => 25
            ],
        ];

        // Data dummy untuk produk unggulan
        $featuredProducts = [
            [
                'name' => 'Tensimeter Digital Omron',
                'price' => 'Rp 450.000',
                'image' => 'tensimeter-omron.jpg',
                'rating' => 4.8,
                'sold' => 150
            ],
            [
                'name' => 'Nebulizer Philips Portable',
                'price' => 'Rp 650.000',
                'image' => 'nebulizer-philips.jpg',
                'rating' => 4.9,
                'sold' => 89
            ],
            [
                'name' => 'Masker Medis 3 Ply (50 Pcs)',
                'price' => 'Rp 75.000',
                'image' => 'masker-3ply.jpg',
                'rating' => 4.7,
                'sold' => 342
            ],
            [
                'name' => 'Termometer Infrared',
                'price' => 'Rp 125.000',
                'image' => 'termometer-infrared.jpg',
                'rating' => 4.6,
                'sold' => 201
            ],
        ];

        return view('site.home', compact('title', 'categories', 'featuredProducts'));
    }

    public function about()
    {
        $title = 'Tentang Kami - ALKES SHOP';
        return view('site.about', compact('title'));
    }

    public function contact()
    {
        $title = 'Hubungi Kami - ALKES SHOP';
        return view('site.contact', compact('title'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
        ]);

        // Di sini Anda bisa menambahkan logika untuk menyimpan pesan ke database
        // atau mengirim email

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
