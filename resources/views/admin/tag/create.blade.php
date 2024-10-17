@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.tag.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Tag</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.tag.index') }}">Tag</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Tag</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.tag.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name">
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
                                            <label for="">Parent Tag <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="parent_tag" value="None">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Parent Category <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="parent_category"
                                                value="None">
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
