<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return response()->json(['message' => 'Welcome, Admin!']);
    });
});

Route::middleware(['auth:sanctum', 'role:User'])->group(function () {
    Route::get('/user-dashboard', function () {
        return response()->json(['message' => 'Welcome, User!']);
    });
});
