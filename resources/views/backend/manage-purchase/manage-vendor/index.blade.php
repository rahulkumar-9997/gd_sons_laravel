@extends('backend.layouts.master')
@section('title','Manage Vendor')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/>   
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">All Vendor List</h4>
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
                  @if (isset($data['vendor_list']) && $data['vendor_list']->count() > 0)
                    <div class="table-responsive" id="vendor-list-container">
                        @include('backend.manage-purchase.manage-vendor.partials.vendor_list_table', ['data' => $data])
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
<script src="{{asset('backend/assets/js/pages/vendor.js')}}"></script>
@endpush