<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Models\Service;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatment = Service::all();

        if ($treatment->isEmpty()) {
            return response()->json([
                'message' => 'No treatment found'
            ], 404);
        }
    }
    // public function store(ServiceStoreRequest $request)
    // {
    //     try {
    //         // Ensure prices is an array
    //         $prices = is_array($request->price) ? $request->price : json_decode($request->price, true);

    //         if (!is_array($prices)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid price format. Expected an array.',
    //             ], 400);
    //         }

    //         // Calculate the total price
    //         $totalPrice = 0;
    //         foreach ($prices as $priceData) {
    //             // If priceData is a number, add it directly
    //             if (is_numeric($priceData)) {
    //                 $totalPrice += floatval($priceData);
    //             }
    //             // If priceData is an associative array, check for 'price' key
    //             elseif (is_array($priceData) && isset($priceData['price']) && (!isset($priceData['type']) || $priceData['type'] !== 'Free')) {
    //                 $totalPrice += floatval($priceData['price']);
    //             }
    //         }

    //         // Store the service
    //         $service = new Service();
    //         $service->user_id = Auth::user()->id;
    //         $service->name = $request->name;
    //         $service->status = $request->status;
    //         $service->total_price = ceil($totalPrice);
    //         $service->category = $request->category;
    //         $service->service_type = $request->service_type;
    //         $service->slug = Str::slug($request->name);
    //         $service->description = $request->description;
    //         $service->save();

    //         // Save price variants
    //         foreach ($prices as $priceData) {
    //             if (is_array($priceData)) { // Ensure it's an array before accessing keys
    //                 $service->priceVariants()->create([
    //                     'name' => $priceData['name'] ?? 'Default Name',  // Use default value if key is missing
    //                     'description' => $priceData['description'] ?? '',
    //                     'duration' => $priceData['duration'] ?? 0,
    //                     'price_type' => $priceData['type'] ?? 'Paid',
    //                     'price' => ($priceData['type'] ?? 'Paid') !== 'Free' ? ($priceData['price'] ?? 0) : null,
    //                 ]);
    //             }
    //         }

    //         return response()->json([
    //             'message' => 'Treatment created successfully',
    //             'success' => true,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred while creating the service.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request): JsonResponse
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
            'message' => 'Service created successfully',
            'data' => $service
        ], 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            // Find the service
            $service = Service::findOrFail($id);

            // Validate request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|integer',
                'category' => 'required|integer',
                'service_type' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration' => 'required|array',
                'duration.*' => 'string',
                'price_type' => 'required|array',
                'price_type.*' => 'string',
                'price' => 'required|array',
                'price.*' => 'numeric',
                'variant_name' => 'required|array',
                'variant_name.*' => 'string',
                'variant_description' => 'required|array',
                'variant_description.*' => 'string',
                'variant_id' => 'nullable|array',
                'variant_id.*' => 'nullable|integer|exists:price_variants,id',
            ]);

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


    // public function update(Request $request, string $id): JsonResponse
    // {
    //     // Find the service by ID
    //     $service = Service::find($id);
    //     if (!$service) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Service not found.'
    //         ], 404);
    //     }

    //     // Validate request
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'status' => 'required|integer',
    //         'category' => 'required|integer',
    //         'service_type' => 'required|string',
    //         'description' => 'required|string',
    //         'duration' => 'required|array',
    //         'price_type' => 'required|array',
    //         'price' => 'required|array',
    //         'variant_name' => 'required|array',
    //         'variant_description' => 'required|array',
    //     ]);

    //     // Extract arrays from request
    //     $durations = $validatedData['duration'];
    //     $priceTypes = $validatedData['price_type'];
    //     $prices = $validatedData['price'];
    //     $variantNames = $validatedData['variant_name'];
    //     $variantDescriptions = $validatedData['variant_description'];

    //     // Ensure all arrays have the same length
    //     $totalVariants = count($prices);
    //     if (
    //         count($durations) !== $totalVariants ||
    //         count($priceTypes) !== $totalVariants ||
    //         count($variantNames) !== $totalVariants ||
    //         count($variantDescriptions) !== $totalVariants
    //     ) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'All variant-related fields must have the same number of elements.'
    //         ], 400);
    //     }

    //     // Calculate the total price
    //     $totalPrice = 0;
    //     foreach ($prices as $index => $price) {
    //         if ($priceTypes[$index] !== 'Free') {
    //             $totalPrice += floatval($price);
    //         }
    //     }

    //     // Update service details
    //     $service->update([
    //         'name' => $validatedData['name'],
    //         'status' => $validatedData['status'],
    //         'category' => $validatedData['category'],
    //         'service_type' => $validatedData['service_type'],
    //         'slug' => Str::slug($validatedData['name']),
    //         'description' => $validatedData['description'],
    //         'total_price' => $totalPrice,
    //     ]);

    //     // Delete existing price variants before updating
    //     $service->priceVariants()->delete();

    //     // Store new price variants
    //     for ($i = 0; $i < $totalVariants; $i++) {
    //         $service->priceVariants()->create([
    //             'name' => $variantNames[$i],
    //             'description' => $variantDescriptions[$i],
    //             'duration' => $durations[$i],
    //             'price_type' => $priceTypes[$i],
    //             'price' => $priceTypes[$i] !== 'Free' ? $prices[$i] : null,
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Service updated successfully',
    //         'data' => $service
    //     ], 200);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(['success' => 'Treatment deleted successfully!'], 200);
    }
}