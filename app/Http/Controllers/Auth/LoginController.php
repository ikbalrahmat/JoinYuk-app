<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected function redirectTo()
    {
        // Ini tetap akan mengarahkan ke halaman home setelah login
        return '/home';
    }

    // Perbaikan pada method logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // PERBAIKAN: Ubah redirect ke rute 'welcome'
        return redirect()->route('welcome');
    }

    /**
     * Override authenticated to enforce single active session and lock checks.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_locked) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda terkunci karena terlalu banyak percobaan masuk gagal (3x). Hubungi Administrator.');
        }

        // Putuskan koneksi dari perangkat/browser lain
        Auth::logoutOtherDevices($request->password);
    }

    /**
     * Override failed login response to show generic message.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Kredensial yang Anda masukkan salah atau akun tidak ditemukan.'],
        ]);
    }

    /**
     * Get the maximum number of attempts to allow.
     */
    public function maxAttempts()
    {
        return 3;
    }

    /**
     * Override to lock the account permanently after max attempts.
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        $attempts = $this->limiter()->attempts($this->throttleKey($request));
        
        if ($attempts >= $this->maxAttempts()) {
            $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();
            if ($user && !$user->is_locked) {
                $user->update(['is_locked' => true]);
            }
            return true;
        }

        return false;
    }
}
