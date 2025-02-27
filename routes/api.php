<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('/posts', PostController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::patch('/posts/{post}/approve', [PostController::class, 'approve']);
        Route::patch('/posts/{post}/reject', [PostController::class, 'reject']);
    });
});
