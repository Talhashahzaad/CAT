<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use Str;

class BlogController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');

        $blog = new Blog();
        $blog->image = $imagePath;
        $blog->title = $request->title;
        $blog->author_id = Auth::user()->id;
        $blog->blog_category_id = $request->category;
        $blog->description = $request->description;
        $blog->slug = \Str::slug($request->title);
        $blog->status = $request->status;
        $blog->is_popular = $request->is_popular;
        $blog->save();

        toastr()->success('Created successfully');
        return to_route('admin.blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $blog = Blog::findOrFail($id);
        $blog->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $blog->title = $request->title;
        $blog->author_id = Auth::user()->id;
        $blog->blog_category_id = $request->category;
        $blog->description = $request->description;
        $blog->slug = \Str::slug($request->title);
        $blog->status = $request->status;
        $blog->is_popular = $request->is_popular;
        $blog->save();

        toastr()->success('Update successfully');
        return to_route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $blog = Blog::findOrFail($id);
            $this->deleteFile($blog->image);
            $blog->delete();

            return response(['status' => 'success', 'message' => 'Deleted successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
