@extends('backend.layouts.master')
@section('title','Customer List')
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
                  All Customer List
               </h4>
               <a href="javascript:void(0)" data-addCustomer-popup="true" data-size="lg" data-title=" Add new Customer" data-url="{{route('manage-customer.add')}}" data-bs-toggle="tooltip" class="btn btn-sm btn-purple" data-bs-original-title=" Add new Customer">
                  Add new Customer
               </a>
               <a href="{{route('customer.importForm')}}" data-title="Import Customer" data-bs-toggle="tooltip" class="btn btn-sm btn-info" data-bs-original-title="Import Customer">
                  Import Customer
               </a>
               <!-- <a href="{{route('customer.importForm')}}" 
                  data-title="Add New Customer" 
                  data-bs-toggle="tooltip" 
                  title="Add New Customer" 
                  class="btn btn-sm btn-success">
                  Add New Customer
               </a> -->


            </div>
            <div class="card-body">
               @if (isset($data['customer_list']) && $data['customer_list']->count() > 0)

               <div class="table-responsive" id="customer-list-container">
                  @include('backend.manage-customer.partials.customer-list', ['data' => $data])
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
<script src="{{asset('backend/assets/js/pages/customer.js')}}" type="text/javascript"></script>
<script>
    var routes = {
        customerIndex: "{{ route('manage-customer') }}",
    };
    var csrfToken = "{{ csrf_token() }}";
</script>
@endpush