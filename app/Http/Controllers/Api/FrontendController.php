<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\CatVideoUpload;
use App\Models\Listing;
use App\Models\ListingPackage;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FrontendController extends Controller
{
    public function blogShow($slug)
    {
        $blog = Blog::where(['slug' => $slug, 'status' => 1])->firstOrFail();

        // If the blog doesn't exist, return a 404 error
        if ($blog === null) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        return response()->json(
            [
                'data' => $blog
            ]
        );
    }

    public function blog()
    {
        $blog = Blog::with('user')->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // If the blog doesn't exist, return a 404 error
        if ($blog->isEmpty()) {
            return response()->json(['error' => 'Blog not Available'], 404);
        }
        return response()->json(
            [
                'data' => $blog
            ]
        );
    }

    public function blogCategory()
    {
        $category = BlogCategory::where('status', 1)->get();

        if ($category->count() === 0) {
            return response()->json(['error' => 'Blog Category not Available'], 404);
        }
        return response()->json(
            [
                'data' => $category
            ]
        );
    }

    public function listingPackage()
    {
        $package = ListingPackage::where('status', 1)->get();

        if ($package->count() === 0) {
            return response()->json(['error' => 'No Listing Package Found!'], 404);
        }

        return response()->json(
            [
                'data' => $package
            ]
        );
    }

    public function category()
    {
        $category = Category::where('status', 1)->get();
        if ($category->count() === 0) {
            return response()->json(['error' => 'No Category Found!'], 404);
        }
        return response()->json(
            [
                'data' => $category
            ]
        );
    }

    public function catVideoUpload()
    {
        $video = CatVideoUpload::where('status', 1)->get();
        if ($video->count() === 0) {
            return response()->json(['error' => 'No Video Found!'], 404);
        }
        return response()->json(
            [
                'data' => $video
            ]
        );
    }

    public function location()
    {
        $location = Location::where('status', 1)->get();
        if ($location->count() === 0) {
            return response()->json(['error' => 'No Location Found!'], 404);
        }
        return response()->json(
            [
                'data' => $location
            ]
        );
    }

    public function checkout($id)
    {
        $listing = ListingPackage::find($id);
        if ($listing === null) {
            return response()->json(['error' => 'Listing Package not found'], 404);
        }
        return response()->json(
            [
                'data' => $listing
            ]
        );
    }

    public function amenity()
    {
        $amenity = Amenity::where('status', 1)->get();
        if ($amenity->count() === 0) {
            return response()->json(['error' => 'No Amenity Found!'], 404);
        }
        return response()->json(
            [
                'data' => $amenity
            ]
        );
    }

    public function tag()
    {
        $tag = Tag::where('status', 1)->get();
        if ($tag->count() === 0) {
            return response()->json(['error' => 'No Tag Found!'], 404);
        }
        return response()->json(
            [
                'data' => $tag
            ]
        );
    }
}