@extends('backend.layouts.master')
@section('title','Add Products')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
@endpush

<!-- Start Container Fluid -->
<div class="container-xxl">
   <!-- <pre>
      {{ json_encode($attributesWithValues, JSON_PRETTY_PRINT) }}
   </pre> -->
   <form method="POST" action="{{route('product.store')}}" accept-charset="UTF-8" id="product_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">
      <div class="row">
         <div class="col-xl-7 col-lg-7">
            <div class="card1">
               <div class="card-body1">
                  <div class="col-lg-6">
                     <div class="mb-2">
                        <label for="product-categories" class="form-label">Select Product Categories *</label>
                        <select class="form-control" id="product_categories" data-choices data-choices-groups data-placeholder="Select Categories" name="product_categories" required="required">
                           <option value="">Choose a category</option>
                           @if ($data['product_category_list'] && $data['product_category_list']->isNotEmpty())
                              @foreach ($data['product_category_list'] as $category)
                                 <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                 </option>
                              @endforeach
                           @endif
                        </select>
                        @if($errors->has('product_categories'))
                           <div class="text-danger">{{ $errors->first('product_categories') }}</div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @if(request('category'))
            <div class="row" id="otherFields">
               <div class="col-xl-7 col-lg-7">
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Product Information</h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <label for="product_name" class="form-label">Product Name *</label>
                                 <input type="text" name="product_name" required="required" id="product_name" class="form-control" placeholder="Items Name" value="{{old('product_name')}}">
                                 @if($errors->has('product_name'))
                                    <div class="text-danger">{{ $errors->first('product_name') }}</div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <!--<div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="label" class="form-label">Product Subcategories</label>
                                 <select class="form-control" id="product_subcategories" data-choices data-choices-groups data-placeholder="Select Subcategories" name="product_subcategories">
                                    <option value="">Choose a categories</option>
                                    <option value="1">Fashion</option>
                                 </select>
                              </div>
                           </div>-->
                           <!--<div class="col-lg-12">
                              <div class="mb-2">
                                 <label for="brand" class="form-label">Brand</label>
                                 <select class="form-control" id="brand" data-choices data-choices-groups data-placeholder="Select Brand" name="brand">
                                 <option value="">Choose a Brand</option>
                                    @if ($data['brand_list'] && $data['brand_list']->isNotEmpty())
                                       @foreach ($data['brand_list'] as $brand)
                                          <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>-->
                           
                        </div>
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="label" class="form-label">Label</label>
                                 <select class="form-control" id="label" data-choices data-choices-groups data-placeholder="Select a Label" name="label">
                                    <option value="">Choose a Label</option>
                                    @if ($data['label_list'] && $data['label_list']->isNotEmpty())
                                       @foreach ($data['label_list'] as $label)
                                          <option value="{{ $label->id }}">{{ $label->title }}</option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="product_tags" class="form-label">Tags</label>
                                 <select class="product_tags js-example-basic-single" name="product_tags" id="product_tags">
                                    <option value="">Choose a Tags</option>
                                    <option value="New">New</option>
                                    <option value="Digital">Digital</option>
                                 </select>
                              </div>
                           </div>
                           <!--<div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="product_weight" class="form-label">Product Weight In Gram</label>
                                 <div class="input-group mb-2">
                                    <span class="input-group-text fs-20"><i class='bx bx-weight'></i></span>
                                    <input type="number" id="product_weight" class="form-control" placeholder="000" name="product_weight">
                                 </div>
                              </div>
                           </div>-->
                        </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <label for="product-categories" class="form-label">Stock Status :</label><br>
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_stock_status" value="1" id="product_stock_status" checked>
                                    <label class="form-check-label" for="product_stock_status">
                                       In Stock 
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_stock_status" value="0" id="product_stock_status">
                                    <label class="form-check-label" for="product_stock_status">
                                       Out of stock 
                                    </label>
                                 </div>
                                 
                              </div>
                           </div>
                           
                        </div>
                     </div>
                  </div>
                  <!--Primary attributes-->
                  @if($attributesWithValues->isNotEmpty())
                     <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                           <h4 class="card-title">
                              Primary Product Attributes <span class="text-danger">(Mandatory)</span>
                           </h4>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              @foreach($attributesWithValues as $attributeName => $items)
                                 <div class="col-lg-6">
                                       <div class="mb-2">
                                          <!-- Attribute Selection -->
                                          <label for="attribute-{{ $loop->index }}">{{ $attributeName }}</label>
                                          @php
                                             $uniqueAttributes = [];
                                          @endphp
                                          <select 
                                             class="primary_product_attributes js-example-basic-single" 
                                             name="primary-product-attributes[]" 
                                             id="primary_product_attributes" 
                                             required>
                                             <option selected disabled>Select an option</option>
                                             @foreach($items as $item)
                                                @if(!in_array($item->attribute->title, $uniqueAttributes))
                                                   <option value="{{ $item->attribute->id }}">{{ $item->attribute->title }}</option>
                                                   @php
                                                      $uniqueAttributes[] = $item->attribute->title;
                                                   @endphp
                                                @endif
                                             @endforeach
                                          </select>
                                       </div>
                                 </div>
                                 
                                 <div class="col-lg-6">
                                       <div class="mb-2">
                                          <!-- Attribute Values Selection -->
                                          <label for="attribute-value-{{ $loop->index }}">{{ $attributeName }} Values</label>
                                          @php
                                             $uniqueValues = [];
                                          @endphp
                                          <select 
                                             class="primary_product_attributes_value js-example-basic-single" 
                                             name="primary-product-attributes-value[]" 
                                             id="primary_product_attributes_value" 
                                             required>
                                             <option selected>Select Attribute Values</option>
                                             @foreach($items as $item)
                                                   @if($item->attribute->AttributesValues->isNotEmpty())
                                                      @foreach($item->attribute->AttributesValues as $value)
                                                         @if(!in_array($value->name, $uniqueValues))
                                                               <option value="{{ $value->id }}"> {{ $value->name }}
                                                               </option>
                                                               @php
                                                                  $uniqueValues[] = $value->name;
                                                               @endphp
                                                         @endif
                                                      @endforeach
                                                   @endif
                                             @endforeach
                                          </select>
                                       </div>
                                 </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                  @endif

                  <!--Primary attributes-->
                  <!--Product Attributes-->
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title">
                           Product Attributes <span class="text-danger">(Mandatory)</span>
                        </h4>
                        <button class="btn btn-primary add-more-attributes btn-sm" type="button">Add More Product Attributes</button>
                     </div>
                     <div class="card-body add-more-attributes-append">
                        <div class="row" id="attribute-row-0">
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <select class="product_attributes js-example-basic-single" name="product_attributes[]" id="pro-att-0" require="">
                                    <option selected>Select an option</option>
                                    @foreach($data['product_attributes_list'] as $attributes_list_row)
                                       <option value="{{ $attributes_list_row->id }}">{{ $attributes_list_row->title }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <!--<select class="js-example-basic-multiple" name="product_attributes_value[0][]" id="pro-att-value-0" multiple="multiple">
                                    <option value="" disabled selected>Select Product Attributes Value</option>
                                    
                                 </select>-->
                                 <input type="text" name="product_attributes_value[0][]" required="required" id="pro-att-value-0" class="form-control" placeholder="Enter attributes value comma separated" >
                              </div>
                           </div>
                        </div>
                        
                     </div>
                  </div>
                  <!--Product Attributes-->
                  <!--Product hsn code and gst Feature-->
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title">
                           Product HSN Code and GST in Percentage <span class="text-success">(Optional)</span>
                        </h4>
                     
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="hsn_code" class="form-label">HSN Code</label>
                                 <input type="number" id="hsn_code" class="form-control" placeholder="3434" name="hsn_code">
                                 @if($errors->has('hsn_code'))
                                    <div class="text-danger">{{ $errors->first('hsn_code') }}</div>
                                 @endif
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <label for="gst_in_percentage" class="form-label">GST In Percentage(%)</label>
                                 <input type="number" id="gst_in_percentage" class="form-control" placeholder="10" name="gst_in_percentage"
                                 min="0" max="99" step="1" />
                                 @if($errors->has('gst_in_percentage'))
                                    <div class="text-danger">{{ $errors->first('gst_in_percentage') }}</div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Product hsn code and gst Feature end code-->
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title">
                           Product Additional Feature <span class="text-success">(Optional)</span>
                        </h4>
                        <button class="btn btn-primary add-more-additional-feature btn-sm" type="button">Add More Additional Feature</button>
                     </div>
                     <div class="card-body add-more-additional-feature-append">
                        <div class="row" id="additional-feature-row-0">
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <input type="text" name="additional_feature_key[]" id="additional-feature-key-0" class="form-control" placeholder="Enter additional feature key" >
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="mb-2">
                                 <input type="text" name="additional_feature_key_value[]" id="additional-feature-key-value-0" class="form-control" placeholder="Enter additional feature key value" >
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Product Additional Feature-->
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Pricing Details <span class="text-success">(Optional)</span></h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-6">
                                 <label for="product-price" class="form-label">Product Price </label>
                                 <div class="input-group mb-2">
                                    <span class="input-group-text fs-20"><i class='bx bx-rupee'></i></span>
                                    <input type="number" id="product_price" class="form-control" placeholder="000" name="product_price">
                                 </div>
                           </div>
                           <div class="col-lg-6">
                              <label for="product-discount" class="form-label">Product Sale Price </label>
                              <div class="input-group mb-2">
                                 <span class="input-group-text fs-20"><i class='bx bx-rupee'></i></span>
                                 <input type="number" id="product_sale_price" name="product_sale_price" class="form-control" placeholder="000">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Main Information</h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-3">
                              <div class="mb-2">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="product_status" name="product_status" checked>
                                    <label class="form-check-label" for="product_status">Product Status</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-4">
                              <div class="mb-2">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="warranty_status" name="warranty_status">
                                    <label class="form-check-label" for="warranty_status">Warranty available for this product?</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-5">
                              <div class="mb-2">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="attributes_show_status" name="attributes_show_status" checked>
                                    <label class="form-check-label" for="attributes_show_status">Product Variant Show In Product Page</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--seo meta-->
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title">SEO Meta Tags <span class="text-success">(Optional)</span></h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <label for="meta_title" class="form-label">Meta Title</label>
                                 <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Meta title">
                              </div>
                           </div>
                           
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <label for="meta_title" class="form-label">Meta Description</label>
                                 <textarea class="form-control bg-light-subtle" id="meta_description" rows="4" name="meta_description" placeholder="Short description about meta description"></textarea>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                  </div>
                  <!--seo meta-->
               </div>
               <div class="col-xl-5 col-lg-5">
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Product Dimensions</h4>
                     </div>
                     <div class="card-body">
                           <div class="row">
                              <div class="col-lg-3">
                                    <div class="mb-1">
                                       <label class="form-label">Product Length (cm)</label>
                                       <input type="text" 
                                             name="products_length" 
                                             class="form-control length" 
                                             placeholder="Enter Length" 
                                             value="{{ old('products_length') }}"
                                             oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                                       @error('products_length')
                                          <div class="text-danger">{{ $message }}</div>                                          
                                       @enderror
                                    </div>
                              </div>
                              <div class="col-lg-3">
                                    <div class="mb-1">
                                       <label class="form-label">Product Breadth (cm)</label>
                                       <input type="text" 
                                             name="products_breadth" 
                                             class="form-control breadth" 
                                             value="{{ old('products_breadth') }}"
                                             placeholder="Enter Breadth"
                                             oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                                       @error('products_breadth')
                                          <div class="text-danger">{{ $message }}</div>                                          
                                       @enderror
                                    </div>
                              </div>

                              <div class="col-lg-3">
                                    <div class="mb-1">
                                       <label class="form-label">Product Height (cm)</label>
                                       <input type="text" 
                                             name="products_height" 
                                             class="form-control height" 
                                             placeholder="Enter Height"
                                             value="{{ old('products_height') }}"
                                             oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                                       @error('products_height')
                                          <div class="text-danger">{{ $message }}</div>
                                       @enderror
                                    </div>
                              </div>

                              <div class="col-lg-3">
                                    <div class="mb-1">
                                       <label class="form-label">Product Weight (kg)</label>
                                       <input type="text" 
                                             name="products_weight" 
                                             class="form-control weight" 
                                             placeholder="Enter Weight"
                                             value="{{ old('products_weight') }}"
                                             oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                                       @error('products_weight')
                                          <div class="text-danger">{{ $message }}</div>                                          
                                       @enderror
                                    </div>
                              </div>

                              <div class="col-lg-12">
                                    <div class="mb-1">
                                       <label class="form-label">
                                          Product Volumetric Weight (kg) <span class="text-muted">(Auto Calculated)</span>
                                       </label>
                                       <input type="text"
                                             name="volumetric_weight_kg"
                                             value="{{ old('volumetric_weight_kg') }}"
                                             class="form-control volumetric-weight-kg"
                                             readonly>
                                          @error('volumetric_weight_kg')
                                             <div class="text-danger">{{ $message }}</div>
                                          @enderror
                                    </div>
                              </div>

                           </div>
                        </div>

                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">About Product</h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                    <h5 class="card-title mb-1 anchor">
                                       Product Images *
                                    </h5>
                                    <div class="mb-3">
                                       <input type="file" id="image-input" class="form-control" aria-label="file example"  name="product_images[]" accept="image/*" multiple >
                                    </div>
                                    <div id="image-preview"></div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <h5 class="card-title mb-1 anchor" id="quill-snow-editor">
                                    Product Description
                                 </h5>
                                 <div class="mb-3">
                                    <div class="snow-editor" style="height: 200px; width: 100%;"></div>
                                    <textarea name="product_description" class="hidden-textarea" style="display:none;"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="mb-2">
                                 <h5 class="card-title mb-1 anchor" id="quill-snow-editor">
                                    Product Specification
                                 </h5>
                                 <div class="mb-3">
                                    <div class="snow-editor" style="height: 200px; width: 100%;"></div>
                                    <textarea name="product_specification" class="hidden-textarea" style="display:none;"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card card_fixed">
                     <div class="card-footer bg-light-subtle" id="footer">
                        <div class="row g-2">
                           <div class="col-lg-6">
                              <input type="submit" value="Create Product" class="btn btn-outline-secondary w-100">
                           </div>
                           <div class="col-lg-6">
                              <input type="reset" class="btn btn-primary w-100" value="Cancel">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         @endif
      </div>
   </form>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/components/form-quilljs.js')}}"></script>
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script> 
<script src="{{asset('backend/assets/js/pages/create-product.js')}}" type="text/javascript"></script> 
<script>
   $(document).ready(function() {
      var selectedFiles = [];
        $('#image-input').on('change', function() {
            selectedFiles = Array.from(this.files);
            displayImages();
        });

        function displayImages() {
            $('#image-preview').html('');
            selectedFiles.forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageContainer = $('<div>').addClass('image-container').css({
                        position: 'relative',
                        display: 'inline-block',
                        margin: '10px'
                    });

                    var img = $('<img>').attr('src', e.target.result).css({
                        width: '100px',
                        height: '100px',
                        border: '1px solid #ddd'
                    });

                    var sizeText = $('<p>').text('Size: ' + Math.round(file.size / 1024) + ' KB').css({
                        fontSize: '12px',
                        color: '#666',
                        marginTop: '5px',
                        textAlign: 'center'
                    });
                    var deleteBtn = $('<button>').html('×').css({
                        position: 'absolute',
                        top: '0',
                        right: '0',
                        backgroundColor: '#ff4444',
                        color: '#fff',
                        border: 'none',
                        width: '20px',
                        height: '20px',
                        fontSize: '16px',
                        cursor: 'pointer',
                        lineHeight: '20px',
                        textAlign: 'center'
                    });

                    deleteBtn.on('click', function() {
                        selectedFiles.splice(index, 1); 
                        resetInputField();
                        displayImages();
                    });
                    imageContainer.append(img, sizeText, deleteBtn);
                    $('#image-preview').append(imageContainer);
                }

                reader.readAsDataURL(file); 
            });
        }
        function resetInputField() {
            var dataTransfer = new DataTransfer();
            selectedFiles.forEach(function(file) {
                dataTransfer.items.add(file);
            });
            $('#image-input')[0].files = dataTransfer.files;
        }

   });
</script>
<script>
      var attributeCount = 0;
      var additionalFeatureCount = 0;
      var selectedAttributeIds = new Set();
      $(document).ready(function() {
         initializeSelect2();
         var newDiv = `...`;
         var new_addtional_feature_key = `...`;
         $('.add-more-attributes').on('click', function() {
            attributeCount++;
            var newDiv = `
            <div class="row" id="attribute-row-${attributeCount}">
               <div class="col-lg-5">
                  <div class="mb-2">
                        <select class="product_attributes js-example-basic-single" name="product_attributes[]" id="pro-att-${attributeCount}">
                              <option selected>Select an option</option>
                              @foreach($data['product_attributes_list'] as $attributes_list_row)
                                 <option value="{{ $attributes_list_row->id }}">{{ $attributes_list_row->title }}</option>
                              @endforeach
                        </select>
                  </div>
               </div>
               <div class="col-lg-5">
                  <div class="mb-2">
                        <!--<select class="js-example-basic-multiple" name="product_attributes_value[${attributeCount}][]" id="pro-att-value-${attributeCount}" multiple="multiple">
                           <option value="" disabled selected>Select Product Attributes Value</option>
                        </select>-->
                         <input type="text" name="product_attributes_value[${attributeCount}][]" required="required" id="pro-att-value-${attributeCount}" class="form-control" placeholder="Enter attributes value comma separated" >
                  </div>
               </div>
               <div class="col-lg-2">
                  <button type="button" class="btn btn-danger remove-attributes btn-sm" data-id="${attributeCount}">Remove</button>
               </div>
            </div>`;
            $('.add-more-attributes-append').append(newDiv);
            initializeSelect2();
            updateAttributeOptions();
         });
         /**Remove attributes */
         $(document).on('click', '.remove-attributes', function() {
            var rowId = $(this).data('id');
            $(`#attribute-row-${rowId}`).remove();
         });
         /**Remove attributes */
         /*add more additional feature dynamic*/
         $('.add-more-additional-feature').on('click', function() {
            additionalFeatureCount++;
            var new_addtional_feature_key = `
            <div class="row" id="additional-feature-row-${additionalFeatureCount}">
               <div class="col-lg-5">
                  <div class="mb-2">
                     <input type="text" name="additional_feature_key[]" required="required" id="additional-feature-key-${additionalFeatureCount}" class="form-control" placeholder="Enter additional feature key" >
                  </div>
               </div>
               <div class="col-lg-5">
                  <div class="mb-2">
                     <input type="text" name="additional_feature_key_value[]" id="additional-feature-key-value-${additionalFeatureCount}" class="form-control" placeholder="Enter additional feature key value" >
                  </div>
               </div>
               <div class="col-lg-2">
                  <button type="button" class="btn btn-danger remove-feature btn-sm" data-id="${additionalFeatureCount}">Remove</button>
               </div>
            </div>`;
            $('.add-more-additional-feature-append').append(new_addtional_feature_key);
         });
         /*add more additional feature dynamic*/
         /*Remove the additional feature row when the remove button is clicked*/
         $(document).on('click', '.remove-feature', function() {
            var rowId = $(this).data('id');
            $(`#additional-feature-row-${rowId}`).remove();
         });
         /**fetch hsn code and gst in percentage */
         $(document).on('change', '.primary_product_attributes, .primary_product_attributes_value', function () {
            var urlParams = new URLSearchParams(window.location.search);
            var categoryId = urlParams.get('category'); 
            if (!categoryId) {
               Toastify({
                     text: 'Category ID is missing in the URL.',
                     duration: 10000,
                     gravity: "top",
                     position: "right",
                     className: "bg-info",
                     close: true,
                     onClick: function () {}
               }).showToast();
               return;
            }
            var attributeIds = $('.primary_product_attributes').map(function () {
               var selectedValues = $(this).val();
               if (Array.isArray(selectedValues)) {
                     return selectedValues.filter(function (value) {
                        return value !== '';
                     });
               } else if (selectedValues) {
                     return [selectedValues];
               }
            }).get();
            var attributeValuesIds = $('.primary_product_attributes_value').map(function () {
               var selectedValues = $(this).val();
               if (Array.isArray(selectedValues)) {
                     return selectedValues.filter(function (value) {
                        return value !== '';
                     });
               } else if (selectedValues) {
                     return [selectedValues];
               }
            }).get();
            if (categoryId && attributeIds.length > 0 && attributeValuesIds.length > 0) {
               $.ajax({
                     url: '{{ route("get-hsn-and-gst") }}',
                     method: 'POST',
                     data: {
                        category_id: categoryId, 
                        attribute_ids: attributeIds,
                        attribute_value_ids: attributeValuesIds,
                        _token: $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function (response) {
                        $('#hsn_code').val(response.hsn_code);
                        $('#gst_in_percentage').val(response.gst_rate);
                        Toastify({
                           text: 'HSN Code and GST in Percentage Successfully feteched.',
                           duration: 10000,
                           gravity: "top",
                           position: "right",
                           className: "bg-success",
                           close: true,
                           onClick: function () {}
                        }).showToast();
                     },
                     error: function () {
                        Toastify({
                           text: 'Unable to fetch HSN Code and GST.',
                           duration: 10000,
                           gravity: "top",
                           position: "right",
                           className: "bg-info",
                           close: true,
                           onClick: function () {}
                        }).showToast();
                     }
               });
            }
         });

         /**fetch hsn code and gst in percentage */
         
         /*attributes select  */
         $(document).on('change', '.product_attributes', function () {
            updateAttributeOptions();
         });
         /*attributes select  */
         //updateAttributeOptions();
         /**copy paste additional value */
         /*$(document).on('paste', '.add-more-additional-feature-append .form-control', function (e) {
            e.preventDefault();
            const pastedText = (e.originalEvent.clipboardData || window.clipboardData).getData('text').trim();
            const words = pastedText.split(/\s+/);
            let wordIndex = 0;
            let currentRow = $(this).closest('.row');
            while (currentRow.length && wordIndex < words.length) {
               currentRow.find('.form-control').each(function () {
                     if (wordIndex < words.length) {
                        $(this).val(words[wordIndex]);
                        wordIndex++;
                     }
               });
               currentRow = currentRow.next('.row');
            }
         });*/
      });

      
      function initializeSelect2() {
         $('.js-example-basic-single').each(function() {
            if (!$(this).data('select2')) {
                $(this).select2({
                    placeholder: "Select an option",
                    allowClear: true
                });
            }
         });
        
         $('.js-example-basic-multiple').each(function() {
               if (!$(this).data('select2')) {
                  $(this).select2({
                     placeholder: "Select Product Attributes Value",
                     allowClear: true
                  });
               }
         });
         console.log('Select2 initialized for existing and new elements.');
      }

      function updateAttributeOptions() {
         var selectedAttributes = [];
         $('.product_attributes').each(function () {
            var selectedValue = $(this).val();
            if (selectedValue) {
               selectedAttributes.push(selectedValue);
            }
         });
         
         $('.product_attributes').each(function () {
            const currentDropdown = $(this);
            const currentValue = currentDropdown.val();
            currentDropdown.find('option').each(function () {
               if ($(this).val()) {
                  const optionValue = $(this).val();
                  if (selectedAttributes.includes(optionValue) && optionValue !== currentValue) {
                     $(this).remove();
                  } else if (!selectedAttributes.includes(optionValue)) {
                     if (currentDropdown.find(`option[value="${optionValue}"]`).length === 0) {
                           currentDropdown.append(`<option value="${optionValue}">${$(this).text()}</option>`);
                     }
                  }
               }
            });
         });
      }
    
</script>

@endpush