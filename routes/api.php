<?php
use App\Http\Controllers\Mahasiswa\FcmTokenController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/mahasiswa/update-fcm-token', [FcmTokenController::class, 'updateToken']);