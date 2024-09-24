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
                            <form action="{{ route('admin.package.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <h4>Services</h4>
                                        <p>Select which services to include in this package and how they should be sequenced
                                            when booked.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                                                data-target="#serviceModal">Add Service</button>
                                        </div>
                                    </div>
                                    <div id="selectedServices" class="mt-3">
                                        <!-- Selected services will be added here -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-right">
                                            <h5>Total Time: <span id="totalTime">0</span> | Total Price: ₹<span
                                                    id="totalPrice">0</span></h5>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="serviceList" class="list-group mt-3">
                        @foreach ($services as $service)
                            <li class="list-group-item" data-service-id="{{ $service->id }}"
                                data-service-name="{{ $service->name }}" data-service-price="{{ $service->total_price }}"
                                data-service-time="{{ $service->time }}">
                                {{ $service->name }} - {{ $service->time }} - ₹{{ $service->total_price }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceList = document.getElementById('serviceList');
            const totalPriceElement = document.getElementById('totalPrice');
            const totalTimeElement = document.getElementById('totalTime');

            serviceList.addEventListener('click', function(event) {
                if (event.target && event.target.matches('li.list-group-item')) {
                    const serviceId = event.target.dataset.serviceId;
                    const serviceName = event.target.dataset.serviceName;
                    const servicePrice = event.target.dataset.servicePrice;
                    const serviceTime = event.target.dataset.serviceTime;
                    addServiceToForm(serviceId, serviceName, servicePrice, serviceTime);
                    $('#serviceModal').modal('hide');
                }
            });

            function addServiceToForm(id, name, price, time) {
                const serviceContainer = document.getElementById('selectedServices');
                const serviceRow = document.createElement('div');
                serviceRow.classList.add('row', 'service-row');
                serviceRow.innerHTML = `
            <div class="col-md-6">
                <input type="hidden" name="services[]" value="${id}">
                <p>${name}</p>
            </div>
            <div class="col-md-2">
                <p>${time}</p>
            </div>
            <div class="col-md-2">
                <p>₹${price}</p>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-service">Remove</button>
            </div>
        `;
                serviceContainer.appendChild(serviceRow);

                // Add event listener to remove button
                serviceRow.querySelector('.remove-service').addEventListener('click', function() {
                    serviceRow.remove();
                    updateTotals();
                });

                updateTotals();
            }

            function updateTotals() {
                const serviceRows = document.querySelectorAll('.service-row');
                let totalPrice = 0;
                let totalTime = 0;
                serviceRows.forEach(row => {
                    const price = parseFloat(row.querySelector('p:nth-child(3)').textContent.replace('₹',
                        ''));
                    const time = parseTime(row.querySelector('p:nth-child(2)').textContent);
                    totalPrice += price;
                    totalTime += time;
                });
                totalPriceElement.textContent = totalPrice.toFixed(2);
                totalTimeElement.textContent = formatTime(totalTime);
            }

            function parseTime(timeStr) {
                const [hours, minutes] = timeStr.split('h').map(part => parseInt(part.trim()) || 0);
                return hours * 60 + minutes;
            }

            function formatTime(totalMinutes) {
                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                return `${hours}h ${minutes}min`;
            }

            // Ensure the modal closes when clicking outside of it
            $('#serviceModal').modal({
                backdrop: true,
                keyboard: true
            });
        });
    </script>
@endpush
