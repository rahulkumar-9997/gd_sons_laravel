@extends('backend.layouts.master')
@section('title','Manage Primary Category')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div id="example-2_wrapper" class="filter-box">
            <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1">
               <div class="d-flex align-items-center">
                  <label class="mb-0 me-2 text-dark-grey f-14">Search:</label>
                  <input type="search" class="form-control form-control-md w-100" id="primary-category-search" placeholder="Search Primary Category">
               </div>
               <button id="reset-button" class="btn btn-danger" style="display:none;">
                  <svg class="svg-inline--fa fa-times-circle fa-w-16 mr-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                  Reset Filters
               </button>
            </div>
         </div>
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Primary Category</h4>
               <a href="{{ route('manage-primary-category.create') }}"
                  class="btn btn-sm btn-primary">
                  Add Primary Category
               </a>
            </div>
            <div class="card-body" id="primary-category-list-container">
                  @include(
                     'backend.primary-category.partials.primary-category-list',
                     ['primaryCategory' => !empty($primaryCategory) ? $primaryCategory : []]
                  )
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
<script src="{{asset('backend/assets/js/pages/primaryCategory.js')}}?v={{ env('ASSET_VERSION', '1.0') }}" type="text/javascript"></script>
<script>
    window.primaryCategoryUrl = "{{ route('manage-primary-category.index') }}";
</script>
@endpush