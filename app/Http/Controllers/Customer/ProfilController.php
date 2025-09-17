<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Show user profile
     */
    public function show()
    {
        $user = Auth::user();
        return view('customer.profil.show', compact('user'));
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

        // Pastikan $user adalah instance dari User model
        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'kontak' => 'nullable|string|max:15', // Sesuaikan dengan field di User model
            'alamat' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date', // Sesuaikan dengan field di User model
            'gender' => 'nullable|in:L,P', // Sesuaikan dengan field di User model
            'id_kota' => 'nullable|exists:kota,id', // Sesuaikan dengan field di User model
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

        // Update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Remove password confirmation and current_password from validated data
        unset($validated['password_confirmation'], $validated['current_password']);

        try {
            // Update menggunakan method update() dari Eloquent Model
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