<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mahasiswa\RequestController as MahasiswaRequest;
use App\Http\Controllers\Teknisi\RequestController as TeknisiRequest;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/login', function () {
    return redirect()->route('login.mahasiswa');
})->name('login');


Route::middleware(['restrict:teknisi'])->group(function () {
    Route::get('/request-list', [TeknisiRequest::class, 'listRequest'])->name('dashboard.teknisi');
    Route::patch('/request-list/{id}', [TeknisiRequest::class, 'acceptRequest'])->name('accept.request');

    Route::get('/list-accept', [TeknisiRequest::class, 'listAccept'])->name('accept.teknisi');
});

Route::middleware(['restrict:mahasiswa'])->group(function (){
    Route::get('/dashboard-mahasiswa', function () {
        return view('mahasiswa.dashboard-mahasiswa');
    })->name('dashboard.mahasiswa');

    Route::get('/request-mahasiswa', function () {
        return view('mahasiswa.input-request-mahasiswa');
    })->name('request.mahasiswa');

    Route::post('/request-mahasiswa', [MahasiswaRequest::class, 'sendRequest'])->name('request.post');
});


Route::middleware('auth:mahasiswa,teknisi')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';