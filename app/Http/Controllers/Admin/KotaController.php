<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kota;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kota::with(['users', 'tokos']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kota', 'like', "%{$search}%")
                    ->orWhere('kode_kota', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'nama_kota_asc');
        switch ($sort) {
            case 'nama_kota_desc':
                $query->orderBy('nama_kota', 'desc');
                break;
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('nama_kota', 'asc');
                break;
        }

        $kota = $query->paginate(10);

        return view('admin.kota.view-kota', compact('kota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kota.add-kota');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kota' => 'required|string|max:100|unique:kota,nama_kota',
            'kode_kota' => 'nullable|string|max:20|unique:kota,kode_kota',
        ], [
            'nama_kota.required' => 'Nama kota wajib diisi',
            'nama_kota.max' => 'Nama kota maksimal 100 karakter',
            'nama_kota.unique' => 'Nama kota sudah ada dalam database',
            'kode_kota.max' => 'Kode kota maksimal 20 karakter',
            'kode_kota.unique' => 'Kode kota sudah ada dalam database',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kota = new Kota();
            $kota->nama_kota = $request->nama_kota;
            $kota->kode_kota = $request->kode_kota;
            $kota->save();

            return redirect()->route('admin.kota.index')
                ->with('success', 'Data kota berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kota = Kota::with(['users', 'tokos'])->findOrFail($id);

            // For AJAX requests
            if (request()->ajax() || request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'kota' => [
                        'id_kota' => $kota->id_kota,
                        'nama_kota' => $kota->nama_kota,
                        'kode_kota' => $kota->kode_kota,
                        'created_at' => $kota->created_at->toISOString(),
                        'updated_at' => $kota->updated_at->toISOString(),
                        'users_count' => $kota->users->count(),
                        'tokos_count' => $kota->tokos->count(),
                    ]
                ]);
            }

            // For regular requests (if you have a show view)
            return view('admin.kota.show', compact('kota'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->ajax() || request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kota tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.kota.index')
                ->with('error', 'Data kota tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('Error in KotaController@show: ' . $e->getMessage());

            if (request()->ajax() || request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.kota.index')
                ->with('error', 'Terjadi kesalahan sistem');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $kota = Kota::findOrFail($id);
            return view('admin.kota.edit-kota', compact('kota'));
        } catch (\Exception $e) {
            return redirect()->route('admin.kota.index')
                ->with('error', 'Data kota tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kota = Kota::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama_kota' => 'required|string|max:100|unique:kota,nama_kota,' . $id . ',id_kota',
                'kode_kota' => 'nullable|string|max:20|unique:kota,kode_kota,' . $id . ',id_kota',
            ], [
                'nama_kota.required' => 'Nama kota wajib diisi',
                'nama_kota.max' => 'Nama kota maksimal 100 karakter',
                'nama_kota.unique' => 'Nama kota sudah ada dalam database',
                'kode_kota.max' => 'Kode kota maksimal 20 karakter',
                'kode_kota.unique' => 'Kode kota sudah ada dalam database',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $kota->update([
                'nama_kota' => $request->nama_kota,
                'kode_kota' => $request->kode_kota,
            ]);

            return redirect()->route('admin.kota.index')
                ->with('success', 'Data kota berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kota = Kota::findOrFail($id);

            // Check if kota is being used by users or tokos
            $usersCount = $kota->users()->count();
            $tokosCount = $kota->tokos()->count();

            if ($usersCount > 0 || $tokosCount > 0) {
                return redirect()->back()
                    ->with('error', "Kota tidak dapat dihapus karena masih digunakan oleh {$usersCount} pengguna dan {$tokosCount} toko");
            }

            $kotaName = $kota->nama_kota;
            $kota->delete();

            return redirect()->route('admin.kota.index')
                ->with('success', "Data kota '{$kotaName}' berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics data
     */
    public function getStatistics()
    {
        try {
            $totalKota = Kota::count();
            $kotaWithUsers = Kota::whereHas('users')->count();
            $kotaWithTokos = Kota::whereHas('tokos')->count();
            $recentKota = Kota::where('created_at', '>=', now()->subDays(30))->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_kota' => $totalKota,
                    'kota_with_users' => $kotaWithUsers,
                    'kota_with_tokos' => $kotaWithTokos,
                    'recent_kota' => $recentKota,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik'
            ], 500);
        }
    }

    /**
     * Bulk action (delete multiple)
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:kota,id_kota'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        }

        try {
            $ids = $request->ids;
            $action = $request->action;

            if ($action === 'delete') {
                // Check if any kota is being used
                $kotas = Kota::whereIn('id_kota', $ids)->get();
                $cannotDelete = [];

                foreach ($kotas as $kota) {
                    $usersCount = $kota->users()->count();
                    $tokosCount = $kota->tokos()->count();

                    if ($usersCount > 0 || $tokosCount > 0) {
                        $cannotDelete[] = $kota->nama_kota;
                    }
                }

                if (!empty($cannotDelete)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kota berikut tidak dapat dihapus karena masih digunakan: ' . implode(', ', $cannotDelete)
                    ], 422);
                }

                $deleted = Kota::whereIn('id_kota', $ids)->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menghapus {$deleted} data kota"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check duplicate name/code
     */
    public function checkDuplicate(Request $request)
    {
        $namaKota = $request->nama_kota;
        $kodeKota = $request->kode_kota;
        $excludeId = $request->exclude_id;

        $duplicates = [];
        $hasDuplicates = false;

        // Check nama kota
        if ($namaKota) {
            $query = Kota::where('nama_kota', $namaKota);
            if ($excludeId) {
                $query->where('id_kota', '!=', $excludeId);
            }
            if ($query->exists()) {
                $duplicates[] = 'Nama kota sudah digunakan';
                $hasDuplicates = true;
            }
        }

        // Check kode kota
        if ($kodeKota) {
            $query = Kota::where('kode_kota', $kodeKota);
            if ($excludeId) {
                $query->where('id_kota', '!=', $excludeId);
            }
            if ($query->exists()) {
                $duplicates[] = 'Kode kota sudah digunakan';
                $hasDuplicates = true;
            }
        }

        return response()->json([
            'success' => true,
            'has_duplicates' => $hasDuplicates,
            'duplicates' => $duplicates
        ]);
    }
}
