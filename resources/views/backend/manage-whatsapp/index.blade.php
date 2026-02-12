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
                  <table id="whattapp_list" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Phone No.</th>
                           <th style="width: 20%;">Product Title</th>
                           <th style="width: 10%;">Special Rate</th>
                           <th>Post Date</th>
                           <th>WhatsApp Message</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $sr_no = 1; @endphp
                        @foreach($data['specialOffers'] as $specialOffers_row)
                        @php
                        $product = $specialOffers_row->product;
                        $firstImage = $product->images->first() ?? null;
                        $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
                        $imageName = 'Girdhar Das & Sons';

                        if ($firstImage && !empty($firstImage->image_path)) {
                        $imageFileName = str_replace('.webp', '.jpg', $firstImage->image_path);
                        $imagePathJpg = asset('images/product/jpg-image/thumb/' . $imageFileName);

                        if (!file_exists(public_path('images/product/jpg-image/thumb/' . $imageFileName))) {
                        $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
                        }
                        $imageName = basename($firstImage->image_path);
                        }
                      
                        $whatsappMessage = "*Item : " . ($product->title ?? 'N/A') . "*\n";
                        $whatsappMessage .= "MRP : ~" . ($product->mrp ?? 0) . "~\n";
                        $whatsappMessage .= "Offer Price : *" . $specialOffers_row->special_offer_rate . "*\n\n";
                        $whatsappMessage .= "Check the Product in the Link given below:\n";
                        $whatsappMessage .= "*".$specialOffers_row->url."*";
                        @endphp
                        <tr>
                           <td>{{ $sr_no }}</td>
                           <td>{{ $specialOffers_row->customer->name ?? 'N/A' }}</td>
                           <td>{{ $specialOffers_row->customer->phone_number ?? 'N/A' }}</td>
                           <td>{{ $product->title ?? 'N/A' }}</td>
                           <td>
                              <span class="offer-rate-display">{{ $specialOffers_row->special_offer_rate }}</span>
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
                              <div class="whatsapp-message-container">
                                 <div class="whatsapp-message-preview mb-2 p-2 bg-light rounded">
                                    @if($firstImage)
                                    <img src="{{ $imagePathJpg }}" alt="{{ $product->title }}" style="max-width: 80px; max-height: 80px;" class="mb-2"><br>
                                    @endif
                                    <strong>Item Name:</strong> {{ $product->title ?? 'N/A' }}<br>
                                    <strong>MRP:</strong> ₹{{ $product->mrp ?? 0 }}<br>
                                    <strong>Offer Price:</strong> ₹{{ $specialOffers_row->special_offer_rate }}<br><br>
                                    <strong>Check the Product in the Link given below:</strong><br>
                                    <a href="{{ $specialOffers_row->url }}" target="_blank">{{ $specialOffers_row->url }}</a>
                                 </div>
                                 <button class="btn btn-sm btn-success btn-copy-message w-100"
                                    data-message="{{ $whatsappMessage }}"
                                    data-image="{{ $imagePathJpg }}">
                                    <i class="ti ti-copy"></i> Copy Message
                                 </button>
                              </div>
                           </td>
                           <td>
                              <div class="d-flex gap-1">
                                 <a href="javascript:void(0);"
                                    class="btn btn-soft-primary btn-sm btn-edit-offer-rate"
                                    data-editwhatappcon-popup="true"
                                    data-size="lg"
                                    data-title="Edit {{ $specialOffers_row->customer->name }}"
                                    data-bs-toggle="tooltip"
                                    data-url="{{ route('manage-whatsapp.edit', $specialOffers_row->id) }}">
                                    <i class="ti ti-pencil"></i>
                                 </a>
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
               <div class="my-pagination" id="pagination-links-whatsapp">
                     {{ $data['specialOffers']->links('vendor.pagination.bootstrap-4') }}
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
                     onClick: function() {}
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
<script>
   document.addEventListener('DOMContentLoaded', function() {
      const copyButtons = document.querySelectorAll('.btn-copy-message');
      copyButtons.forEach(button => {
         button.addEventListener('click', function() {
            const message = this.getAttribute('data-message');
            const textarea = document.createElement('textarea');
            textarea.value = message;
            document.body.appendChild(textarea);
            textarea.select();
            try {
               document.execCommand('copy');
               const originalHtml = this.innerHTML;
               this.innerHTML = '<i class="ti ti-check"></i> Copied!';
               this.classList.remove('btn-success');
               this.classList.add('btn-primary');

               setTimeout(() => {
                  this.innerHTML = originalHtml;
                  this.classList.remove('btn-primary');
                  this.classList.add('btn-success');
               }, 2000);
            } catch (err) {
               console.error('Failed to copy message: ', err);
               alert('Failed to copy message. Please try again.');
            }

            document.body.removeChild(textarea);
         });
      });
   });
</script>

@endpush