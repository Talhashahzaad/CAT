<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

// Route::middleware('guest')->group(function () {
//     Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
//     Route::get('admin/forgot-password', [AdminAuthController::class, 'PasswordRequest'])->name('admin.password.request');
// });

Route::get('admin/login', [AdminAuthController::class, 'login'])->middleware('guest')->name('admin.login');
Route::get('admin/forgot-password', [AdminAuthController::class, 'PasswordRequest'])->middleware('guest')->name('admin.password.request');

Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /** Profile Routes */

    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
    Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
    Route::put('/profile-password',[ProfileController::class,'passwordUpdate'])->name('profile-password.update');

    /** Category Route */
    Route::resource('/category',CategoryController::class);

    /** Location Route */
    Route::resource('/location',LocationController::class);

    /** Amenity Route */
    Route::resource('/amenity',AmenityController::class);

    Route::resource('/tag',TagController ::class);

});