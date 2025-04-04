<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PractitionerStoreRequest;
use App\Http\Requests\Admin\PractitionerUpdateRequest;
use App\Models\Practitioner;
use Auth;
use Illuminate\Http\Request;
use Str;

class PractitionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        $practitioners = Practitioner::where('user_id', $user->id)
            ->with(['packages' => function ($query) {
                $query->with('packageServiceVariants');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($practitioners->isEmpty()) {
            return response()->json(['message' => 'No practitioners found'], 404);
        }

        return response()->json($practitioners);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PractitionerStoreRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        $practitioner = new Practitioner();
        $practitioner->user_id = $user->id;
        $practitioner->slug = Str::slug($request->name);
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->certificate = $request->certificate;

        if ($practitioner->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Practitioner created successfully',
                'practitioner' => $practitioner
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create practitioner'
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PractitionerUpdateRequest $request, string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        $practitioner = Practitioner::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$practitioner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Practitioner not found or unauthorized'
            ], 404);
        }

        $practitioner->name = $request->name;
        $practitioner->slug = Str::slug($request->name);
        $practitioner->qualification = $request->qualification;
        $practitioner->certificate = $request->certificate;

        if ($practitioner->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Practitioner updated successfully',
                'data' => $practitioner
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update practitioner'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        $practitioner = Practitioner::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$practitioner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Practitioner not found or unauthorized'
            ], 404);
        }

        if ($practitioner->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Practitioner deleted successfully'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete practitioner'
        ], 500);
    }
}