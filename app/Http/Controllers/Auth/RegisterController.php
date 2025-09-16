<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        // Get all cities for dropdown
        $kotas = Kota::orderBy('nama_kota')->get();

        return view('auth.register', [
            'title' => 'Daftar - ALKES SHOP',
            'kotas' => $kotas
        ]);
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Debug: Log semua input yang diterima
        Log::info('Registration attempt', [
            'email' => $request->email,
            'name' => $request->name,
            'has_required_fields' => [
                'name' => $request->has('name'),
                'email' => $request->has('email'),
                'password' => $request->has('password'),
                'password_confirmation' => $request->has('password_confirmation'),
            ],
            'ip' => $request->ip()
        ]);

        try {
            $validatedData = $this->validateRegistration($request);

            Log::info('Validation passed for registration', [
                'email' => $validatedData['email'],
                'name' => $validatedData['name']
            ]);

            // Create the user
            $user = $this->create($validatedData);

            // Log successful registration
            $this->logSuccessfulRegistration($request, $user);

            // Instead of auto-login, redirect to login page with success message
            return redirect()->route('login')
                ->with('success', 'Akun berhasil dibuat! Silakan masuk dengan email dan password yang telah Anda daftarkan.')
                ->with('registered_email', $user->email); // Optional: untuk pre-fill email di login form

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Registration validation failed', [
                'errors' => $e->errors(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration failed with exception', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
        }
    }

    /**
     * Validate the registration request.
     */
    protected function validateRegistration(Request $request)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:users,name',
                'regex:/^[a-zA-Z\s]+$/' // Only letters and spaces
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->letters()
                    ->numbers()
            ],
            'kontak' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s]+$/' // Numbers, +, -, and spaces only
            ],
            'alamat' => [
                'required',
                'string',
                'max:500'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01'
            ],
            'gender' => [
                'required',
                'in:laki-laki,perempuan'
            ],
            'id_kota' => [
                'required',
                'exists:kota,id_kota'
            ],
            'terms' => [
                'required',
                'accepted'
            ]
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 50 karakter.',
            'name.unique' => 'Nama sudah terdaftar. Gunakan nama lain.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Gunakan email lain atau masuk dengan akun yang sudah ada.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter dengan kombinasi huruf dan angka.',

            'kontak.required' => 'Nomor kontak wajib diisi.',
            'kontak.regex' => 'Format nomor kontak tidak valid.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',

            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.date' => 'Format tanggal tidak valid.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'date_of_birth.after' => 'Tanggal lahir tidak valid.',

            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',

            'id_kota.required' => 'Kota wajib dipilih.',
            'id_kota.exists' => 'Kota yang dipilih tidak valid.',

            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $user = User::create([
            'id_user' => Str::uuid(),
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
            'kontak' => trim($data['kontak']),
            'alamat' => trim($data['alamat']),
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'role' => 'customer', // Default role for registration
            'id_kota' => $data['id_kota'],
            'email_verified_at' => null, // Can be implemented later for email verification
        ]);

        Log::info('User created successfully', [
            'user_id' => $user->id_user,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role
        ]);

        return $user;
    }

    /**
     * Log successful registration.
     */
    protected function logSuccessfulRegistration(Request $request, $user)
    {
        Log::info('User registration completed successfully', [
            'user_id' => $user->id_user,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role,
            'id_kota' => $user->id_kota,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'registered_at' => now()
        ]);
    }
}
