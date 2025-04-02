<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PendingListingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class PendingListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PendingListingDataTable $dataTable)
    {
        return $dataTable->render('admin.pending-listing.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'value' => 'required',
        ]);

        try {
            $listing = Listing::find($request->id);
            $listing->is_approved = $request->value;
            $listing->save();

            return response()->json(['status' => 'success', 'message' => 'Listing updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}