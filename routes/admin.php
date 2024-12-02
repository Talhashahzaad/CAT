<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ListingImageGalleryController;
use App\Http\Controllers\Admin\ListingScheduleController;
use App\Http\Controllers\Admin\ListingVideoGalleryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PractitionerController;
use App\Http\Controllers\Admin\ProfessionalCertificateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile-password', [ProfileController::class, 'passwordUpdate'])->name('profile-password.update');

    /** Category Route */
    Route::resource('/category', CategoryController::class);

    /** Location Route */
    Route::resource('/location', LocationController::class);

    /** Amenity Route */
    Route::resource('/amenity', AmenityController::class);

    /** Tag Route */
    Route::resource('/tag', TagController::class);

    /** Service Route */
    Route::resource('/service', ServiceController::class);

    /** Package Route */
    Route::resource('/package', PackageController::class);

    /** Certificate Route */
    Route::resource('/certificate', ProfessionalCertificateController::class);

    /** Practitioner Route */
    Route::resource('/practitioner', PractitionerController::class);

    /** Listing Route */
    Route::resource('/listing', ListingController::class);

    /**Listing Image Gallery */
    Route::resource('/listing-image-gallery', ListingImageGalleryController::class);

    /**Listing Video Gallery */
    Route::resource('/listing-video-gallery', ListingVideoGalleryController::class);

    /**Listing Schedule */
    Route::get('/listing-schedule', [ListingScheduleController::class, 'index'])->name('listing-schedule.index');
    Route::get('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'create'])->name('listing-schedule.create');
    Route::post('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'store'])->name('listing-schedule.store');
});