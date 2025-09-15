<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\Kota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan ini ada

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $query = Toko::with(['kota', 'user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_toko', 'like', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi_toko', 'like', '%' . $searchTerm . '%')
                    ->orWhere('alamat_toko', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_toko', $request->status);
        }

        // Filter by city
        if ($request->has('kota') && $request->kota) {
            $query->where('id_kota', $request->kota);
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Pagination with 10 items per page
        $toko = $query->paginate(10);

        return view('admin.toko.view-toko', compact('toko'));
    }

    public function create(Request $request)
    {
        $kota = Kota::orderBy('nama_kota')->get();
        $users = User::orderBy('name')->get();

        // Handle duplicate functionality
        $duplicateData = [];
        if ($request->has('duplicate')) {
            $duplicateData = $request->only([
                'nama_toko',
                'status_toko',
                'id_user',
                'id_kota',
                'alamat_toko',
                'deskripsi_toko'
            ]);
        }

        return view('admin.toko.add-toko', compact('kota', 'users', 'duplicateData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi_toko' => 'nullable|string',
            'alamat_toko' => 'nullable|string',
            'status_toko' => 'required|in:disetujui,ditolak,menunggu',
            'id_kota' => 'nullable|exists:kota,id_kota',
            'id_user' => 'nullable|exists:users,id_user',
        ], [
            'nama_toko.required' => 'Nama toko harus diisi.',
            'nama_toko.max' => 'Nama toko maksimal 100 karakter.',
            'status_toko.required' => 'Status toko harus dipilih.',
            'status_toko.in' => 'Status toko tidak valid.',
            'id_kota.exists' => 'Kota yang dipilih tidak valid.',
            'id_user.exists' => 'User yang dipilih tidak valid.',
        ]);

        try {
            Toko::create($request->all());
            return redirect()->route('admin.toko.index')->with('success', 'Data toko berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data toko: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Toko $toko)
    {
        $toko->load(['kota', 'user']);
        return response()->json([
            'success' => true,
            'toko' => $toko
        ]);
    }

    public function edit(Toko $toko)
    {
        $kota = Kota::orderBy('nama_kota')->get();
        $users = User::orderBy('name')->get();
        return view('admin.toko.edit-toko', compact('toko', 'kota', 'users'));
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi_toko' => 'nullable|string',
            'alamat_toko' => 'nullable|string',
            'status_toko' => 'required|in:disetujui,ditolak,menunggu',
            'id_kota' => 'nullable|exists:kota,id_kota',
            'id_user' => 'nullable|exists:users,id_user',
        ], [
            'nama_toko.required' => 'Nama toko harus diisi.',
            'nama_toko.max' => 'Nama toko maksimal 100 karakter.',
            'status_toko.required' => 'Status toko harus dipilih.',
            'status_toko.in' => 'Status toko tidak valid.',
            'id_kota.exists' => 'Kota yang dipilih tidak valid.',
            'id_user.exists' => 'User yang dipilih tidak valid.',
        ]);

        try {
            $toko->update($request->all());
            return redirect()->route('admin.toko.index')->with('success', 'Data toko berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data toko: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Toko $toko)
    {
        try {
            $namatoko = $toko->nama_toko;
            $toko->delete();
            return redirect()->route('admin.toko.index')->with('success', "Data toko '{$namatoko}' berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()->route('admin.toko.index')->with('error', 'Gagal menghapus data toko: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            // Get the same filtered data as index
            $query = Toko::with(['kota', 'user']);

            // Apply same filters as index
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('nama_toko', 'like', '%' . $searchTerm . '%')
                        ->orWhere('deskripsi_toko', 'like', '%' . $searchTerm . '%')
                        ->orWhere('alamat_toko', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->has('status') && $request->status) {
                $query->where('status_toko', $request->status);
            }

            if ($request->has('kota') && $request->kota) {
                $query->where('id_kota', $request->kota);
            }

            $query->orderBy('created_at', 'desc');

            // Get all data for PDF (no pagination)
            $toko = $query->get();

            // Cek apakah view exists
            if (!view()->exists('admin.toko.export-pdf-toko')) {
                return redirect()->back()->with('error', 'Template PDF tidak ditemukan');
            }

            // Generate PDF dengan konfigurasi yang lebih sederhana
            $pdf = Pdf::loadView('admin.toko.export-pdf-toko', compact('toko'));
            
            // Set paper dan orientasi
            $pdf->setPaper('a4', 'landscape');
            
            // Set options untuk PDF yang presisi
            $pdf->setOptions([
                'isPhpEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Arial',
                'dpi' => 72,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
            ]);

            $filename = 'laporan-data-toko-' . date('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengeksport PDF: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total' => Toko::count(),
            'disetujui' => Toko::where('status_toko', 'disetujui')->count(),
            'menunggu' => Toko::where('status_toko', 'menunggu')->count(),
            'ditolak' => Toko::where('status_toko', 'ditolak')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Bulk actions for multiple toko
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'toko_ids' => 'required|array',
            'toko_ids.*' => 'exists:toko,id_toko'
        ]);

        try {
            $count = 0;

            switch ($request->action) {
                case 'approve':
                    $count = Toko::whereIn('id_toko', $request->toko_ids)
                        ->update(['status_toko' => 'disetujui']);
                    $message = "{$count} toko berhasil disetujui";
                    break;

                case 'reject':
                    $count = Toko::whereIn('id_toko', $request->toko_ids)
                        ->update(['status_toko' => 'ditolak']);
                    $message = "{$count} toko berhasil ditolak";
                    break;

                case 'delete':
                    $count = Toko::whereIn('id_toko', $request->toko_ids)->delete();
                    $message = "{$count} toko berhasil dihapus";
                    break;
            }

            return redirect()->route('admin.toko.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.toko.index')->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }

    /**
     * Quick status change
     */
    public function changeStatus(Request $request, Toko $toko)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,menunggu'
        ]);

        try {
            $oldStatus = $toko->status_toko;
            $toko->update(['status_toko' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => "Status toko berhasil diubah dari {$oldStatus} ke {$request->status}",
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}