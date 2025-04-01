<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingVideoGallery;
use Auth;
use Illuminate\Http\Request;

class ListingVideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $videos = ListingVideoGallery::where('listing_id', $listing->id)
            ->select('id', 'video_url')
            ->get();

        if ($videos->isEmpty()) {
            return response()->json(['message' => 'No videos  found'], 404);
        }

        return response()->json([
            'listing_title' => $listing->title,
            'videos' => $videos
        ], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'video_url' => ['required', 'url'],
            'listing_id' => ['required', 'integer', 'exists:listings,id'],
        ]);

        $user = Auth::user();

        $listing = Listing::where('id', $request->listing_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$listing) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $video = new ListingVideoGallery();
        $video->listing_id = $request->listing_id;
        $video->video_url = $request->video_url;
        $video->save();

        return response()->json(['message' => 'Video uploaded successfully'], 201);
    }

    public function show($id)
    {
        return response()->json(['error' => 'Not Implemented'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        try {
            $user = Auth::user();

            $video = ListingVideoGallery::findOrFail($id);
            $listing = Listing::where('id', $video->listing_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$listing) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }

            $video->delete();
            return response()->json(['message' => 'Video deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}