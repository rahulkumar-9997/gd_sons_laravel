@extends('backend.layouts.master')
@section('title','Manage Coupon')
@section('main-content')
@push('styles')

@endpush
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">All Coupons</h4>
               <a href="javascript:void(0)" data-ajax-coupon-add="true" data-size="lg" data-title="Add Coupon"
                  data-url="{{ route('manage-coupon.create') }}" data-bs-toggle="tooltip" title="Add Coupon"
                  class="btn btn-sm btn-primary">
                  Add Coupon
               </a>
            </div>
            <div class="card-body">
               <div class="coupon-list-table-render">
                  @include('backend.manage-coupon.partials.coupon-list', ['coupons' => $coupons])
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/components/form-flatepicker.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/manage-coupon.js')}}"></script>
@endpush