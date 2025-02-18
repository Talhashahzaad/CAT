@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.listing.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Listing</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.listing.index') }}">Listing</a></div>
                <div class="breadcrumb-item">Update</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Listing</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.listing.update', $listing->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Image<span class="text-danger">*</span>
                                            </label>
                                            <div id="image-preview" class="image-preview preview-1">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image" id="image-upload" />
                                                <input type="hidden" name="old_image" value="{{ $listing->image }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thumbnail Image <span class="text-danger">*</span>
                                            </label>
                                            <div id="image-preview-2" class="image-preview preview-2">
                                                <label for="image-upload-2" id="image-label-2">Choose File</label>
                                                <input type="file" name="thumbnail_image" id="image-upload-2" />
                                                <input type="hidden" name="old_thumbnail_image"
                                                    value="{{ $listing->thumbnail_image }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ $listing->title }}"
                                        required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Category<span class="text-danger">*</span></label>
                                            <select name="category" id="" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option @selected($category->id === $listing->category_id) value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Location<span class="text-danger">*</span></label>
                                            <select name="location" id="" class="form-control" required>
                                                <option value="">Select Location</option>
                                                @foreach ($locations as $location)
                                                    <option @selected($location->id === $listing->location_id) value="{{ $location->id }}">
                                                        {{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ $listing->address }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $listing->phone }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $listing->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Website <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="website"
                                                value="{{ $listing->website }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Facebook Url <span class="text-danger"></span></label>
                                            <input type="text" name="facebook_link" class="form-control"
                                                value="{{ $listing->facebook_link }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Instagram Url <span class="text-danger"></span></label>
                                            <input type="text" name="instagram_link" class="form-control"
                                                value="{{ $listing->instagram_link }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">TikTok Url <span class="text-danger"></span></label>
                                            <input type="text" name="tiktok_link" class="form-control"
                                                value="{{ $listing->tiktok_link }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">YouTube Url <span class="text-danger"></span></label>
                                            <input type="text" name="youtube_link" class="form-control"
                                                value="{{ $listing->youtube_link }}">
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Professional Affiliations</label>
                                            <select class="form-control select2 listingCertificate" multiple=""
                                                name="professional_certificates[]">
                                                @foreach ($certificates as $certificate)
                                                    <option value="{{ $certificate->id }}">{{ $certificate->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Choose Practitioner</label>
                                            <select class="form-control select2 listingPractitioner" multiple=""
                                                name="practitioner[]">
                                                @foreach ($practitioners as $practitioner)
                                                    <option value="{{ $practitioner->id }}">{{ $practitioner->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if ($listing->file)
                                            <div><i class="fas fa-file-alt" style="font-size: 70px;"></i>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="">Attachment <span class="text-danger"></span></label>
                                            <input type="file" name="attachment" class="form-control">
                                            <input type="hidden" class="form-control" name="old_attachment"
                                                value="{{ $listing->file }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Amenities</label>
                                    <select class="form-control select2" multiple="" name="amenities[]">
                                        @foreach ($amenities as $amenity)
                                            <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="summernote" required>{!! $listing->description !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Google Map Embed Code <span class="text-danger">*</span></label>
                                    <textarea name="google_map_embed_code" class="form-control">{!! $listing->google_map_embed_code !!}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tags</label>
                                            <select class="form-control select2 listingtag" multiple=""
                                                name="tag[]">
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Booking Capacity</label>
                                            <input type="text" class="form-control" name="service_capacity"
                                                value="{{ $listing->service_capacity }}" pattern="\d*"
                                                title="Please enter a positive number"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">SEO Title <span class="text-danger">*</span></label>
                                    <input type="text" name="seo_title" class="form-control"
                                        value="{{ $listing->seo_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">SEO Description <span class="text-danger">*</span></label>
                                    <textarea name="seo_description" class="form-control">{!! $listing->seo_description !!}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option @selected($listing->status === 1) value="1">Active</option>
                                                <option @selected($listing->status === 0) value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Is Featured <span class="text-danger"></span></label>
                                            <select name="is_featured" class="form-control">
                                                <option @selected($listing->is_featured === 0) value="0">No</option>
                                                <option @selected($listing->is_featured === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Is Verified <span class="text-danger"></span></label>
                                            <select name="is_verified" class="form-control">
                                                <option @selected($listing->is_verified === 0) value="0">No</option>
                                                <option @selected($listing->is_verified === 1) value="1">Yes</option>
                                            </select>
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
@endsection

@push('scripts')
    <script>
        var listingAmenities = {!! json_encode($listingAmenities) !!}
        $('.select2').select2().val(listingAmenities).trigger("change");

        var listingPractitioner = {!! json_encode($listingPractitioner) !!}
        $('.listingPractitioner').select2().val(listingPractitioner).trigger("change");

        var listingCertificate = {!! json_encode($listingCertificate) !!}
        $('.listingCertificate').select2().val(listingCertificate).trigger("change");

        var listingtag = {!! json_encode($listingTag) !!}
        $('.listingtag').select2().val(listingtag).trigger("change");

        $(document).ready(function() {
            $('.preview-1').css({
                'background-image': 'url({{ asset($listing->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

            $('.preview-2').css({
                'background-image': 'url({{ asset($listing->thumbnail_image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        })

        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload
            preview_box: "#image-preview-2", // Default: .image-preview
            label_field: "#image-label-2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
