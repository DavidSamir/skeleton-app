<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::post('/projects/update/{id}', [ProjectController::class, 'update']);
    Route::post('/projects/delete/{id}', [ProjectController::class, 'delete']);
    Route::apiResource('timesheets', TimesheetController::class);
});

// Route::fallback(function () {
//     return response()->json(['error' => 'Not Found'], 404);
// });
