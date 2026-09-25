<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Admin\ResourceAdminController;

// Public Routes
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);
Route::get('/resources', [ResourceController::class, 'index']);

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

        // Blogs CRUD
        Route::get('/blogs', [BlogAdminController::class, 'index']);
        Route::get('/blogs/{id}', [BlogAdminController::class, 'show']);
        Route::post('/blogs', [BlogAdminController::class, 'store']);
        Route::post('/blogs/{id}', [BlogAdminController::class, 'update']); // POST for file upload support
        Route::delete('/blogs/{id}', [BlogAdminController::class, 'destroy']);

                // Resources CRUD
        Route::get('/resources', [ResourceAdminController::class, 'index']);
        Route::get('/resources/{id}', [ResourceAdminController::class, 'show']);
        Route::post('/resources', [ResourceAdminController::class, 'store']);
        Route::post('/resources/{id}', [ResourceAdminController::class, 'update']);
        Route::delete('/resources/{id}', [ResourceAdminController::class, 'destroy']);
    });
});