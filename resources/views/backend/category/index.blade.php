@extends('backend.layouts.master')
@section('title','Manage Category')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/>   
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">All Category List</h4>
               <a href="javascript:void(0)" 
                  data-category-popup="true" 
                  data-size="lg" 
                  data-title="Add Category" 
                  data-url="{{ route('category.create') }}" 
                  data-bs-toggle="tooltip" 
                  title="Add Category" 
                  class="btn btn-sm btn-primary">
                  Add Category
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
               @if (isset($data['category_list']) && $data['category_list']->count() > 0)
                  <div class="table-responsive1">
                     <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                              <tr>
                                 <th>Sr. No.</th>
                                 <th>Name</th>
                                 <th>Attributes</th>
                                 <th>Image</th>
                                 <th>Trending</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                        </thead>
                        <tbody>
                              @php
                                 $sr_no = 1;
                              @endphp
                              @foreach($data['category_list'] as $category_list_row)
                                 <tr>
                                    <td>{{ $sr_no }}</td>
                                    <td>
                                       {{ $category_list_row->title }}
                                       <br><a href="{{ route('category.show', ['id' => $category_list_row->id]) }}" data-bs-toggle="tooltip" class="badge bg-indigo text-light border py-1 px-2" data-bs-original-title="Mapped attributes to display in front">
                                       Mapped attributes to display in front
                                       </a>
                                    </td>
                                    <td>
                                          @if ($category_list_row->attributes->isNotEmpty())
                                             @php
                                                /*Get mappings for this category*/
                                                $categoryMappings = collect($data['existing_mappings'])
                                                      ->where('category_id', $category_list_row->id)
                                                      ->pluck('attributes_id')
                                                      ->toArray();
                                             @endphp
                                             
                                             @foreach ($category_list_row->attributes as $attribute)
                                                @if (in_array($attribute->id, $categoryMappings))
                                                   <!-- Active Link for Mapped Attribute -->
                                                   <a 
                                                      data-title="Update HSN Code/GST in Percentage" 
                                                      data-bs-toggle="tooltip" 
                                                      title="This attribute is already mapped" 
                                                      href="{{ route('update-hsn-gst-with-attributes-value', ['attributes_id' => $attribute->id, 'category_id' => $category_list_row->id]) }}"
                                                   >
                                                      <span class="badge bg-success text-light border py-1 px-2">
                                                         {{ $attribute->title }} 
                                                         <iconify-icon icon="solar:check-circle-bold" class="ms-1"></iconify-icon>
                                                      </span>
                                                   </a>
                                                @elseif(empty($categoryMappings))
                                                   <!-- Active Link for Categories with No Mappings -->
                                                   <a 
                                                      data-title="Update HSN Code/GST in Percentage" 
                                                      data-bs-toggle="tooltip" 
                                                      title="Click to map this attribute" 
                                                      href="{{ route('update-hsn-gst-with-attributes-value', ['attributes_id' => $attribute->id, 'category_id' => $category_list_row->id]) }}"
                                                   >
                                                      <span class="badge bg-info-subtle text-muted border py-1 px-2">
                                                         {{ $attribute->title }}
                                                      </span>
                                                   </a>
                                                @else
                                                   <!-- Inactive Link -->
                                                   <span class="badge bg-dark border py-1 px-2" data-bs-toggle="tooltip" title="This attribute is not mapped">
                                                      {{ $attribute->title }}
                                                   </span>
                                                @endif
                                             @endforeach
                                          @else
                                             No attributes assigned.
                                          @endif
                                    </td>
                                    <td>
                                          @if(!empty($category_list_row->image))
                                             <img src="{{ asset('images/category/thumb/'. $category_list_row->image) }}" style="width: 50px;">
                                          @endif
                                    </td>
                                    <td>
                                          @if($category_list_row->trending == 'on')
                                             <span class="badge border border-success text-success px-2 py-1 fs-13">Yes</span>
                                          @else
                                             <span class="badge border border-danger text-danger px-2 py-1 fs-13">No</span>
                                          @endif
                                    </td>
                                    <td>
                                          @if($category_list_row->status == 'on')
                                             <span class="badge bg-success text-light px-2 py-1 fs-13">Active</span>
                                          @else
                                             <span class="badge bg-light text-dark px-2 py-1 fs-13">Inactive</span>
                                          @endif
                                    </td>
                                    <td>
                                          <div class="d-flex gap-2">
                                             <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm editCategory" data-catid="{{ $category_list_row->id }}" data-size="lg" data-title="Edit Category" data-bs-toggle="tooltip" data-url="{{ route('category.edit', $category_list_row->id) }}">
                                                <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
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
                  form.submit();
               }
         });
      });
           
   });
</script>
@endpush