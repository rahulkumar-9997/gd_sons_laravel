@extends('backend.layouts.master')
@section('title','Manage Products')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>   
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/daterangepicker/daterangepicker.css')}}" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div id="example-2_wrapper" class="filter-box">
                <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1 client-list-filter">
                    <!-- Category Filter -->
                    <input type="hidden" id="product-update-gst-url" value="{{ route('product-update-gst.filter') }}">
                    <div class="d-flex align-items-center border-end pe-1">
                        <p class="mb-0 me-2 text-dark-grey f-14">Category:</p>
                        <select id="category-filter" class="form-select form-select-md">
                            <option value="">All Categories</option>
                            @foreach($data['categories'] as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Search Filter -->
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
                <h4 class="card-title flex-grow-1">
                    All Produtcs List
                </h4>
                </div>
                <div class="card-body">
                    @if (isset($data['product_list']) && $data['product_list']->count() > 0)
                    <div class="table-responsive" id="product-list-with-gst-hsn">
                        @include('backend.product.update-gst.partials.product-table-with-hsn-gst', ['data' => $data])
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
<script src="{{asset('backend/assets/js/pages/hsncodeorgst-update.js')}}"></script>
@endpush