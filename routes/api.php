<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// Rute untuk login
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk register
Route::post('/register', [AuthController::class, 'register']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::resource('posts', PostController::class);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group( function() {
    // Route::resource('products', ProductController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{id}', [UserController::class, 'show']);

});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
