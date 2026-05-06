<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Mahasiswa;
use App\Models\Teknisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function createTeknisi(): View
    {
        return view('auth.login');
    }

    public function createMahasiswa(): View
    {
        return view('auth.register');
    }

    public function storeMahasiswa(Request $request): RedirectResponse
    {
        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();
        if($mahasiswa){
            Auth::guard('mahasiswa')->login($mahasiswa);

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        $request->session()->regenerate();

        return back()->withErrors([
          'mahasiswa'   => 'Mahasiswa Tidak Tidak Ada'  
        ]);
        
    }

    /**
     * Handle an incoming authentication request.
     */
    public function storeTeknisi(Request $request): RedirectResponse
    {
        $teknisi = Teknisi::where('nama_teknisi', $request->teknisi)->first();

        if($teknisi){
            Auth::guard('teknisi')->login($teknisi);
            
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->session()->regenerate();

        return back()->withErrors([
           'teknisi'   => 'Nama Tidak Terdaftar Di Sistem.' 
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('teknisi')->logout();
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}