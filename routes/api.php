<?php

use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->post('logout', [OAuthController::class, 'logout']);


    // User routes
Route::resource('users', UserController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

// Post routes
Route::resource('posts', PostController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

// Non-authenticated routes
Route::post('login', [OAuthController::class, 'login']);






