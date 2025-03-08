@extends('backend.layouts.master')
@section('title','Manage Blog Category')
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
               <h4 class="card-title flex-grow-1">Blog Category List</h4>
               <a href="javascript:void(0)" 
                  data-blog-category-popup="true" 
                  data-size="lg" 
                  data-title="Add Blog Category" 
                  data-url="{{ route('manage-blog-category.create') }}" 
                  data-bs-toggle="tooltip" 
                  title="Add Blog Category" 
                  class="btn btn-sm btn-primary">
                  Add Blog Category
               </a>
               
            </div>
            <div class="card-body">
               @if (isset($blog_category) && $blog_category->count() > 0)
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
                              @foreach($blog_category as $blog_category_row)
                                 <tr>
                                    <td>{{ $sr_no }}</td>
                                    <td>{{ $blog_category_row->title }}</td>
                                    <td>
                                          <div class="d-flex gap-2">
                                             <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm" data-blogcatid="{{ $blog_category_row->id }}" data-size="lg" data-title="Edit Blog Category" 
                                             data-edit-blog-category-popup="true" 
                                             data-bs-toggle="tooltip" data-url="{{ route('manage-blog-category.edit', $blog_category_row->id) }}">
                                                <i class="ti ti-pencil"></i>
                                             </a>
                                             <form method="POST" action="{{ route('manage-blog-category.destroy', $blog_category_row->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" data-name="{{ $blog_category_row->title }}" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"></i></button>
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

<script src="{{asset('backend/assets/js/pages/blog-category.js')}}" type="text/javascript"></script> 
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