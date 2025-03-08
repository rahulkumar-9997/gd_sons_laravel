@extends('backend.layouts.master')
@section('title', $label_row->title)
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div id="example-2_wrapper" class="filter-box">
                <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1 client-list-filter">
                    <div class="d-flex align-items-center border-end pe-1">
                    <p class="mb-0 me-2 text-dark-grey f-14">Category:</p>
                    <select id="category-filter" class="form-select form-select-md">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <label class="mb-0 me-2 text-dark-grey f-14">Search:</label>
                    <input type="search" class="form-control form-control-md" id="product-search" placeholder="Search products">
                </div>
                <button id="reset-button" class="btn btn-danger" style="display:none;">
                    <svg class="svg-inline--fa fa-times-circle fa-w-16 mr-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                    Reset Filters
                </button>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <a href="{{route('label')}}"
                        data-title="Go Back to Previous Page"
                        data-bs-toggle="tooltip"
                        title="Go Back to Previous Page"
                        class="btn btn-sm btn-danger">
                        << Go Back to Previous Page
                    </a>
                    <h4 class="card-title flex-grow-1">
                        Selected Label
                        <span class="text-success">({{$label_row->title}})</span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="label_product_list">
                        @if (isset($productsWithLabel))
                            @include('backend.label.partials.product-label-partials', ['productsWithLabel' => $productsWithLabel])
                        @endif
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
        labelIndex: "{{ route('label-product', ['labelId' =>$label_row->id]) }}", 
    };
    var csrfToken = "{{ csrf_token() }}";
</script>
<script type="text/javascript" src="{{asset('backend/assets/js/pages/product-label.js')}}"></script>
@endpush