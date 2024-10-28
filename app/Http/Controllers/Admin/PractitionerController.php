<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PractitionerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PractitionerStoreRequest;
use App\Http\Requests\Admin\PractitionerUpdateRequest;
use App\Models\Practitioner;
use App\Models\PractitionerCertificate;
use App\Models\ProfessionalCertificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class PractitionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PractitionerDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.practitioner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $certificates = ProfessionalCertificate::all();
        return view('admin.practitioner.create', compact('certificates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PractitionerStoreRequest $request): RedirectResponse
    {
        $practitioner = new Practitioner();
        $practitioner->user_id = auth()->user()->id;
        $practitioner->slug = Str::slug($request->name);
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->save();


        // Store certificates
        $certificates = $request->input('certificates', []);
        foreach ($certificates as $certificateId) {
            $practitionerCertificate = new PractitionerCertificate();
            $practitionerCertificate->practitioner_id = $practitioner->id;
            $practitionerCertificate->certificate_id = $certificateId;
            $practitionerCertificate->save();
        }
        toastr()->success('Created Successfully');

        return redirect()->route('admin.practitioner.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $practitioner = Practitioner::findOrFail($id);
        $certificates = ProfessionalCertificate::all();
        return view('admin.practitioner.edit', compact('practitioner', 'certificates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PractitionerUpdateRequest $request, string $id): RedirectResponse
    {
        $practitioner = Practitioner::findOrFail($id);
        $practitioner->name = $request->name;
        $practitioner->qualification = $request->qualification;
        $practitioner->save();

        // Update certificates
        $certificates = $request->input('certificates', []);

        // Remove certificates that are not in the updated list
        $practitioner->certificates()->whereNotIn('certificate_id', $certificates)->delete();

        // Add new certificates
        $existingCertificates = $practitioner->certificates()->pluck('certificate_id')->toArray();
        foreach ($certificates as $certificateId) {
            if (!in_array($certificateId, $existingCertificates)) {
                $practitionerCertificate = new PractitionerCertificate();
                $practitionerCertificate->practitioner_id = $practitioner->id;
                $practitionerCertificate->certificate_id = $certificateId;
                $practitionerCertificate->save();
            }
        }

        toastr()->success('Updated Successfully');
        return redirect()->route('admin.practitioner.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        // Delete associated PractitionerCertificate records
        $practitioner->certificates()->delete();

        // Delete the practitioner
        $practitioner->delete();

        return response(['status' => 'success', 'message' => 'Practitioner and associated certificates deleted successfully!']);
    }
}
