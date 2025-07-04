@extends('backend.layouts.master')
@section('title','All Review List')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        All Review List
                    </h4>

                </div>
                <div class="card-body">
                    @if (isset($reviews) && $reviews->count() > 0)
                    <div class="table-responsive" id="review_list">
                         @include('backend.manage-review.partials.ajax-review-list', ['reviews' => $reviews])
                    </div>
                    @endif
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