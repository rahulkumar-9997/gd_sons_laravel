@extends('backend.layouts.master')
@section('title','Manage Attributes Options')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-8 col-lg-8">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">
                    Manage ({{ $attributes->title }})
                    <a href="{{ route('attributes') }}" 
                        data-title="Go Back to Attributes"  
                        data-bs-toggle="tooltip" 
                        title="Go Back to Attributes" 
                        class="btn btn-sm btn-danger" >
                       << Go Back to Attributes
                    </a>
                    <!--<a href="javascript:void(0)" 
                        data-attributes-popup="true" 
                        data-size="md" 
                        data-title="Add Attributes" 
                        data-url="{{ route('attributes.create') }}" 
                        data-bs-toggle="tooltip" 
                        title="Add Attributes" 
                        class="btn btn-sm btn-primary pull-right" style="float: right;">
                    Add Attributes
                    </a>-->
               </h4>
            </div>
            <div class="card-body">
                <div class="tab-pane fade show   active " role="tabpanel">
                    <ul class="list-unstyled list-group sortable stage ui-sortable" id="sortable">
                        @foreach($attributes->AttributesValues as $value)
                        <li class="d-flex align-items-center justify-content-between list-group-item ui-sortable-handle" data-id="{{ $value->id }}" style="position: relative; left: 0px; top: 0px;">
                            <h6 class="mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move me-3 ti ti-arrows-maximize ">
                                <polyline points="5 9 2 12 5 15"></polyline>
                                <polyline points="9 5 12 2 15 5"></polyline>
                                <polyline points="15 19 12 22 9 19"></polyline>
                                <polyline points="19 9 22 12 19 15"></polyline>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <line x1="12" y1="2" x2="12" y2="22"></line>
                                </svg>
                                <span>
                                    {{ $value->name }},                 
                                </span>
                                @if($value->map_attributes_value_to_categories->isNotEmpty())
                                    <span>
                                        <strong> Mapped Category :</strong>
                                    </span>
                                    {{ $value->map_attributes_value_to_categories->pluck('title')->implode(', ') }}
                                @else
                                    <span class="text-danger">This Attributes Value no mapped any Category, Please Edit & Mapped.</span>
                                @endif
                            </h6>
                            <span class="float-end">
                                <button class="btn btn-sm btn-warning mergeAttributesValue" data-url="{{ route('merge-attributes-value') }}" data-size="lg" data-attriid="{{ $attributes->id }}" data-attrivalid="{{ $value->id }}" data-title="Merge this ({{ $value->name }}) Attribute Value" data-bs-toggle="tooltip" title="Merge this Attribute Value">
                                    <i class="ti ti-arrow-merge"></i>
                                </button>
                                <button class="btn btn-sm btn-info editAttValue" data-url="{{ route('attributes-value.edit', $value->id) }}" data-size="md"   data-attrivid="{{$value->id}}" data-title="Edit Attribute Option" data-bs-toggle="tooltip" title="Edit Attribute Option">
                                <i class="ti ti-pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('attributes-value.delete', $value->id) }}" accept-charset="UTF-8" class="d-inline">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="button" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip"  data-name="{{ $value->name }}" title="Delete">
                                    <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-lg-4">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">Add Attributes Value ({{ $attributes->title }})</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('attributes-value.store')}}" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <input type="hidden" name="attributes_id" value="{{ request()->route('attributes') }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Attributes Value Name</label>
                                <input type="text" id="name" name="name" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-2">
                                <label for="name" class="form-label">Select Category (Multiple)</label>
                                <select class="js-example-basic-multiple" name="category[]" id="category" multiple="multiple">
                                    <optio value="" disabled selected>Select Category</optio>
                                    @foreach($category_list as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div> 
                    </div>
                </form>
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

<script src="{{asset('backend/assets/js/rahul-jquery-ui.min.js')}}"></script><!--sortable jquery-->
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script> 
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
$(function() {
    $('#sortable').sortable({
        placeholder: "ui-sortable-placeholder",
        update: function(event, ui) {
            var sortedIDs = $(this).sortable('toArray', {attribute: 'data-id'});
            $.ajax({
                url: '{{ route("attribute-values.sort") }}', // Change to your route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sortedIDs: sortedIDs
                },
                success: function(response) {
                    if (response.success) {
                        Toastify({
                            text: response.message, 
                            duration: 10000,
                            gravity: "bottom",
                            position: "right", 
                            className: "bg-success",
                            close: true, 
                            onClick: function() { }
                        }).showToast();
                        console.log('Status updated successfully: ', response.success);
                    
                    } else {
                        alert('Failed to update sort order.');
                    }
                },
                error: function() {
                    alert('Error updating sort order.');
                }
            });
        }
    });
});
</script>

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
                    form.submit();  // Submit the form if confirmed
                }
            });
        });
        /*Merge Attributes Value*/
        $(document).on('click', '.mergeAttributesValue', function () {
            var attributes_id = $(this).data('attriid');
            var attributes_value_id = $(this).data('attrivalid');
            
            var title = $(this).data('title');
            var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
            var url = $(this).data('url');
            
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                attributes_id: attributes_id,
                merge_from_attributes_value_id: attributes_value_id,
            };
            $("#commanModel .modal-title").html(title);
            $("#commanModel .modal-dialog").addClass('modal-' + size);
            
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    $('#commanModel .render-data').html(data.form);
                    $("#commanModel").modal('show');
                },
                error: function (data) {
                    data = data.responseJSON;
                }
            });
        });
        /*Merge Attributes Value*/
   });
</script>
@endpush