<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['kota'])
            ->whereIn('role', ['penjual', 'customer'])
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('kontak', 'like', '%' . $search . '%');
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter kota
        if ($request->filled('kota')) {
            $query->where('id_kota', $request->kota);
        }

        // Filter gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $pengguna = $query->paginate(10)->appends($request->query());

        return view('admin.pengguna.view-pengguna', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kota = Kota::orderBy('nama_kota')->get();
        return view('admin.pengguna.add-pengguna', compact('kota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:laki-laki,perempuan',
            'role' => 'required|in:penjual,customer',
            'id_kota' => 'nullable|exists:kota,id_kota',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.unique' => 'Nama pengguna sudah terdaftar.',
            'name.max' => 'Nama pengguna maksimal 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kontak.max' => 'Kontak maksimal 20 karakter.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'id_kota.exists' => 'Kota yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'kontak' => $request->kontak,
                'alamat' => $request->alamat,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'role' => $request->role,
                'id_kota' => $request->id_kota,
                'email_verified_at' => now(),
            ]);

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengguna = User::with(['kota', 'tokos', 'pesanans'])
            ->whereIn('role', ['penjual', 'customer'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'pengguna' => $pengguna
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $pengguna = User::whereIn('role', ['penjual', 'customer'])->findOrFail($id);
    
    // Force cast date_of_birth to Carbon if it's not null
    if ($pengguna->date_of_birth && !$pengguna->date_of_birth instanceof \Carbon\Carbon) {
        if (is_numeric($pengguna->date_of_birth)) {
            $pengguna->date_of_birth = \Carbon\Carbon::createFromTimestamp($pengguna->date_of_birth);
        } else {
            $pengguna->date_of_birth = \Carbon\Carbon::parse($pengguna->date_of_birth);
        }
    }
    
    $kota = Kota::orderBy('nama_kota')->get();
    return view('admin.pengguna.edit-pengguna', compact('pengguna', 'kota'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengguna = User::whereIn('role', ['penjual', 'customer'])->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($pengguna->id_user, 'id_user')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($pengguna->id_user, 'id_user')
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:laki-laki,perempuan',
            'role' => 'required|in:penjual,customer',
            'id_kota' => 'nullable|exists:kota,id_kota',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.unique' => 'Nama pengguna sudah terdaftar.',
            'name.max' => 'Nama pengguna maksimal 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kontak.max' => 'Kontak maksimal 20 karakter.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'id_kota.exists' => 'Kota yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'kontak' => $request->kontak,
                'alamat' => $request->alamat,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'role' => $request->role,
                'id_kota' => $request->id_kota,
            ];

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $pengguna->update($updateData);

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pengguna = User::whereIn('role', ['penjual', 'customer'])->findOrFail($id);

            // Cek apakah pengguna memiliki toko atau pesanan
            if ($pengguna->tokos()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus pengguna yang memiliki toko!');
            }

            if ($pengguna->pesanans()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus pengguna yang memiliki riwayat pesanan!');
            }

            $pengguna->delete();

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Export data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = User::with(['kota'])
            ->whereIn('role', ['penjual', 'customer'])
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('kontak', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('kota')) {
            $query->where('id_kota', $request->kota);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $pengguna = $query->get();

        $pdf = Pdf::loadView('admin.pengguna.export-pdf-pengguna', compact('pengguna'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-data-pengguna-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Get statistics data
     */
    public function getStatistics()
    {
        $total = User::whereIn('role', ['penjual', 'customer'])->count();
        $penjual = User::where('role', 'penjual')->count();
        $customer = User::where('role', 'customer')->count();
        $lakiLaki = User::whereIn('role', ['penjual', 'customer'])->where('gender', 'laki-laki')->count();
        $perempuan = User::whereIn('role', ['penjual', 'customer'])->where('gender', 'perempuan')->count();

        return response()->json([
            'total' => $total,
            'penjual' => $penjual,
            'customer' => $customer,
            'laki_laki' => $lakiLaki,
            'perempuan' => $perempuan,
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'Pilih data terlebih dahulu']);
        }

        try {
            switch ($action) {
                case 'delete':
                    $users = User::whereIn('id_user', $ids)->whereIn('role', ['penjual', 'customer']);

                    // Check if any user has related data
                    foreach ($users->get() as $user) {
                        if ($user->tokos()->count() > 0 || $user->pesanans()->count() > 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Beberapa pengguna memiliki data terkait dan tidak dapat dihapus'
                            ]);
                        }
                    }

                    $users->delete();
                    return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);

                default:
                    return response()->json(['success' => false, 'message' => 'Aksi tidak valid']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Check duplicate name or email
     */
    public function checkDuplicate(Request $request)
    {
        $field = $request->field;
        $value = $request->value;
        $exclude_id = $request->exclude_id;

        $query = User::where($field, $value);

        if ($exclude_id) {
            $query->where('id_user', '!=', $exclude_id);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}