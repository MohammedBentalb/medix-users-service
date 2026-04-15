<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DoctorController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/register/patient', [AuthController::class, 'registerPatient']);
    Route::post('/register/doctor', [AuthController::class, 'registerDoctor']);
    Route::post('/register/assistant', [AuthController::class, 'registerAssistant']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('v1/users')->middleware('internal')->group(function () {
    Route::prefix('me')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/profile/patient', [ProfileController::class, 'updatePatient']);
        Route::put('/profile/doctor', [ProfileController::class, 'updateDoctor']);
        Route::put('/profile/assistant', [ProfileController::class, 'updateAssistant']);
        Route::put('/password', [ProfileController::class, 'changePassword']);
    });
    
    Route::prefix('all')->group(function () {
        Route::get('/admins', [UserController::class, 'getAdmins']);
        Route::get('/doctors', [UserController::class, 'getDoctors']);
        Route::get('/assistants', [UserController::class, 'getAssistants']);
        Route::get('/patients', [UserController::class, 'getPatients']);
    });

    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}/status', [UserController::class, 'updateStatus']);
    Route::post('/{id}/roles', [UserController::class, 'assignRoles']);
});

Route::prefix('v1/doctor')->middleware('internal')->group(function () {
    Route::post('/assistants', [DoctorController::class, 'assignAssistant']);
    Route::get('/assistants', [DoctorController::class, 'listAssistants']);
    Route::delete('/assistants/{assistantId}', [DoctorController::class, 'removeAssistant']);
    Route::get('/patients', [DoctorController::class, 'listDoctorPatients']);
});

Route::prefix('v1/patient')->middleware('internal')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'listPatientDoctors']);
});
