<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JasaPengiriman;
use Illuminate\Http\Request;

class JasaPengirimanController extends Controller
{
    public function index(Request $request)
    {
        $query = JasaPengiriman::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_jasa_pengiriman', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by biaya range
        if ($request->has('biaya_min') && $request->biaya_min) {
            $query->where('biaya_pengiriman', '>=', $request->biaya_min);
        }

        if ($request->has('biaya_max') && $request->biaya_max) {
            $query->where('biaya_pengiriman', '<=', $request->biaya_max);
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Pagination with 10 items per page
        $jasaPengiriman = $query->paginate(10);

        return view('admin.jasa-pengiriman.view-jasa-pengiriman', compact('jasaPengiriman'));
    }

    public function create()
    {
        return view('admin.jasa-pengiriman.add-jasa-pengiriman');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jasa_pengiriman' => 'required|string|max:100',
            'biaya_pengiriman' => 'required|numeric|min:0|max:999999999999.99',
        ], [
            'nama_jasa_pengiriman.required' => 'Nama jasa pengiriman harus diisi.',
            'nama_jasa_pengiriman.max' => 'Nama jasa pengiriman maksimal 100 karakter.',
            'biaya_pengiriman.required' => 'Biaya pengiriman harus diisi.',
            'biaya_pengiriman.numeric' => 'Biaya pengiriman harus berupa angka.',
            'biaya_pengiriman.min' => 'Biaya pengiriman tidak boleh negatif.',
            'biaya_pengiriman.max' => 'Biaya pengiriman terlalu besar.',
        ]);

        try {
            JasaPengiriman::create($request->all());
            return redirect()->route('admin.jasa-pengiriman.index')->with('success', 'Data jasa pengiriman berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data jasa pengiriman: ' . $e->getMessage())->withInput();
        }
    }

    public function show(JasaPengiriman $jasaPengiriman)
    {
        return response()->json([
            'success' => true,
            'jasa_pengiriman' => $jasaPengiriman
        ]);
    }

    public function edit(JasaPengiriman $jasaPengiriman)
    {
        return view('admin.jasa-pengiriman.edit-jasa-pengiriman', compact('jasaPengiriman'));
    }

    public function update(Request $request, JasaPengiriman $jasaPengiriman)
    {
        $request->validate([
            'nama_jasa_pengiriman' => 'required|string|max:100',
            'biaya_pengiriman' => 'required|numeric|min:0|max:999999999999.99',
        ], [
            'nama_jasa_pengiriman.required' => 'Nama jasa pengiriman harus diisi.',
            'nama_jasa_pengiriman.max' => 'Nama jasa pengiriman maksimal 100 karakter.',
            'biaya_pengiriman.required' => 'Biaya pengiriman harus diisi.',
            'biaya_pengiriman.numeric' => 'Biaya pengiriman harus berupa angka.',
            'biaya_pengiriman.min' => 'Biaya pengiriman tidak boleh negatif.',
            'biaya_pengiriman.max' => 'Biaya pengiriman terlalu besar.',
        ]);

        try {
            $jasaPengiriman->update($request->all());
            return redirect()->route('admin.jasa-pengiriman.index')->with('success', 'Data jasa pengiriman berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data jasa pengiriman: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(JasaPengiriman $jasaPengiriman)
    {
        try {
            $namaJasa = $jasaPengiriman->nama_jasa_pengiriman;
            $jasaPengiriman->delete();
            return redirect()->route('admin.jasa-pengiriman.index')->with('success', "Data jasa pengiriman '{$namaJasa}' berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()->route('admin.jasa-pengiriman.index')->with('error', 'Gagal menghapus data jasa pengiriman: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total' => JasaPengiriman::count(),
            'avg_biaya' => JasaPengiriman::avg('biaya_pengiriman'),
            'min_biaya' => JasaPengiriman::min('biaya_pengiriman'),
            'max_biaya' => JasaPengiriman::max('biaya_pengiriman'),
        ];

        return response()->json($stats);
    }

    /**
     * Bulk actions for multiple jasa pengiriman
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'jasa_pengiriman_ids' => 'required|array',
            'jasa_pengiriman_ids.*' => 'exists:jasa_pengiriman,id_jasa_pengiriman'
        ]);

        try {
            $count = 0;

            if ($request->action === 'delete') {
                $count = JasaPengiriman::whereIn('id_jasa_pengiriman', $request->jasa_pengiriman_ids)->delete();
                $message = "{$count} jasa pengiriman berhasil dihapus";
            }

            return redirect()->route('admin.jasa-pengiriman.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.jasa-pengiriman.index')->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }
}
