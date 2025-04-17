@extends('backend.layouts.master')
@section('title','Manage whatsapp')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Whatspp Messages List</h4>
               <a href="{{ route('manage-whatsapp.create') }}"
                  data-title="Send Whatsapp Messages"
                  data-bs-toggle="tooltip"
                  title="Send Whatsapp Messages"
                  class="btn btn-sm btn-primary">
                  Send Whatsapp Messages
               </a>


            </div>
            <div class="card-body">
               @if (isset($data['specialOffers']) && $data['specialOffers']->count() > 0)
               <div class="table-responsive1">
                  <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Phone No.</th>
                           <th style="width: 20%;">Product Title</th>
                           <th style="width: 25%;">Special Rate</th>
                           <th>Post Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $sr_no = 1; @endphp
                        @foreach($data['specialOffers'] as $specialOffers_row)
                        <tr>
                           <td>{{ $sr_no }}</td>
                           <td>{{ $specialOffers_row->customer->name ?? 'N/A' }}</td>
                           <td>{{ $specialOffers_row->customer->phone_number ?? 'N/A' }}</td>
                           <td>{{ $specialOffers_row->product->title ?? 'N/A' }}</td>
                           <td>
                              <span class="offer-rate-display">{{ $specialOffers_row->special_offer_rate }}</span>
                              <!-- Edit mode (hidden by default) -->
                              <div class="offer-rate-edit d-none">
                                 <input type="number"
                                    class="form-control form-control-sm offer-rate-input"
                                    value="{{ $specialOffers_row->special_offer_rate }}"
                                    data-id="{{ $specialOffers_row->id }}" />
                                 <button class="btn btn-sm btn-success btn-save-offer-rate mt-1">Save</button>
                                 <button class="btn btn-sm btn-secondary btn-cancel-offer-rate mt-1">Cancel</button>
                              </div>
                           </td>

                           <td>{{ \Carbon\Carbon::parse($specialOffers_row->created_at)->format('d-m-Y') }}</td>
                           <td>
                              <div class="d-flex gap-1">
                                 <!-- Edit Button -->
                                 <a href="javascript:void(0);"
                                    class="btn btn-soft-primary btn-sm btn-edit-offer-rate"
                                    data-editwhatappcon-popup="true"
                                    data-size="lg"
                                    data-title="Edit {{ $specialOffers_row->customer->name }}"
                                    data-bs-toggle="tooltip"
                                    data-url="{{ route('manage-whatsapp.edit', $specialOffers_row->id) }}">
                                    <i class="ti ti-pencil"></i>
                                 </a>

                                 <!-- Delete Form -->
                                 <form method="POST"
                                    action="{{ route('manage-whatsapp.destroy', $specialOffers_row->id) }}"
                                    style="margin-left: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0);"
                                       title="Delete {{ $specialOffers_row->customer->name }}"
                                       data-name="special offer {{ $specialOffers_row->customer->name }}"
                                       class="show_confirm btn btn-soft-danger btn-sm"
                                       data-title="Delete this special offer {{ $specialOffers_row->customer->name }}"
                                       data-bs-toggle="tooltip">
                                       <i class="ti ti-trash"></i>
                                    </a>
                                 </form>
                              </div>
                           </td>
                        </tr>
                        @php $sr_no++; @endphp
                        @endforeach
                     </tbody>

                  </table>
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

<script>
   $(document).ready(function() {
      $('.show_confirm').click(function(event) {
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
<script>
   $(document).ready(function() {
      $(document).on('click', '.btn-edit-offer-rate', function() {
         let $tr = $(this).closest('tr');
         $tr.find('.offer-rate-display').addClass('d-none');
         $tr.find('.offer-rate-edit').removeClass('d-none');
      });

      // On clicking "Cancel"
      $(document).on('click', '.btn-cancel-offer-rate', function() {
         let $tr = $(this).closest('tr');
         $tr.find('.offer-rate-edit').addClass('d-none');
         $tr.find('.offer-rate-input').val($tr.find('.offer-rate-display').text()); // Reset value
         $tr.find('.offer-rate-display').removeClass('d-none');
      });

      // On clicking "Save"
      $(document).on('click', '.btn-save-offer-rate', function() {
         let $btn = $(this);
         let $tr = $btn.closest('tr');
         let $input = $tr.find('.offer-rate-input');
         let newRate = $input.val();
         let id = $input.data('id');
         $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Saving...');

         $.ajax({
            url: '{{ route("manage-whatsapp.update", ":id") }}'.replace(':id', id),
            type: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               _method: 'PUT',
               special_offer_rate: newRate
            },
            success: function(response) {
               if (response.status === 'success') {
                  Toastify({
                     text: response.message,
                     duration: 10000,
                     gravity: "top",
                     position: "right",
                     className: "bg-success",
                     close: true,
                     onClick: function () { }
                  }).showToast();
               }
               $tr.find('.offer-rate-display').text(newRate).removeClass('d-none');
               $tr.find('.offer-rate-edit').addClass('d-none');
               
            },
            error: function() {
               alert('Something went wrong. Please try again.');
            },
            complete: function() {
               $btn.prop('disabled', false).html('Save');
            }
         });
      });
   });
</script>
@endpush