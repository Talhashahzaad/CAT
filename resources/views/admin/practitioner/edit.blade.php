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
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Practitioner</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.practitioner.update', $practitioner->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $practitioner->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="qualification">Qualification and Level <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qualification"
                                        value="{{ $practitioner->qualification }}">
                                </div>

                                <div id="certificates-container">
                                    <div class="certificate-group row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Certificate</label>
                                                <input type="text" class="form-control" name="certificate"
                                                    value="{{ $practitioner->certificate }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <input type="checkbox" name="practitioner_consent_checkbox"
                                        id="practitioner_consent_checkbox">
                                    <label for="practitioner_consent_checkbox">I confirm that I have obtained
                                        consent from
                                        the practitioner listed on this business profile to display their
                                        professional
                                        affiliations publicly on Check a Treatment.</label>
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
