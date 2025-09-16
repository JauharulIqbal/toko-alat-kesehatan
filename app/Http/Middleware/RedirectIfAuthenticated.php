<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect based on user role
                return redirect($this->redirectPath($user->role ?? 'customer'));
            }
        }

        return $next($request);
    }

    /**
     * Get redirect path based on user role
     */
    private function redirectPath(string $role): string
    {
        return match ($role) {
            'admin' => '/admin/dashboard',
            'penjual' => '/penjual/dashboard', 
            'customer' => '/customer/dashboard',
            default => '/',
        };
    }
}