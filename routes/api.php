<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlatformController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // User Profile Routes
    Route::prefix('user')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
    });

    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('platforms', [PlatformController::class, 'index']);
    Route::post('platforms/{platform}/toggle', [PlatformController::class, 'toggle']);

    Route::middleware('post.rate_limit')->post('posts', [PostController::class, 'store']);
    Route::get('posts', [PostController::class, 'listByUser']);
    Route::put('posts/{post}', [PostController::class, 'update']);
});


