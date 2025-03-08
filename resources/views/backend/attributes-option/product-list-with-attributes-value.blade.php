@extends('backend.layouts.master')
@section('title', $attributes_value->name)
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
                    All Produtcs List (<span class="text-danger">{{$attributes_value->name}}</span>)
                    <a href="{{route('attributes')}}" data-title="Go Back to Attributes" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title="Go Back to Attributes">
                       << Go Back to Previous Page
                    </a>
                </h4>
                
            </div>
            <div class="card-body">
                @if (isset($data['product_list']) && $data['product_list']->count() > 0)
                  <div class="table-responsive">
                     <table id="example-2" class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th data-orderable="false">No.</th>
                                <th style="width: 20%;">Name</th>
                                <th data-orderable="false">Image</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @php
                              $sr_no = 1;
                           @endphp
                           @foreach($data['product_list'] as $product_list_row)
                              <tr class="product-row">
                                <td>{{ $sr_no }}</td>
                                 <td>{{ $product_list_row->title }}</td>
                                 <td>
                                    @if(!empty($product_list_row->images) && count($product_list_row->images) > 0)
                                       <img src="{{ asset('images/product/thumb/' . $product_list_row->images[0]->image_path) }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $product_list_row->title }}">
                                    @else
                                       <span>No images.</span>
                                    @endif
                                 </td>
                                 <td>
                                    @if($product_list_row->product_status === 1)
                                       <span class="badge bg-success text-light px-2 py-1 fs-10">Published</span>
                                    @else
                                       <span class="badge bg-light text-dark px-2 py-1 fs-10">Not Published</span>
                                    @endif
                                 </td>
                                 <td>{{ $product_list_row->category->title ?? 'No Category' }}</td>
                                 <!-- <td>{{ $product_list_row->brand->title ?? 'No Brand' }}</td> -->
                                 <td>
                                    <span class="text-success">
                                       {{ $product_list_row->created_at->toFormattedDateString() }}
                                    </span>
                                 </td>
                                 <td>
                                 <div class="d-flex gap-1">
                                    <a href="{{ route('product.show', $product_list_row->id) }}" class="btn btn-soft-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="View Product Details">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('product.edit', $product_list_row->id) }}" class="btn btn-soft-primary btn-sm editAttributes" data-bs-toggle="tooltip" data-bs-original-title="Edit Product">
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
                    <div class="my-pagination">
                        {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
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


@endpush