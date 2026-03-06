@extends('backend.layouts.master')
@section('title','Edit Related Product')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css"
    media="screen" />
<style>
    #productTable input.form-control,
    #subtotal input.form-control {
        padding: 0.5rem 0.5rem;
        border-radius: 0.2rem;
        line-height: 0.5;
    }

    #productTable .calculated-row input.form-control {
        padding: 0.2rem 0.5rem;
    }
    
    .ui-autocomplete {
        z-index: 9999 !important;
    }
</style>
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        Edit Related Product (Variant ID: {{ $variantId }})
                    </h4>
                    <a href="{{ route('manage-related-product.index')}}" title="Back to List"
                        class="btn btn-sm btn-primary">
                        << Go Back </a>
                    </div>
                    <div class="card-body">
                        <div id="error-container"></div>
                        <form method="POST" action="{{ route('manage-related-product.update', $variantId) }}" accept-charset="UTF-8"
                            enctype="multipart/form-data" id="edit_related_product_form">
                            @csrf
                            @method('PUT')
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 position-relative">
                                            <label for="relation_type" class="form-label fw-bold">
                                                Select Relation Type *
                                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                                    title="Choose how these products are related"></i>
                                            </label>
                                            <div class="input-group">
                                                <select name="relation_type" id="relation_type" class="form-select"
                                                    required>
                                                    <option value="">-- Choose Relation Type --</option>
                                                    <option value="related" {{ $relationType == 'related' ? 'selected' : '' }}>Related Products</option>
                                                    <option value="upsell" {{ $relationType == 'upsell' ? 'selected' : '' }}>Upsell Products</option>
                                                    <option value="cross-sell" {{ $relationType == 'cross-sell' ? 'selected' : '' }}>Cross Sell Products</option>
                                                    <option value="similar" {{ $relationType == 'similar' ? 'selected' : '' }}>Similar Products</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Group Title *</label>
                                        <input type="text" name="group_title" id="group_title"  class="form-control" value="{{ $relatedProducts->first()->group_title }}">
                                    </div> 
                                    <div class="row related-product-container">
                                        <table class="table table-bordered smalltext" id="productTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%;">
                                                        Select Product *
                                                        <a href="{{ route('product.create', ['redirect_url' => url()->current()]) }}"
                                                            target="_blank" data-title="Add Product"
                                                            data-bs-toggle="tooltip" title="Add Product"
                                                            class="btn btn-sm btn-info">
                                                            Add new Product
                                                        </a>
                                                    </th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($relatedProducts as $index => $relatedProduct)
                                                <tr>
                                                    <td>
                                                        <div class="position-relative">
                                                            <div class="input-group">
                                                                <input type="text" 
                                                                    class="form-control related-product-autocomplete" 
                                                                    value="{{ $relatedProduct->product->title ?? '' }}"
                                                                    data-product-id="{{ $relatedProduct->product_id }}"
                                                                    autocomplete="off">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-refresh"></i>
                                                                    <div class="spinner-border spinner-border-sm product-loader"
                                                                        role="status" style="display: none;">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" name="product_id[]" class="product_id" value="{{ $relatedProduct->product_id }}">
                                                            <input type="hidden" name="related_product_id[]" value="{{ $relatedProduct->id }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="related_title[]" class="form-control" value="{{ $relatedProduct->title }}">
                                                    </td>
                                                    <td>
                                                        <textarea name="related_description[]" class="form-control" rows="1">{{ $relatedProduct->description }}</textarea>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="col-lg-12">
                                            <div style="display: flex; justify-content: flex-end;">
                                                <button type="button" class="btn btn-success btn-sm" id="addMoreRelatedProduct">
                                                    Add More
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary w-100">Update</button>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="{{ route('manage-related-product.index') }}" class="btn btn-danger w-100">Cancel</a>
                                        </div>
                                    </div>
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
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/related-product.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}" type="text/javascript"></script>
@endpush