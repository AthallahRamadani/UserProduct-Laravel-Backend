<?php

use Illuminate\Support\Facades\Route;

Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('/User', App\Http\Controllers\Api\UserController::class);
    Route::apiResource('/Product', App\Http\Controllers\Api\ProductController::class);
    Route::apiResource('/Category_Product', App\Http\Controllers\Api\Category_ProductController::class);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::get('me', [App\Http\Controllers\AuthController::class, 'me'])->middleware('auth:api');
});
