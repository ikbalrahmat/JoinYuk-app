<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforcePasswordPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Rute yang dikecualikan (proses logout dan ubah password)
            $exceptRoutes = [
                'profile.edit',
                'profile.update',
                'profile.password.update',
                'password.setup',
                'password.setup.update',
                'logout',
            ];

            if ($request->route() && !in_array($request->route()->getName(), $exceptRoutes)) {
                
                // Cek kadaluarsa 90 hari
                $expired = false;
                if ($user->password_updated_at && $user->password_updated_at->diffInDays(now()) > 90) {
                    $expired = true;
                }

                if ($user->requires_password_change || $expired) {
                    return redirect()->route('password.setup');
                }
            }
        }

        return $next($request);
    }
}
