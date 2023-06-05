<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('user', 'user');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get('posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('posts', PostController::class)
        ->except('index', 'show');
});
