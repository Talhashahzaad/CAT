<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProfessionalCertificatesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfessionalCertificateStoreRequest;
use App\Http\Requests\Admin\ProfessionalCertificateUpdateRequest;
use App\Models\ProfessionalCertificate;
use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Str;

class ProfessionalCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProfessionalCertificatesDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.certificate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.certificate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfessionalCertificateStoreRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        // Create the package
        $package = new ProfessionalCertificate();
        $package->name = $validated['name'];
        $package->user_id = Auth::user()->id;
        $package->slug = Str::slug($validated['name']);
        $package->description = $validated['description'];
        $package->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.certificate.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $certificate = ProfessionalCertificate::findOrFail($id);
        return view('admin.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfessionalCertificateUpdateRequest $request, string $id): RedirectResponse
    {

        $certificate = ProfessionalCertificate::findOrFail($id);

        $validated = $request->validated();
        $certificate->name = $validated['name'];
        $certificate->description = $validated['description'];
        $certificate->save();
        toastr()->success('Updated Successfully');
        return redirect()->route('admin.certificate.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $certificate = ProfessionalCertificate::findOrFail($id);
        $certificate->delete();
        return response(['status' => 'success', 'message' => 'Item deleted Successfuly!']);
    }
}