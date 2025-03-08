@extends('backend.layouts.master')
@section('title','Social Media Track List')
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
               <h4 class="card-title flex-grow-1">Social Media Track List</h4>
            </div>
            <div class="card-body">
               @if (isset($data['social_media_track_list']) && $data['social_media_track_list']->count() > 0)
                  <div class="table-responsive1">
                     <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                              <tr>
                                 <th>Source</th>
                                 <th>Method</th>
                                 <th>Identity</th>
                                 <th>IP Address</th>
                                 <th>Browser</th>
                                 <th>Page Name</th>
                                 <th>Location</th>
                              </tr>
                        </thead>
                        <tbody>
                            @php
                                $sr_no = 1;
                            @endphp
                            @foreach($data['social_media_track_list'] as $social_media_track_row)
                                <tr>
                                    
                                    <td>{{ $social_media_track_row->source ?? 'N/A' }}</td>
                                    <td>{{ $social_media_track_row->method ?? 'N/A' }}</td>
                                    <td>{{ $social_media_track_row->identity ?? 'N/A' }}</td>
                                    <td>{{ $social_media_track_row->ip_address }}</td>
                                    <td>{{ $social_media_track_row->browser }}</td>
                                    <td>{{ $social_media_track_row->page_name }}</td>
                                    <td>
                                        @if(!empty($social_media_track_row->location))
                                            <pre>{{ json_encode(json_decode($social_media_track_row->location), JSON_PRETTY_PRINT) }}</pre>
                                        @else
                                            N/A
                                        @endif
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