<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingPackageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingPackageStoreRequest;
use App\Http\Requests\Admin\ListingPackageUpdateRequest;
use App\Models\ListingPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListingPackageDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.listing-package.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.listing-package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingPackageStoreRequest $request): RedirectResponse
    {
        $package = new ListingPackage();
        $package->type = $request->type;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->number_of_days = $request->number_of_days;
        $package->num_of_listing = $request->num_of_listing;
        $package->cat_ecommarce = $request->cat_ecommarce;
        $package->cat_pro_social_media = $request->cat_pro_social_media;
        $package->social_media_post = $request->social_media_post;
        $package->featured_listing = $request->featured_listing;
        $package->multiple_locations = $request->multiple_locations;
        $package->live_chat = $request->live_chat;
        $package->status = $request->status;
        $package->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.listing-package.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $package = ListingPackage::findOrFail($id);
        return view('admin.listing-package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingPackageUpdateRequest $request, string $id): RedirectResponse
    {
        $package = ListingPackage::findOrFail($id);
        $package->type = $request->type;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->number_of_days = $request->number_of_days;
        $package->num_of_listing = $request->num_of_listing;
        $package->cat_ecommarce = $request->cat_ecommarce;
        $package->cat_pro_social_media = $request->cat_pro_social_media;
        $package->social_media_post = $request->social_media_post;
        $package->featured_listing = $request->featured_listing;
        $package->multiple_locations = $request->multiple_locations;
        $package->live_chat = $request->live_chat;
        $package->status = $request->status;
        $package->save();

        toastr()->success('Updated Successfully!');

        return to_route('admin.listing-package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ListingPackage::findOrFail($id)->delete();

            return response(['status' => 'success', 'message' => 'Deleted successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}