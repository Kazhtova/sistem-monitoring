<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Menjadi rute fallback agar middleware auth tidak error
// Route::get('/login', function () {
//     return redirect()->route('login.mahasiswa');
// })->name('login');

Route::get('/dashboard-mahasiswa', function () {
    return view('dashboard-mahasiswa');
})->middleware(['auth:mahasiswa'])->name('dashboard.mahasiswa');

Route::get('/dashboard-teknisi', function () {
    return view('dashboard-teknisi');
})->middleware(['auth:teknisi'])->name('dashboard.teknisi');

// Jika Mahasiswa juga ingin masuk ke profil, tambahkan guard-nya di sini
Route::middleware('auth:mahasiswa,teknisi')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';