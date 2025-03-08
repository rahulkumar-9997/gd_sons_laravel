@extends('backend.layouts.master')
@section('title','Manage Item')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
 <style>
   #productTable input.form-control, #subtotal input.form-control{
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
                    Purchase List
                    <a href="{{ route('manage-item.index') }}" data-title="Go Back to Purchase List" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title="Go Back to Purchase List">
                      << Go Back to Purchase List
                    </a>
                </h4>
                <a href="javascript:void(0)" 
                    data-vendor-popup="true" 
                    data-size="lg" 
                    data-title="Add New Vendor" 
                    data-url="{{ route('manage-vendor.create') }}" 
                    data-bs-toggle="tooltip" 
                    title="Add New Vendor" 
                    class="btn btn-sm btn-primary">
                    Add New Vendor
                </a>
            </div>
            <div class="card-body">
               <!--@if (isset($data['vendor_list']) && $data['vendor_list']->count() > 0)
                  <div class="table-responsive" id="vendor-list-container">
                     @include('backend.manage-purchase.manage-vendor.partials.vendor_list_table', ['data' => $data])
                  </div>
               @endif-->
               <form method="POST" action="{{ route('manage-item.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="itemForm">
               @csrf
               <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="mb-3 position-relative">
                           <label for="vendor_name" class="form-label">
                              Select a Vendor name *
                           </label>
                           <div class="input-group">
                              <input type="text" id="vendor_name" name="vendor_name" class="form-control vendor-autocomplete" required="" placeholder="Select a vendor">
                              <span class="input-group-text">
                                 <i class="ti ti-refresh"></i>
                                 <div class="spinner-border spinner-border-sm" role="status" id="vendor_loader" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>
                              </span>
                           </div>
                           <input type="text" id="vendor_id" name="vendor_id" class="vendor-id" style="display: none;">
                           
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3 position-relative">
                           <label for="bill_date" class="form-label">Bill Date *</label>
                           <div class="input-group">
                              <input type="text" id="basic-datepicker" name="bill_date" class="form-control" placeholder="Select Bill date">
                              
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3 position-relative">
                           <label for="bill_no" class="form-label">Bill No *</label>
                           <div class="input-group">
                              <input type="text" id="bill_no" name="bill_no" class="form-control" placeholder="Enter Bill No.">
                              
                           </div>
                        </div>
                     </div>
                     <table class="table table-bordered smalltext" id="productTable">
                           <tr>
                              <th style="width: 25%;">
                                 Select Product * 
                                 <a href="{{ route('product.create', ['redirect_url' => url()->current()]) }}" target="_blank" 
                                    data-title="Add Product" 
                                    data-bs-toggle="tooltip" 
                                    title="Add Product" 
                                    class="btn btn-sm btn-success">
                                    Add new Product
                                 </a>
                                 <!--<a href="javascript:void(0)" data-ajax-product-popup="true" data-size="lg"   data-title="Add New Product" data-url="{{route('create-new-product.modal')}}" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Add New Product">
                                    Add new Product Modal
                                 </a>-->
                              </th>
                              <th>HSN *</th>
                              <th>MRP *</th>
                              <th>Qty *</th>
                              <th>Total Amount *</th>
                              <th>Purchase Rate *</th>
                              <th>Offer Rate *</th>
                              <th>GST%</th>
                           </tr>
                           <tr>
                              <td>
                                 <div class="position-relative">
                                       <div class="input-group">
                                          <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete" required>
                               
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
                                 <input type="text" id="hsn" name="hsn_code[]" class="form-control hsn-purchase" required>
                              </td>
                              <td>
                                 <input type="number" id="mrp" name="mrp[]" class="form-control" required>
                              </td>
                              <td>
                                 <input type="number" id="quantity" name="quantity[]" class="form-control" required>
                              </td>
                              <td>
                                 <input type="number" id="total_amount" name="total_amount[]" class="form-control" required>
                              </td>
                              <td>
                                 <input type="text" id="purchase_rate" name="purchase_rate[]" class="form-control" required>
                                 
                              </td>
                              <td>
                                 <input type="text" id="offer_rate" name="offer_rate[]" class="form-control" required>
                              </td>
                              <td>
                                 <input type="text" id="gst" name="gst_in_per[]" class="form-control gst-purchase">
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm remove-row">
                                    <i class="ti ti-trash"></i>
                                 </button>
                              </td>
                           </tr>
                     </table>
                     <div class="col-lg-12">
                        <div style="display: flex; justify-content: flex-start;">
                           <button type="button" class="btn btn-success btn-sm" id="addMore">
                              Add More
                              <i class="ti ti-plus"></i>
                           </button>
                        </div>
                     </div>
                     <div class="row mt-1 mb-1" id="subtotal">
                        <div class="col-md-12">
                           <div class="row mb-1">
                              <div class="col-md-9 text-end">
                                 <strong>Sub Total:</strong>
                              </div>
                              <div class="col-md-3">
                                 <input type="text" id="subTotal" name="sub_total" class="form-control text-end" readonly>
                              </div>
                           </div>
                           <div class="row mb-1">
                              <div class="col-md-9 text-end">
                                 <strong>GST Payable:</strong>
                              </div>
                              <div class="col-md-3">
                                 <input type="text" id="gstPayable" name="gst_payable" class="form-control text-end" readonly>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-9 text-end">
                                 <strong>Grand Total:</strong>
                              </div>
                              <div class="col-md-3">
                                 <input type="text" id="grandTotal" name="grand_total" class="form-control text-end" readonly>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <div class="col-lg-2">
                        <input type="submit" value="Submit" class="btn btn-primary w-100">
                     </div>
                     <div class="col-lg-2">
                        <input type="reset" class="btn btn-danger w-100" value="Reset">
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
<script src="{{asset('backend/assets/js/components/form-flatepicker.js')}}"></script>
<!--for vendor js code-->
<script src="{{asset('backend/assets/js/pages/vendor.js')}}"></script>
<!--for vendor js code-->
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<!--Select 2 -->
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<!--Select 2 -->
<script src="{{asset('backend/assets/js/pages/purchase-item.js')}}"></script>
@endpush