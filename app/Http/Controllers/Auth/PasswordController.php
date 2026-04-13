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
                return back()->withErrors(['password' => 'Anda tidak boleh menggunakan kembali 3 password terakhir Anda.'])->withInput();
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
}
