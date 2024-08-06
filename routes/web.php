<?php

use App\Http\Controllers\Business\BusinessAuthController;
use App\Http\Controllers\Business\DashboardController as BusinessDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AdminAuthController;


// Route::middleware('guest')->group(function () {
//     Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
//     Route::get('admin/forgot-password', [AdminAuthController::class, 'PasswordRequest'])->name('admin.password.request');
// });

Route::get('business/login', [BusinessAuthController::class, 'login'])->name('business.login');
Route::get('business/forgot-password', [BusinessAuthController::class, 'forgotPassword'])->name('business.forgotPassword');
Route::get('business/dashboard', [BusinessDashboardController::class, 'index'])->name('business.dashboard.index')->middleware('role:vendor');



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';