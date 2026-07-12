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
        $request->validate([
            'nrp'      => 'required|string',
            'password' => 'required|string',
        ]);
        
        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();
        
        if(!$mahasiswa){
            return back()->withErrors([
               'nrp' => 'NRP tidak ditemukan di dalam sistem.' 
            ])->withInput();
        }

        $isPasswordValid = (md5($request->password) === $mahasiswa->password);

        if (!$isPasswordValid) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.'
            ])->withInput();
        }

        Auth::guard('mahasiswa')->login($mahasiswa, $request->boolean('remember'));
        $request->session()->regenerate();

        $requestCount = $mahasiswa->requests()->count();

        if($requestCount === 0){
            return redirect()->route('mahasiswa.request.mahasiswa');
        }
        
        return redirect()->intended(route('mahasiswa.dashboard.mahasiswa', absolute: false));
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
            return redirect()->intended(route('teknisi.dashboard.request', absolute: false));
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
        $teknisi   = Auth::guard('teknisi')->check();
        $mahasiswa = Auth::guard('mahasiswa')->check();

        Auth::guard('teknisi')->logout();
        Auth::guard('mahasiswa')->logout();
        
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($teknisi){
            return redirect()->route('login.teknisi');
        }

        if($mahasiswa){
            return redirect()->route('login.mahasiswa');
        }

        return redirect('/');
    }
}