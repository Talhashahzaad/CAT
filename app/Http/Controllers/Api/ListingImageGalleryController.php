<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImageGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ListingImageGalleryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $images = ListingImageGallery::where('listing_id', $request->id)->select('id', 'image_path')->get();
        $listingTitle = Listing::select('title')->where('id', $request->id)->first();
        if ($images->isEmpty()) {
            return response()->json(['message' => 'No images found'], 404);
        }
        // Return the images and listing title if found
        return response()->json([
            'title' => $listingTitle->title,
            'images' => $images
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return response()->json(['error' => $imagePath['error']], 422); // Return error as JSON
        }
        foreach ($imagePath as $path) {
            $image =  new ListingImageGallery();
            $image->listing_id = $request->listing_id;
            $image->image = $path;
            $image->save();
        }

        return response()->json(['message' => 'Images uploaded successfully'], 201); // Return success message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $image = ListingImageGallery::findOrFail($id);
            $this->deleteFile($image->image);
            $image->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted Successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}