<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Consultation\ConsultationController;
use App\Http\Controllers\V1\Consultation\ExamController;
use App\Http\Controllers\V1\Consultation\PrescriptionController;
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
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('doctors', DoctorController::class);

    Route::get('doctors/{doctor_id}/consultations', [ConsultationController::class, 'index']);
    Route::post('consultations', [ConsultationController::class, 'store']);

    Route::get('/consultations/{consultation_id}/exams', [ExamController::class, 'index']);
    Route::post('/consultations/{consultation_id}/exams', [ExamController::class, 'store']);

    Route::get('/prescriptions/{consultation_id}', [PrescriptionController::class, 'index']);
    Route::post('/prescriptions', [PrescriptionController::class, 'store']);
});

