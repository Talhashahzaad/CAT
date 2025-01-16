<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //

    use FileUploadTrait;

    public function index(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'User Profile',
            'user' => $user,
        ], 200);
    }

    function update(ProfileUpdateRequest $request): JsonResponse
    {

        $user = Auth::user();
        if ($user) {

            $avatarPath = $this->uploadImage($request, 'avatar', $request->old_avatar);
            $bannerPath = $this->uploadImage($request, 'banner', $request->old_banner);

            $user = Auth::user();
            $user->avatar = !empty($avatarPath) ? $avatarPath : $request->old_avatar;
            $user->banner = !empty($bannerPath) ? $bannerPath : $request->old_banner;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->about = $request->about;
            $user->website = $request->website;
            $user->fb_link = $request->fb_link;
            $user->tt_link = $request->tt_link;
            $user->yt_link = $request->yt_link;
            $user->ig_link = $request->ig_link;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully!',
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }

    function passwordUpdate(Request $request): JsonResponse
    {

        $user = Auth::user();

        if ($user) {

            $request->validate([
                'password' => ['required', 'min:5', 'confirmed']
            ]);

            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }
}
