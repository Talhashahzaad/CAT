<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Models\ServicePriceVariant;
use App\Models\Service;
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

        return view('admin.service.create');
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
                'name' => $priceData['name'],p
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
        $service = Service::findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, string $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->status = $request->status;
        $service->category = $request->category;
        $service->service_type = $request->service_type;
        $service->slug =  Str::slug($request->name);
        $service->description = $request->description;
        $service->save();

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