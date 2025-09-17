<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MetodePembayaran;
use App\Models\NomorRekeningPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Show user profile
     */
    public function show()
    {
        $user = Auth::user();
        $paymentMethods = NomorRekeningPengguna::with('metodePembayaran')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();
            
        return view('customer.profil.show', compact('user', 'paymentMethods'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profil.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        // Add password validation if password is being changed
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', Password::min(8), 'confirmed'];
            $rules['current_password'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Check current password if changing password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto) {
                Storage::disk('public')->delete('users/' . $user->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('users', $filename, 'public');
            $validated['foto'] = $filename;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Remove password confirmation and current_password from validated data
        unset($validated['password_confirmation'], $validated['current_password']);

        try {
            $updateResult = $user->update($validated);
            
            if ($updateResult) {
                return redirect()->route('customer.profil.show')
                    ->with('success', 'Profil berhasil diperbarui.');
            } else {
                return back()->withErrors(['error' => 'Gagal memperbarui profil.']);
            }
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show payment methods management
     */
    public function paymentMethods()
    {
        $user = Auth::user();
        $metodePembayaran = MetodePembayaran::orderBy('metode_pembayaran')->get();
        $userPaymentMethods = NomorRekeningPengguna::with('metodePembayaran')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        return view('customer.profil.payment-methods', compact('user', 'metodePembayaran', 'userPaymentMethods'));
    }

    /**
     * Store new payment method
     */
    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'id_metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'nomor_rekening' => 'required|string|max:50'
        ]);

        $user = Auth::user();

        // Check if user already has this payment method
        $exists = NomorRekeningPengguna::where('id_user', $user->id_user)
            ->where('id_metode_pembayaran', $validated['id_metode_pembayaran'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki nomor rekening untuk metode pembayaran ini.'
            ]);
        }

        try {
            NomorRekeningPengguna::create([
                'id_nrp' => Str::uuid(),
                'nomor_rekening' => $validated['nomor_rekening'],
                'id_user' => $user->id_user,
                'id_metode_pembayaran' => $validated['id_metode_pembayaran']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Metode pembayaran berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan metode pembayaran: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update payment method
     */
    public function updatePaymentMethod(Request $request, $id)
    {
        $validated = $request->validate([
            'nomor_rekening' => 'required|string|max:50'
        ]);

        $user = Auth::user();
        $paymentMethod = NomorRekeningPengguna::where('id_user', $user->id_user)->findOrFail($id);

        try {
            $paymentMethod->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Nomor rekening berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui nomor rekening: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete payment method
     */
    public function deletePaymentMethod($id)
    {
        $user = Auth::user();
        $paymentMethod = NomorRekeningPengguna::where('id_user', $user->id_user)->findOrFail($id);

        try {
            $paymentMethod->delete();

            return response()->json([
                'success' => true,
                'message' => 'Metode pembayaran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus metode pembayaran: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show user addresses
     */
    public function addresses()
    {
        $user = Auth::user();
        // Assuming you have an Address model and relationship
        $addresses = collect(); // Placeholder - implement when Address model is ready

        return view('customer.profil.addresses', compact('user', 'addresses'));
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat_lengkap' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'is_default' => 'boolean'
        ]);

        $validated['id_user'] = Auth::id();

        // If this is set as default, unset other defaults
        if ($request->boolean('is_default')) {
            // Address::where('id_user', Auth::id())->update(['is_default' => false]);
        }

        // Address::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan.'
        ]);
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request, $id)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat_lengkap' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'is_default' => 'boolean'
        ]);

        // $address = Address::where('id_user', Auth::id())->findOrFail($id);

        if ($request->boolean('is_default')) {
            // Address::where('id_user', Auth::id())->update(['is_default' => false]);
        }

        // $address->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil diperbarui.'
        ]);
    }

    /**
     * Delete address
     */
    public function destroyAddress($id)
    {
        // $address = Address::where('id_user', Auth::id())->findOrFail($id);
        // $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dihapus.'
        ]);
    }
}