<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingSchedule;
use Auth;
use Illuminate\Http\Request;

class ListingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|integer|exists:listings,id',
        ]);

        $user = Auth::user();

        $listing = Listing::where('id', $validated['id'])
            ->where('user_id', $user->id)
            ->select('id', 'title')
            ->firstOrFail();

        $schedules = ListingSchedule::where('listing_id', $listing->id)
            ->select('id', 'day', 'start_time', 'end_time', 'status')
            ->get();
        if ($schedules->isEmpty()) {
            return response()->json(['message' => 'No Schedule found'], 404);
        }
        return response()->json([
            'title' => $listing->title,
            'schedules' => $schedules->isEmpty() ? 'No schedules found' : $schedules
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $listingId)
    {

        $validated = $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'status' => 'required|string',
        ]);

        $user = Auth::user();

        $listing = Listing::where('id', $listingId)
            ->where('user_id', $user->id)
            ->first();

        if (!$listing) {
            return response()->json(['message' => 'Unauthorized or listing not found'], 403);
        }

        $schedule = new ListingSchedule();
        $schedule->listing_id = $listingId;
        $schedule->day = $validated['day'];
        $schedule->start_time = $validated['start_time'];
        $schedule->end_time = $validated['end_time'];
        $schedule->status = $validated['status'];
        $schedule->save();

        return response()->json([
            'message' => 'Schedule added successfully',
            'schedule' => $schedule
        ], 201);
    }

    public function show($id)
    {
        return response()->json(['error' => 'Not Implemented'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'status' => 'required|string',
        ]);


        $schedule = ListingSchedule::findOrFail($id);
        $user = Auth::user();

        $listing = Listing::where('id', $schedule->listing_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$listing) {
            return response()->json(['error' => 'Unauthorized access or schedule not found'], 403);
        }

        $schedule->update($validated);

        return response()->json([
            'message' => 'Schedule updated successfully',
            'data' => $schedule
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();

            $schedule = ListingSchedule::findOrFail($id);

            $listing = Listing::where('id', $schedule->listing_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$listing) {
                return response()->json(['error' => 'Unauthorized access or schedule not found'], 403);
            }

            $schedule->delete();

            return response()->json(['message' => 'Schedule deleted successfully', 'data' => $schedule], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
