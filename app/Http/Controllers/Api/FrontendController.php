<?php

namespace App\Http\Controllers\Api;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\CatVideoUpload;
use App\Models\Coupon;
use App\Models\Listing;
use App\Models\ListingPackage;
use App\Models\Location;
use App\Models\Tag;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Session;

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

    public function category()
    {
        $category = Category::where('status', 1)->get();
        if ($category->count() === 0) {
            return response()->json(['error' => 'No Category Found!'], 404);
        }
        return response()->json($category);
    }

    public function catVideoUpload()
    {
        $video = CatVideoUpload::where('status', 1)->get();
        if ($video->count() === 0) {
            return response()->json(['error' => 'No Video Found!'], 404);
        }
        return response()->json($video);
    }

    public function location()
    {
        $location = Location::where('status', 1)->get();
        if ($location->count() === 0) {
            return response()->json(['error' => 'No Location Found!'], 404);
        }
        return response()->json($location);
    }

    public function checkout($id)
    {
        // Find the listing package
        $listing = ListingPackage::find($id);

        // If not found, return an error response
        if (!$listing) {
            return response()->json(['error' => 'Listing Package not found'], 404);
        }

        if ($listing->type === 'free' || $listing->price == 0) {
            $paymentInfo = [
                'transaction_id' => uniqid(),
                'payment_method' => 'free',
                'paid_amount' => 0,
                'paid_currency' => config('settings.site_default_currency'),
                'payment_status' => 'completed',
                'user_id' => Auth::id(),
                'package_id' => $listing->id
            ];

            CreateOrder::dispatch($paymentInfo);
            return response()->json([
                'message' => 'Package subscribed successfully',
                'selected_package_id' => $listing->id,
                'listing' => $listing
            ]);
        }
        // Return the listing details
        return response()->json([
            'message' => 'Package stored in session successfully',
            'selected_package_id' => $listing->id,
            'listing' => $listing
        ]);
    }

    public function amenity()
    {
        $amenity = Amenity::where('status', 1)->get();
        if ($amenity->count() === 0) {
            return response()->json(['error' => 'No Amenity Found!'], 404);
        }
        return response()->json($amenity);
    }

    public function tag()
    {
        $tag = Tag::where('status', 1)->get();
        if ($tag->count() === 0) {
            return response()->json(['error' => 'No Tag Found!'], 404);
        }
        return response()->json($tag);
    }

    public function searchListings(Request $request)
    {
        $query = Listing::with('tags')->where('status', 1);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('description', 'like', "%{$searchTerm}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($searchTerm) {
                        $tagQuery->where('name', 'like', "%{$searchTerm}%"); // assuming your tag table has a 'name' column
                    });
            });
        }

        $listings = $query->get();

        if ($listings->isEmpty()) {
            return response()->json(['error' => 'No listings found!'], 404);
        }

        return response()->json($listings);
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'package_id' => 'required|integer',
        ]);

        $coupon = Coupon::where('status', 1)
            ->where('code', $request->coupon_code)
            ->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Coupon does not exist!'], 404);
        }

        if ($coupon->start_date > Carbon::now()->toDateString()) {
            return response()->json(['status' => 'error', 'message' => 'Coupon not active yet!'], 400);
        }

        if ($coupon->end_date < Carbon::now()->toDateString()) {
            return response()->json(['status' => 'error', 'message' => 'Coupon expired!'], 400);
        }

        if ($coupon->total_used >= $coupon->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Coupon usage limit reached'], 400);
        }

        $package = ListingPackage::find($request->package_id);
        if (!$package) {
            return response()->json(['status' => 'error', 'message' => 'Invalid package ID'], 404);
        }

        $discount = 0;
        if ($coupon->discount_type === 'amount') {
            $discount = $coupon->discount;
        } elseif ($coupon->discount_type === 'percent') {
            $discount = ($package->price * $coupon->discount) / 100;
        }

        $finalAmount = max(0, round($package->price - $discount, 2));

        // Cache coupon data against user
        $cacheKey = 'coupon_user_' . Auth::id() . '_package_' . $package->id;
        Cache::put($cacheKey, [
            'coupon_id' => $coupon->id,
            'discount' => $discount,
            'final_amount' => $finalAmount,
        ], now()->addMinutes(30));

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'final_amount' => $finalAmount,
            'discount' => $discount,
            'original_price' => $package->price
        ]);
    }
}