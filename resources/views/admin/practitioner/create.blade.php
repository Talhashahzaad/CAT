@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.practitioner.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Practitioner</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.practitioner.index') }}">Practitioner</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Practitioner</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.practitioner.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name">
                                </div>



                                <div class="form-group">
                                    <label for="qualification">Qualification and Level <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qualification">
                                </div>

                                <div id="certificates-container">
                                    <div class="certificate-group row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Certificate</label>
                                                <input type="text" class="form-control" name="certificate">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <input type="checkbox" name="practitioner_concent_checkbox"
                                        id="practitioner_concent_checkbox">
                                    <label for="practitioner_concent_checkbox">I confirm that I have obtained consent from
                                        the practitioner listed on this business profile to display their professional
                                        affiliations publicly on Check a Treatment.</label>
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