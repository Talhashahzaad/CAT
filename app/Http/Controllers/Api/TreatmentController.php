<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Models\Service;
use Auth;
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
    public function store(ServiceStoreRequest $request)
    {
        $validatedData = $request->validated();

        // Decode the price JSON from the request
        $prices = json_decode($request->price, true);

        // Calculate the total price
        $totalPrice = 0;
        foreach ($prices as $priceData) {
            if ($priceData['type'] !== 'Free' && isset($priceData['price'])) {
                $totalPrice += floatval($priceData['price']);
            }
        }

        $service = new Service();
        $service->user_id = Auth::user()->id;
        $service->name = $validatedData['name'];
        $service->status = $validatedData['status'];
        $service->total_price = $totalPrice; // Store the calculated total price
        $service->category = $validatedData['category'];
        $service->service_type = $validatedData['service_type'];
        $service->slug = Str::slug($validatedData['name']);
        $service->description = $validatedData['description'];
        $service->save();

        foreach ($prices as $priceData) {
            $service->priceVariants()->create([
                'name' => $priceData['name'],
                'description' => $priceData['description'],
                'duration' => $priceData['duration'],
                'price_type' => $priceData['type'],
                'price' => $priceData['type'] !== 'Free' ? $priceData['price'] : null,
            ]);
        }
        return response()->json([
            'message' => 'Treatment created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
