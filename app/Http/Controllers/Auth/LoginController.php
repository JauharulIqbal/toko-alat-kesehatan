<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the user has too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Attempt to log the user in
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }
            
            // Get the authenticated user
            $user = Auth::user();
            
            // Log the login
            $this->logSuccessfulLogin($request, $user);
            
            // Clear login attempts
            $this->clearLoginAttempts($request);
            
            // Redirect based on role
            return $this->authenticated($request, $user);
        }

        // If login fails, increment attempts and return error
        $this->incrementLoginAttempts($request);
        
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     */
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(
            $this->credentials($request),
            $request->boolean('remember') // Use boolean() method yang lebih reliable
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        // Pastikan user memiliki role yang valid
        $validRoles = ['admin', 'penjual', 'customer'];
        
        if (!in_array($user->role, $validRoles)) {
            Auth::logout();
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect()->route('login')
                ->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }

        // Set session untuk mencegah akses balik ke site
        if ($request->hasSession()) {
            $request->session()->put('user_authenticated', true);
            $request->session()->put('user_role', $user->role);
        }

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang di Admin Panel, ' . ($user->name ?? 'Admin'));
            case 'penjual':
                return redirect()->intended(route('seller.dashboard'))
                    ->with('success', 'Selamat datang di Seller Dashboard, ' . ($user->name ?? 'Penjual'));
            case 'customer':
                return redirect()->intended(route('customer.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . ($user->name ?? 'Customer'));
            default:
                Auth::logout();
                if ($request->hasSession()) {
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
                return redirect()->route('login')
                    ->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }
    }

    /**
     * Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [
                'Email atau password yang Anda masukkan salah. Silakan coba lagi.'
            ],
        ]);
    }

    /**
     * Log a successful login.
     */
    protected function logSuccessfulLogin(Request $request, $user)
    {
        Log::info('User logged in', [
            'user_id' => $user->id_user ?? $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
    }

    /**
     * Determine if the user has too many failed login attempts.
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request), 5
        );
    }

    /**
     * Increment the login attempts for the user.
     */
    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request), 60);
    }

    /**
     * Clear the login locks for the given user credentials.
     */
    protected function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Fire an event when a lockout occurs.
     */
    protected function fireLockoutEvent(Request $request)
    {
        // You can dispatch an event here if needed
    }

    /**
     * Redirect the user after determining they are locked out.
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => [
                'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
            ],
        ])->status(429);
    }

    /**
     * Get the throttle key for the given request.
     */
    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log the logout
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id_user ?? $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('site.home')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}