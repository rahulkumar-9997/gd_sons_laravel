@extends('backend.layouts.master')
@section('title','Edit Bulk Featured Product')
@section('main-content')
@push('styles')
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
@endpush
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Edit Bulk Featured Product</h4>
               <a href="{{ route('bulk-featured-products.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
            </div>
            <div class="card-body">

               @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
               @endif

               <form action="{{ route('bulk-featured-products.update', $bulkFeaturedProduct->id) }}" method="POST" id="bulkFeaturedForm">
                  @csrf
                  @method('PUT')

                  <div class="row g-3">
                     <div class="col-md-6">
                        <label class="form-label">Select Product <span class="text-danger">*</span></label>
                        <div class="position-relative">
                           <div class="input-group">
                              <input type="text" name="product_name" class="form-control product-autocomplete"
                                     placeholder="Type product name"
                                     value="{{ old('product_name', $bulkFeaturedProduct->product->title ?? '') }}" required>
                              <span class="input-group-text">
                                 <i class="ti ti-refresh"></i>
                                 <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>
                              </span>
                           </div>
                           <input type="hidden" name="product_id" class="product_id"
                                  value="{{ old('product_id', $bulkFeaturedProduct->product_id) }}">
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label class="form-label">Bulk Rate (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="bulk_rate" class="form-control"
                               value="{{ old('bulk_rate', $bulkFeaturedProduct->bulk_rate) }}" required>
                     </div>

                     <div class="col-md-3">
                        <label class="form-label">Min Qty (pcs) <span class="text-danger">*</span></label>
                        <input type="number" name="min_qty" class="form-control" value="{{ old('min_qty', $bulkFeaturedProduct->min_qty) }}" required>
                     </div>
                     <div class="col-md-3 d-flex align-items-end">
                        <div class="form-check">
                           <input type="checkbox" name="status" value="1" class="form-check-input" id="status" {{ old('status', $bulkFeaturedProduct->status) ? 'checked' : '' }}>
                           <label class="form-check-label" for="status">Active</label>
                        </div>
                     </div>
                  </div>

                  <div class="mt-4">
                     <button type="submit" class="btn btn-primary">Update</button>
                     <a href="{{ route('bulk-featured-products.index') }}" class="btn btn-light">Cancel</a>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<script>
   $(function () {
      const autocompleteUrl = "{{ route('supplies.product-autocomplete') }}";
      const $input = $('.product-autocomplete');
      const $hiddenId = $('.product_id');
      const $loader = $('.product-loader');

      $input.autocomplete({
         minLength: 0,
         source: function (request, response) {
            $loader.show();
            $.getJSON(autocompleteUrl, { term: request.term }, function (data) {
               $loader.hide();
               response(data);
            }).fail(function () {
               $loader.hide();
               response([]);
            });
         },
         select: function (event, ui) {
            $input.val(ui.item.value);
            $hiddenId.val(ui.item.id);
            return false;
         },
         change: function (event, ui) {
            if (!ui.item) {
               $hiddenId.val('');
            }
         }
      });

      $('#bulkFeaturedForm').on('submit', function () {
         $(this).find('button[type="submit"]')
            .prop('disabled', true)
            .html('Updating... <i class="spinner-border spinner-border-sm"></i>');
      });
   });
</script>
@endpush