<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserBusinessCategory;
use Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function signup(Request $request)
    {

        $validateUser  = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone' => 'required|numeric',
                'heard_about_options' => 'required',
                'business_location' => 'required',
                'business_size' => 'required',
                'premises_count' => 'required',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation Error",
                'errors' => $validateUser->errors()->all()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'agent',
            'password' => $request->password,
            'heard_about_options' => $request->heard_about_options,
            'business_location' => $request->business_location,
            'business_size' => $request->business_size,
            'premises_count' => $request->premises_count,
            'phone' => $request->phone,

        ]);
        foreach ($request->categories as $categoriesId) {

            $categories = new UserBusinessCategory();
            $categories->user_id = $user->id;
            $categories->category_id = $categoriesId;
            $categories->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user,

        ], 200);
    }


    public function signupUser(Request $request)
    {

        $validateUser  = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone' => 'required|numeric',
                'heard_about_options' => 'required',
                'main_location' => 'required',
                'age_group' => 'required',

            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation Error",
                'errors' => $validateUser->errors()->all()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'heard_about_options' => $request->heard_about_options,
            'main_location' => $request->main_location,
            'age_group' => $request->age_group,
            'phone' => $request->phone,

        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user,

        ], 200);
    }


    public function login(Request $request)
    {
        $userValidate = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($userValidate->fails()) {
            return response()->json([

                'status' => false,
                'message' => "Authentication failed",
                'errors' => $userValidate->errors()->all()
            ], 404);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();

            return response()->json([
                'status' => true,
                'message' => 'User Logged in successfully',
                'token' => $authUser->createToken("API Token")->plainTextToken,
                'token_type' => 'Bearer',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match',
                'errors' => []
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'You logged Out Successfully',
            'user' => $user,
        ], 200);
    }
}