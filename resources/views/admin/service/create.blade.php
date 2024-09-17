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
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Service</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.service.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_type">Service Type</label>
                                            <input type="text" class="form-control" name="service_type" id="service_type"
                                                value="None">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" name="category" id="category"
                                                value="None">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Pricing and duration</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="variations-container">
                                            <div class="variation-row">
                                                <div class="row align-items-center">
                                                    <div class="col-md-3 variant-name" style="display: none;">
                                                        <strong>Service</strong>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control duration" name="duration[]">
                                                            <option value="1h">1h</option>
                                                            <option value="2h">2h</option>
                                                            <option value="3h">3h</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control price-type" name="price_type[]">
                                                            <option value="Fixed">Fixed</option>
                                                            <option value="Variable">Variable</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control price" name="price[]"
                                                            placeholder="Price" step="0.01" required>
                                                        <div class="error-message text-danger service"></div>
                                                    </div>
                                                    <div class="col-md-3 remove-button" style="display: none;">
                                                        <!-- Empty column for alignment -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="add-variant" class="btn btn-primary mt-3">Add variant</button>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variantModalLabel">Add Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="variantForm">
                        <div class="form-group">
                            <label for="variantName">Name</label>
                            <input type="text" class="form-control" id="variantName" name="variantName"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="variantDescription">Description</label>
                            <textarea class="form-control" id="variantDescription" name="variantDescription"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="variantPrice">Price</label>
                            <input type="number" class="form-control" id="variantPrice" name="variantPrice"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="variantPriceType">Price Type</label>
                            <select class="form-control" id="variantPriceType" name="variantPriceType">
                                <option value="Fixed">Fixed</option>
                                <option value="Variable">Variable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="variantDuration">Duration</label>
                            <select class="form-control" id="variantDuration" name="variantDuration">
                                <option value="1h">1h</option>
                                <option value="2h">2h</option>
                                <option value="3h">3h</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveVariant">Save variant</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const variantModal = new bootstrap.Modal(document.getElementById('variantModal'));

            function updateVariantDisplay() {
                const variantCount = $('.variation-row').length;
                if (variantCount > 1) {
                    $('.variant-name, .remove-button').show();
                    $('.variation-row:first .variant-name strong').text('Default Service');
                } else {
                    $('.variant-name, .remove-button').hide();
                }
            }

            $('#add-variant').click(function(e) {
                e.preventDefault();
                // Check if the last variation's price is filled
                const lastPrice = $('.variation-row:last .price').val();
                if (!lastPrice || lastPrice <= 0) {
                    $('.variation-row:last .price').next('.error-message ').text(
                        'Please enter a valid price');
                    return;
                }
                $('#variantName').val($('#name').val());
                variantModal.show();
            });

            $('#saveVariant').click(function() {
                const name = $('#variantName').val();
                const description = $('#variantDescription').val();
                const price = $('#variantPrice').val();
                const priceType = $('#variantPriceType').val();
                const duration = $('#variantDuration').val();

                if (!price || price <= 0) {
                    alert('Please enter a valid price');
                    return;
                }

                const serviceName = $('#name').val();
                const displayName = name || serviceName || 'Service';

                const newVariation = `
                <div class="variation-row mt-3">
                    <div class="row align-items-center">
                        <div class="col-md-3 variant-name">
                            <strong>${displayName}</strong>
                            <input type="hidden" name="variant_name[]" value="${name}">
                            <input type="hidden" name="variant_description[]" value="${description}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control duration" name="duration[]">
                                <option value="1h" ${duration === '1h' ? 'selected' : ''}>1h</option>
                                <option value="2h" ${duration === '2h' ? 'selected' : ''}>2h</option>
                                <option value="3h" ${duration === '3h' ? 'selected' : ''}>3h</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control price-type" name="price_type[]">
                                <option value="Fixed" ${priceType === 'Fixed' ? 'selected' : ''}>Fixed</option>
                                <option value="Variable" ${priceType === 'Variable' ? 'selected' : ''}>Variable</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control price" name="price[]" value="${price}" step="0.01" required>
                            <div class="error-message text-danger"></div>
                        </div>
                        <div class="col-md-3 remove-button">
                            <button type="button" class="btn btn-danger remove-variant">Remove</button>
                        </div>
                    </div>
                </div>
            `;

                $('#variations-container').append(newVariation);
                updateVariantDisplay();
                variantModal.hide();
                $('#variantForm')[0].reset();
            });

            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.variation-row').remove();
                updateVariantDisplay();
            });

            // Clear error messages when user starts typing in price field
            $(document).on('input', '.price', function() {
                $(this).next('.error-message').text('');
            });
        });
    </script>
@endpush
