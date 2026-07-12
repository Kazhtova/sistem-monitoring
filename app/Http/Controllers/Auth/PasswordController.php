<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth; // BENAR

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'current_password' => ['required'],
            // Catatan: Password::defaults() membutuhkan minimal 8 karakter secara bawaan Laravel
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        /** @var \App\Models\Mahasiswa $user */
        $user = Auth::guard('mahasiswa')->user();

        // 2. Cek apakah password lama (saat ini) valid
        $passwordInfo = password_get_info($user->password);
        $isBcryptValid = false;
        $isMd5Valid = false;

        // Mendukung pengecekan jika password lama masih menggunakan format Bcrypt
        if ($passwordInfo['algo'] !== 0 && $passwordInfo['algoName'] !== 'unknown') {
            try {
                $isBcryptValid = Hash::check($request->current_password, $user->password);
            } catch (\RuntimeException $e) {
                $isBcryptValid = false;
            }
        } else {
            // Komparasi MD5 manual untuk data legacy
            $isMd5Valid = (md5($request->current_password) === $user->password);
        }

        // Jika password lama tidak cocok di kedua algoritma, lempar eror
        if (!$isBcryptValid && !$isMd5Valid) {
            return back()->withErrors([
                'current_password' => 'Password saat ini yang Anda masukkan salah.'
            ]);
        }

        // 🟢 3. PERBAIKAN MUTLAK: Simpan password baru sebagai MD5 murni
        $user->update([
            'password' => md5($request->password)
        ]);

        // 4. Kembali dengan pesan sukses ke UI
        return back()->with('status', 'password-updated');
    }
}