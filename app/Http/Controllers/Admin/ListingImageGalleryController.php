<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ListingImageGallery;
use Illuminate\Http\Response;

class ListingImageGalleryController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $images = ListingImageGallery::where('listing_id', $request->id)->get();
        $listingTitle = Listing::select('title')->where('id', $request->id)->first();
        return view('admin.listing.listing-image-gallery.index', compact('images', 'listingTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'images' => ['required'],
            'images.*' => ['image', 'max:3000'],
            'listing_id' => ['required']
        ], [
            'images.*.image' => 'One or more selected files are not valid images.',
            'images.*.max' => 'One or more images exceed the maximum file size (3MB).'
        ]);
        $imagePath = $this->uploadMultipleImage($request, 'images');

        // Check if $imagePath contains an error
        if (isset($imagePath['error'])) {
            return redirect()->back()->withErrors(['images' => $imagePath['error']]);
        }
        foreach ($imagePath as $path) {
            $image =  new ListingImageGallery();
            $image->listing_id = $request->listing_id;
            $image->image = $path;
            $image->save();
        }


        toastr()->success('Uploaded Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $image = ListingImageGallery::findOrFail($id);
            $this->deleteFile($image->image);
            $image->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}