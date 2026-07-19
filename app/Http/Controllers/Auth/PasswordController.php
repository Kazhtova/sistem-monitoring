<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth; 

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        /** @var \App\Models\Mahasiswa $user */
        $user = Auth::guard('mahasiswa')->user();

        $passwordInfo = password_get_info($user->password);
        $isBcryptValid = false;
        $isMd5Valid = false;

        if ($passwordInfo['algo'] !== 0 && $passwordInfo['algoName'] !== 'unknown') {
            try {
                $isBcryptValid = Hash::check($request->current_password, $user->password);
            } catch (\RuntimeException $e) {
                $isBcryptValid = false;
            }
        } else {
            $isMd5Valid = (md5($request->current_password) === $user->password);
        }

        if (!$isBcryptValid && !$isMd5Valid) {
            return back()->withErrors([
                'current_password' => 'Password saat ini yang Anda masukkan salah.'
            ]);
        }

        $user->update([
            'password' => md5($request->password)
        ]);

        return back()->with('status', 'password-updated');
    }
}