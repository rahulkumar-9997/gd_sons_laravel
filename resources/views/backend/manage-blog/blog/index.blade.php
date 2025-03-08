@extends('backend.layouts.master')
@section('title','Manage Blog')
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
               <h4 class="card-title flex-grow-1"> Blog List</h4>
               <a href="{{ route('manage-blog.create') }}" 
                  data-title="Add new Blog" 
                  data-bs-toggle="tooltip" 
                  title="Add new Blog" 
                  class="btn btn-sm btn-primary">
                  Add new Blog
               </a>
               
            </div>
            <div class="card-body">
               @if (isset($blogs) && $blogs->count() > 0)
                  <div class="table-responsive1">
                     <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                              <tr>
                                 <th>Sr. No.</th>
                                 <th>Name</th>
                                 <th>Category</th>
                                 <th style="width: 30%;">Blog Details</th>
                                 <th>Blog Img</th>
                                 <th>Paragraphs</th>
                                 <th>Action</th>
                              </tr>
                        </thead>
                        <tbody>
                              @php
                                 $sr_no = 1;
                              @endphp
                              @foreach($blogs as $blogs_row)
                                 <tr>
                                    <td>{{ $sr_no }}</td>
                                    <td>{{ $blogs_row->title }}</td>
                                    <td>{{ $blogs_row->category->title }}</td>
                                    <td>
                                       {!! $blogs_row->bog_description !!}
                                    </td>
                                    <td>
                                       <img src="{{ asset($blogs_row->blog_image) }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $blogs_row->title }}">
                                    </td>
                                    <td>
                                          <span class="badge bg-primary ms-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $blogs_row->title }}">
                                             {{ $blogs_row->paragraphs->count() }}
                                          </span>
                                    </td>
                                    <td>
                                          <div class="d-flex gap-2">
                                             <a href="{{ route('manage-blog.edit', $blogs_row->id) }}" class="btn btn-soft-primary btn-sm"
                                             data-bs-toggle="tooltip" data-bs-original-title="{{ $blogs_row->title }}">
                                                <i class="ti ti-pencil"></i>
                                             </a>
                                             <form method="POST" action="{{ route('manage-blog.destroy', $blogs_row->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" data-name="{{ $blogs_row->title }}" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"></i></button>
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