<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfessionalCertificateStoreRequest;
use App\Http\Requests\Admin\ProfessionalCertificateUpdateRequest;
use App\Models\ProfessionalCertificate;
use App\Traits\ChecksOwnership;
use Auth;
use Illuminate\Http\Request;
use Str;

class ProfessionalCertificateController extends Controller
{

    use ChecksOwnership;

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

        $certificate = ProfessionalCertificate::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($certificate->isEmpty()) {
            return response()->json([
                'message' => 'No certificate found'
            ], 404);
        }

        return response()->json([
            'certificate' => $certificate
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfessionalCertificateStoreRequest $request)
    {
        $validated = $request->validated();

        $certificate = new ProfessionalCertificate();
        $certificate->user_id = Auth::user()->id;
        $certificate->name = $validated['name'];
        $certificate->slug = Str::slug($validated['name']);
        $certificate->description = $validated['description'];
        $certificate->save();

        return response()->json([
            'message' => 'Certificate created successfully',
            'certificate' => $certificate
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfessionalCertificateUpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $certificate = ProfessionalCertificate::findOrFail($id);

        $user = Auth::user();
        $certificate->user_id = $user->id;
        $certificate->name = $validated['name'];
        $certificate->slug = Str::slug($validated['name']);
        $certificate->description = $validated['description'];
        $certificate->save();

        return response()->json([
            'message' => 'Certificate updated successfully',
            'certificate' => $certificate
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $certificate = ProfessionalCertificate::find($id);
        $user = Auth::user();
        if ($certificate->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        $certificate->delete();

        return response()->json([
            'message' => 'Certificate deleted successfully'
        ], 200);
    }
}