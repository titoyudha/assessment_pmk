<?php


use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'OAuthController@logout');

    // User routes
    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@store');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update');
    Route::delete('users/{id}', 'UserController@destroy');

    // Post routes
    Route::get('posts', 'PostController@index');
    Route::post('posts', 'PostController@store');
    Route::get('posts/{id}', 'PostController@show');
    Route::put('posts/{id}', 'PostController@update');
    Route::delete('posts/{id}', 'PostController@destroy');
});

// Non-authenticated routes
Route::post('login', 'OAuthController@login');






