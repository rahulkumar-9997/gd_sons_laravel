@extends('backend.layouts.master')
@section('title','Shipping Rates List')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
@endpush
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">
                  All Shipping Rates List
               </h4>
               
            </div>
            <div class="card-body">
               @if (isset($shipping_rates) && $shipping_rates->count() > 0)
               <form action="{{ route('shipment-rate.export') }}" method="POST" class="mb-3" id="exportShipmentRatesForm">
                  @csrf
                  <div class="row">
                     <div class="col-md-5">
                           <label for="name" class="form-label">Select Weight Categories (Multiple)</label>
                           <select name="weight_category_ids[]" class="select-multiple" multiple="multiple" id="weightCategorySelect">
                              <option value="" disabled selected>Select Category</option>
                              @foreach($weight_categories as $weight)
                                 <option value="{{ $weight->id }}">
                                       {{ $weight->primary_weight }} KG
                                       (
                                       {{ number_format($weight->min_weight,2) }}
                                       -
                                       {{ $weight->max_weight ? number_format($weight->max_weight,2) : 'Above' }}
                                       )
                                 </option>
                              @endforeach
                           </select>
                           @error('weight_category_ids')
                              <div class="text-danger mt-1">{{ $message }}</div>
                           @enderror
                     </div>
                     <div class="col-md-2 mt-3">
                           <button type="submit" class="btn btn-success" id="exportBtn">
                              Export Excel
                           </button>
                     </div>
                  </div>
               </form>
               <div class="table-responsive" id="shipping-rates-container">                  
                  @include('backend.shipment-rate.partials.shipment-rate-list-2', ['shipping_rates' => $shipping_rates])
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('backend/assets/js/pages/inventory-shipping-rate.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}"></script>
<script>
   $(document).ready(function() {
      $('.select-multiple').select2();
   });
   $(document).ready(function() {
      let formSubmitted = false;      
      $('#exportShipmentRatesForm').on('submit', function(e) {
         let selectedValues = $('#weightCategorySelect').val();
         if (!selectedValues || selectedValues.length === 0) {
               e.preventDefault();
               Toastify({
                  text: "Please select at least one weight category",
                  duration: 3000,
                  gravity: "top",
                  position: "right",
                  className: "bg-warning"
               }).showToast();
               return false;
         }
         let submitBtn = $('#exportBtn');
         submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Exporting...');         
         formSubmitted = true;
         setTimeout(function() {
               if (formSubmitted) {
                  $('#weightCategorySelect').val(null).trigger('change');
                  submitBtn.prop('disabled', false).html('Export Excel');
                  formSubmitted = false;
                  Toastify({
                     text: "Export completed! Form reset.",
                     duration: 2000,
                     gravity: "top",
                     position: "right",
                     className: "bg-success"
                  }).showToast();
               }
         }, 2000);
      });
   });
   window.appConfig = {
      routes: {
         shipmentRateIndex: "{{ route('shipment-rate.index') }}",
         refreshSingle: "{{ url('shipment-rate') }}"
      },
      csrfToken: "{{ csrf_token() }}"
   };
</script>
<script src="{{ asset('backend/assets/js/pages/shipping-rate.js') }}?v={{ env('ASSET_VERSION', '1.0.0') }}"></script>
<script src="{{asset('backend/assets/js/rahul-jquery-ui.min.js')}}"></script><!--sortable jquery-->
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script>
@endpush