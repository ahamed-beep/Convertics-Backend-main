<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactAdminController;

// Public Routes
Route::post('/contact', [ContactController::class, 'store']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        // Contacts CRUD
        Route::get('/contacts', [ContactAdminController::class, 'index']);
        Route::get('/contacts/stats', [ContactAdminController::class, 'stats']);
        Route::get('/contacts/{id}', [ContactAdminController::class, 'show']);
        Route::patch('/contacts/{id}/read', [ContactAdminController::class, 'markRead']);
        Route::delete('/contacts/{id}', [ContactAdminController::class, 'destroy']);
    });
});