<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\ConfirmablePasswordController;
// use App\Http\Controllers\Auth\EmailVerificationNotificationController;
// use App\Http\Controllers\Auth\EmailVerificationPromptController;
// use App\Http\Controllers\Auth\NewPasswordController;
// use App\Http\Controllers\Auth\PasswordController;
// use App\Http\Controllers\Auth\PasswordResetLinkController;
// use App\Http\Controllers\Auth\RegisteredUserController;
// use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login-mahasiswa', [AuthenticatedSessionController::class, 'createMahasiswa'])
        ->name('login.mahasiswa');

    Route::post('login-mahasiswa', [AuthenticatedSessionController::class, 'storeMahasiswa']);

    Route::get('login-teknisi', [AuthenticatedSessionController::class, 'createTeknisi'])
        ->name('login.teknisi');

    Route::post('login-teknisi', [AuthenticatedSessionController::class, 'storeTeknisi']);
 
});

Route::middleware('auth:mahasiswa,teknisi')->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
        
});