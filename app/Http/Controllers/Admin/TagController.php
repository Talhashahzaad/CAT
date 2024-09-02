<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TagDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagStoreRequest;
use App\Models\Tag;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

use function Termwind\render;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TagDataTable $dataTable): View | JsonResponse
    {

        return $dataTable->render('admin.tag.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagStoreRequest $request): RedirectResponse
    {

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->status = $request->status;
        $tag->parent_category = $request->parent_category;
        $tag->parent_tag = $request->parent_tag;
        $tag->slug = Str::slug($request->name);
        $tag->description = $request->description;
        $tag->save();

        toastr()->success('Created Successfully');

        return to_route('admin.tag.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $tag = Tag::findOrFail($id);
       return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $tag = Tag::findOrFail($id);
         $tag->name = $request->name;
         $tag->status = $request->status;
         $tag->parent_category = $request->parent_category;
         $tag->parent_tag = $request->parent_tag;
         $tag->description = $request->description;
         $tag->save();

         toastr()->success('Created Successfully');

         return to_route('admin.tag.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $tag = Tag::findOrFail($id);
         $tag->delete();

         return response(['status' => 'success', 'message' => 'Item deleted successfully']);
   }
}