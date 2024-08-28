<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    // User Routes
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/delete', [UserController::class, 'delete']);

    // Project Routes
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::post('/projects/update', [ProjectController::class, 'update']);
    Route::post('/projects/delete', [ProjectController::class, 'delete']);

    // Timesheet Routes
    Route::post('/timesheets', [TimesheetController::class, 'store']);
    Route::get('/timesheets/{id}', [TimesheetController::class, 'show']);
    Route::get('/timesheets', [TimesheetController::class, 'index']);
    Route::post('/timesheets/update', [TimesheetController::class, 'update']);
    Route::post('/timesheets/delete', [TimesheetController::class, 'delete']);
});
