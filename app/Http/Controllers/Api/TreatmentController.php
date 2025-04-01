<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceStoreApiRequest;
use App\Http\Requests\Api\ServiceUpdateApiRequest;
use App\Models\Service;
use App\Traits\ChecksOwnership;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class TreatmentController extends Controller
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

        $treatment = Service::with('priceVariants')
            ->where('status', 1)
            // ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($treatment->isEmpty()) {
            return response()->json([
                'message' => 'No treatment found'
            ], 404);
        }

        if ($treatment->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'All Treatment Data.',
            'treatment' => $treatment
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreApiRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        // Extract arrays from the request
        $durations = $validatedData['duration'] ?? [];
        $priceTypes = $validatedData['price_type'] ?? [];
        $prices = $validatedData['price'] ?? [];
        $variantNames = $validatedData['variant_name'] ?? [];
        $variantDescriptions = $validatedData['variant_description'] ?? [];

        // Ensure all arrays have the same length
        $totalVariants = count($prices);
        if (
            count($durations) !== $totalVariants ||
            count($priceTypes) !== $totalVariants ||
            count($variantNames) !== $totalVariants ||
            count($variantDescriptions) !== $totalVariants
        ) {
            return response()->json([
                'success' => false,
                'message' => 'All variant-related fields must have the same number of elements.'
            ], 400);
        }

        // Calculate the total price
        $totalPrice = 0;
        foreach ($prices as $index => $price) {
            if ($priceTypes[$index] !== 'Free') {
                $totalPrice += floatval($price);
            }
        }

        // Create service
        $service = new Service();
        $service->user_id = Auth::user()->id;
        $service->name = $validatedData['name'];
        $service->status = $validatedData['status'];
        $service->total_price = ceil($totalPrice);
        $service->category = $validatedData['category'];
        $service->service_type = $validatedData['service_type'];
        $service->slug = Str::slug($validatedData['name']);
        $service->description = $validatedData['description'];
        $service->save();

        // Store price variants
        for ($i = 0; $i < $totalVariants; $i++) {
            $service->priceVariants()->create([
                'name' => $variantNames[$i],
                'description' => $variantDescriptions[$i],
                'duration' => $durations[$i],
                'price_type' => $priceTypes[$i],
                'price' => $priceTypes[$i] !== 'Free' ? $prices[$i] : null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Treatment created successfully',
            'data' => $service
        ], 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateApiRequest $request, string $id): JsonResponse
    {
        try {
            // Find the service
            $user = Auth::user();

            $service = Service::findOrFail($id);
            if ($service->user_id != $user->id) {
                return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
            }


            // Validate request
            $validatedData = $request->validated();



            // Extract arrays
            $durations = $validatedData['duration'];
            $priceTypes = $validatedData['price_type'];
            $prices = $validatedData['price'];
            $variantNames = $validatedData['variant_name'];
            $variantDescriptions = $validatedData['variant_description'];
            $variantIds = $validatedData['variant_id'] ?? array_fill(0, count($prices), null);

            // Ensure all arrays have the same length
            if (
                count($durations) !== count($prices) ||
                count($priceTypes) !== count($prices) ||
                count($variantNames) !== count($prices) ||
                count($variantDescriptions) !== count($prices)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'All variant-related fields must have the same number of elements.'
                ], 400);
            }

            // Update service details
            $service->update([
                'name' => $validatedData['name'],
                'status' => $validatedData['status'],
                'category' => $validatedData['category'],
                'service_type' => $validatedData['service_type'],
                'slug' => Str::slug($validatedData['name']),
                'description' => $validatedData['description'],
            ]);

            // Calculate total price
            $totalPrice = 0;
            $updatedVariantIds = [];

            foreach ($prices as $index => $price) {
                $variantData = [
                    'name' => $variantNames[$index],
                    'description' => $variantDescriptions[$index],
                    'duration' => $durations[$index],
                    'price_type' => $priceTypes[$index],
                    'price' => $priceTypes[$index] !== 'Free' ? floatval($price) : 0,
                ];

                if ($variantIds[$index]) {
                    // Update existing variant
                    $service->priceVariants()->where('id', $variantIds[$index])->update($variantData);
                    $updatedVariantIds[] = $variantIds[$index];
                } else {
                    // Create new variant

                    $newVariant = $service->priceVariants()->create($variantData);
                    $updatedVariantIds[] = $newVariant->id;
                }

                $totalPrice += $variantData['price'];
            }

            // Update total price
            $service->update(['total_price' => ceil($totalPrice)]);

            // Delete removed variants
            $service->priceVariants()->whereNotIn('id', $updatedVariantIds)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'data' => $service->load('priceVariants')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the service',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $service = Service::findOrFail($id);
        if ($service->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }
        $service->delete();
        return response()->json(['success' => 'Treatment deleted successfully!'], 200);
    }
}