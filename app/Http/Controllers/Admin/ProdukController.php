<?php

namespace App\Http\Controllers\Admin;

use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PDF;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'toko']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Store filter
        if ($request->filled('toko')) {
            $query->where('id_toko', $request->toko);
        }

        // Stock filter
        if ($request->filled('stok')) {
            switch ($request->stok) {
                case 'habis':
                    $query->where('stok', 0);
                    break;
                case 'menipis':
                    $query->where('stok', '>', 0)->where('stok', '<=', 10);
                    break;
                case 'tersedia':
                    $query->where('stok', '>', 10);
                    break;
            }
        }

        $produk = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.produk.view-produk', compact('produk'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $tokos = Toko::where('status_toko', 'disetujui')->orderBy('nama_toko')->get();

        return view('admin.produk.add-produk', compact('kategoris', 'tokos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_toko' => 'required|exists:toko,id_toko',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'nama_produk',
            'deskripsi',
            'harga',
            'stok',
            'id_kategori',
            'id_toko'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('produk', $imageName, 'public');
            $data['gambar_produk'] = $imagePath;
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        $produk->load(['kategori', 'toko']);

        return response()->json([
            'success' => true,
            'produk' => $produk
        ]);
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $tokos = Toko::where('status_toko', 'disetujui')->orderBy('nama_toko')->get();

        return view('admin.produk.edit-produk', compact('produk', 'kategoris', 'tokos'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_toko' => 'required|exists:toko,id_toko',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'nama_produk',
            'deskripsi',
            'harga',
            'stok',
            'id_kategori',
            'id_toko'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar_produk')) {
            // Delete old image if exists
            if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            $image = $request->file('gambar_produk');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('produk', $imageName, 'public');
            $data['gambar_produk'] = $imagePath;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        // Delete image if exists
        if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Produk::with(['kategori', 'toko']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('toko')) {
            $query->where('id_toko', $request->toko);
        }

        if ($request->filled('stok')) {
            switch ($request->stok) {
                case 'habis':
                    $query->where('stok', 0);
                    break;
                case 'menipis':
                    $query->where('stok', '>', 0)->where('stok', '<=', 10);
                    break;
                case 'tersedia':
                    $query->where('stok', '>', 10);
                    break;
            }
        }

        $produk = $query->orderBy('created_at', 'desc')->get();

        return view('admin.produk.export-pdf-produk', compact('produk'));
    }

    public function getStatistics()
    {
        $totalProduk = Produk::count();
        $stokHabis = Produk::where('stok', 0)->count();
        $stokMenupis = Produk::where('stok', '>', 0)->where('stok', '<=', 10)->count();
        $totalNilaiStok = Produk::selectRaw('SUM(harga * stok) as total')->first()->total ?? 0;

        return response()->json([
            'total_produk' => $totalProduk,
            'stok_habis' => $stokHabis,
            'stok_menipis' => $stokMenupis,
            'total_nilai_stok' => number_format($totalNilaiStok, 0, ',', '.')
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_stock',
            'ids' => 'required|array',
            'ids.*' => 'exists:produk,id_produk'
        ]);

        $produk = Produk::whereIn('id_produk', $request->ids);

        switch ($request->action) {
            case 'delete':
                $produk->each(function ($item) {
                    if ($item->gambar_produk && Storage::disk('public')->exists($item->gambar_produk)) {
                        Storage::disk('public')->delete($item->gambar_produk);
                    }
                });
                $produk->delete();
                return response()->json(['message' => 'Produk berhasil dihapus!']);

            case 'update_stock':
                $request->validate(['new_stock' => 'required|integer|min:0']);
                $produk->update(['stok' => $request->new_stock]);
                return response()->json(['message' => 'Stok produk berhasil diperbarui!']);
        }

        return response()->json(['message' => 'Aksi berhasil dijalankan!']);
    }
}
