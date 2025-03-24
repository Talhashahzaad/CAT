<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\ListingPackage;
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
        return response()->json($blog);
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
        return response()->json($blog);
    }

    public function blogCategory()
    {
        $category = BlogCategory::where('status', 1)->get();

        if ($category->count() === 0) {
            return response()->json(['error' => 'Blog Category not Available'], 404);
        }
        return response()->json($category);
    }

    public function listingPackage()
    {
        $package = ListingPackage::where('status', 1)->get();

        if ($package->count() === 0) {
            return response()->json(['error' => 'No Listing Package Found!'], 404);
        }

        return response()->json($package);
    }
}