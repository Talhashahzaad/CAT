<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendDashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('login', [FrontendAuthController::class, 'loginApi']);
Route::post('register', [FrontendAuthController::class, 'storeApi']);
Route::post('contact-store', [ContactController::class, 'store']);
// Route::post('logout', [AuthenticatedSessionController::class, 'logoutApi']);
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'logoutApi']);
});
Route::middleware('auth:sanctum')->get('/dashboard', [FrontendDashboardController::class, 'index']);
// Route::group([
//     'middleware' => ['auth', 'role:admin', 'auth:sanctum']
// ], function () {
//     Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard.index');
// });