@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.service.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Treatment</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.service.index') }}">Treatment</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Treatment</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.service.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
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
                                            <label for="category">Treatment Category <span
                                                    class="text-danger">*</span></label>

                                            <select name="category" class="form-control" id="category">
                                                @foreach ($category as $categories)
                                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
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
                                                        <input type="hidden" name="variant_name[]" value="Service">
                                                        <input type="hidden" name="variant_description[]" value="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="duration">Duration <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control duration" name="duration[]">
                                                            <!-- Options will be populated by JavaScript -->
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="price_type">Price Type <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control price-type" name="price_type[]">
                                                            <option value="Free">Free</option>
                                                            <option value="From">From</option>
                                                            <option value="Fixed">Fixed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 price-section">
                                                        <label for="price">Price <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control price" name="price[]"
                                                            step="0.01">
                                                        <div class="error-message text-danger"></div>
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
                                <option value="Free">Free</option>
                                <option value="From">From</option>
                                <option value="Fixed">Fixed</option>
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

            const durationOptions = [{
                    value: "5",
                    text: "5min"
                },
                {
                    value: "10",
                    text: "10min"
                },
                {
                    value: "15",
                    text: "15min"
                },
                {
                    value: "20",
                    text: "20min"
                },
                {
                    value: "25",
                    text: "25min"
                },
                {
                    value: "30",
                    text: "30min"
                },
                {
                    value: "35",
                    text: "35min"
                },
                {
                    value: "40",
                    text: "40min"
                },
                {
                    value: "45",
                    text: "45min"
                },
                {
                    value: "50",
                    text: "50min"
                },
                {
                    value: "55",
                    text: "55min"
                },
                {
                    value: "60",
                    text: "1h"
                },
                {
                    value: "65",
                    text: "1h 5min"
                },
                {
                    value: "70",
                    text: "1h 10min"
                },
                {
                    value: "75",
                    text: "1h 15min"
                },
                {
                    value: "80",
                    text: "1h 20min"
                },
                {
                    value: "85",
                    text: "1h 25min"
                },
                {
                    value: "90",
                    text: "1h 30min"
                },
                {
                    value: "95",
                    text: "1h 35min"
                },
                {
                    value: "100",
                    text: "1h 40min"
                },
                {
                    value: "105",
                    text: "1h 45min"
                },
                {
                    value: "110",
                    text: "1h 50min"
                },
                {
                    value: "115",
                    text: "1h 55min"
                },
                {
                    value: "120",
                    text: "2h"
                },
                {
                    value: "135",
                    text: "2h 15min"
                },
                {
                    value: "150",
                    text: "2h 30min"
                },
                {
                    value: "165",
                    text: "2h 45min"
                },
                {
                    value: "180",
                    text: "3h"
                },
                {
                    value: "195",
                    text: "3h 15min"
                },
                {
                    value: "210",
                    text: "3h 30min"
                },
                {
                    value: "225",
                    text: "3h 45min"
                },
                {
                    value: "240",
                    text: "4h"
                },
                {
                    value: "270",
                    text: "4h 30min"
                },
                {
                    value: "300",
                    text: "5h"
                },
                {
                    value: "330",
                    text: "5h 30min"
                },
                {
                    value: "360",
                    text: "6h"
                },
                {
                    value: "390",
                    text: "6h 30min"
                },
                {
                    value: "420",
                    text: "7h"
                },
                {
                    value: "450",
                    text: "7h 30min"
                },
                {
                    value: "480",
                    text: "8h"
                },
                {
                    value: "540",
                    text: "9h"
                },
                {
                    value: "600",
                    text: "10h"
                },
                {
                    value: "660",
                    text: "11h"
                },
                {
                    value: "720",
                    text: "12h"
                }
            ];

            function generateDurationOptions(selectedValue = '') {
                return durationOptions.map(option =>
                    `<option value="${option.value}" ${option.value === selectedValue ? 'selected' : ''}>${option.text}</option>`
                ).join('');
            }

            function updateVariantDisplay() {
                const variantCount = $('.variation-row').length;
                if (variantCount > 1) {
                    $('.variant-name, .remove-button').show();
                    $('.variation-row:first .variant-name strong').text('Service');
                } else {
                    $('.variant-name, .remove-button').hide();
                }
                updatePriceVisibility();
            }

            function updatePriceVisibility() {
                $('.variation-row').each(function(index) {
                    const priceType = $(this).find('.price-type').val();
                    const priceSection = $(this).find('.price-section');
                    const priceInput = priceSection.find('.price');
                    if (priceType === 'Free') {
                        priceSection.hide();
                        priceInput.prop('required', false).val(''); // Clear the value
                    } else {
                        priceSection.show();
                        priceInput.prop('required', true);
                    }
                });
            }

            $('#add-variant').click(function(e) {
                e.preventDefault();
                const lastPriceType = $('.variation-row:last .price-type').val();
                const lastPrice = $('.variation-row:last .price').val();
                if (lastPriceType !== 'Free' && (!lastPrice || parseFloat(lastPrice) <= 0)) {
                    $('.variation-row:last .price').next('.error-message').text(
                        'Please enter a valid price');
                    return;
                }
                $('#variantName').val('');
                $('#variantDuration').html(generateDurationOptions());
                variantModal.show();
            });

            $('#saveVariant').click(function() {
                const name = $('#variantName').val();
                const description = $('#variantDescription').val();
                const price = $('#variantPrice').val();
                const priceType = $('#variantPriceType').val();
                const duration = $('#variantDuration').val();

                if (priceType !== 'Free' && (!price || parseFloat(price) <= 0)) {
                    alert('Please enter a valid price');
                    return;
                }

                const serviceName = $('#name').val();
                const displayName = name || serviceName || 'Service';
                const variantName = name || serviceName || 'Service';

                const newVariation = `
        <div class="variation-row mt-3">
            <div class="row align-items-center">
                <div class="col-md-3 variant-name">
                    <strong>${displayName}</strong>
                    <input type="hidden" name="variant_name[]" value="${variantName}">
                    <input type="hidden" name="variant_description[]" value="${description}">
                </div>
                <div class="col-md-2">
                    <select class="form-control duration" name="duration[]">
                        ${generateDurationOptions(duration)}
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control price-type" name="price_type[]">
                        <option value="Free" ${priceType === 'Free' ? 'selected' : ''}>Free</option>
                        <option value="From" ${priceType === 'From' ? 'selected' : ''}>From</option>
                        <option value="Fixed" ${priceType === 'Fixed' ? 'selected' : ''}>Fixed</option>
                    </select>
                </div>
                <div class="col-md-2 price-section">
                    <input type="number" class="form-control price" name="price[]" value="${price}" step="0.01" ${priceType !== 'Free' ? 'required' : ''}>
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

            $(document).on('input', '.price', function() {
                $(this).next('.error-message').text('');
            });

            $(document).on('change', '.price-type', function() {
                updatePriceVisibility();
            });

            // Update existing duration dropdowns
            $('.duration').each(function() {
                const currentValue = $(this).val();
                $(this).html(generateDurationOptions(currentValue));
            });

            // Form submission
            $('form').on('submit', function(e) {
                e.preventDefault();

                // Collect all prices
                var prices = [];
                $('.variation-row').each(function() {
                    var priceType = $(this).find('.price-type').val();
                    var price = $(this).find('.price').val();
                    var duration = $(this).find('.duration').val();
                    var variantName = $(this).find('input[name="variant_name[]"]').val();
                    var variantDescription = $(this).find('input[name="variant_description[]"]')
                        .val();

                    prices.push({
                        name: variantName,
                        description: variantDescription,
                        type: priceType,
                        price: priceType === 'Free' ? null : price,
                        duration: duration
                    });
                });

                // Remove any existing price input
                $('input[name="price"]').remove();

                // Add prices to a hidden input
                $('<input>').attr({
                    type: 'hidden',
                    name: 'price',
                    value: JSON.stringify(prices)
                }).appendTo('form');

                // Submit the form
                this.submit();
            });

            // Initial setup
            updateVariantDisplay();
            updatePriceVisibility();
        });
    </script>
@endpush
