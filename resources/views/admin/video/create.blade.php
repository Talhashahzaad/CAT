@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.cat-video-upload.index') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Tag</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.cat-video-upload.index') }}">Tag</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Upload Video</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cat-video-upload.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Video Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="video_title"
                                                value="{{ old('video_title') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Video Url<span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="video_url"
                                                value="{{ old('video_url') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description </label>
                                            <textarea name="video_description" class="form-control">{{ old('video_description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
@endpush
