@extends('backend.layouts.master')
@section('title','Manage Item')
@section('main-content')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/daterangepicker/daterangepicker.css')}}" />
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <!--Filter section-->
         <div id="example-2_wrapper" class="filter-box">
            <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1 client-list-filter">
               <div class="d-flex align-items-center border-end pe-1">
                  <p class="mb-0 me-2 text-dark-grey f-14">Duration:</p>
                  <input type="text" class="form-control form-control-sm text-dark border-0 f-14" id="bill_daterange" name="bill_daterange" placeholder="Start Date To End Date" autocomplete="off">
               </div>

               <!-- Category Filter -->
               <div class="d-flex align-items-center border-end pe-1">
                  <p class="mb-0 me-2 text-dark-grey f-14">Vendor Name:</p>
                  <select class="vendor_list_filter form-select-md js-example-basic-single" id="vendor_list_filter" name="vendor_list_filter" style="width: 250px;">
                     <option value="">All Vendor</option>
                        @foreach($data['vendor_list'] as $vendor_list_row)
                           <option value="{{ $vendor_list_row->id }}">
                              {{ $vendor_list_row->vendor_name }} ::
                              {{ $vendor_list_row->location }}
                           </option>
                        @endforeach
                  </select>
               </div>
               <button id="reset-filters-btn" class="btn btn-danger" style="display: none;">
                  <svg class="svg-inline--fa fa-times-circle fa-w-16 mr-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                  Reset Filters
               </button>
            </div>
         </div>
         <!--Filter section-->
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Purchase List</h4>
               <a href="{{route('manage-item.create')}}" 
                  data-title="Create new Purchase" 
                  data-url="{{ route('manage-vendor.create') }}" 
                  data-bs-toggle="tooltip" 
                  title="Create new Purchase" 
                  class="btn btn-sm btn-primary">
                  Create new Purchase
               </a>
            </div>
            <div class="card-body">
               @if (isset($vendor_purchase_bills) && $vendor_purchase_bills->count() > 0)
                  <div class="table-responsive" id="vendor_purchase_list">
                     @include('backend.manage-purchase.manage-item.partials.vendor_purchase_list_table', ['vendor_purchase_bills' => $vendor_purchase_bills])
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
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script> 
<script>
   $(document).ready(function () {
      $('#vendor_list_filter').select2();
      /** DATE RANGE PICKER */
      $('#bill_daterange').daterangepicker({
         opens: 'right',
         ranges: {
               'Today': [moment(), moment()],
               'Last 15 Days': [moment().subtract(15, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'Last 60 Days': [moment().subtract(59, 'days'), moment()],
               'Last 90 Days': [moment().subtract(89, 'days'), moment()],
               'Last 6 Months': [moment().subtract(6, 'months'), moment()],
               'Last 1 Year': [moment().subtract(1, 'year'), moment()],
         },
         autoUpdateInput: false,
         locale: {
               format: 'YYYY-MM-DD',
               cancelLabel: 'Clear',
         }
      });

      $('#bill_daterange').on('apply.daterangepicker', function (ev, picker) {
         $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
         updateFilters();
         showResetButton();
      });
      $('#bill_daterange').on('cancel.daterangepicker', function (ev, picker) {
         $(this).val('');
         updateFilters();
         hideResetButton(); // Hide the reset button if the filter is cleared
      });
      /** DATE RANGE PICKER */
      var $deleteForm = $('#delete-multiple-bills-form');
      var $deleteButton = $('#confirm-delete-btn');
      function handleDeleteClick() {
         var selectedBills = $('input.select-bill:checked').length;
         if (selectedBills > 0) {
               Swal.fire({
                  title: 'Are you sure you want to delete these purchase list?',
                  text: "If you delete these, they will be gone forever.",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonText: "Yes, delete them!",
                  cancelButtonText: "Cancel",
                  dangerMode: true,
               }).then(function (result) {
                  if (result.isConfirmed) {
                     $deleteForm.submit();
                  }
               });
         } else {
               Swal.fire({
                  title: 'No bills selected!',
                  text: 'Please select at least one bill to delete.',
                  icon: 'info',
                  confirmButtonText: 'OK',
               });
         }
      }
      $('body').on('click', '#confirm-delete-btn', function () {
         handleDeleteClick();
      });
      function bindCheckboxEvents() {
         /* Select/Deselect all bills */
         $('body').on('change', '#select-all-bills', function () {
               var isChecked = $(this).is(':checked');
               $('input.select-bill').prop('checked', isChecked);
         });
         /* Uncheck "Select All" if any checkbox is unchecked */
         $('body').on('change', 'input.select-bill', function () {
               if (!$('input.select-bill:checked').length) {
                  $('#select-all-bills').prop('checked', false);
               }
         });
      }
      function updateFilters(page = 1) {
         var vendorId = $('#vendor_list_filter').val();
         var billDateRange = $('#bill_daterange').val();
         $.ajax({
               url: "{{ route('manage-item.index') }}",
               type: "GET",
               data: {
                  vendor_id: vendorId,
                  bill_daterange: billDateRange,
                  page: page
               },
               beforeSend: function () {
                  $('#loader').fadeIn();
               },
               success: function (response) {
                  $('#vendor_purchase_list').html(response.html);
                  bindCheckboxEvents();
               },
               error: function (xhr) {
                  console.error('Error:', xhr.responseText);
               },
               complete: function () {
                  $('#loader').fadeOut();
               }
         });
      }
      /* Handle pagination click */
      $(document).on('click', '.pagination a', function (e) {
         e.preventDefault();
         const page = $(this).attr('href').split('page=')[1];
         updateFilters(page);
      });
      /* Event listener for the vendor list filter change */
      $('#vendor_list_filter').on('change', function () {
         updateFilters();
         showResetButton();
      });
      /*Show reset button if filters are applied*/
      function showResetButton() {
         $('#reset-filters-btn').show();
      }
      /*Hide reset button if no filters are applied*/
      function hideResetButton() {
         var vendorId = $('#vendor_list_filter').val();
         var billDateRange = $('#bill_daterange').val();
         if (!vendorId && !billDateRange) {
               $('#reset-filters-btn').hide();
         }
      }
      /*Reset filters and reload data*/
      $('body').on('click', '#reset-filters-btn', function () {
         $('#vendor_list_filter').val('').trigger('change'); 
         $('#bill_daterange').val('').trigger('cancel.daterangepicker');
         updateFilters(); 
         hideResetButton();
      });
      /*Call bindCheckboxEvents initially*/
      bindCheckboxEvents();
      hideResetButton();
   });
</script>
@endpush