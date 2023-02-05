<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(UserController::class)->prefix('auth')->name('auth.')->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:api')->group(function() {
    Route::controller(UserController::class)->prefix('auth')->name('auth.')->group(function() {
        Route::get('data', 'data')->name('data');
        Route::post('logout', 'logout')->name('logout');
        Route::post('refresh', 'refresh')->name('refresh');
    });

    Route::apiResource('kendaraan', KendaraanController::class);

    Route::apiResource('penjualan', PenjualanController::class);
});
