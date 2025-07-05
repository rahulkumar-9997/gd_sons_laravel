@extends('backend.layouts.master')
@section('title','Review details')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <a href="{{ route('manage-rating') }}" class="btn btn-sm btn-outline-primary" title="Back">
                        <i class="ti ti-arrow-left"></i> Back to previous page
                    </a>
                    <h4 class="card-title flex-grow-1">
                        Edit Review ({{ $review->review_name }})
                        <br>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$review->rating_star_value)
                            <i class="ti ti-star-filled text-warning"></i>
                            @else
                            <i class="ti ti-star text-warning"></i>
                            @endif
                        @endfor
                        ({{ $review->rating_star_value }})
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive1">
                        <form method="POST" action="{{ route('manage-rating.update', $review->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product name *</label>
                                        <input type="text" id="product_name" name="product_name" class="form-control" readonly="" value="{{ $review->product->title }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="review_title" class="form-label">Review Title</label>
                                        <input type="text" id="review_title" name="review_title" class="form-control" value="{{ $review->review_title }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="review_message" class="form-label">Review Message</label>
                                        <textarea class="form-control" id="review_message" rows="2" name="review_message">{{ $review->review_message }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="review_name" class="form-label">Review Name</label>
                                        <input type="text" id="review_name" name="review_name" class="form-control" value="{{ $review->review_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="review_email" class="form-label">Review Email</label>
                                        <input type="text" id="review_email" name="review_email" class="form-control" value="{{ $review->review_email }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @if($review->reviewFiles && $review->reviewFiles->count() > 0)
                                    <div class="d-flex gap-1">
                                        @foreach($review->reviewFiles as $file)
                                        @if($file->file_type == 'image')
                                        <div class="re-img mb-2" style="max-width: 150px;">
                                            <a href="{{ asset('images/review/'.$file->review_file) }}" data-fancybox="review-gallery">
                                                <img src="{{ asset('images/review/' . $file->review_file) }}"
                                                    class="img-thumbnail img-fluid"
                                                    alt="Review image"
                                                    loading="lazy">
                                            </a>
                                            <a href="{{ route('review.files.destroy', $file->id) }}" 
                                                class="mt-2 btn btn-soft-danger btn-sm show_confirm"
                                                title="Delete this file">
                                                <i class="ti ti-trash"></i>
                                            </a> 
                                        </div>
                                        @else
                                        <div class="re-video mb-2" style="max-width: 250px;">
                                            <video controls class="img-thumbnail img-fluid">
                                                <source src="{{ asset('images/review/' . $file->review_file) }}"
                                                    type="video/{{ pathinfo($file->review_file, PATHINFO_EXTENSION) }}">
                                                Your browser does not support the video tag.
                                            </video>
                                            <a href="{{ route('review.files.destroy', $file->id) }}" 
                                                class="mt-2 btn btn-soft-danger btn-sm show_confirm"
                                                title="Delete this file">
                                                <i class="ti ti-trash"></i>
                                            </a> 
                                        </div>
                                        @endif
                                            
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer pb-0">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')

@endpush