<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Models\Category;
use App\Models\ServicePriceVariant;
use App\Models\Service;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class ServiceController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(ServiceDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $category =  Category::all();
        return view('admin.service.create', compact('category'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request): RedirectResponse
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

        toastr()->success('Created Successfully');
        return to_route('admin.service.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::with('priceVariants')->findOrFail($id);
        $category =  Category::all();
        // Add this line for debugging
        // dd($service->toArray());
        return view('admin.service.edit', compact('service', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, string $id): RedirectResponse
    {

        // $service = Service::findOrFail($id);

        // // Update service details
        // $service->update([
        //     'name' => $request->name,
        //     'status' => $request->status,
        //     'category' => $request->category,
        //     'service_type' => $request->service_type,
        //     'slug' => Str::slug($request->name),
        //     'description' => $request->description,
        // ]);

        // // Decode the price JSON from the request
        // $prices = json_decode($request->price, true);

        // // Calculate total price and update variants
        // $totalPrice = 0;
        // $updatedVariantIds = [];

        // foreach ($prices as $priceData) {
        //     $variantId = $priceData['id'] ?? null;
        //     $price = $priceData['type'] !== 'Free' ? floatval($priceData['price']) : 0;
        //     $totalPrice += $price;

        //     $variantData = [
        //         'name' => $priceData['name'],
        //         'description' => $priceData['description'],
        //         'duration' => $priceData['duration'],
        //         'price_type' => $priceData['type'],
        //         'price' => $price,
        //     ];

        //     if ($variantId) {
        //         // Update existing variant
        //         $service->priceVariants()->where('id', $variantId)->update($variantData);
        //         $updatedVariantIds[] = $variantId;
        //     } else {
        //         // Create new variant
        //         $newVariant = $service->priceVariants()->create($variantData);
        //         $updatedVariantIds[] = $newVariant->id;
        //     }
        // }

        // // Update total price
        // $service->total_price = $totalPrice;
        // $service->save();

        // // Remove variants that are not in the updated data
        // if (!empty($updatedVariantIds)) {
        //     $service->priceVariants()
        //         ->whereNotIn('id', $updatedVariantIds)
        //         ->delete();
        // }

        // // Ensure at least one variant exists
        // if ($service->priceVariants()->count() === 0) {
        //     toastr()->error('At least one variant must exist.');
        //     return back();
        // }

        // toastr()->success('Updated Successfully');
        // return to_route('admin.service.index');

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

        // Check if prices is null or not an array
        if (!is_array($prices)) {
            toastr()->error('Invalid price data.');
            return back();
        }

        // Calculate total price and update variants
        $totalPrice = 0;
        $updatedVariantIds = [];

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
                $updatedVariantIds[] = $variantId;
            } else {
                // Create new variant
                $newVariant = $service->priceVariants()->create($variantData);
                $updatedVariantIds[] = $newVariant->id;
            }
        }

        // Update total price
        $service->total_price = $totalPrice;
        $service->save();

        // Remove variants that are not in the updated data
        if (!empty($updatedVariantIds)) {
            $service->priceVariants()
                ->whereNotIn('id', $updatedVariantIds)
                ->delete();
        }

        // Ensure at least one variant exists
        if ($service->priceVariants()->count() === 0) {
            toastr()->error('At least one variant must exist.');
            return back();
        }

        toastr()->success('Updated Successfully');
        return to_route('admin.service.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response(['status' => 'success', 'message' => 'Item deleted Successfully']);
    }
}