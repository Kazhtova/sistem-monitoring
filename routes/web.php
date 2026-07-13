<?php

use App\Http\Controllers\Mahasiswa\RequestController as MahasiswaRequest;
use App\Http\Controllers\Teknisi\RequestController as TeknisiRequest;
use App\Http\Controllers\Teknisi\ActivityController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/login', function () {
    return redirect()->route('login.mahasiswa');
})->name('login');


Route::middleware(['auth:teknisi', 'restrict:teknisi'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/pending-list', [TeknisiRequest::class, 'listPending'])->name('dashboard.request');

    Route::get('/pending/list/{id}', [TeknisiRequest::class, 'viewPendingDetails'])->name('pending.details');
    
    Route::get('/request/list/{id}', [TeknisiRequest::class, 'viewRequestDetails'])->name('request.details');
    
    Route::get('/dashboard-activity', [ActivityController::class, 'activityLogs'])->name('dashboard.activity');
    
    Route::get('/request-list', [TeknisiRequest::class, 'listRequest'])->name('dashboard.accept');
    
    Route::patch('/request-list/accept/{id}', [TeknisiRequest::class, 'acceptRequest'])->name('accept.request');
    
    Route::patch('/request-list/reject/{id}', [TeknisiRequest::class, 'rejectRequest'])->name('reject.request');
    
    Route::patch('/request/accept/cancle/{id}', [TeknisiRequest::class, 'cancelRequest'])->name('cancel.request');

    Route::get('/dashboard-list-pc', [TeknisiRequest::class, 'listPc'])->name('dashboard.pc_list');

    Route::get('/komputer/{id_komputer}/kalender', [ActivityController::class, 'viewKalenderTeknisi'])->name('komputer.kalender');

    Route::get('/api/komputer/{id_komputer}/jadwal', [ActivityController::class, 'getJadwalKomputer'])->name('api.komputer.jadwal');
});

Route::middleware(['auth:mahasiswa', 'restrict:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function (){
    Route::get('/dashboard-mahasiswa',  [MahasiswaRequest::class, 'readRequest'])->name('dashboard.mahasiswa');

    Route::get('/request-mahasiswa/{id?}', [MahasiswaRequest::class, 'viewRequest'])->name('request.mahasiswa');

    Route::get('/upload-mahasiswa/{id}', [MahasiswaRequest::class, 'viewCard'])->name('foto.card');

    Route::patch('/upload-foto-mahasiswa/{id}', [MahasiswaRequest::class, 'uploadImage'])->name('foto.post');

    Route::patch('/update-time-mahasiswa/{id}', [MahasiswaRequest::class, 'extendTime'])->name('time.extend');

    Route::post('/request-mahasiswa', [MahasiswaRequest::class, 'sendRequest'])->name('request.post');

    Route::post('/update-fcm-token', [MahasiswaRequest::class, 'updateFcmToken'])->name('update.fcm');

    Route::get('/profile/{mahasiswa}', [MahasiswaRequest::class, 'showProfile'])->name('show.profile');

    Route::get('/dashboard-list-pc', [MahasiswaRequest::class, 'listPc'])->name('dashboard.pc_list');

    Route::patch('/mahasiswa/password', [PasswordController::class, 'updatePassword'])->name('password.update');

    Route::get('/komputer/{id_komputer}/kalender', [ActivityController::class, 'viewKalender'])->name('komputer.kalender');

    Route::get('/api/komputer/{id_komputer}/jadwal', [ActivityController::class, 'getJadwalKomputer'])->name('api.komputer.jadwal');
});


require __DIR__.'/auth.php';