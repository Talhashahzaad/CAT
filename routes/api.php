<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthenticatedSessionController::class, 'loginApi']);
Route::post('register', [RegisteredUserController::class, 'storeApi']);
// Route::post('logout', [AuthenticatedSessionController::class, 'logoutApi']);
Route::middleware(['web'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'logoutApi']);
});