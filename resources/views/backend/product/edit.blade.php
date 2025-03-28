@extends('backend.layouts.master')
@section('title','Edit Products')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
@endpush
<!-- Start Container Fluid -->
<div class="container-xxl">
   <form method="POST" action="{{ route('product.update', $data['product']->id) }}" accept-charset="UTF-8" id="product_form_edit" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
         <div class="col-xl-7 col-lg-7">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Product Information</h4>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="mb-2">
                           <label for="product-categories" class="form-label">Product Categories *</label>
                           <select class="form-control" id="product_categories" data-choices data-choices-groups data-placeholder="Select Categories" name="product_categories" required="required" >
                              <option value="">Choose a category</option>
                              @if ($data['product_category_list'] && $data['product_category_list']->isNotEmpty())
                                 @foreach ($data['product_category_list'] as $category)
                                    <option value="{{ $category->id }}" {{ $data['product']->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
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
                           <label for="product_name" class="form-label">Product Name *</label>
                           <input type="text" name="product_name" required="required" id="product_name" class="form-control" placeholder="Items Name" value="{{ $data['product']->title }}">
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
                           <label for="brand" class="form-label">Brand *</label>
                           <select class="form-control" id="brand" data-choices data-choices-groups data-placeholder="Select Brand" name="brand">
                           <option value="">Choose a Brand</option>
                              @if ($data['brand_list'] && $data['brand_list']->isNotEmpty())
                                 @foreach ($data['brand_list'] as $brand)
                                    <option value="{{ $brand->id }}" {{ $data['product']->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
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
                                    <option value="{{ $label->id }}" {{ $data['product']->label_id == $label->id ? 'selected' : '' }}>{{ $label->title }}</option>
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
                              <option value="New" {{ $data['product']->product_tags == 'New' ? 'selected' : '' }}>New</option>
                              <option value="Digital" {{ $data['product']->product_tags == 'Digital' ? 'selected' : '' }}>Digital</option>
                           </select>
                        </div>
                     </div>
                     <!--<div class="col-lg-6">
                        <div class="mb-2">
                           <label for="product_weight" class="form-label">Product Weight In Gram</label>
                           <div class="input-group mb-2">
                              <span class="input-group-text fs-20"><i class='bx bx-weight'></i></span>
                              <input type="number" id="product_weight" class="form-control" placeholder="000" name="product_weight" value="{{ $data['product']->product_weight }}">
                           </div>
                        </div>
                     </div>-->
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="mb-2">
                           <label for="product-categories" class="form-label">Stock Status *:</label><br>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="product_stock_status" value="1" id="product_stock_status" {{ $data['product']->product_stock_status == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="product_stock_status">In Stock</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="product_stock_status" value="0" id="product_stock_status" {{ $data['product']->product_stock_status == 0 ? 'checked' : '' }}>
                              <label class="form-check-label" for="product_stock_status">Out of Stock</label>
                           </div>
                           
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
            <!--Product Attributes-->
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center gap-1">
                  <h4 class="card-title">Product Attributes <span class="text-danger">(Mandatory)</span></h4>
                  <button class="btn btn-primary add-more-attributes btn-sm" type="button">Add More Product Attribute</button>
               </div>
               <div class="card-body add-more-attributes-append">
                  @foreach($data['product']->attributes as $index => $productAttribute)
                     <div class="row attribute-row" id="attribute-row-{{ $index }}">
                        <div class="col-lg-4">
                           <div class="mb-2">
                                 <select class="product_attributes js-example-basic-single" name="product_attributes[{{ $index }}]" id="pro-att-{{ $index }}">
                                    <option value="" disabled>Select an option</option>
                                    @foreach($data['product_attributes_list'] as $attribute)
                                       <option value="{{ $attribute->id }}" {{ $attribute->id == $productAttribute->attribute->id ? 'selected' : '' }}>
                                             {{ $attribute->title }}
                                       </option>
                                    @endforeach
                                 </select>
                           </div>
                        </div>

                        <div class="col-lg-8">
                           <div class="mb-2">
                                 <!--<select class="js-example-basic-multiple" name="product_attributes_value[{{ $index }}][]" id="pro-att-value-{{ $index }}" multiple="multiple">
                                    <option value="" disabled>Select Product Attributes Value</option>
                                    @foreach($productAttribute->values as $value)
                                       <option value="{{ $value->attributeValue->id }}" selected>
                                             {{ $value->attributeValue->name }}
                                       </option>
                                    @endforeach
                                 </select>-->
                                 @php
                                    $attributes_values = $productAttribute->values->pluck('attributeValue.name')->implode(', ');
                                    $attributes_value_id = $productAttribute->values->pluck('attributeValue.id')->implode(',');
                                 @endphp

                                 <input type="text" name="product_attributes_value[{{ $index }}][]" 
                                    required="required" 
                                    id="pro-att-value-{{ $index }}" 
                                    class="form-control" 
                                    placeholder="Enter attributes value comma separated" 
                                    value="{{ $attributes_values }}">
                                 <input type="hidden" value="{{$attributes_value_id}}" name="product_attributes_value_id[{{ $index }}][]" >
                           </div>
                        </div>
                        <!--<div class="col-lg-2">
                           <button type="button" class="btn btn-sm btn-danger remove-attribute">Remove</button>
                        </div>-->
                     </div>
                  @endforeach
                  
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
                           <input type="number" id="hsn_code" class="form-control" placeholder="3434" name="hsn_code" value="{{ $data['product']->hsn_code }}">
                           @if($errors->has('hsn_code'))
                              <div class="text-danger">{{ $errors->first('hsn_code') }}</div>
                           @endif
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="mb-2">
                           <label for="gst_in_percentage" class="form-label">GST In Percentage(%)</label>
                           <input type="number" id="gst_in_percentage" class="form-control" placeholder="10" name="gst_in_percentage"
                           min="0" max="99" step="1" value="{{ $data['product']->gst_in_per }}"/>
                           @if($errors->has('gst_in_percentage'))
                              <div class="text-danger">{{ $errors->first('gst_in_percentage') }}</div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--Product hsn code and gst Feature end code-->
            <!--Product Additional Feature-->
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center gap-1">
                  <h4 class="card-title">
                     Product Additional Feature <span class="text-success">(Optional)</span>
                  </h4>
                  <button class="btn btn-primary add-more-additional-feature btn-sm" type="button">Add More Additional Feature</button>
               </div>
               <div class="card-body add-more-additional-feature-append">
                  @foreach($data['product']->additionalFeatures as $index => $additionalFeature)
                     <div class="row feature-row" id="feature-row-{{ $index }}">
                        <div class="col-lg-5">
                           <div class="mb-2">
                              <input type="text" name="additional_feature_key[]" required="required" id="additional-feature-key-{{ $index }}" class="form-control" value="{{ $additionalFeature->feature->title }}" placeholder="Enter additional feature key" >
                           </div>
                        </div>
                        <div class="col-lg-5">
                           <div class="mb-2">
                              <input type="text" name="additional_feature_key_value[]" id="additional-feature-key-value-{{ $index }}" class="form-control" value="{{ $additionalFeature->product_additional_featur_value }}" placeholder="Enter additional feature key value" >
                           </div>
                        </div>
                        <div class="col-lg-2">
                           <button type="button" class="btn btn-danger remove-feature btn-sm" data-id="{{ $index }}">Remove</button>
                        </div>
                     </div>
                  @endforeach
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
                           <label for="product-price" class="form-label">Product Price *</label>
                           <div class="input-group mb-2">
                              <span class="input-group-text fs-20"><i class='bx bx-rupee'></i></span>
                              <input type="number" id="product_price" class="form-control" placeholder="000" name="product_price" value="{{ old('product_price', $data['product']->product_price) }}">
                           </div>
                     </div>
                     <div class="col-lg-6">
                        <label for="product-discount" class="form-label">Product Sale Price *</label>
                        <div class="input-group mb-2">
                           <span class="input-group-text fs-20"><i class='bx bx-rupee'></i></span>
                           <input type="number" id="product_sale_price" name="product_sale_price" class="form-control" placeholder="000"  value="{{ old('product_sale_price', $data['product']->product_sale_price) }}">
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
                              <input class="form-check-input" type="checkbox" role="switch" id="product_status" name="product_status"  {{ $data['product']->product_status == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="product_status">Product Status</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="mb-2">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" role="switch" id="warranty_status" name="warranty_status" {{ $data['product']->warranty_status == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="warranty_status">Warranty available for this product?</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-5">
                        <div class="mb-2">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" role="switch" id="attributes_show_status" name="attributes_show_status" {{ $data['product']->attributes_show_status == 1 ? 'checked' : '' }}>
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
                           <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Meta title" value="{{ $data['product']->meta_title }}">
                        </div>
                     </div>
                     
                     <div class="col-lg-12">
                        <div class="mb-2">
                           <label for="meta_title" class="form-label">Meta Description</label>
                           <textarea class="form-control bg-light-subtle" id="meta_description" rows="4" name="meta_description" placeholder="Short description about meta description">{{ $data['product']->meta_description }}</textarea>
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
                        <div class="row mb-3">
                           @if ($data['product']->images && $data['product']->images->isNotEmpty())
                              @foreach ($data['product']->images as $image)
                                 <div class="col-md-3 mb-2">
                                    <img src="{{ asset('images/product/thumb/'. $image->image_path) }}" class="img-thumbnail" alt="Product Image" style="width: 100px; height: 100px;">
                                    <a href="{{ route('product.image.delete', $image->id) }}" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Are you sure you want to delete this image?')">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                    </a>
                                 </div>
                              @endforeach
                           @else
                              <p>No images found for this product.</p>
                           @endif
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
                              <div class="snow-editor" style="height: 200px; width: 100%;">{!! $data['product']->product_description !!}</div>
                              <textarea name="product_description" class="hidden-textarea" style="display:none;">{!! $data['product']->product_description !!}</textarea>
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
                              <div class="snow-editor" style="height: 200px; width: 100%;">{!! $data['product']->product_specification !!}</div>
                              <textarea name="product_specification" class="hidden-textarea" style="display:none;">{!! $data['product']->product_specification !!}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card card_fixed">
               <div class="card-footer bg-light-subtle">
                  <div class="row g-2">
                     <div class="col-lg-6">
                        <input type="submit" value="Update Product" class="btn btn-primary w-100">
                     </div>
                     <!-- <div class="col-lg-6">
                        <input type="reset" class="btn btn-primary w-100" value="Cancel">
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
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
      
      var selectedAttributeIds = new Set();
      /*$('.add-more-attributes-append').on('change', '.product_attributes', function() {
         let selectedAttributeId = $(this).val();
         let currentRowId = $(this).attr('id').split('-')[2];
         var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            attribute_id: selectedAttributeId
         };
         if (selectedAttributeId) {
            selectedAttributeIds.add(selectedAttributeId);
         } else {
            selectedAttributeIds.delete($(this).data('previous-value')); 
         }
         $(this).data('previous-value', selectedAttributeId); 
         $.ajax({
            url: "{{ route('getFilteredAttributes') }}",
            type: 'POST',
            data: data,
            success: function(response) {
                  let $select = $(`#pro-att-value-${currentRowId}`);
                  $select.empty();
                  if (response.data && response.data.length > 0) {
                     response.data.forEach(function(item) {
                        let newOption = new Option(item.name, item.id, false, false);
                        $select.append(newOption);
                     });
                     $select.trigger('change'); 
                  } else {
                     console.log("No data found");
                  }
            },
            error: function(xhr, status, error) {
               console.error("Error:", error);
               console.error("Response:", xhr.responseText);
            }
         });
      });
      */
      $(document).ready(function() {
         initializeSelect2();
         var newDiv = `...`;
         $('.add-more-attributes').on('click', function() {
            var lastRow = $('.attribute-row').last();
            var attributeCount = lastRow.length ? parseInt(lastRow.attr('id').split('-')[2]) + 1 : 0;
            var newDiv = `
            <div class="row attribute-row" id="attribute-row-${attributeCount}">
               <div class="col-lg-4">
                  <div class="mb-2">
                        <select class="product_attributes js-example-basic-single" name="product_attributes[${attributeCount}]" id="pro-att-${attributeCount}">
                           <option value="" disabled selected>Select an option</option>
                              @foreach($data['product_attributes_list'] as $attributes_list_row)
                                 <option value="{{ $attributes_list_row->id }}">{{ $attributes_list_row->title }}</option>
                              @endforeach
                        </select>
                  </div>
               </div>
               <div class="col-lg-8">
                  <div class="mb-2">
                        <!--<select class="js-example-basic-multiple" name="product_attributes_value[${attributeCount}][]" id="pro-att-value-${attributeCount}" multiple="multiple">
                           <option value="" disabled selected>Select Product Attributes Value</option>
                        </select>-->
                        <input type="text" name="product_attributes_value[${attributeCount}][]" id="pro-att-value-${attributeCount}"
                        class="form-control" 
                        placeholder="Enter attributes value comma separated" 
                        >
                  </div>
               </div>
               <!--<div class="col-lg-2">
                  <button type="button" class="btn btn-sm btn-danger remove-attribute">Remove</button>
               </div>-->
            </div>`;
            $('.add-more-attributes-append').append(newDiv);
            //console.log('Added new attribute row:', newDiv);
            //console.log('Current attribute count:', attributeCount);
            initializeSelect2();
            updateAttributeOptions();
         });
         /*attributes select  */
         $(document).on('change', '.product_attributes', function () {
            updateAttributeOptions();
         });
         /*attributes select  */
         /*add more additional feature dynamic*/
         $('.add-more-additional-feature').on('click', function() {
            var lastRow = $('.feature-row').last();
            var additionalFeatureCount = lastRow.length ? parseInt(lastRow.attr('id').split('-')[2]) + 1 : 0;
            var new_addtional_feature_key = `
            <div class="row feature-row" id="feature-row-${additionalFeatureCount}">
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
            $(`#feature-row-${rowId}`).remove();
         });
         /**copy paste additional value */
         $(document).on('paste', '.add-more-additional-feature-append .form-control', function (e) {
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
         });
         /**copy paste additional value */

      });
      /**remove attributes code start */
      $('.add-more-attributes-append').on('click', '.remove-attribute', function() {
         $(this).closest('.attribute-row').remove();
      });
      /**remove attributes code end */

      
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