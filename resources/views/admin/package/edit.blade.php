@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.package.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Treatment Package</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.package.index') }}">Treatment Package</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Treatment Package</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.package.update', $package->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $package->name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ $package->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $package->status == 0 ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Treatment Category<span
                                                    class="text-danger"></span></label>
                                            <select name="category" class="form-control">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $package->category == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea name="description" class="form-control">{{ $package->description }}</textarea>
                                </div>

                                <div class="card-treatments">
                                    <div class="card-header-treatments">
                                        <h4>Treatments</h4>
                                        <p>Select which treatments to include in this package and how they should be
                                            sequenced when booked.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                                                data-target="#serviceModal">Add Treatment</button>
                                        </div>
                                    </div>
                                    <div id="selectedServices" class="mt-5">
                                        @foreach ($package->packageServiceVariants as $variant)
                                            <div class="row service-row mt-2">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="services[]"
                                                        value="{{ $variant->treatment_name }}">
                                                    <input type="hidden" name="variants[]"
                                                        value="{{ $variant->variants }}">
                                                    <input type="hidden" name="service_prices[]"
                                                        value="{{ $variant->price }}">
                                                    <input type="hidden" name="service_durations[]"
                                                        value="{{ $variant->duration }}">
                                                    <p><strong>{{ $variant->treatment_name }}</strong> -
                                                        {{ $variant->variants }}</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p>{{ $variant->duration }} min</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p>{{ $variant->price === 'free' ? 'Free' : '₹' . $variant->price }}
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-service">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-right">
                                            <h5>Total Time: <span id="totalTime">{{ $package->total_time }}</span> | Total
                                                Price: <span id="totalPrice">{{ $package->total_price }}</span></h5>
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
                                                    <option value="Treatment Pricing"
                                                        {{ $package->price_type == 'Treatment Pricing' ? 'selected' : '' }}>
                                                        Treatment pricing</option>
                                                    <option value="Custom Pricing"
                                                        {{ $package->price_type == 'Custom Pricing' ? 'selected' : '' }}>
                                                        Custom pricing</option>
                                                    <option value="Percentage Discount"
                                                        {{ $package->price_type == 'Percentage Discount' ? 'selected' : '' }}>
                                                        Percentage discount</option>
                                                    <option value="Free"
                                                        {{ $package->price_type == 'Free' ? 'selected' : '' }}>Free
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="retail_price_group">
                                                <label for="retail_price">Retail price</label>
                                                <input type="number" step="0.01" name="retail_price" id="retail_price"
                                                    class="form-control" value="{{ $package->total_price }}" readonly>
                                                <small id="price_info" class="form-text text-muted"></small>
                                            </div>

                                            <input type="hidden" name="total_duration" id="total_duration"
                                                class="form-control" value="{{ $package->total_time }}" readonly>

                                            <div class="form-group" id="discount_group" style="display: none;">
                                                <label for="discount_percentage">Discount percentage</label>
                                                <input type="number" step="0.01" name="discount_percentage"
                                                    id="discount_percentage" class="form-control"
                                                    value="{{ $package->discount_percentage }}">
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
                                                    <option value="All genders"
                                                        {{ $package->available_for == 'All genders' ? 'selected' : '' }}>
                                                        All genders</option>
                                                    <option value="Females only"
                                                        {{ $package->available_for == 'Females only' ? 'selected' : '' }}>
                                                        Females only</option>
                                                    <option value="Males only"
                                                        {{ $package->available_for == 'Males only' ? 'selected' : '' }}>
                                                        Males only</option>
                                                    <option value="Unisex"
                                                        {{ $package->available_for == 'Unisex' ? 'selected' : '' }}>Unisex
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
                        @foreach ($services as $service)
                            @foreach ($service->priceVariants as $variant)
                                <li class="list-group-item" data-service-id="{{ $service->id }}"
                                    data-service-name="{{ $service->name }}" data-variant-id="{{ $variant->id }}"
                                    data-variant-name="{{ $variant->name }}" data-service-price="{{ $variant->price }}"
                                    data-service-duration="{{ $variant->duration }}">
                                    <strong>{{ $service->name }}</strong> - {{ $variant->name }}
                                    (<b>By -{{ $service->user->name }}</b>)
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
            const totalDurationInput = document.getElementById('total_duration');

            // Code for closing the modal
            var serviceModal = document.getElementById('serviceModal');
            var closeButton = serviceModal.querySelector('.close');

            function closeModal() {
                serviceModal.classList.remove('show');
                document.body.classList.remove('modal-open');
                setTimeout(function() {
                    serviceModal.style.display = 'none';
                    var modalBackdrop = document.querySelector('.modal-backdrop');
                    if (modalBackdrop) {
                        modalBackdrop.parentNode.removeChild(modalBackdrop);
                    }
                }, 150); // Adjust this timeout to match your fade duration
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === serviceModal) {
                    closeModal();
                }
            });

            // Close modal when clicking the close button
            closeButton.addEventListener('click', function() {
                closeModal();
            });

            // Store the original total price
            const originalTotalPrice = parseFloat(retailPriceInput.value) || 0;

            let selectedServicesArray = [];

            // Initialize selectedServicesArray with existing services
            document.querySelectorAll('#selectedServices .service-row').forEach(row => {
                const serviceId = row.querySelector('input[name="services[]"]').value;
                const variantName = row.querySelector('input[name="variants[]"]').value;
                const price = row.querySelector('input[name="service_prices[]"]').value;
                const duration = parseInt(row.querySelector('input[name="service_durations[]"]').value);

                selectedServicesArray.push({
                    serviceId,
                    serviceName: serviceId, // Assuming serviceId is the treatment name
                    variantId: variantName,
                    variantName,
                    price,
                    duration
                });
            });

            function markExistingServicesAsSelected() {
                const serviceListItems = document.querySelectorAll('#serviceList li');
                serviceListItems.forEach(item => {
                    const serviceId = item.dataset.serviceName;
                    const variantId = item.dataset.variantName;
                    const isSelected = selectedServicesArray.some(service =>
                        service.serviceName === serviceId && service.variantName === variantId
                    );
                    if (isSelected) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
                updateModalTotals();
            }

            // Call this function when the modal is shown
            $('#serviceModal').on('show.bs.modal', function() {
                markExistingServicesAsSelected();
            });

            // Event listener for adding/removing services in the modal
            serviceList.addEventListener('click', function(event) {
                if (event.target && event.target.matches('li.list-group-item')) {
                    const serviceId = event.target.dataset.serviceName;
                    const serviceName = event.target.dataset.serviceName;
                    const variantId = event.target.dataset.variantName;
                    const variantName = event.target.dataset.variantName;
                    const servicePrice = event.target.dataset.servicePrice;
                    const serviceDuration = parseInt(event.target.dataset.serviceDuration);

                    const isAlreadySelected = selectedServicesArray.some(service =>
                        service.serviceName === serviceId && service.variantName === variantId
                    );

                    if (isAlreadySelected) {
                        selectedServicesArray = selectedServicesArray.filter(service =>
                            !(service.serviceName === serviceId && service.variantName === variantId)
                        );
                        event.target.classList.remove('active');
                        removeServiceFromForm(serviceId, variantId);
                    } else {
                        addServiceToForm(serviceId, serviceName, variantId, variantName, servicePrice,
                            serviceDuration);
                        event.target.classList.add('active');
                    }
                    updateModalTotals();
                }
            });

            function addServiceToForm(serviceId, serviceName, variantId, variantName, price, duration) {
                const serviceRow = document.createElement('div');
                serviceRow.classList.add('row', 'service-row', 'mt-2');

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

                const existingServiceIndex = selectedServicesArray.findIndex(service =>
                    service.serviceName === serviceId && service.variantName === variantId
                );

                if (existingServiceIndex === -1) {
                    selectedServicesArray.push({
                        serviceId,
                        serviceName,
                        variantId,
                        variantName,
                        price: priceToStore,
                        duration
                    });
                }

                updateTotals();
            }

            function removeServiceFromForm(serviceId, variantId) {
                const serviceRow = Array.from(selectedServices.children).find(row => {
                    const rowServiceId = row.querySelector('input[name="services[]"]').value;
                    const rowVariantId = row.querySelector('input[name="variants[]"]').value;
                    return rowServiceId === serviceId && rowVariantId === variantId;
                });

                if (serviceRow) {
                    serviceRow.remove();
                }

                selectedServicesArray = selectedServicesArray.filter(service =>
                    !(service.serviceName === serviceId && service.variantName === variantId)
                );

                updateTotals();
                markExistingServicesAsSelected();
            }

            // Event listener for remove buttons
            selectedServices.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-service')) {
                    const serviceRow = event.target.closest('.service-row');
                    const serviceId = serviceRow.querySelector('input[name="services[]"]').value;
                    const variantId = serviceRow.querySelector('input[name="variants[]"]').value;
                    removeServiceFromForm(serviceId, variantId);
                }
            });

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
                totalDurationInput.value = totalTime;
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
                const currentTotalPrice = parseFloat(totalPriceElement.textContent.replace('₹', '')) || 0;

                retailPriceGroup.style.display = 'block';
                discountGroup.style.display = 'none';
                retailPriceInput.readOnly = true;
                priceInfo.textContent = '';

                switch (selectedType) {
                    case 'Treatment Pricing':
                        retailPriceInput.value = currentTotalPrice.toFixed(2);
                        priceInfo.textContent = 'Total price of selected services';
                        break;
                    case 'Custom Pricing':
                        retailPriceInput.value = originalTotalPrice.toFixed(2);
                        retailPriceInput.readOnly = false;
                        priceInfo.textContent = 'Enter custom price';
                        break;
                    case 'Percentage Discount':
                        retailPriceInput.value = currentTotalPrice.toFixed(2);
                        discountGroup.style.display = 'block';
                        priceInfo.textContent = 'Discounted price will be calculated';
                        calculateDiscountedPrice();
                        break;
                    case 'Free':
                        retailPriceGroup.style.display = 'block';
                        retailPriceInput.value = '0.00';
                        retailPriceInput.readOnly = true;
                        priceInfo.textContent = 'This package is free';
                        break;
                }
            }

            function calculateDiscountedPrice() {
                const totalPrice = parseFloat(totalPriceElement.textContent.replace('₹', '')) || 0;
                const discountPercentage = parseFloat(discountInput.value) || 0;
                const discountedPrice = totalPrice * (1 - discountPercentage / 100);
                retailPriceInput.value = discountedPrice.toFixed(2);
            }

            // Event listener for price type changes
            priceTypeSelect.addEventListener('change', updatePricingFields);

            // Calculate discount when percentage changes
            discountInput.addEventListener('input', calculateDiscountedPrice);

            // Ensure the modal closes when clicking outside of it
            $('#serviceModal').modal({
                backdrop: true,
                keyboard: true
            });

            // Initial call to set up the pricing fields
            updateTotals();
            updatePricingFields();
        });
    </script>
@endpush
