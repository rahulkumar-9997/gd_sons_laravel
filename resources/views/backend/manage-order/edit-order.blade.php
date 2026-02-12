@extends('backend.layouts.master')
@section('title','Edit Order')
@section('main-content')
@push('styles')

@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">
                    diudahasiudah
                    
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
                
            </div>
         </div>
      </div>
   </div>
</div>
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')

@endpush