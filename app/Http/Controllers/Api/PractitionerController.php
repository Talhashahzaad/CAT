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
            ->orderBy('created_at', 'desc')
            ->get();

        $practitioners = Practitioner::orderBy('created_at', 'desc')->get();


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
        $practitioner = new Practitioner();
        $practitioner->user_id = Auth::user()->id;
        $practitioner->slug = Str::slug($request->name);
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->certificate = $request->certificate;
        $practitioner->save();
        return response()->json(['success' => 'Practitioner created successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PractitionerUpdateRequest $request, string $id)
    {
        $practitioner = Practitioner::findOrFail($id);
        $user = Auth::user();
        if ($practitioner->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->certificate = $request->certificate;
        $practitioner->save();
        return response()->json(['success' => 'Practitioner Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $practitioner = Practitioner::findOrFail($id);
        $user = Auth::user();

        if ($practitioner->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        // Delete the practitioner
        $practitioner->delete();

        return response()->json(['success' => 'Practitioner deleted successfully!'], 200);
    }
}