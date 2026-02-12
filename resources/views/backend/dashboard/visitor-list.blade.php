@extends('backend.layouts.master')
@section('title','All visitor list')
@section('main-content')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/daterangepicker/daterangepicker.css')}}" />
@endpush

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
<script>
   $(document).on('change', '#selectAllVisitors', function() {
      $('.visitor-checkbox').prop(
         'checked',
         $(this).is(':checked')
      );
   });
   $(document).on('click', '#deleteSelectedVisitors', function() {
      let ids = [];
      $('.visitor-checkbox:checked').each(function() {
         ids.push($(this).val());
      });
     // alert(ids);
      if (ids.length === 0) {
         Swal.fire({
            icon: 'warning',
            title: 'No selection',
            text: 'Please select at least one visitor.'
         });
         return;
      }
      Swal.fire({
         title: 'Are you sure?',
         text: "Selected visitors will be deleted permanently!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes, delete',
         cancelButtonText: 'Cancel'
      }).then((result) => {
         if (!result.isConfirmed) {
            return;
         }
         $.ajax({
            url: "{{ route('visitors.bulk-delete') }}",
            type: "POST",
            data: {
               _token: "{{ csrf_token() }}",
               ids: ids
            },
            success: function(res) {
               if (res.success) {
                  $('#product-list-container').html(res.html);
                  Swal.fire({
                     icon: 'success',
                     title: 'Deleted!',
                     text: 'Selected visitors deleted successfully.',
                     timer: 2000,
                     showConfirmButton: false
                  });
               }
            },
            error: function() {
               Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Something went wrong. Please try again.'
               });
            }
         });
      });
   });
</script>

@endpush