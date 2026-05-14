<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        // 1. Cek apakah password baru sama dengan 3 password terakhir
        $histories = $user->passwordHistories()->latest()->take(3)->get();
        foreach ($histories as $history) {
            if (Hash::check($validated['password'], $history->password)) {
                return back()->withErrors(['password' => 'Anda tidak boleh menggunakan kembali 3 password terakhir Anda.'], 'updatePassword')->withInput();
            }
        }

        // 2. Update user
        $newPasswordHash = Hash::make($validated['password']);
        $user->update([
            'password' => $newPasswordHash,
            'password_updated_at' => now(),
            'requires_password_change' => false,
            'is_locked' => false, // jika tadinya terkunci karena suatu hal
        ]);

        // 3. Simpan ke history
        $user->passwordHistories()->create([
            'password' => $newPasswordHash
        ]);

        return back()->with('status', 'password-updated')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Show the password setup form for first-time login or expired passwords.
     */
    public function setup(Request $request)
    {
        // Hanya tampilkan jika user memang butuh ganti password atau expired
        $user = $request->user();
        $expired = false;
        
        if ($user->password_updated_at && $user->password_updated_at->diffInDays(now()) > 90) {
            $expired = true;
        }

        if (!$user->requires_password_change && !$expired) {
            return redirect()->route('home'); // Jika tidak butuh, arahkan ke home
        }

        $message = $user->requires_password_change 
            ? 'Demi keamanan, Anda diwajibkan untuk mengubah password pada login pertama kali.' 
            : 'Masa aktif password Anda telah melewati 90 hari. Silakan ganti dengan yang baru.';

        return view('auth.password-setup', compact('message'));
    }

    /**
     * Handle the forced password setup.
     */
    public function updateSetup(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        // 1. Cek apakah password baru sama dengan 3 password terakhir
        $histories = $user->passwordHistories()->latest()->take(3)->get();
        foreach ($histories as $history) {
            if (Hash::check($validated['password'], $history->password)) {
                return back()->withErrors(['password' => 'Anda tidak boleh menggunakan kembali 3 password terakhir Anda.'])->withInput();
            }
        }

        // 2. Update user
        $newPasswordHash = Hash::make($validated['password']);
        $user->update([
            'password' => $newPasswordHash,
            'password_updated_at' => now(),
            'requires_password_change' => false,
            'is_locked' => false,
        ]);

        // 3. Simpan ke history
        $user->passwordHistories()->create([
            'password' => $newPasswordHash
        ]);

        return redirect()->route('home')->with('success', 'Password berhasil diperbarui. Selamat datang di aplikasi!');
    }
}
