@extends('backend.layouts.master')
@section('title','Manage Products')
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
                    {{ $data['product_details']->title }}
                    <a href="{{ route('product.edit', $data['product_details']->id) }}" class="btn btn-soft-success btn-sm">
                        Edit Product
                    </a>
                </h4>
               <a href="{{route('product.excel.import')}}" 
                  data-title="Import Product" 
                  data-bs-toggle="tooltip" 
                  title="Import Product" 
                  class="btn btn-sm btn-warning">
                  Import Product
               </a>
               <a href="{{route('product.create')}}" 
                  data-title="Add Product" 
                  data-bs-toggle="tooltip" 
                  title="Add Product" 
                  class="btn btn-sm btn-success">
                  Add Product
               </a>
               
            </div>
            <div class="card-body">
                <div class="table-responsive1">
                    <table class="table align-middle mb-0 table-hover table-centered">
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $data['product_details']->title }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $data['product_details']->category->title ?? 'No Category' }}</td>
                        </tr>
                        <tr>
                            <th>Product Price</th>
                            <td>{{ $data['product_details']->product_price }}</td>
                        </tr>
                        <tr>
                            <th>Product Sale Price</th>
                            <td>{{ $data['product_details']->product_sale_price }}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{ $data['product_details']->brand->title ?? 'No Brand' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($data['product_details']->product_status === 1)
                                    <span class="badge bg-success text-light  px-2 py-1 fs-10">Active</span>
                                @else
                                <span class="badge bg-primary text-light  px-2 py-1 fs-10">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Warranty Status</th>
                            <td>
                                @if($data['product_details']->warranty_status === 1)
                                    <span class="badge bg-success text-light  px-2 py-1 fs-10">In Warranty</span>
                                @else
                                <span class="badge bg-primary text-light  px-2 py-1 fs-10">No Warranty</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Product Tags</th>
                            <td>
                                <span class="badge bg-warning-subtle text-muted border py-1 px-2">{{$data['product_details']->product_tags}}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Attributes Show Status</th>
                            <td>
                                @if($data['product_details']->attributes_show_status === 1)
                                    <span class="badge bg-success text-light  px-2 py-1 fs-10">Show Attributes</span>
                                @else
                                <span class="badge bg-primary text-light  px-2 py-1 fs-10">Not Showing</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Images</th>
                            <td>
                                <div class="tab-pane fade show active" role="tabpanel">
                                    <ul class="list-unstyled list-group sortable stage ui-sortable" id="sortable_product_image">
                                        @if($data['product_details']->images->isNotEmpty())
                                            @foreach($data['product_details']->images as $image)
                                                <li class="d-flex align-items-center justify-content-between list-group-item ui-sortable-handle" data-id="{{ $image->id }}" style="position: relative; left: 0px; top: 0px; padding: 5px;">
                                                    <h6 class="mb-0">
                                                        <img src="{{ asset('images/product/thumb/' . $image->image_path) }}" class="img-thumbnail me-3" style="width: 50px; height: 50px;" alt="{{ $data['product_details']->title }}">
                                                        <span>{{ $image->image_path }}</span>
                                                    </h6>
                                                    <span class="float-end">
                                                        
                                                        <form method="POST" action="{{ route('product.image.delete', $image->id) }}" accept-charset="UTF-8" class="d-inline">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="GET">
                                                            <button type="button" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" data-name="{{ $image->image_path }}" title="Delete">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">No images available</li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Attributes</th>
                            <td>
                                @if($data['product_details']->attributes->isNotEmpty())
                                    <table class="table table">
                                        @foreach($data['product_details']->attributes as $attribute)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ $attribute->attribute->title ?? 'No Title' }}:
                                                    </strong>
                                                    @foreach($attribute->values as $value)
                                                        {{ $value->attributeValue->name ?? 'No Value' }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <span>No attributes available</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Product Inventories</th>
                            <td>
                                @if($data['product_details']->inventories->isNotEmpty())
                                    <table class="table table">
                                        <tr>
                                            <th>Mrp</th>
                                            <th>Purchase Rate</th>
                                            <th>Offer Rate</th>
                                            <th>Stock Quantity</th>
                                        </tr>
                                        @foreach($data['product_details']->inventories as $index => $inventory_row)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Rs. 
                                                    </strong>
                                                    {{ $inventory_row->mrp }}</td>
                                                <td>
                                                    <strong>
                                                        Rs. 
                                                    </strong>
                                                    {{ $inventory_row->purchase_rate }}
                                                </td>
                                                <td>
                                                    <strong>
                                                        Rs. 
                                                    </strong>
                                                    {{ $inventory_row->offer_rate }}
                                                </td>
                                                <td>
                                                   {{ $inventory_row->stock_quantity }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <span>No inventories available</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Product Additional Feature</th>
                            <td>
                                @if($data['product_details']->additionalFeatures->isNotEmpty())
                                    <ul>
                                        @foreach($data['product_details']->additionalFeatures as $index => $additionalFeature)
                                            <li>
                                                <strong>{{ $additionalFeature->feature->title }}:</strong>
                                                {{ $additionalFeature->product_additional_featur_value }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>No additional feature available</span>
                                @endif
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Description</th>
                            <td>{{ $data['product_details']->product_description }}</td>
                        </tr>
                        <tr>
                            <th>Specifications</th>
                            <td>{{ $data['product_details']->product_specification }}</td>
                        </tr>
                        <tr>
                            <th>Meta Title</th>
                            <td>{{ $data['product_details']->meta_title }}</td>
                        </tr>
                        <tr>
                            <th>Meta Sescription</th>
                            <td>{{ $data['product_details']->meta_description }}</td>
                        </tr>
                    </table>
               </div>
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
<script src="{{asset('backend/assets/js/rahul-jquery-ui.min.js')}}"></script>
<script>
$(function() {
    $('#sortable_product_image').sortable({
        placeholder: "ui-sortable-placeholder",
        update: function(event, ui) {
            var order = $(this).sortable('toArray', {attribute: 'data-id'});
            /*alert(JSON.stringify(order));*/
            $.ajax({
                url: '{{ route("product-image.sort") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order
                },
                success: function(response) {
                    if (response.success) {
                        Toastify({
                            text: response.message, 
                            duration: 10000,
                            gravity: "top",
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
   });
</script>
@endpush