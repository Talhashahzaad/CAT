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
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Location</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.location.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Image Icon <span class="text-danger"></span>
                                            </label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="location_image" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Show at Home <span class="text-danger">*</span></label>
                                        <select name="show_at_home" id="" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Parent Location <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="parent_location" value="None">
                                    </div>
                                </div>
                            </div>


                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea name="description" class="form-control"></textarea>
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
