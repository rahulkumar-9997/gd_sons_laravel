@extends('backend.layouts.master')
@section('title','Shipping Rates List')
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
                  All Shipping Rates List
               </h4>
            </div>
            <div class="card-body">
               @if (isset($shipping_rates) && $shipping_rates->count() > 0)
               <div class="table-responsive" id="shipping-rates-container">
                  @include('backend.shipment-rate.partials.shipment-rate-list', ['shipping_rates' => $shipping_rates])
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
<script src="{{ asset('backend/assets/js/pages/shipping-rate.js') }}"></script>
<script>
    window.appConfig = {
        routes: {
            shipmentRateIndex: "{{ route('shipment-rate.index') }}",
            refreshSingle: "{{ url('shipment-rate') }}"
        },
        csrfToken: "{{ csrf_token() }}"
    };
</script>
@endpush