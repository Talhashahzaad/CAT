<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImageGallery;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;

class ListingImageGalleryController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:listings,id',
        ]);

        $user = $request->user();

        $listing = Listing::where('id', $validated['id'])
            // ->where('user_id', $user->id) // Ensures only owner can access
            ->select('id', 'title')
            ->first();

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or unauthorized'], 403);
        }
        $images = ListingImageGallery::where('listing_id', $listing->id)
            ->select('id', 'image')
            ->get();

        if ($images->isEmpty()) {
            return response()->json(['message' => 'No images found'], 404);
        }

        return response()->json([
            'title' => $listing->title,
            'images' => $images
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:3000'],
            'listing_id' => ['required', 'exists:listings,id']
        ], [
            'images.*.image' => 'One or more selected files are not valid images.',
            'images.*.max' => 'One or more images exceed the maximum file size (3MB).'
        ]);

        $user = Auth::user();

        $listing = Listing::where('id', $request->listing_id)
            // ->where('user_id', $user->id)
            ->first();

        if (!$listing) {
            return response()->json(['error' => 'Unauthorized: You do not own this listing.'], 403);
        }

        $imagePath = $this->uploadMultipleImage($request, 'images');

        if (isset($imagePath['error'])) {
            return response()->json(['error' => $imagePath['error']], 422);
        }

        foreach ($imagePath as $path) {
            ListingImageGallery::create([
                'listing_id' => $request->listing_id,
                'image_path' => $path
            ]);
        }

        return response()->json(['message' => 'Images uploaded successfully'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();

            $image = ListingImageGallery::findOrFail($id);
            $listing = Listing::where('id', $image->listing_id)
                // ->where('user_id', $user->id)
                ->first();

            if (!$listing) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized: You do not own this listing.'
                ], 403);
            }

            $this->deleteFile($image->image);
            $image->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}