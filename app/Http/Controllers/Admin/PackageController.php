<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PackageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageStoreRequest;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Package;
use App\Models\PackageServiceVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\PackageUpdateRequest;
use Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PackageDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.package.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $services = Service::with('priceVariants')->get();
        $category = Category::all();
        return view('admin.package.create', compact('services', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreRequest $request): RedirectResponse
    {
        // dd($request->all());
        $validated = $request->validated();

        // Create the package
        $package = new Package();
        $package->user_id = Auth::user()->id;
        $package->name = $validated['name'];
        $package->slug = Str::slug($validated['name']);
        $package->status = $validated['status'];
        $package->category = $validated['category'];
        $package->description = $validated['description'];
        $package->total_price = $validated['retail_price'];
        $package->discount_percentage = $validated['discount_percentage'];
        $package->total_time = $validated['total_duration'];
        $package->price_type = $validated['price_type'];
        $package->available_for = $validated['available_for'];
        $package->save();

        // Create package service variants
        foreach ($validated['services'] as $key => $serviceId) {
            $packageServiceVariant = new PackageServiceVariant();
            $packageServiceVariant->package_id = $package->id;
            $packageServiceVariant->treatment_name = $serviceId; // Assuming serviceId is the treatment name
            $packageServiceVariant->treatment_category = 'default'; // You may need to adjust this
            $packageServiceVariant->variants = $validated['variants'][$key];
            $packageServiceVariant->duration = $validated['service_durations'][$key];
            $packageServiceVariant->price = $validated['service_prices'][$key];
            $packageServiceVariant->save();
        }

        toastr()->success('Created Successfully');

        return to_route('admin.package.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $package = Package::with('packageServiceVariants')->findOrFail($id);
        $categories = Category::all();
        $services = Service::with('priceVariants')->get();
        return view('admin.package.edit', compact('package', 'categories', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageUpdateRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $package = Package::findOrFail($id);
        $package->name = $validated['name'];
        $package->slug = Str::slug($validated['name']);
        $package->status = $validated['status'];
        $package->category = $validated['category'];
        $package->description = $validated['description'];
        $package->total_price = $validated['retail_price'];
        $package->discount_percentage = $validated['discount_percentage'];
        $package->total_time = $validated['total_duration'];
        $package->price_type = $validated['price_type'];
        $package->available_for = $validated['available_for'];
        $package->save();

        // Get existing package service variants
        $existingVariants = $package->packageServiceVariants()->pluck('id')->toArray();

        // Create or update package service variants
        $updatedVariantIds = [];
        foreach ($validated['services'] as $key => $serviceId) {
            $variantData = [
                'package_id' => $package->id,
                'treatment_name' => $serviceId,
                'treatment_category' => 'default', // You may need to adjust this
                'variants' => $validated['variants'][$key],
                'duration' => $validated['service_durations'][$key],
                'price' => $validated['service_prices'][$key],
            ];

            $packageServiceVariant = PackageServiceVariant::updateOrCreate(
                [
                    'package_id' => $package->id,
                    'treatment_name' => $serviceId,
                    'variants' => $validated['variants'][$key],
                ],
                $variantData
            );

            $updatedVariantIds[] = $packageServiceVariant->id;
        }

        // Delete variants that are no longer in the updated list
        $variantsToDelete = array_diff($existingVariants, $updatedVariantIds);
        PackageServiceVariant::destroy($variantsToDelete);

        toastr()->success('Updated Successfully');

        return to_route('admin.package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::findOrFail($id);

        // Delete associated PackageServiceVariant records
        $package->packageServiceVariants()->delete();

        // Delete the package
        $package->delete();

        return response(['status' => 'success', 'message' => 'Package deleted successfully!']);
    }
}
