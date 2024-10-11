<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists by Google ID
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // If not found by Google ID, check by email
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // User exists but doesn't have Google ID, update it
                    $user->google_id = $googleUser->id;
                    $user->save();
                } else {
                    // User doesn't exist, create new user
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => bcrypt(Str::random(16)) // Generate a random password
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to authenticate with Google. Please try again.');
        }
    }
}