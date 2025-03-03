<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\PackageStoreRequest;
use App\Http\Requests\Admin\PackageUpdateRequest;
use App\Models\Package;
use App\Models\PackageServiceVariant;
use Auth;
use Illuminate\Http\Request;
use Str;

class TreatmentPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $package = Package::all();

        if ($package->isEmpty()) {
            return response()->json([
                'message' => 'No package found'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreRequest $request)
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

        // Return a success response
        return response()->json([
            'message' => 'Package created successfully',
            'package' => $package // Optionally return the created package
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageUpdateRequest $request, string $id)
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

        return response()->json(['status' => 'success', 'message' => 'Updated Successfully', 'data' => $package]);
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

        // Updated response for API
        return response()->json([
            'status' => 'success',
            'message' => 'Package deleted successfully!',
            'data' => null // Optional: include data if needed
        ], 200);
    }
}