@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.location.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Location</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.location.index') }}">Location</a></div>
                <div class="breadcrumb-item">Update</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Location</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.location.update', $location->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Image Icon <span class="text-danger"></span>
                                            </label>
                                            <div id="image-preview" class="image-preview icon-image">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="location_image" id="image-upload" />
                                                <input type="hidden" name="old_image"
                                                    value="{{ $location->location_image }}" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $location->name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Show at Home <span class="text-danger">*</span></label>
                                            <select name="show_at_home" id="" class="form-control">
                                                <option @selected($location->show_at_home === 0) value="0">No</option>
                                                <option @selected($location->show_at_home === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option @selected($location->status === 1) value="1">Active</option>
                                                <option @selected($location->status === 0) value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Parent Location <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="parent_location"
                                                value="{{ $location->parent_location }}">
                                    </div>
                                </div>
                            </div>


                                <div class="form-group">
                                            <label for="">Description </label>
                                            <textarea name="description" class="form-control">{{ $location->name }}</textarea>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
    <script>
        $(document).ready(function() {
            $('.icon-image').css({
                'background-image': 'url({{ asset($location->location_image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        })
    </script>
@endpush
