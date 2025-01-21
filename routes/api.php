<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnnouncementGuestController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/users', 'index');
        Route::get('/users/logout', 'logout');
    });

    Route::apiResource('announcements', AnnouncementController::class);
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/users/login', 'login');
    Route::post('/users/register', 'store');
});

Route::apiResource('guests-announcements', AnnouncementGuestController::class);
