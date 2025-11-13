@extends('backend.layouts.master')
@section('title','Product Multiple Update')
@section('main-content')
@push('styles')

@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1 filter-box">
                    <h4 class="card-title flex-grow-1">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="dropdown">
                                    <select id="selecte-criteria" class="form-select">
                                        <option value="">Select Criteria For Update</option>
                                        <option value="product-name" {{ request('criteria') == 'product-name' ? 'selected' : '' }}>
                                            Product Name
                                        </option>
                                        <option value="meta-title-description" {{ request('criteria') == 'meta-title-description' ? 'selected' : '' }}>
                                            Meta Title, Meta Description
                                        </option>
                                        <option value="product-description" {{ request('criteria') == 'product-description' ? 'selected' : '' }}>
                                            Product Description
                                        </option>
                                        <option value="product-specification" {{ request('criteria') == 'product-specification' ? 'selected' : '' }}>
                                            Product Specification
                                        </option>
                                        <option value="product-image" {{ request('criteria')=='product-image' ? 'selected' : '' }}>
                                            Product Image
                                        </option>
                                        <option value="video-id" {{ request('criteria')=='video-id' ? 'selected' : '' }}>
                                            Product Video ID
                                        </option>
                                        <option value="g-tin-no" {{ request('criteria')=='g-tin-no' ? 'selected' : '' }}>
                                            Product GTIN (Global Trade Item Number) No.
                                        </option>
                                        <option value="length-breadth-height-weight" {{ request('criteria')=='length-breadth-height-weight' ? 'selected' : '' }}>
                                            Product Length, Breadth, Height, Weight
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="multiple-filter-wraperd-flex flex-wrap align-items-center bg-white gap-1">
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
                        </div>
                    </h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose any Links
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('export.product') }}" class="dropdown-item">Export Product</a>
                            <!-- item-->
                            <a href="{{route('product.excel.import')}}" class="dropdown-item">Import Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="multiple_update" id="multiple_update">
                        @include('backend.product.product-multiple-update.partials.list-table', ['criteria' => $criteria, 'products' =>$products])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/components/form-quilljs.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/multiple-update.js')}}"></script>
<script>
    var routes = {
        filterIndex: "{{ route('product-multiple-update') }}",
    };
    $('#selecte-criteria').on('change', function() {
        var selectedValue = $(this).val();
        var url = new URL(window.location.href);
        if (selectedValue) {
            url.searchParams.set('criteria', selectedValue);
        } else {
            url.searchParams.delete('criteria');
        }
        window.location.href = url.toString();
    });
    
</script>
@endpush