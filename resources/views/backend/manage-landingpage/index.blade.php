@extends('backend.layouts.master')
@section('title','Manage Landing Page')
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
               <h4 class="card-title flex-grow-1">Landing Page List</h4>
               <a href="{{ route('manage-landing-page.create') }}"
                  data-title="Send Whatsapp Messages"
                  data-bs-toggle="tooltip"
                  title="Send Whatsapp Messages"
                  class="btn btn-sm btn-primary">
                  Create New Landing Page
               </a>

            </div>
            <div class="card-body">
               @if (isset($data['landing_page_list']) && $data['landing_page_list']->count() > 0)
               <div class="table-responsive1">
                  <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>URL</th>
                        
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                        $sr_no = 1;
                        @endphp
                        @foreach($data['landing_page_list'] as $landing_page_row)
                        <tr>
                           <td>{{ $sr_no }}</td>
                           <td>
                              {{ $landing_page_row->title }}
                           </td>
                           <td>
                              @if(!empty($landing_page_row->image_path))
                              <img src="{{ asset('landing-page/images/'. $landing_page_row->image_path) }}" style="width: 50px;">
                              @endif
                           </td>
                           <td>
                              {{ $landing_page_row->page_url }}
                           </td>                 
                           <td>
                              <div class="d-flex gap-2">
                                 <a href="{{ route('manage-landing-page.edit', $landing_page_row->id) }}" class="btn btn-soft-primary btn-sm" data-title="Edit {{ $landing_page_row->title }}" data-bs-toggle="tooltip">
                                    <i class="ti ti-pencil"></i>
                                 </a>
                                 <form method="POST" action="{{ route('manage-landing-page.destroy', $landing_page_row->id) }}" style="margin-left: 10px;">
                                    @csrf
                                    @method('DELETE')
                                       <a href="javascript:void(0);" title="Delete {{ $landing_page_row->title }}" data-name="{{ $landing_page_row->title }}" class="show_confirm btn btn-soft-danger btn-sm" data-title="Delete {{ $landing_page_row->title }}" data-bs-toggle="tooltip" >
                                       <i class="ti ti-trash"></i>
                                    </a>
                                 </form>
                                 
                              </div>
                           </td>
                        </tr>
                        @php
                        $sr_no++;
                        @endphp
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
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script>
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
@endpush