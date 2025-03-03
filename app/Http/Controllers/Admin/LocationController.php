<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LocationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationStoreRequest;
use App\Http\Requests\Admin\LocationUpdateRequest;
use App\Models\Location;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class LocationController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(LocationDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.location.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return View('admin.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationStoreRequest $request): RedirectResponse
    {
        $locationPath = $this->uploadImage($request, 'location_image');

        $location = new Location();
        $location->name = $request->name;
        $location->location_image = $locationPath;
        $location->show_at_home = $request->show_at_home;
        $location->status = $request->status;
        $location->parent_location = $request->parent_location;
        $location->description = $request->description;
        $location->slug = Str::slug($request->name);
        $location->save();

        toastr()->success('Created Successfully');

        return to_route('admin.location.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $locations = Location::all();
        $location = Location::findOrFail($id);
        return view('admin.location.edit', compact('location', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationUpdateRequest $request, string $id): RedirectResponse
    {

        $locationPath = $this->uploadImage($request, 'location_image', $request->old_image);

        $location = Location::findOrFail($id);
        $location->name = $request->name;
        $location->location_image = !empty($locationPath) ? $locationPath : $request->old_image;
        $location->show_at_home = $request->show_at_home;
        $location->status = $request->status;
        $location->parent_location = $request->parent_location;
        $location->description = $request->description;
        $location->slug = Str::slug($request->name);
        $location->save();

        toastr()->success('Updated Successfully');

        return to_route('admin.location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $this->deleteFile($location->location_image);

        $location->delete();

        return response(['status' => 'success', 'message' => 'Item deleted Successfully!']);
    }
}