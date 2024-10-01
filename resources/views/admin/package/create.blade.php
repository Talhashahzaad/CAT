@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.location.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Treatment Package</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.package.index') }}">Treatment Package</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Treatment Package</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.package.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
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
                                            <label for="">Treatment Category<span
                                                    class="text-danger"></span></label>
                                            <select name="category" class="form-control">
                                                @foreach ($category as $categories)
                                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>

                                <div class="card-treatments">
                                    <div class="card-header-treatments">
                                        <h4>Treatments</h4>
                                        <p>Select which treatments to include in this package and how they should be
                                            sequenced
                                            when booked.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                                                data-target="#serviceModal">Add Treatment</button>
                                        </div>
                                    </div>
                                    <div id="selectedServices" class="mt-5">
                                        <!-- Selected services will be added here -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-right">
                                            <h5>Total Time: <span id="totalTime">0</span> | Total Price: <span
                                                    id="totalPrice">0</span></h5>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-pricing mt-4">
                                    <div class="card-header-pricing">
                                        <h4>Pricing</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price_type">Price type</label>
                                                <select name="price_type" id="price_type" class="form-control">
                                                    <option value="Treatment Pricing">Treatment pricing</option>
                                                    <option value="Custom Pricing">Custom pricing</option>
                                                    <option value="Percentage Discount">Percentage discount</option>
                                                    <option value="Free">Free</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="retail_price_group">
                                                <label for="retail_price">Retail price</label>
                                                <input type="number" step="0.01" name="retail_price" id="retail_price"
                                                    class="form-control" readonly>
                                                <small id="price_info" class="form-text text-muted"></small>
                                            </div>

                                            <input type="hidden" name="total_duration" id="total_duration"
                                                class="form-control" readonly>

                                            <div class="form-group" id="discount_group" style="display: none;">
                                                <label for="discount_percentage">Discount percentage</label>
                                                <input type="number" step="0.01" name="discount_percentage"
                                                    id="discount_percentage" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-availability mt-4">
                                    <div class="card-header-availability">
                                        <h4>Availability</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="available_for">Available for</label>
                                                <select name="available_for" id="available_for" class="form-control">
                                                    <option value="All genders">All genders</option>
                                                    <option value="Females only">Females only</option>
                                                    <option value="Males only">Males only</option>
                                                    <option value="Unisex">Unisex</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Add Treatment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="serviceList" class="list-group mt-3">
                        {{-- @php
                            dd($category);
                        @endphp --}}
                        @foreach ($services as $service)
                            @foreach ($service->priceVariants as $variant)
                                <li class="list-group-item" data-service-id="{{ $service->id }}"
                                    data-service-name="{{ $service->name }}" data-variant-id="{{ $variant->id }}"
                                    data-variant-name="{{ $variant->name }}" data-service-price="{{ $variant->price }}"
                                    data-service-duration="{{ $variant->duration }}">
                                    <strong>{{ $service->name }}</strong> - {{ $variant->name }}
                                    <br>
                                    <small>
                                        @if (floor($variant->duration / 60) == 0)
                                            {{ $variant->duration }}min
                                        @elseif($variant->duration % 60 == 0)
                                            {{ floor($variant->duration / 60) }}h
                                        @else
                                            {{ floor($variant->duration / 60) }}h {{ $variant->duration % 60 }}min
                                        @endif
                                        -
                                        @if ($variant->price === null || $variant->price === 'free')
                                            Free
                                        @else
                                            ₹{{ $variant->price }}
                                        @endif
                                    </small>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                    <div class="mt-3 modal-price-duration">
                        <p>Total Price: <span id="modalTotalPrice">0</span></p>
                        <p>Total Duration: <span id="modalTotalDuration">0h 0min</span> minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceList = document.getElementById('serviceList');
            const selectedServices = document.getElementById('selectedServices');
            const totalPriceElement = document.getElementById('totalPrice');
            const totalTimeElement = document.getElementById('totalTime');
            const modalTotalPriceElement = document.getElementById('modalTotalPrice');
            const modalTotalDurationElement = document.getElementById('modalTotalDuration');
            const priceTypeSelect = document.getElementById('price_type');
            const retailPriceGroup = document.getElementById('retail_price_group');
            const retailPriceInput = document.getElementById('retail_price');
            const discountGroup = document.getElementById('discount_group');
            const discountInput = document.getElementById('discount_percentage');
            const priceInfo = document.getElementById('price_info');

            let selectedServicesArray = [];

            // Event listener for adding services
            serviceList.addEventListener('click', function(event) {
                if (event.target && event.target.matches('li.list-group-item')) {
                    const serviceId = event.target.dataset.serviceId;
                    const serviceName = event.target.dataset.serviceName;
                    const variantId = event.target.dataset.variantId;
                    const variantName = event.target.dataset.variantName;
                    const servicePrice = event.target.dataset.servicePrice;
                    const serviceDuration = parseInt(event.target.dataset.serviceDuration);
                    addServiceToForm(serviceId, serviceName, variantId, variantName, servicePrice,
                        serviceDuration);
                    $('#serviceModal').modal('hide');
                }
            });

            // Event listener for price type changes
            priceTypeSelect.addEventListener('change', updatePricingFields);

            function addServiceToForm(serviceId, serviceName, variantId, variantName, price, duration) {
                const serviceRow = document.createElement('div');
                serviceRow.classList.add('row', 'service-row', 'mt-2');

                // Determine the price value to store
                const priceToStore = price === null || price === undefined || price === 'free' || isNaN(parseFloat(
                    price)) ? 'free' : price;

                serviceRow.innerHTML = `
        <div class="col-md-6">
            <input type="hidden" name="services[]" value="${serviceName}">
            <input type="hidden" name="variants[]" value="${variantName}">
            <input type="hidden" name="service_prices[]" value="${priceToStore}">
            <input type="hidden" name="service_durations[]" value="${duration}">
            <p><strong>${serviceName}</strong> - ${variantName}</p>
        </div>
        <div class="col-md-2">
            <p>${duration} min</p>
        </div>
        <div class="col-md-2">
            <p>${priceToStore === 'free' ? 'Free' : '₹' + parseFloat(priceToStore).toFixed(2)}</p>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-service">Remove</button>
        </div>
    `;
                selectedServices.appendChild(serviceRow);

                selectedServicesArray.push({
                    serviceId,
                    serviceName,
                    variantId,
                    variantName,
                    price: priceToStore,
                    duration
                });


                // Add event listener to remove button
                serviceRow.querySelector('.remove-service').addEventListener('click', function() {
                    serviceRow.remove();
                    selectedServicesArray = selectedServicesArray.filter(service =>
                        !(service.serviceId === serviceId && service.variantId === variantId)
                    );
                    updateTotals();
                });

                updateTotals();
            }

            const totalDurationInput = document.getElementById('total_duration');

            function updateTotals() {
                let totalPrice = 0;
                let totalTime = 0;
                selectedServicesArray.forEach(service => {
                    if (service.price !== null && service.price !== 'free' && !isNaN(parseFloat(service
                            .price))) {
                        totalPrice += parseFloat(service.price);
                    }
                    totalTime += service.duration;
                });
                totalPriceElement.textContent = totalPrice > 0 ? '₹' + totalPrice.toFixed(2) : 'Free';
                totalTimeElement.textContent = formatTime(totalTime);
                totalDurationInput.value = formatTime(totalTime); // Update the new input field
                updatePricingFields();
            }

            function updateModalTotals() {
                let totalPrice = 0;
                let totalDuration = 0;
                document.querySelectorAll('#serviceList li.active').forEach(li => {
                    const price = li.dataset.servicePrice;
                    if (price !== null && price !== 'free' && !isNaN(parseFloat(price))) {
                        totalPrice += parseFloat(price);
                    }
                    totalDuration += parseInt(li.dataset.serviceDuration);
                });
                modalTotalPriceElement.textContent = totalPrice > 0 ? '₹' + totalPrice.toFixed(2) : 'Free';
                modalTotalDurationElement.textContent = formatTime(totalDuration);
            }

            function formatTime(totalMinutes) {
                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;

                if (hours === 0) {
                    return `${totalMinutes}min`;
                } else if (minutes === 0) {
                    return `${hours}h`;
                } else {
                    return `${hours}h ${minutes}min`;
                }
            }

            function updatePricingFields() {
                const selectedType = priceTypeSelect.value;

                retailPriceGroup.style.display = 'block';
                discountGroup.style.display = 'none';
                retailPriceInput.readOnly = true;
                priceInfo.textContent = '';

                switch (selectedType) {
                    case 'service_pricing':
                        retailPriceInput.value = totalPriceElement.textContent === 'Free' ? '0' : totalPriceElement
                            .textContent.replace('₹', '');
                        priceInfo.textContent = 'Total price of selected services';
                        break;
                    case 'custom_pricing':
                        retailPriceInput.value = '';
                        retailPriceInput.readOnly = false;
                        priceInfo.textContent = 'Enter custom price';
                        break;
                    case 'percentage_discount':
                        retailPriceInput.value = totalPriceElement.textContent === 'Free' ? '0' : totalPriceElement
                            .textContent.replace('₹', '');
                        discountGroup.style.display = 'block';
                        priceInfo.textContent = 'Discounted price will be calculated';
                        break;
                    case 'free':
                        retailPriceGroup.style.display = 'none';
                        retailPriceInput.value = '0';
                        break;
                }
            }

            // Calculate discount when percentage changes
            discountInput.addEventListener('input', function() {
                if (priceTypeSelect.value === 'percentage_discount') {
                    const totalPrice = parseFloat(totalPriceElement.textContent.replace('₹', '')) || 0;
                    const discountPercentage = parseFloat(discountInput.value) || 0;
                    const discountedPrice = totalPrice * (1 - discountPercentage / 100);
                    retailPriceInput.value = discountedPrice.toFixed(2);
                }
            });

            // Update modal totals when selecting/deselecting services
            serviceList.addEventListener('click', function(event) {
                if (event.target && event.target.matches('li.list-group-item')) {
                    event.target.classList.toggle('active');
                    updateModalTotals();
                }
            });

            // Ensure the modal closes when clicking outside of it
            $('#serviceModal').modal({
                backdrop: true,
                keyboard: true
            });

            // Initial call to set up the pricing fields
            updatePricingFields();
        });
    </script>
@endpush
