<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login - ALKES SHOP'
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Check rate limiting
        $key = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }

        // Attempt to authenticate user
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                // Clear rate limiting on successful login
                RateLimiter::clear($key);
                
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();
                
                $user = Auth::user();
                
                // Enhanced logging for debugging
                Log::info('Login Success', [
                    'user_id' => $user->id_user,
                    'email' => $user->email,
                    'role' => $user->role,
                    'name' => $user->name,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => session()->getId(),
                    'auth_check' => Auth::check(),
                ]);

                // Check if user has a role
                if (empty($user->role)) {
                    Auth::logout();
                    throw ValidationException::withMessages([
                        'email' => 'Akun Anda belum memiliki role. Silakan hubungi administrator.',
                    ]);
                }

                // Redirect based on user role with error handling
                return $this->redirectBasedOnRole($user->role, $request);
            }
        } catch (\Exception $e) {
            Log::error('Login Error', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ])->withInput($request->except('password'));
        }

        // Increment rate limiting on failed login
        RateLimiter::hit($key, 300); // 5 minutes

        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        throw ValidationException::withMessages([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id_user ?? 'unknown',
                'email' => $user->email,
                'role' => $user->role ?? 'unknown',
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('site.home')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole(string $role, Request $request)
    {
        $welcomeMessage = 'Selamat datang! Login berhasil.';
        
        try {
            switch ($role) {
                case 'admin':
                    // Check if admin dashboard route exists
                    if (!route('admin.dashboard', [], false)) {
                        throw new \Exception('Admin dashboard route not found');
                    }
                    
                    Log::info('Redirecting to admin dashboard', ['user_role' => $role]);
                    return redirect()->route('admin.dashboard')
                        ->with('success', $welcomeMessage . ' Selamat datang di Admin Dashboard.');
                        
                case 'penjual':
                    Log::info('Redirecting to penjual dashboard', ['user_role' => $role]);
                    return redirect()->route('penjual.dashboard')
                        ->with('success', $welcomeMessage . ' Selamat datang di Penjual Dashboard.');
                        
                case 'customer':
                    Log::info('Redirecting to customer dashboard', ['user_role' => $role]);
                    return redirect()->route('customer.dashboard')
                        ->with('success', $welcomeMessage . ' Selamat datang di Customer Dashboard.');
                        
                default:
                    Log::warning('Unknown role detected during login', ['role' => $role]);
                    return redirect()->route('site.home')
                        ->with('warning', 'Role tidak dikenali. Anda berhasil login namun perlu verifikasi role.');
            }
        } catch (\Exception $e) {
            // Jika terjadi error saat redirect, log dan redirect ke home
            Log::error('Error during role-based redirect', [
                'role' => $role,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('site.home')
                ->with('error', 'Login berhasil namun terjadi error redirect. Silakan coba akses dashboard manual.');
        }
    }
}