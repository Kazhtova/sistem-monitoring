<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $teknisi = Teknisi::where('nama_teknisi', $request->teknisi)->first();

        if($teknisi){
            Auth::guard('teknisi');
            
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->session()->regenerate();

        return back()->withErrors([
           'nama_teknisi'   => 'Nama Tidak Terdaftar Di Sistem.' 
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}