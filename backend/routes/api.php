<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/register', [AuthController::class, 'register']); // UC1
Route::post('/login', [AuthController::class, 'login']); // UC2
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']); // UC7: Feed
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']); // UC3: Đăng bài
    Route::post('/posts/{postId}/like', [InteractionController::class, 'like']); // UC4
    Route::post('/posts/{postId}/comments', [InteractionController::class, 'comment']); // UC4
    Route::get('/users/{id}', [UserController::class, 'show']); // UC6: Profile
    Route::patch('/users/{id}', [UserController::class, 'update']); // UC6
    Route::post('/users/{id}/follow', [UserController::class, 'follow']); // UC5
    Route::post('/users/{id}/unfollow', [UserController::class, 'unfollow']); // UC5
});