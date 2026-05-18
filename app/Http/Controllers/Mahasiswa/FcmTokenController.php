<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function updateToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        /** @var \App\Models\Mahasiswa $mahasiswa */
        $mahasiswa = auth()->user();
        
        if ($mahasiswa) {
            $mahasiswa->update([
                'fcm_token' => $request->fcm_token
            ]);

            return response()->json([
                'success' => true,
                'message' => 'FCM Token berhasil diperbarui di database.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pengguna tidak terautentikasi.'
        ], 401);
    }
}