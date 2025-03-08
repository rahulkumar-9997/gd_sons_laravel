@extends('backend.layouts.master')
@section('title','All visitor list')
@section('main-content')
@push('styles')
<!-- <link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>    -->
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/daterangepicker/daterangepicker.css')}}" />
@endpush
<!-- Start Container Fluid -->
 
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">
                  All Visitor List
                </h4>
                <!-- <a href="{{route('product-multiple-update')}}" 
                    data-title="Product Multiple Update" 
                    data-bs-toggle="tooltip" 
                    title="Product Multiple Update" 
                    class="btn btn-sm btn-info">
                    Product Multiple Update
                </a> -->
            </div>
            <div class="card-body">
               @if (isset($data['visitor_list']) && $data['visitor_list']->count() > 0)
                  <div class="table-responsive" id="product-list-container">
                     @include('backend.dashboard.partials.ajax-visitor-list', ['data' => $data])
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
<script type="text/javascript" src="{{asset('backend/assets/js/daterangepicker/daterangepicker.min.js')}}"></script>

@endpush