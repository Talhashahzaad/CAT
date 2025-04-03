<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PackageStoreApiRequest;
use App\Http\Requests\Api\PackageUpdateApiRequest;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageServiceVariant;
use App\Models\Service;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class TreatmentPackage extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $services = Service::with('priceVariants')->where('status', 1)->get();
        $category = Category::where('status', 1)->get();
        $package = Package::where('status', 1)
            ->where('user_id', $user->id)
            ->get();

        if ($package->isEmpty()) {
            return response()->json([
                'message' => 'No treatment package found'
            ], 404);
        }

        return response()->json([
            'services' => $services,
            'categories' => $category,
            'packages' => $package,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Create the package
        $package = new Package();
        $package->user_id = $user->id;
        $package->name = $validated['name'];
        $package->slug = Str::slug($validated['name']);
        $package->status = $validated['status'];
        $package->category = $validated['category'];
        $package->description = $validated['description'] ?? null;
        $package->total_price = floatval($validated['retail_price']);
        $package->discount_percentage = isset($validated['discount_percentage']) ? floatval($validated['discount_percentage']) : null;
        $package->total_time = $validated['total_duration'];
        $package->price_type = $validated['price_type'];
        $package->available_for = $validated['available_for'];
        $package->save();

        // Store package service variants
        foreach ($validated['services'] as $key => $serviceName) {
            // Ensure indexes exist to avoid undefined index errors
            $variant = $validated['variants'][$key] ?? null;
            $duration = $validated['service_durations'][$key] ?? null;
            $price = $validated['service_prices'][$key] ?? null;

            PackageServiceVariant::create([
                'package_id' => $package->id,
                'treatment_name' => $serviceName, // Using service name directly
                'treatment_category' => 'default', // Default value, you can adjust this
                'variants' => $variant,
                'duration' => $duration,
                'price' => $price,
            ]);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Package created successfully',
            'package' => $package->load('packageServiceVariants'),
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PackageUpdateApiRequest $request, string $id): JsonResponse
    {

        $validated = $request->validated();


        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $package = Package::findOrFail($id);
        if ($package->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }

        // Update package details
        $package->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'status' => $validated['status'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'total_price' => floatval($validated['retail_price']),
            'discount_percentage' => isset($validated['discount_percentage']) ? floatval($validated['discount_percentage']) : null,
            'total_time' => $validated['total_duration'],
            'price_type' => $validated['price_type'],
            'available_for' => $validated['available_for'],
        ]);

        // Get existing variants for the package
        $existingVariants = $package->packageServiceVariants()->pluck('id')->toArray();
        $updatedVariantIds = [];

        // Update or create package service variants
        foreach ($validated['services'] as $key => $serviceName) {
            $variantData = [
                'package_id' => $package->id,
                'treatment_name' => $serviceName,
                'treatment_category' => 'default', // Default category, change if needed
                'variants' => $validated['variants'][$key] ?? null,
                'duration' => $validated['service_durations'][$key] ?? null,
                'price' => $validated['service_prices'][$key] ?? null,
            ];

            $packageServiceVariant = PackageServiceVariant::updateOrCreate(
                [
                    'package_id' => $package->id,
                    'treatment_name' => $serviceName,
                    'variants' => $validated['variants'][$key] ?? null,
                ],
                $variantData
            );

            $updatedVariantIds[] = $packageServiceVariant->id;
        }

        // Delete variants not in the updated list
        $variantsToDelete = array_diff($existingVariants, $updatedVariantIds);
        PackageServiceVariant::destroy($variantsToDelete);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully',
            'package' => $package->load('packageServiceVariants'),
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $package = Package::findOrFail($id);

        // Delete associated PackageServiceVariant records
        $package->packageServiceVariants()->delete();
        if ($package->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        // Delete the package
        $package->delete();

        return response()->json(['success' => 'Package deleted successfully!'], 200);
    }
}