@extends('backend.layouts.master')
@section('title','Manage Offer Popup')
@section('main-content')
@push('styles')

@endpush
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">All Offer Popup</h4>
               <a href="{{ route('offer-popups.create') }}" title="Add Coupon"
                  class="btn btn-sm btn-primary">
                  Add Offer Popup
               </a>
            </div>
            <div class="card-body">
               <div class="coupon-list-table-render">
                  @include('backend.offer-popups.partials.offer-list', ['popups' => $popups])
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script>
   $('.status-toggle').on('change', function () {
      const checkbox = $(this);
      const url = checkbox.data('url');
      checkbox.prop('disabled', true);
      $.ajax({
         url: url,
         method: 'PATCH',
         headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         dataType: 'json',
         success: function (data) {
               checkbox.prop('checked', data.is_active);
               checkbox.closest('.form-check').find('.status-text').text(data.is_active ? 'Active' : 'Inactive');
               Toastify({
                  text: data.message,
                  duration: 10000,
                  gravity: "top",
                  position: "right",
                  className: "bg-success",
                  escapeMarkup: false,
                  close: true,
                  onClick: function () { }
               }).showToast();
         },
         error: function (jqXHR) {
               checkbox.prop('checked', !checkbox.prop('checked'));
               Toastify({
                  text: jqXHR.responseJSON?.message || 'Could not update status. Please try again.',
                  duration: 10000,
                  gravity: "top",
                  position: "right",
                  className: "bg-danger",
                  escapeMarkup: false,
                  close: true,
                  onClick: function () { }
               }).showToast();
         },
         complete: function () {
            checkbox.prop('disabled', false);
         }
      });
   });
   $(document).on('click', '.show_confirm_offer', function (event) {
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
</script>
@endpush