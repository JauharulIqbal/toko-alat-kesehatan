<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; 

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kategori::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        // Get paginated results
        $kategori = $query->latest()->paginate(10);

        // For AJAX requests (modal detail)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $kategori
            ]);
        }

        return view('admin.kategori-produk.view-kategori', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori-produk.add-kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.string' => 'Nama kategori harus berupa teks',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada, gunakan nama lain'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $kategori = new Kategori();
            $kategori->id_kategori = Str::uuid();
            $kategori->nama_kategori = trim($request->nama_kategori);
            $kategori->save();

            return redirect()->route('admin.kategori-produk.index')
                ->with('success', 'Kategori produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Kategori $kategoriProduk)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'kategori' => $kategoriProduk->load(['produk' => function($query) {
                    $query->take(5); // Limit produk yang ditampilkan
                }])
            ]);
        }

        return view('admin.kategori-produk.detail-kategori', compact('kategoriProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategoriProduk)
    {
        return view('admin.kategori-produk.edit-kategori', compact('kategoriProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategoriProduk)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategoriProduk->id_kategori . ',id_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.string' => 'Nama kategori harus berupa teks',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada, gunakan nama lain'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $kategoriProduk->update([
                'nama_kategori' => trim($request->nama_kategori)
            ]);

            return redirect()->route('admin.kategori-produk.index')
                ->with('success', 'Kategori produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategoriProduk)
    {
        try {
            // Check if kategori has products
            $produkCount = $kategoriProduk->produk()->count();
            
            if ($produkCount > 0) {
                return back()->with('error', "Kategori tidak dapat dihapus karena masih memiliki {$produkCount} produk.");
            }

            $kategoriProduk->delete();

            return redirect()->route('admin.kategori-produk.index')
                ->with('success', 'Kategori produk berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): JsonResponse
    {
        $totalKategori = Kategori::count();
        $kategoriTerbaru = Kategori::whereDate('created_at', today())->count();
        $kategoriWithProducts = Kategori::has('produk')->count();
        $kategoriEmpty = Kategori::doesntHave('produk')->count();

        return response()->json([
            'total_kategori' => $totalKategori,
            'kategori_terbaru' => $kategoriTerbaru,
            'kategori_with_products' => $kategoriWithProducts,
            'kategori_empty' => $kategoriEmpty,
        ]);
    }

    /**
     * Bulk action for multiple categories
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete',
            'kategori_ids' => 'required|array',
            'kategori_ids.*' => 'exists:kategori,id_kategori'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            switch ($request->action) {
                case 'delete':
                    $kategoriIds = $request->kategori_ids;
                    $kategoriesWithProducts = Kategori::whereIn('id_kategori', $kategoriIds)
                        ->has('produk')
                        ->count();
                    
                    if ($kategoriesWithProducts > 0) {
                        return back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk.');
                    }
                    
                    $deletedCount = Kategori::whereIn('id_kategori', $kategoriIds)->delete();
                    return back()->with('success', "Berhasil menghapus {$deletedCount} kategori.");
                    
                default:
                    return back()->with('error', 'Aksi tidak valid.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }
}