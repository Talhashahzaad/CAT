@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.amenity.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Amenity</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.amenity.index') }}">Amenity</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Amenity</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.amenity.update', $amenity->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="">Icon <span class="text-danger">*</span></label>
                                    <div role="iconpicker" data-align="left" data-unselected-class=" "
                                        name="icon" data-selected-class="btn-primary" data-icon="{{ $amenity->icon }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $amenity->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option @selected($amenity->status === 1) value="1">Active</option>
                                        <option @selected($amenity->status === 0) value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Parent Amenity <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="parent_amenity" value="{{ $amenity->parent_amenity }}">
                                    {{-- <select name="parent_category" class="form-control">
                                        <option value="none">None</option>
                                        <option value="hair">Hair</option>
                                    </select> --}}
                                </div>

                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea name="description" class="form-control">{{ $amenity->description }}</textarea>
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
