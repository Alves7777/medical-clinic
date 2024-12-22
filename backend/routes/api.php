<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Consultation\ConsultationController;
use App\Http\Controllers\V1\Doctor\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['status' => 'success', 'message' => 'Bem Vindo ao Backend!'], 200);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('doctors', DoctorController::class);
    Route::get('doctors/{doctor_id}/consultations', [ConsultationController::class, 'index']);
    Route::post('consultations', [ConsultationController::class, 'store']);
});

