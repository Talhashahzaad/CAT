<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function blogShow($slug)
    {
        $blog = Blog::where(['slug' => $slug, 'status' => 1])->get();

        // If the blog doesn't exist, return a 404 error
        if ($blog->isEmpty()) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        return response()->json($blog);
    }

    public function blog($slug)
    {
        $blog = Blog::where(['slug' => $slug, 'status' => 1])->get();

        // If the blog doesn't exist, return a 404 error
        if ($blog->isEmpty()) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        return response()->json($blog);
    }
}
