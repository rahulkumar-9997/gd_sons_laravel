@extends('backend.layouts.master')
@section('title','Manage Label')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>   
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">All Label List</h4>
               <a href="javascript:void(0)" 
                  data-label-popup="true" 
                  data-size="md" 
                  data-title="Add Label" 
                  data-url="{{ route('label.create') }}" 
                  data-bs-toggle="tooltip" 
                  title="Add Label" 
                  class="btn btn-sm btn-primary">
                  Add Label
               </a>
               <div class="dropdown">
                  <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                  This Month
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                     <!-- item-->
                     <a href="#!" class="dropdown-item">Download</a>
                     <!-- item-->
                     <a href="#!" class="dropdown-item">Export</a>
                     <!-- item-->
                     <a href="#!" class="dropdown-item">Import</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
            @if (isset($data['label_list']) && $data['label_list']->count() > 0)
               <div class="table-responsive1">
                  <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Slug</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                           $sr_no = 1;
                        @endphp
                        @foreach($data['label_list'] as $label_list_row)
                           
                           <tr>
                              <td>
                                 {{ $sr_no }}
                              </td>
                              <td>
                                 {{ $label_list_row->title }}
                                 <br>
                                 <a href="{{ route('label-product', ['labelId' => $label_list_row->id]) }}" title="View {{ $label_list_row->title }}" data-bs-toggle="tooltip" >
                                    <span class="badge bg-danger-subtle text-black py-1 px-2">
                                       View {{ $label_list_row->title }}
                                    </span>
                                 </a>
                              </td>
                              <td>
                                 {{ $label_list_row->slug }}
                              </td>
                              
                              <td>
                                 @if(!empty($label_list_row->status=='on'))
                                    <div class="form-check form-switch">
                                       <input class="form-check-input statusonoff" data-bid="{{ $label_list_row->id }}" type="checkbox" role="switch" checked="">
                                    </div>
                                 @else
                                    <div class="form-check form-switch">
                                       <input class="form-check-input statusonoff" data-bid="{{ $label_list_row->id }}" type="checkbox" role="switch">
                                    </div>
                                 @endif
                              </td>
                              
                              <td>
                                 <div class="d-flex gap-2">
                                    <!--<a href="#!" class="btn btn-light btn-sm">
                                       <iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon>
                                    </a>-->
                                    <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm editLabel" data-lid="{{ $label_list_row->id }}" data-ajax-popup="true" data-size="md" data-title="Edit Label" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Edit Label" data-url="{{ route('label.edit', $label_list_row->id) }}">
                                       <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('label.delete', $label_list_row->id) }}" style="margin-left: 10px;">
                                          @csrf
                                          <input name="_method" type="hidden" value="DELETE">
                                             <a href="#" title="Delete Label" data-name="{{ $label_list_row->title }}" class="show_confirm btn btn-soft-danger btn-sm" adta-title="Delete Label" data-bs-toggle="tooltip" >
                                             <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
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
               <!-- end table-responsive -->
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
         var form = $(this).closest("form");  // Assuming there's a form related to this button
         var name = $(this).data("name");     // You can use this data attribute if needed
         event.preventDefault();              // Prevent default button action

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
                  form.submit();  // Submit the form if confirmed
               }
         });
      });
   });
</script>
@endpush