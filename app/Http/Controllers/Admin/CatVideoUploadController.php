<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CatVideoUploadDataTable;
use App\Http\Controllers\Controller;
use App\Models\CatVideoUpload;
use Illuminate\Http\Request;

class CatVideoUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CatVideoUploadDataTable $dataTable)
    {
        return $dataTable->render('admin.video.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'video_title' => 'required',
            'video_url' => 'required',
            'status' => 'required',
        ]);

        $video = new CatVideoUpload();
        $video->video_title = $request->video_title;
        $video->video_url = $request->video_url;
        $video->status = $request->status;
        $video->video_description = $request->video_description;
        $video->save();

        toastr()->success('Video Uploaded successfully');
        return redirect()->route('admin.cat-video-upload.index');
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
        $video = CatVideoUpload::find($id);
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'video_title' => 'required',
            'video_url' => 'required',
            'status' => 'required',
        ]);

        $video = CatVideoUpload::find($id);
        $video->video_title = $request->video_title;
        $video->video_url = $request->video_url;
        $video->status = $request->status;
        $video->video_description = $request->video_description;
        $video->save();

        toastr()->success('Video Updated successfully');
        return redirect()->route('admin.cat-video-upload.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = CatVideoUpload::find($id);
        $video->delete();
        return response(['status' => 'success', 'message' => 'Video deleted successfully']);
    }
}