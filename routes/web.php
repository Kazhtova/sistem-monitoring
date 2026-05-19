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


Route::middleware(['auth:teknisi', 'restrict:teknisi'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/request-list', [TeknisiRequest::class, 'listRequest'])->name('dashboard.request');
    Route::patch('/request-list/accept/{id}', [TeknisiRequest::class, 'acceptRequest'])->name('accept.request');
    Route::patch('/request-list/reject/{id}', [TeknisiRequest::class, 'rejectRequest'])->name('reject.request');
    Route::patch('/request/accept/cancle/{id}', [TeknisiRequest::class, 'cancleRequest'])->name('cancle.request');
    Route::get('/accept-list', [TeknisiRequest::class, 'listAccept'])->name('dashboard.accept');
});

Route::middleware(['auth:mahasiswa', 'restrict:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function (){
    Route::get('/dashboard-mahasiswa',  [MahasiswaRequest::class, 'readRequest'])->name('dashboard.mahasiswa');

    Route::get('/request-mahasiswa', [MahasiswaRequest::class, 'viewRequest'])->name('request.mahasiswa');

    Route::post('/request-mahasiswa', [MahasiswaRequest::class, 'sendRequest'])->name('request.post');

    Route::post('/update-fcm-token', [MahasiswaRequest::class, 'updateFcmToken'])->name('update.fcm');
});


require __DIR__.'/auth.php';