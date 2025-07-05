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
                        Review Details ({{ $review->review_name }})
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive1">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <tbody>
                                <tr>
                                    <th>Review post date/time</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($review->review_post_date)->format('d M Y h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review product name</th>
                                    <td>
                                        <h4 class="text-info">{{ $review->product->title }}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review name</th>
                                    <td>
                                        {{ $review->review_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <=$review->rating_star_value)
                                            <i class="ti ti-star-filled text-warning"></i>
                                            @else
                                            <i class="ti ti-star text-warning"></i>
                                            @endif
                                            @endfor
                                            ({{ $review->rating_star_value }})
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review title</th>
                                    <td>
                                        {{ $review->review_title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review message</th>
                                    <td>
                                        {{ $review->review_message }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Review email
                                    </th>
                                    <td>
                                        {{ $review->review_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($review->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                        @else
                                        <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Images/Video</th>
                                    <td>
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
<script>
    var routes = {
        reviewIndex: "{{ route('manage-rating') }}",
    };
</script>
<script src="{{asset('backend/assets/js/pages/product-review.js')}}" type="text/javascript"></script>
@endpush