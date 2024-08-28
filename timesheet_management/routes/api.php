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
    Route::post('/api/users', [UserController::class, 'store']); 
    Route::get('/api/users/{id}', [UserController::class, 'show']); 
    Route::get('/api/users', [UserController::class, 'index']); 
    Route::post('/api/users/update', [UserController::class, 'update']); 
    Route::post('/api/users/delete', [UserController::class, 'delete']); 

    // Project Routes
    Route::post('/api/projects', [ProjectController::class, 'store']); 
    Route::get('/api/projects/{id}', [ProjectController::class, 'show']); 
    Route::get('/api/projects', [ProjectController::class, 'index']); 
    Route::post('/api/projects/update', [ProjectController::class, 'update']); 
    Route::post('/api/projects/delete', [ProjectController::class, 'delete']); 

    // Timesheet Routes
    Route::post('/api/timesheets', [TimesheetController::class, 'store']); 
    Route::get('/api/timesheets/{id}', [TimesheetController::class, 'show']); 
    Route::get('/api/timesheets', [TimesheetController::class, 'index']); 
    Route::post('/api/timesheets/update', [TimesheetController::class, 'update']); 
    Route::post('/api/timesheets/delete', [TimesheetController::class, 'delete']); 
    
});
