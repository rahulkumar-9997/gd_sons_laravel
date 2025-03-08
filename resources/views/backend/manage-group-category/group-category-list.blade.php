@extends('backend.layouts.master')
@section('title','Group Category List')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">

         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">
                  Group Category List
               </h4>

               <a href="javascript:void(0)" data-addgroupcategory-popup="true" data-size="lg" data-title="Add new Group Category" data-url="{{route('add-new-group-category')}}" data-bs-toggle="tooltip" class="btn btn-sm btn-info" data-bs-original-title="Add new Group Category">
                  Add new Group Category
               </a>
            </div>
            <div class="card-body">
               <div class="group-category-list">
                  @include('backend.manage-group-category.partials.ajax-group-category-list', ['data' => $data])
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
<script src="{{asset('backend/assets/js/pages/group-category.js')}}" type="text/javascript"></script>
<script>
   $(document).ready(function() {
      $('.show_confirm_group_category').click(function(event) {
         var form = $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();

         Swal.fire({
               title: `Are you sure you want to delete this ${name}?`,
               text: "If you delete this, it will be gone forever.",
               icon: "warning",
               showCancelButton: true,
               confirmButtonText: "Yes, delete it!",
               cancelButtonText: "Cancel",
               dangerMode: true,
         }).then((result) => {
               if (result.isConfirmed) {
                  form.submit();
               }
         });
      });
   });
</script>
@endpush