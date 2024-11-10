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
                                    @foreach ($practitioner->certificates as $practitionerCertificate)
                                        <div class="certificate-group row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="">Certificate</label>
                                                    <select name="certificates[]" class="form-control certificate-select">
                                                        <option value="">Select Certificate</option>
                                                        @foreach ($certificates as $certificate)
                                                            <option value="{{ $certificate->id }}"
                                                                {{ $certificate->id == $practitionerCertificate->certificate_id ? 'selected' : '' }}>
                                                                {{ $certificate->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-danger remove-certificate">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-certificate" class="btn btn-primary">Add Certificate</button>

                                <div id="error-message" class="text-danger mt-2" style="display: none;">
                                    Please select a certificate for all existing entries before adding more.
                                </div>

                                <div class="form-group mt-4">
                                    <input type="checkbox" name="practitioner_consent_checkbox"
                                        id="practitioner_consent_checkbox">
                                    <label for="practitioner_consent_checkbox">I confirm that I have obtained consent from
                                        the practitioner listed on this business profile to display their professional
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addCertificateBtn = document.getElementById('add-certificate');
            const certificatesContainer = document.getElementById('certificates-container');
            const errorMessage = document.getElementById('error-message');

            // Store the certificate options
            const certificateOptions = `
        <option value="">Select Certificate</option>
        @foreach ($certificates as $certificate)
            <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
        @endforeach
    `;

            // Set up initial state
            updateRemoveButtons();

            // Add new certificate group
            addCertificateBtn.addEventListener('click', function() {
                if (validateAllCertificates()) {
                    errorMessage.style.display = 'none';
                    addNewCertificateGroup();
                } else {
                    errorMessage.style.display = 'block';
                }
            });

            // Validate all certificate selections
            function validateAllCertificates() {
                const certificateGroups = certificatesContainer.querySelectorAll('.certificate-group');
                for (let group of certificateGroups) {
                    const certificate = group.querySelector('.certificate-select');
                    if (!certificate.value) {
                        return false;
                    }
                }
                return true;
            }

            // Add a new certificate group
            function addNewCertificateGroup() {
                const newGroup = document.createElement('div');
                newGroup.className = 'certificate-group row';
                newGroup.innerHTML = `
            <div class="col-md-10">
                <div class="form-group">
                    <label for="">Certificate</label>
                    <select name="certificates[]" class="form-control certificate-select">
                        ${certificateOptions}
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-certificate">Remove</button>
            </div>
        `;

                certificatesContainer.appendChild(newGroup);
                updateRemoveButtons();
            }

            // Update remove buttons for all certificate groups
            function updateRemoveButtons() {
                const removeButtons = document.querySelectorAll('.remove-certificate');
                removeButtons.forEach(button => {
                    button.removeEventListener('click', removeCertificateGroup);
                    button.addEventListener('click', removeCertificateGroup);
                });
            }

            // Remove certificate group
            function removeCertificateGroup() {
                this.closest('.certificate-group').remove();
            }

            // Prevent form submission if any certificate is not selected
            document.querySelector('form').addEventListener('submit', function(event) {
                if (!validateAllCertificates()) {
                    event.preventDefault();
                    errorMessage.style.display = 'block';
                    errorMessage.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endpush
