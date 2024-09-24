<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PackageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function Termwind\render;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PackageDataTable $dataTable) : View
    {
        return $dataTable->render('admin.package.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $services = Service::all();
        $category = Category::all();
        return view('admin.package.create', compact('services', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}