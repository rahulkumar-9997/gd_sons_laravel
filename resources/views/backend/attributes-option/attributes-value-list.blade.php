@extends('backend.layouts.master')
@section('title','Manage Attributes')
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
                <h4 class="card-title flex-grow-1">
                    Attributes Value List
                    <a href="{{route('attributes')}}" data-title="Go Back to Attributes"     data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title="Go Back to Attributes">
                    << Go Back to Attributes
                </a>
                </h4>
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
            @if (isset($data['attributesvalue_list']) && $data['attributesvalue_list']->count() > 0)
               <div class="table-responsive1">
                  <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                           $sr_no = 1;
                        @endphp
                        @foreach($data['attributesvalue_list'] as $attributes_value)
                           
                           <tr>
                              <td>
                                 {{ $sr_no }}
                              </td>
                              <td>
                                 {{ $attributes_value->name }}
                                 @if ($attributes_value->is_mapped_in_category && $attributes_value->is_mapped_in_product)
                                        <p>This attribute value is used in both Category and Product mappings.</p>
                                    @elseif ($attributes_value->is_mapped_in_category)
                                        <p>This attribute value is mapped in Category only.</p>
                                    @elseif ($attributes_value->is_mapped_in_product)
                                        <p>This attribute value is mapped in Product only.</p>
                                    @else
                                        <p>This attribute value is not mapped in Category or Product.</p>
                                    @endif
                              </td>
                              
                              <td>
                                 <div class="d-flex gap-2">
                                    <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm editAttributes" data-attriid="{{ $attributes_value->id }}"  data-size="md" data-title="Edit Attributes" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Edit Attributes" data-url="{{ route('attributes.edit', $attributes_value->id) }}">
                                       <i class="ti ti-pencil"></i>
                                    </a>
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