<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendDashboardController extends Controller
{
    //

    function index(Request $request): View
    {
        $user = $request->user(); // Get the authenticated user from the request

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Debugging: Log the user information
        \Log::info('Authenticated User:', ['user' => $user]);

        return view('admin.dashboard.index');
    }
}