@extends('backend.layouts.master')
@section('title','Create Whatsapp Message')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen" />
<style>
    #productTable input.form-control,
    #subtotal input.form-control {
        padding: 0.5rem 0.5rem;
        border-radius: 0.2rem;
        line-height: 0.5;
    }

    .calculated-row {
        background-color: #f9f9f9;
        color: #555;
    }

    .calculated-row td {
        padding: 5px;
        font-size: 10px;
        color: red;
    }

    #productTable .calculated-row input.form-control {
        padding: 0.2rem 0.5rem;

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
                        Create Whatapp Message
                        <a href="{{ route('manage-whatsapp.index') }}" data-title=" Go Back to Previous page" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title=" Go Back to Previous page">
                            << Go Back to Previous page
                        </a>
                    </h4>
                    <a href="javascript:void(0)" data-conversation-popup="true" data-size="lg" data-title=" Create New Conversation to Whatsapp" data-url="{{ route('manage-whatsapp-conversation.create') }}" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Make Conversation to Whatsapp">
                        Create New Conversation to Whatsapp
                    </a>

                </div>
                <div class="card-body">

                    <div class="mb-2" id="error-container"></div>
                    <form method="POST" action="{{ route('manage-whatsapp.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="whatsAppMessageForm">
                        @csrf
                        <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">
                        <div class="row whatsapp-name-mobile">
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="mobile_no" class="form-label">Select Name/Mobile No. (Whatsapp No.) *</label>
                                    <div class="input-group">
                                        <input type="text" id="name" name="name" class="form-control whatsapp-conversation-autocomplete conversation_name" require="">
                                        <span class="input-group-text">
                                            <i class="ti ti-refresh"></i>
                                            <div class="spinner-border spinner-border-sm whatsapp-loader" role="status" style="display: none;">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="hidden" name="whatsapp_conversation_id" class="whatsapp_conversation_id">
                                </div>
                                
                            </div>
                        
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="mobile_no" class="form-label">Enter Mobile No. *</label>
                                    <div class="input-group">
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control conversation_mobile_number" maxlength="10" pattern="^\d{10}$">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered smalltext" id="productTable">
                                <tr>
                                    <th style="width: 25%;">
                                        Select Product *
                                        <!-- <a href="{{ route('product.create', ['redirect_url' => url()->current()]) }}" target="_blank" 
                                            data-title="Add Product" 
                                            data-bs-toggle="tooltip" 
                                            title="Add Product" 
                                            class="btn btn-sm btn-success">
                                            Add new Product
                                        </a> -->

                                    </th>
                                    <th>MRP *</th>
                                    <th>Purchase Rate *</th>
                                    <th>Offer Rate *</th>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="input-group">
                                                <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete">

                                                <span class="input-group-text">
                                                    <i class="ti ti-refresh"></i>
                                                    <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <input type="hidden" name="product_id[]" class="product_id">
                                        </div>
                                    </td>

                                    <td>
                                        <input type="text" id="mrp" name="mrp[]" class="form-control mrp">
                                    </td>
                                    <td>
                                        <input type="text" id="purchase_rate" name="purchase_rate[]" class="form-control purchase_rate">
                                        <input type="hidden" id="gst_per" name="gst_in_per[]" class="form-control gst_per">

                                    </td>
                                    <td>
                                        <input type="text" id="offer_rate" name="offer_rate[]" class="form-control offer_rate">
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </table>
                            <div class="col-lg-12 mb-3">
                                <div style="display: flex; justify-content: flex-start;">
                                    <button type="button" class="btn btn-success btn-sm" id="addMore">
                                        Add More
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <input type="submit" value="Submit" class="btn btn-primary w-100">
                            </div>
                        </div>
                    </form>
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
<script src="{{asset('backend/assets/js/pages/vendor.js')}}?v=1.1"></script>
<!--for vendor js code-->
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}?v=1.1">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}?v=1.1"></script>

<script src="{{asset('backend/assets/js/pages/create-whatsapp.js')}}?v=1.1"></script>
<script src="{{asset('backend/assets/js/pages/whatsapp-conversation.js')}}?v=1.1" type="text/javascript"></script>
@endpush