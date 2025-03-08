@extends('backend.layouts.master')
@section('title','Import Product')
@section('main-content')
@push('styles')
  
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Import Excel</h4>
               <!--<a href="#" 
                  data-title="Download Excel Format" 
                  data-bs-toggle="tooltip" 
                  title="Download Excel Format" 
                  class="btn btn-sm btn-danger">
                  Download Excel Format
               </a>-->
               <a href="{{route('product.create')}}" 
                  data-title="Add Product" 
                  data-bs-toggle="tooltip" 
                  title="Add Product" 
                  class="btn btn-sm btn-success">
                  Add Product
               </a>
            </div>
            <div class="card-body">
               
               <form method="POST" action="{{ route('product.excel.store') }}" accept-charset="UTF-8" id="product_form" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-lg-12">
                        @if (request()->has('category_id') && request()->query('category_id') !== '')
                           @if (isset($product_category_with_attributes))
                              @if ($product_category_with_attributes->attributes->isNotEmpty())
                                 <h5>Selected Category: {{ $product_category_with_attributes->title }}</h5>
                                 <table class="table table-bordered">
                                    <thead>
                                          <tr>
                                             <th>Product Name</th>
                                            
                                             @if ($product_category_with_attributes->attributes->isNotEmpty())
                                                @foreach ($product_category_with_attributes->attributes as $attribute)
                                                   <th>{{ $attribute->title }}</th> 
                                                @endforeach
                                             @endif
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <tr>
                                             <td>Hawkins Classic 1.5 ltr</td>
                                             @if ($product_category_with_attributes->attributes->isNotEmpty())
                                                @foreach ($product_category_with_attributes->attributes as $attribute)
                                                   <td>Example Value</td> 
                                                @endforeach
                                             @endif
                                          </tr>
                                    </tbody>
                                 </table>
                              @else
                                 <h4 class="text-danger">Selected category attribute not define please define first attributes, then import excel file.</h4>
                              @endif
                           @endif
                        @endif
                     </div>
                     <div class="col-lg-6">
                        <div class="mb-2">
                           <label for="product-categories" class="form-label">Product Categories *</label>
                           <select class="form-control" id="product_categories" data-choices data-choices-groups data-placeholder="Select Categories" name="product_categories" required="required" >
                              <option value="">Choose a category</option>
                              @if ($data['product_category_list'] && $data['product_category_list']->isNotEmpty())
                                 @foreach ($data['product_category_list'] as $category)
                                    <option 
                                    value="{{ $category->id }}"
                                    @if (isset($product_category_with_attributes) && is_object($product_category_with_attributes) && $category->id == $product_category_with_attributes->id) selected @endif
                                    >{{ $category->title }}</option>
                                 @endforeach
                              @endif
                           </select>
                           @if($errors->has('product_categories'))
                              <div class="text-danger">{{ $errors->first('product_categories') }}</div>
                           @endif
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="mb-2">
                           <label for="product-categories" class="form-label">Import File *</label>
                           <input type="file" id="import_file" class="form-control" aria-label="file example" required="required" name="import_file">
                           @if($errors->has('import_file'))
                              <div class="text-danger">{{ $errors->first('import_file') }}</div>
                           @endif
                        </div>
                     </div>
                  </div>
                  @if (request()->has('category_id') && request()->query('category_id') !== '')
                     @if (isset($product_category_with_attributes))
                        @if ($product_category_with_attributes->attributes->isNotEmpty())
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="mb-2 mt-3">
                                    <input type="submit" value="Submit" class="btn btn-primary w-50">
                                 </div>
                              </div>
                           </div>
                        @endif
                     @endif
                  @endif
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
<script>
   $(document).ready(function() {
      $('#product_categories').change(function() {
         var selectedAttribute = $(this).val();
         if (selectedAttribute) {
               var newUrl = '{{ url()->current() }}?category_id=' + selectedAttribute;
               window.location.href = newUrl;
         }
      });
   });
</script>
@endpush