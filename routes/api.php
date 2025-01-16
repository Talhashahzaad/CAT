<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendDashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('login', [FrontendAuthController::class, 'loginApi']);
Route::post('register', [FrontendAuthController::class, 'storeApi']);
Route::post('contact-store', [ContactController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'logoutApi']);
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'logoutApi']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user-profile', [ProfileController::class, 'index']);
    Route::post('user-profile-update', [ProfileController::class, 'update']);
    Route::post('user-password-update', [ProfileController::class, 'passwordUpdate']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');