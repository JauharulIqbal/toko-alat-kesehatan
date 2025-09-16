<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            Log::warning('Unauthenticated user trying to access protected route', [
                'route' => $request->route()->getName(),
                'url' => $request->url()
            ]);
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();
        
        // Log for debugging
        Log::info('CheckRole middleware accessed', [
            'user_id' => $user->id ?? $user->id_user ?? 'unknown',
            'user_role' => $user->role ?? 'no_role',
            'required_roles' => $roles,
            'route' => $request->route()->getName()
        ]);
        
        // Check if user has the required role
        if (!in_array($user->role, $roles)) {
            Log::warning('User role access denied', [
                'user_role' => $user->role,
                'required_roles' => $roles,
                'route' => $request->route()->getName()
            ]);
            
            // Redirect based on user's actual role with proper route names
            return $this->redirectBasedOnRole($user->role);
        }

        return $next($request);
    }

    /**
     * Redirect user based on their role using route names
     *
     * @param string $role
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole(?string $role)
    {
        $message = 'Anda tidak memiliki akses ke halaman ini.';
        
        try {
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('error', $message);
                case 'penjual':
                    return redirect()->route('penjual.dashboard')->with('error', $message);
                case 'customer':
                    return redirect()->route('customer.dashboard')->with('error', $message);
                default:
                    Log::warning('Unknown role in CheckRole middleware', ['role' => $role]);
                    return redirect()->route('site.home')->with('error', $message . ' Role tidak dikenali.');
            }
        } catch (\Exception $e) {
            Log::error('Error in CheckRole redirect', [
                'role' => $role,
                'error' => $e->getMessage()
            ]);
            
            // Fallback to home if route doesn't exist
            return redirect()->route('site.home')->with('error', 'Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }
    }
}