<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingScheduleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingScheduleStoreRequest;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ListingSchedule;
use Illuminate\Http\Response;


class ListingScheduleController extends Controller
{
    public function index(ListingScheduleDataTable $dataTable, string $listingId): View| JsonResponse
    {
        $dataTable->with('listingId', $listingId);
        $listingTitle = Listing::select('title')->where('id', $listingId)->first();
        return $dataTable->render('admin.listing.listing-schedule.index', compact('listingId', 'listingTitle'));
    }

    public function create(Request $request, string $listingId): View
    {
        return view('admin.listing.listing-schedule.create', compact('listingId'));
    }

    public function store(ListingScheduleStoreRequest $request, string $listingId): RedirectResponse
    {
        $schedule = new ListingSchedule();
        $schedule->listing_id = $listingId;
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.listing-schedule.index', $listingId);
    }

    public function edit(string $id): View
    {
        $schedule = ListingSchedule::findOrFail($id);
        return view('admin.listing.listing-schedule.edit', compact('schedule'));
    }

    public function update(ListingScheduleStoreRequest $request, string $id): RedirectResponse
    {
        $schedule = ListingSchedule::findOrFail($id);
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Updated Successfully!');

        return to_route('admin.listing-schedule.index', $schedule->listing_id);
    }

    public function destroy(string $id): Response
    {
        try {
            $schedule = ListingSchedule::findOrFail($id);
            $schedule->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}