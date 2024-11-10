<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingStoreRequest;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingAmenity;
use App\Models\Location;
use App\Models\ProfessionalCertificate;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\FileUploadTrait;
use Auth;
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
        return view('admin.listing.create', compact('categories', 'locations', 'amenities', 'tags', 'certificates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ListingStoreRequest $request)
    // {
    //     try {
    //         $imagePath = $this->uploadImage($request, 'image');
    //         $thumbnailPath = $this->uploadImage($request, 'thumbnail_image');
    //         $attachmentPath = $this->uploadImage($request, 'attachment');

    //         $listing = new Listing();
    //         $listing->user_id = Auth::user()->id;
    //         $listing->package_id = 0;
    //         $listing->image = $imagePath;
    //         $listing->thumbnail_image =  $thumbnailPath;
    //         $listing->title = $request->title;
    //         $listing->slug = Str::slug($request->title);
    //         $listing->description = $request->description;
    //         $listing->category_id = $request->category;
    //         $listing->location_id = $request->location;
    //         $listing->status = $request->status;
    //         $listing->file = $attachmentPath;
    //         $listing->phone = $request->phone;
    //         $listing->email = $request->email;
    //         $listing->address = $request->address;
    //         $listing->website = $request->website;
    //         $listing->facebook_link = $request->facebook_link;
    //         $listing->tiktok_link = $request->tiktok_link;
    //         $listing->instagram_link = $request->instagram_link;
    //         $listing->youtube_link = $request->youtube_link;
    //         $listing->is_verified = $request->is_verified;
    //         $listing->is_featured = $request->is_featured;
    //         $listing->seo_title = $request->seo_title;
    //         $listing->seo_description = $request->seo_description;
    //         $listing->google_map_embed_code = $request->google_map_embed_code;
    //         $listing->expire_date = date('Y-m-d');
    //         $listing->save();

    //         /** amenity store */

    //         foreach ($request->amenities as $amenityId) {

    //             $amenity = new ListingAmenity();
    //             $amenity->listing_id = $listing->id;
    //             $amenity->amenity_id = $amenityId;
    //             $amenity->save();
    //         }

    //         toastr()->success('Created Successfully');

    //         return redirect()->route('admin.listing.index');
    //     } catch (\Exception $e) {
    //         toastr()->error('An error occurred: ' . $e->getMessage());
    //         return redirect()->back()->withInput();
    //     }
    // }


    public function store(ListingStoreRequest $request)
    {
        try {
            // Your file upload and processing code

            // Validate the uploaded files
            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                toastr()->error('Image upload failed.');
                return redirect()->back()->withInput();
            }

            if (!$request->hasFile('thumbnail_image') || !$request->file('thumbnail_image')->isValid()) {
                toastr()->error('Thumbnail image upload failed.');
                return redirect()->back()->withInput();
            }

            if (!$request->hasFile('attachment') || !$request->file('attachment')->isValid()) {
                toastr()->error('Thumbnail image upload failed.');
                return redirect()->back()->withInput();
            }

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
            // foreach ($request->amenities as $amenityId) {
            //     $amenity = new ListingAmenity();
            //     $amenity->listing_id = $listing->id;
            //     $amenity->amenity_id = $amenityId;
            //     $amenity->save();
            // }
            /** amenity store */
            foreach ($request->amenities as $amenityId) {
                // Check if the amenity exists before saving
                $amenity = Amenity::find($amenityId);
                if ($amenity) {
                    $listingAmenity = new ListingAmenity();
                    $listingAmenity->listing_id = $listing->id;
                    $listingAmenity->amenity_id = $amenityId;
                    $listingAmenity->save();
                } else {
                    toastr()->error('Amenity ID ' . $amenityId . ' does not exist.');
                }
            }

            toastr()->success('Created Successfully');
            return redirect()->route('admin.listing.index');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}