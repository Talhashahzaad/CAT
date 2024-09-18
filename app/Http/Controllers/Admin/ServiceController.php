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
     * Duration method for blade file
     */

    private function getDurations()
    {
        $durations = [
            5 => '5min',
            10 => '10min',
            15 => '15min',
            20 => '20min',
            25 => '25min',
            30 => '30min',
            35 => '35min',
            40 => '40min',
            45 => '45min',
            50 => '50min',
            55 => '55min',
            60 => '1h',
            65 => '1h 5min',
            70 => '1h 10min',
            75 => '1h 15min',
            80 => '1h 20min',
            85 => '1h 25min',
            90 => '1h 30min',
            95 => '1h 35min',
            100 => '1h 40min',
            105 => '1h 45min',
            110 => '1h 50min',
            115 => '1h 55min',
            120 => '2h',
            135 => '2h 15min',
            150 => '2h 30min',
            165 => '2h 45min',
            180 => '3h',
            195 => '3h 15min',
            210 => '3h 30min',
            225 => '3h 45min',
            240 => '4h',
            270 => '4h 30min',
            300 => '5h',
            330 => '5h 30min',
            360 => '6h',
            390 => '6h 30min',
            420 => '7h',
            450 => '7h 30min',
            480 => '8h',
            540 => '9h',
            600 => '10h',
            660 => '11h',
            720 => '12h'
        ];

        return $durations;
    }

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
        $durations = $this->getDurations();
    return view('admin.service.create', compact('durations'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();

        $service = new Service();
        $service->name = $request->name;
        $service->status = $request->status;
        $service->category = $request->category;
        $service->service_type = $request->service_type;
        $service->slug = Str::slug($request->name);
        $service->description = $request->description;
        $service->save();

        foreach ($validatedData['duration'] as $index => $duration) {
            ServicePriceVariant::create([
                'service_id' => $service->id,
                'duration' => $duration,
                'price_type' => $validatedData['price_type'][$index],
                'price' => $validatedData['price'][$index],
                // Add these if your table has these columns, otherwise remove them
                'name' => $validatedData['variant_name'][$index] ?? null,
                'description' => $validatedData['variant_description'][$index] ?? null,
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