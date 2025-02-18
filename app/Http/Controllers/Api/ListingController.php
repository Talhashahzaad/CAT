<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingStoreRequest;
use App\Http\Requests\Admin\ListingUpdateRequest;
use App\Http\Requests\Admin\PractitionerStoreRequest;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingAmenity;
use App\Models\ListingCategory;
use App\Models\ListingCertificate;
use App\Models\ListingPractitioner;
use App\Models\ListingTag;
use App\Models\Location;
use App\Models\Practitioner;
use App\Models\ProfessionalCertificate;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Str;

class ListingController extends Controller
{
    use FileUploadTrait;
    public function store(ListingStoreRequest $request)
    {

        $imagePath = $this->uploadImage($request, 'image');
        $thumbnailPath = $this->uploadImage($request, 'thumbnail_image');
        $attachmentPath = $this->uploadImage($request, 'attachment');

        $listing = new Listing();
        $listing->user_id = Auth::user()->id;
        $listing->package_id = 0;
        $listing->image = $imagePath;
        $listing->thumbnail_image =  $thumbnailPath;
        $listing->title = $request->title;
        $listing->slug = Str::slug($request->title);
        $listing->description = $request->description;
        $listing->category_id = $request->category;
        $listing->location_id = $request->location;
        $listing->status = $request->status;
        $listing->file = $attachmentPath;
        $listing->phone = $request->phone;
        $listing->email = $request->email;
        $listing->address = $request->address;
        $listing->website = $request->website;
        $listing->facebook_link = $request->facebook_link;
        $listing->tiktok_link = $request->tiktok_link;
        $listing->instagram_link = $request->instagram_link;
        $listing->youtube_link = $request->youtube_link;
        $listing->is_verified = $request->is_verified;
        $listing->is_featured = $request->is_featured;
        $listing->seo_title = $request->seo_title;
        $listing->seo_description = $request->seo_description;
        $listing->google_map_embed_code = $request->google_map_embed_code;
        $listing->expire_date = date('Y-m-d');
        $listing->save();

        /** amenity store */

        foreach ($request->amenities as $amenityId) {

            $amenity = new ListingAmenity();
            $amenity->listing_id = $listing->id;
            $amenity->amenity_id = $amenityId;
            $amenity->save();
        }

        /** professional certificate store */

        foreach ($request->professional_certificates as $certificateId) {

            $certificate = new ListingCertificate();
            $certificate->listing_id = $listing->id;
            $certificate->certificates_id = $certificateId;
            $certificate->save();
        }

        /** Tag store */

        foreach ($request->tag as $tagId) {

            $tag = new ListingTag();
            $tag->listing_id = $listing->id;
            $tag->tag_id = $tagId;
            $tag->save();
        }

        /** Practitioner store */

        foreach ($request->practitioner as $practitionerId) {

            $practitioner = new ListingPractitioner();
            $practitioner->listing_id = $listing->id;
            $practitioner->practitioner_id = $practitionerId;
            $practitioner->save();
        }

        return response()->json(['success' => 'Listing created successfully'], 200);
    }

    public function storePractitioner(PractitionerStoreRequest $request)
    {
        $practitioner = new Practitioner();
        $practitioner->user_id = Auth::user()->id;
        $practitioner->slug = Str::slug($request->name);
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->certificate = $request->certificate;
        $practitioner->save();
        return response()->json(['success' => 'Practitioner created successfully'], 200);
    }
}
