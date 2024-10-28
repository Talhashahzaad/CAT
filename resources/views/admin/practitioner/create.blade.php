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
                                                <select name="certificates[]" class="form-control certificate-select">
                                                    <option value="">Select Certificate</option>
                                                    @foreach ($certificates as $certificate)
                                                        <option value="{{ $certificate->id }}">{{ $certificate->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-certificate" class="btn btn-primary">Add Certificate</button>

                                <div id="error-message" class="text-danger mt-2" style="display: none;">
                                    Please select a certificate for the previous entry before adding more.
                                </div>

                                <div class="form-group mt-4">
                                    <input type="checkbox" name="practitioner_concent_checkbox"
                                        id="practitioner_concent_checkbox">
                                    <label for="practitioner_concent_checkbox">I confirm that the information provided is
                                        accurate</label>
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

            // Add new certificate group
            addCertificateBtn.addEventListener('click', function() {
                const lastCertificateGroup = certificatesContainer.querySelector(
                    '.certificate-group:last-child');
                const lastCertificateSelect = lastCertificateGroup.querySelector('.certificate-select');

                if (lastCertificateSelect.value) {
                    errorMessage.style.display = 'none';
                    addNewCertificateGroup();
                } else {
                    errorMessage.style.display = 'block';
                }
            });

            // Add a new certificate group
            function addNewCertificateGroup() {
                const newGroup = document.createElement('div');
                newGroup.className = 'certificate-group row align-items-end mb-3';
                newGroup.innerHTML = `
                    <div class="col-md-10">
                        <div class="form-group mb-0">
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
                const certificateSelects = certificatesContainer.querySelectorAll('.certificate-select');
                for (let select of certificateSelects) {
                    if (!select.value) {
                        event.preventDefault();
                        errorMessage.textContent = 'Please select all certificates before submitting.';
                        errorMessage.style.display = 'block';
                        errorMessage.scrollIntoView({
                            behavior: 'smooth'
                        });
                        break;
                    }
                }
            });
        });
    </script>
@endpush
