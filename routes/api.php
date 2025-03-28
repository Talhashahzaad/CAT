<?php

use App\Http\Controllers\Api\ListingScheduleController;
use App\Http\Controllers\Api\ListingImageGalleryController;
use App\Http\Controllers\Api\ProfessionalCertificateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\ListingVideoGalleryController;
use App\Http\Controllers\Api\PractitionerController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TreatmentController;
use App\Http\Controllers\Api\TreatmentPackage;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    /**Auth Route */
    Route::get('user-profile', [ProfileController::class, 'index']);
    Route::post('user-profile-update', [ProfileController::class, 'update']);
    Route::post('user-password-update', [ProfileController::class, 'passwordUpdate']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:agent'])->group(function () {

    /**Listing Route */
    Route::apiResource('listing', ListingController::class);

    /**Practitioner Route */
    Route::apiResource('/practitioner', PractitionerController::class);

    /** Treatment Route */
    Route::apiResource('/treatment', TreatmentController::class);

    /**Treatment Package Route */
    Route::apiResource('/treatment-package', TreatmentPackage::class);

    /** Professional Certificate Route */
    Route::apiResource('/professional-certificate', ProfessionalCertificateController::class);


    /**Listing Image Gallery */
    Route::apiResource('/listing-image-gallery', ListingImageGalleryController::class);

    /**Listing Video Gallery */
    Route::apiResource('/listing-video-gallery', ListingVideoGalleryController::class);

    /**Listing Schedule Route */
    Route::get('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'index'])->name('listing-schedule.index');
    Route::post('/listing-schedule/{listing_id}', [ListingScheduleController::class, 'store'])->name('listing-schedule.store');
    Route::put('/listing-schedule/{id}', [ListingScheduleController::class, 'update'])->name('listing-schedule.update');
    Route::delete('/listing-schedule/{id}', [ListingScheduleController::class, 'destroy'])->name('listing-schedule.destroy');
});

/** Auth Route */
Route::post('signup', [AuthController::class, 'signup']);
Route::post('user-signup', [AuthController::class, 'signupUser']);
Route::post('login', [AuthController::class, 'login']);


/** Blog Route */
Route::get('blog/{slug}', [FrontendController::class, 'blogShow']);
Route::get('blog', [FrontendController::class, 'blog']);
Route::get('blog-category', [FrontendController::class, 'blogCategory']);

/**Listing Package Route */

Route::get('listing-packages', [FrontendController::class, 'listingPackage']);

/** Contact Route */
Route::post('contact-store', [ContactController::class, 'store']);

/** Category Route */

Route::get('category', [FrontendController::class, 'category'])->name('category');