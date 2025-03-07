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

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ServiceStoreRequest $request)
    // {
    //     // Decode the price JSON from the request
    //     $prices = json_decode($request->price, true);

    //     // Calculate the total price
    //     $totalPrice = 0;
    //     foreach ($prices as $priceData) {
    //         if ($priceData['type'] !== 'Free' && isset($priceData['price'])) {
    //             $totalPrice += floatval($priceData['price']);
    //         }
    //     }

    //     $service = new Service();
    //     $service->user_id = Auth::user()->id;
    //     $service->name = $request->name;
    //     $service->status = $request->status;
    //     $service->total_price = $totalPrice; // Store the calculated total price
    //     $service->category = $request->category;
    //     $service->service_type = $request->service_type;
    //     $service->slug = Str::slug($request->name);
    //     $service->description = $request->description;
    //     $service->save();

    //     foreach ($prices as $priceData) {
    //         $service->priceVariants()->create([
    //             'name' => $priceData['name'],
    //             'description' => $priceData['description'],
    //             'duration' => $priceData['duration'],
    //             'price_type' => $priceData['type'],
    //             'price' => $priceData['type'] !== 'Free' ? $priceData['price'] : null,
    //         ]);
    //     }
    //     return response()->json([
    //         'message' => 'Treatment created successfully'
    //     ], 200);
    // }

    public function store(ServiceStoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Create the service
            $service = new Service();
            $service->user_id = Auth::user()->id;
            $service->name = $validatedData['name'];
            $service->status = $validatedData['status'];
            $service->category = $validatedData['category'];
            $service->slug = Str::slug($validatedData['name']);
            $service->service_type = $validatedData['service_type'] ?? null;
            $service->description = $validatedData['description'] ?? null;
            $service->save();

            // Save price variants
            foreach ($validatedData['duration'] as $index => $duration) {
                $service->priceVariants()->create([
                    'duration' => $duration,
                    'price_type' => $validatedData['price_type'][$index],
                    'price' => $validatedData['price'][$index] ?? null,
                    'variant_name' => $validatedData['variant_name'][$index] ?? null,
                    'variant_description' => $validatedData['variant_description'][$index] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'data' => $service,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the service.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, string $id)
    {
        $service = Service::findOrFail($id);

        // Update service details
        $service->update([
            'name' => $request->name,
            'status' => $request->status,
            'category' => $request->category,
            'service_type' => $request->service_type,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        // Decode the price JSON from the request
        $prices = json_decode($request->price, true);

        // Calculate total price and update variants
        $totalPrice = 0;

        foreach ($prices as $priceData) {
            $variantId = $priceData['id'] ?? null;
            $price = $priceData['type'] !== 'Free' ? floatval($priceData['price']) : 0;
            $totalPrice += $price;

            $variantData = [
                'name' => $priceData['name'],
                'description' => $priceData['description'],
                'duration' => $priceData['duration'],
                'price_type' => $priceData['type'],
                'price' => $price,
            ];

            if ($variantId) {
                // Update existing variant
                $service->priceVariants()->where('id', $variantId)->update($variantData);
            } else {
                // Create new variant
                $service->priceVariants()->create($variantData);
            }
        }

        // Update total price
        $service->update(['total_price' => $totalPrice]);

        // Remove variants that are not in the updated data
        $updatedVariantIds = array_column($prices, 'id');
        $service->priceVariants()
            ->whereNotIn('id', $updatedVariantIds)
            ->delete();

        // Return success message
        return response()->json([
            'message' => 'Treatment updated successfully'
        ], 200);
    }

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