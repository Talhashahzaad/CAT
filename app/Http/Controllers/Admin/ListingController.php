<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingStoreRequest;
use App\Http\Requests\Admin\ListingUpdateRequest;
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

    /**
     * Display a listing of the resource.
     */
    public function index(ListingDataTable $dataTable): View | JsonResponse
    {
        return  $dataTable->render('admin.listing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $locations = Location::all();
        $amenities = Amenity::all();
        $tags = Tag::all();
        $certificates = ProfessionalCertificate::all();
        $practitioners = Practitioner::all();
        return view('admin.listing.create', compact('categories', 'locations', 'amenities', 'tags', 'certificates', 'practitioners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingStoreRequest $request)
    {

        try {
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

                $amenity = new ListingCertificate();
                $amenity->listing_id = $listing->id;
                $amenity->certificates_id = $certificateId;
                $amenity->save();
            }

            /** Tag store */

            foreach ($request->tag as $tagId) {

                $amenity = new ListingTag();
                $amenity->listing_id = $listing->id;
                $amenity->tag_id = $tagId;
                $amenity->save();
            }

            /** Practitioner store */

            foreach ($request->practitioner as $practitionerId) {

                $amenity = new ListingPractitioner();
                $amenity->listing_id = $listing->id;
                $amenity->practitioner_id = $practitionerId;
                $amenity->save();
            }

            toastr()->success('Created Successfully');

            return redirect()->route('admin.listing.index');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $listing = Listing::findOrFail($id);

        $listingAmenities = ListingAmenity::where('listing_id', $listing->id)->pluck('amenity_id')->toArray();
        $listingTag = ListingTag::where('listing_id', $listing->id)->pluck('tag_id')->toArray();
        $listingCertificate = ListingCertificate::where('listing_id', $listing->id)->pluck('certificates_id')->toArray();
        $listingPractitioner = ListingPractitioner::where('listing_id', $listing->id)->pluck('practitioner_id')->toArray();
        $categories = Category::all();
        $locations = Location::all();
        $amenities = Amenity::all();
        $tags = Tag::all();
        $certificates = ProfessionalCertificate::all();
        $practitioners = Practitioner::all();
        return view('admin.listing.edit', compact('categories', 'locations', 'amenities', 'tags', 'certificates', 'listing', 'listingAmenities', 'listingTag', 'listingCertificate', 'practitioners', 'listingPractitioner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingUpdateRequest $request, string $id): RedirectResponse
    {

        try {
            $listing =  Listing::findOrFail($id);
            $imagePath = $this->uploadImage($request, 'image', $request->old_image);
            $thumbnailPath = $this->uploadImage($request, 'thumbnail_image', $request->old_thumbnail_image);
            $attachmentPath = $this->uploadImage($request, 'attachment', $request->old_attachment);


            $listing->user_id = Auth::user()->id;
            $listing->package_id = 0;
            $listing->image = !empty($imagePath) ? $imagePath : $request->old_image;
            $listing->thumbnail_image =  !empty($thumbnailPath) ? $thumbnailPath : $request->old_thumbnail_image;
            $listing->title = $request->title;
            $listing->slug = Str::slug($request->title);
            $listing->description = $request->description;
            $listing->category_id = $request->category;
            $listing->location_id = $request->location;
            $listing->status = $request->status;
            $listing->file =  !empty($attachmentPath) ? $attachmentPath : $request->old_attachment;
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

            // Remove previous amenities
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

            toastr()->success('Updated Successfully');

            return redirect()->route('admin.listing.index');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return response(['status' => 'success', 'message' => 'Item deleted Successfuly!']);
    }
}