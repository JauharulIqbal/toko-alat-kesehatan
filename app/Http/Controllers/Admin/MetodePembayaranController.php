<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = MetodePembayaran::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('metode_pembayaran', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by tipe pembayaran
        if ($request->filled('tipe')) {
            $query->where('tipe_pembayaran', $request->tipe);
        }

        // Sort by created_at desc by default
        $query->orderBy('created_at', 'desc');

        $metodePembayaran = $query->paginate(10)->appends($request->query());

        return view('admin.metode-pembayaran.view-metode-pembayaran', compact('metodePembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.metode-pembayaran.add-metode-pembayaran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string|max:255',
            'tipe_pembayaran' => 'required|in:prepaid,postpaid',
        ], [
            'metode_pembayaran.required' => 'Nama metode pembayaran wajib diisi',
            'metode_pembayaran.max' => 'Nama metode pembayaran maksimal 255 karakter',
            'tipe_pembayaran.required' => 'Tipe pembayaran wajib dipilih',
            'tipe_pembayaran.in' => 'Tipe pembayaran harus prepaid atau postpaid',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            MetodePembayaran::create([
                'metode_pembayaran' => $request->metode_pembayaran,
                'tipe_pembayaran' => $request->tipe_pembayaran,
            ]);

            return redirect()->route('admin.metode-pembayaran.index')
                ->with('success', 'Metode pembayaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menambahkan metode pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MetodePembayaran $metodePembayaran): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'metodePembayaran' => $metodePembayaran->load('pembayarans'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail metode pembayaran'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodePembayaran $metodePembayaran): View
    {
        return view('admin.metode-pembayaran.edit-metode-pembayaran', compact('metodePembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodePembayaran $metodePembayaran): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string|max:255',
            'tipe_pembayaran' => 'required|in:prepaid,postpaid',
        ], [
            'metode_pembayaran.required' => 'Nama metode pembayaran wajib diisi',
            'metode_pembayaran.max' => 'Nama metode pembayaran maksimal 255 karakter',
            'tipe_pembayaran.required' => 'Tipe pembayaran wajib dipilih',
            'tipe_pembayaran.in' => 'Tipe pembayaran harus prepaid atau postpaid',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $metodePembayaran->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'tipe_pembayaran' => $request->tipe_pembayaran,
            ]);

            return redirect()->route('admin.metode-pembayaran.index')
                ->with('success', 'Metode pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui metode pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodePembayaran $metodePembayaran): RedirectResponse
    {
        try {
            // Check if metode pembayaran is being used
            if ($metodePembayaran->pembayarans()->count() > 0) {
                return back()->with('error', 'Metode pembayaran tidak dapat dihapus karena masih digunakan dalam transaksi pembayaran');
            }

            $metodePembayaran->delete();

            return redirect()->route('admin.metode-pembayaran.index')
                ->with('success', 'Metode pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus metode pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics data for metode pembayaran
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => MetodePembayaran::count(),
                'prepaid' => MetodePembayaran::where('tipe_pembayaran', 'prepaid')->count(),
                'postpaid' => MetodePembayaran::where('tipe_pembayaran', 'postpaid')->count(),
                'used' => MetodePembayaran::has('pembayarans')->count(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat statistik'
            ], 500);
        }
    }

    /**
     * Bulk action for multiple records
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:metode_pembayaran,id_metode_pembayaran'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        }

        try {
            $metodePembayarans = MetodePembayaran::whereIn('id_metode_pembayaran', $request->ids);

            switch ($request->action) {
                case 'delete':
                    // Check if any metode pembayaran is being used
                    $usedCount = $metodePembayarans->has('pembayarans')->count();
                    if ($usedCount > 0) {
                        return response()->json([
                            'success' => false,
                            'message' => "Terdapat {$usedCount} metode pembayaran yang masih digunakan dan tidak dapat dihapus"
                        ], 422);
                    }

                    $deletedCount = $metodePembayarans->delete();
                    
                    return response()->json([
                        'success' => true,
                        'message' => "Berhasil menghapus {$deletedCount} metode pembayaran"
                    ]);

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Aksi tidak valid'
                    ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan aksi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check for duplicate metode pembayaran
     */
    public function checkDuplicate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string',
            'exclude_id' => 'nullable|exists:metode_pembayaran,id_metode_pembayaran'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        }

        try {
            $query = MetodePembayaran::where('metode_pembayaran', $request->metode_pembayaran);
            
            if ($request->filled('exclude_id')) {
                $query->where('id_metode_pembayaran', '!=', $request->exclude_id);
            }

            $exists = $query->exists();

            return response()->json([
                'success' => true,
                'exists' => $exists,
                'message' => $exists ? 'Metode pembayaran sudah ada' : 'Metode pembayaran tersedia'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa duplikasi'
            ], 500);
        }
    }
}