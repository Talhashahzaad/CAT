<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class FrontendAuthController extends Controller
{

    /** API Frontend Login */

    public function loginApi(Request $request): JsonResponse
    {
        $incomingFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($incomingFields)) {
            $user = User::where('email', $incomingFields['email'])->first();
            $token = $user->createToken('ourapptoken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function storeApi(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Trigger the registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    /**
     * API Logout
     */

    public function logoutApi(Request $request)
    {
        // Debugging: Check if session is started
        if (!$request->session()->isStarted()) {
            return response()->json(['error' => 'Session not started'], 400);
        }

        // Proceed with logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}