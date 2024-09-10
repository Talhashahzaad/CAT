@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.service.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Service</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.service.index') }}">Service</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Service</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.service.update',$service->id) }}" method="POST">

                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $service->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option @selected($service->status === 1 ) value="1">Active</option>
                                        <option @selected($service->status === 0 ) value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Service Type <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="service_type" value="{{ $service->service_type }}">
                                    {{-- <select name="parent_category" class="form-control">
                                        <option value="none">None</option>
                                        <option value="hair">Hair</option>
                                    </select> --}}
                                </div>

                                <div class="form-group">
                                    <label for="">Category <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="category" value="{{ $service->category }}">
                                    {{-- <select name="parent_category" class="form-control">
                                        <option value="none">None</option>
                                        <option value="hair">Hair</option>
                                    </select> --}}
                                </div>

                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea name="description" class="form-control">{{ $service->description }}</textarea>
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

@endpush
