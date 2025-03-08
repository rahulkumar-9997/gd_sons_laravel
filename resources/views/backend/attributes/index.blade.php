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
               <h4 class="card-title flex-grow-1">All Attributes List</h4>
               <a href="{{route('attributesvalue-list')}}" 
                  data-title="Attribute Value List" 
                  data-bs-toggle="tooltip" 
                  title="Attribute Value List" 
                  class="btn btn-sm btn-secondary">
                  Attribute Value List
               </a>
               <a href="javascript:void(0)" 
                  data-attributes-popup="true" 
                  data-size="md" 
                  data-title="Add Attributes" 
                  data-url="{{ route('attributes.create') }}" 
                  data-bs-toggle="tooltip" 
                  title="Add Attributes" 
                  class="btn btn-sm btn-primary">
                  Add Attributes
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
            @if (isset($data['attributes_list']) && $data['attributes_list']->count() > 0)
               <div class="table-responsive1">
                  <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Attributes Value</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                           $sr_no = 1;
                        @endphp
                        @foreach($data['attributes_list'] as $attributes_list_row)
                           
                           <tr>
                              <td>
                                 {{ $sr_no }}
                              </td>
                              <td>
                                 {{ $attributes_list_row->title }}
                              </td>
                              <td>
                              @foreach($attributes_list_row->AttributesValues as $value)
                              <a href="{{route('product-catalog-attributes-value', $value->id)}}">
                                 <span class="mb-1 mt-1 badge bg-light-subtle text-muted border py-1 px-1"  data-bs-toggle="tooltip" data-bs-original-title="{{ $value->name }} ">
                                    {{ $value->name }} 
                                    <span class="badge bg-primary ms-1" data-bs-toggle="tooltip" data-bs-original-title="Total Products on This Attributes Value">   {{$value->product_attributes_values_count}}
                                    </span>
                                 </span>
                              </a>
                              @endforeach
                              <a href="{{ route('attributes-option', $attributes_list_row->id) }}">
                                 <span class="badge bg-success text-white py-1 px-2">Configure Values</span>
                              </a>
                              </td>
                              <td>
                                 <div class="d-flex gap-2">
                                    <!--<a href="#!" class="btn btn-light btn-sm">
                                       <iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon>
                                    </a>-->
                                    <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm editAttributes" data-attriid="{{ $attributes_list_row->id }}"  data-size="md" data-title="Edit Attributes" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Edit Attributes" data-url="{{ route('attributes.edit', $attributes_list_row->id) }}">
                                       <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                    </a>
                                    <!--<form method="POST" action="{{ route('label.delete', $attributes_list_row->id) }}" style="margin-left: 10px;">
                                          @csrf
                                          <input name="_method" type="hidden" value="DELETE">
                                             <a href="#" title="Delete Label" data-name="{{ $attributes_list_row->title }}" class="show_confirm btn btn-soft-danger btn-sm" data-title="Delete Label" data-bs-toggle="tooltip" >
                                             <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                          </a>
                                    </form>-->
                                    
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