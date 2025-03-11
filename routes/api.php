<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\PractitionerController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\Api\TreatmentController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {
    /**Auth Route */
    Route::get('user-profile', [ProfileController::class, 'index']);
    Route::post('user-profile-update', [ProfileController::class, 'update']);
    Route::post('user-password-update', [ProfileController::class, 'passwordUpdate']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:agent,admin'])->group(function () {

    /**Listing Route */
    Route::post('listing-store', [ListingController::class, 'store']);

    /**Practitioner Route */
    Route::apiResource('/practitioner', PractitionerController::class);

    /** Treatment Route */
    Route::apiResource('/treatment', TreatmentController::class);
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