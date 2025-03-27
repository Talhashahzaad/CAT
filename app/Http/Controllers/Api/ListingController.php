<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListingStoreApiRequest;
use App\Http\Requests\Api\ListingUpdateApiRequest;
use App\Models\Listing;
use App\Models\ListingAmenity;
use App\Models\ListingCertificate;
use App\Models\ListingPractitioner;
use App\Models\ListingTag;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class ListingController extends Controller
{

    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        $listing = Listing::with('Category')->with('listingTags')->with('listingCertificates')->with('listingPractitioners')->with('Location')->with('User')->with('listingAmenities')
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($listing->isEmpty()) {
            return response()->json([
                'message' => 'No treatment found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'All Listing Data.',
            'treatment' => $listing
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingStoreApiRequest $request)
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
        $listing->service_capacity = $request->service_capacity;
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

        return response()->json(['success' => true, 'success' => 'Listing created successfully', 'data' => $listing], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ListingUpdateApiRequest $request, $id)
    {
        $user = Auth::user();
        $listing = Listing::find($id);
        if ($listing->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        if (!$listing) {
            return response()->json(['error' => 'Listing not found'], 404);
        }

        // Handle image uploads (only update if a new file is provided)
        $imagePath = $request->hasFile('image') ? $this->uploadImage($request, 'image') : $listing->image;
        $thumbnailPath = $request->hasFile('thumbnail_image') ? $this->uploadImage($request, 'thumbnail_image') : $listing->thumbnail_image;
        $attachmentPath = $request->hasFile('attachment') ? $this->uploadImage($request, 'attachment') : $listing->file;

        // Manually update fields
        $listing->title = $request->title;
        $listing->category_id = $request->category;
        $listing->location_id = $request->location;
        $listing->description = $request->description;
        $listing->status = $request->status;
        $listing->slug = Str::slug($request->title);
        $listing->phone = $request->phone;
        $listing->email = $request->email;
        $listing->address = $request->address;
        $listing->website = $request->website;
        $listing->facebook_link = $request->facebook_link;
        $listing->instagram_link = $request->instagram_link;
        $listing->tiktok_link = $request->tiktok_link;
        $listing->youtube_link = $request->youtube_link;
        $listing->is_verified = $request->is_verified;
        $listing->is_featured = $request->is_featured;
        $listing->seo_title = $request->seo_title;
        $listing->seo_description = $request->seo_description;
        $listing->google_map_embed_code = $request->google_map_embed_code;
        $listing->image = $imagePath;
        $listing->thumbnail_image = $thumbnailPath;
        $listing->file = $attachmentPath;

        $listing->save(); // Ensure the data is saved

        if ($request->hasFile('image')) {
            $updateData['image'] = $this->uploadImage($request, 'image');
        }
        if ($request->hasFile('thumbnail_image')) {
            $updateData['thumbnail_image'] = $this->uploadImage($request, 'thumbnail_image');
        }
        if ($request->hasFile('attachment')) {
            $updateData['file'] = $this->uploadImage($request, 'attachment');
        }

        ListingAmenity::where('listing_id', $listing->id)->delete();

        /** amenity store */
        foreach ($request->amenities as $amenityId) {
            $amenity = new ListingAmenity();
            $amenity->listing_id = $listing->id;
            $amenity->amenity_id = $amenityId;
            $amenity->save();
        }

        // Remove previous professional certificates
        ListingCertificate::where('listing_id', $listing->id)->delete();

        /** professional certificate store */
        foreach ($request->professional_certificates as $certificateId) {
            $amenity = new ListingCertificate();
            $amenity->listing_id = $listing->id;
            $amenity->certificates_id = $certificateId;
            $amenity->save();
        }

        // Remove previous tags
        ListingTag::where('listing_id', $listing->id)->delete();

        /** Tag store */
        foreach ($request->tag as $tagId) {
            $amenity = new ListingTag();
            $amenity->listing_id = $listing->id;
            $amenity->tag_id = $tagId;
            $amenity->save();
        }

        // Remove previous practitioners
        ListingPractitioner::where('listing_id', $listing->id)->delete();

        /** Practitioner store */
        foreach ($request->practitioner as $practitionerId) {
            $amenity = new ListingPractitioner();
            $amenity->listing_id = $listing->id;
            $amenity->practitioner_id = $practitionerId;
            $amenity->save();
        }

        // Debugging log
        \Log::info('Updated Listing:', $listing->toArray());

        return response()->json(['success' => true, 'message' => 'Listing updated successfully', 'data' => $listing->fresh()]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();
            $listing = Listing::findOrFail($id);
            if (!$listing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Listing not found'
                ], 404);
            }
            if ($listing->user_id != $user->id) {
                return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
            }
            // Delete all related data before deleting the listing
            $this->deleteFile($listing->image);
            $this->deleteFile($listing->thumbnail_image);
            $this->deleteFile($listing->file);
            $listing->listingAmenities()->delete();
            $listing->listingTags()->delete();
            $listing->listingCertificates()->delete();
            $listing->listingPractitioners()->delete();

            // Now delete the listing itself
            $listing->delete();

            return response()->json(['status' => 'success', 'message' => 'Listing and related data deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => 'error', 'message' => 'Failed to delete listing: ' . $e->getMessage()]);
        }
    }
}