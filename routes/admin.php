<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ListingImageGalleryController;
use App\Http\Controllers\Admin\ListingPackageController;
use App\Http\Controllers\Admin\ListingScheduleController;
use App\Http\Controllers\Admin\ListingVideoGalleryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PractitionerController;
use App\Http\Controllers\Admin\ProfessionalCertificateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CatVideoUploadController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PendingListingController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AdminAuthController::class, 'login'])->middleware('guest')->name('admin.login');
Route::get('admin/forgot-password', [AdminAuthController::class, 'PasswordRequest'])->middleware('guest')->name('admin.password.request');

Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

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

    /**Listing Schedule Route */
    Route::get('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'index'])->name('listing-schedule.index');
    Route::get('/listing-schedule/{listing_id}/create', [ListingScheduleController::class, 'create'])->name('listing-schedule.create');
    Route::post('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'store'])->name('listing-schedule.store');
    Route::get('/listing-schedule/{id}/edit', [ListingScheduleController::class, 'edit'])->name('listing-schedule.edit');
    Route::put('/listing-schedule/{id}', [ListingScheduleController::class, 'update'])->name('listing-schedule.update');
    Route::delete('/listing-schedule/{id}', [ListingScheduleController::class, 'destroy'])->name('listing-schedule.destroy');

    /** Pending Listing Route */
    Route::get('/pending-listing', [PendingListingController::class, 'index'])->name('pending-listing.index');
    Route::post('/pending-listing', [PendingListingController::class, 'update'])->name('pending-listing.update');

    /** Contact Form */
    Route::resource('/contact-form', ContactController::class);

    /** Blog Route*/
    Route::resource('/blog-category', BlogCategoryController::class);
    Route::resource('/blog', BlogController::class);

    /**Listing Packages Route */
    Route::resource('/listing-package', ListingPackageController::class);

    /**Cat Video Upload Route */
    Route::resource('/cat-video-upload', CatVideoUploadController::class);

    /**Setting Route */
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/general-settings', [SettingController::class, 'updateGeneralSetting'])->name('general-settings.update');
    Route::post('/pusher-settings', [SettingController::class, 'updatePusherSetting'])->name('pusher-settings.update');
    Route::post('/logo-settings', [SettingController::class, 'logoSettings'])->name('logo-settings.update');
    Route::post('/appearance-settings', [SettingController::class, 'appearanceSetting'])->name('appearance-settings.update');

    /**Payment Setting Route */
    Route::get('/payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::post('/paypal-settings', [PaymentSettingController::class, 'paypalSetting'])->name('paypal-settings.update');
    Route::post('/stripe-settings', [PaymentSettingController::class, 'stripeSetting'])->name('stripe-settings.update');
    Route::post('/razorpay-settings', [PaymentSettingController::class, 'razorpaySetting'])->name('razorpay-settings.update');
});