@extends('backend.layouts.master')
@section('title','Product Multiple Update')
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
                        <div class="col-lg-5">
                            <div class="dropdown">
                                <select id="selecte-criteria" class="form-select">
                                    <option value="">Select Criteria For Update</option>
                                    <option value="product-name" {{ request('criteria') == 'product-name' ? 'selected' : '' }}>
                                        Product Name
                                    </option>
                                    <option value="meta-title-description" {{ request('criteria') == 'meta-title-description' ? 'selected' : '' }}>
                                        Meta Title, Meta Description
                                    </option>
                                    <option value="product-description" {{ request('criteria') == 'product-description' ? 'selected' : '' }}>
                                        Product Description
                                    </option>
                                    <option value="product-specification" {{ request('criteria') == 'product-specification' ? 'selected' : '' }}>
                                        Product Specification
                                    </option>
                                    <option value="product-image" { request('criteria')=='product-image' ? 'selected' : '' }}>
                                        Product Image
                                    </option>
                                    <option value="video-id" { request('criteria')=='video-id' ? 'selected' : '' }}>
                                        Product Video ID
                                    </option>
                                </select>
                            </div>
                        </div>
                    </h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose any Links
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('export.product') }}" class="dropdown-item">Export Product</a>
                            <!-- item-->
                            <a href="{{route('product.excel.import')}}" class="dropdown-item">Import Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($criteria))
                    <form action="{{ route('product-update-all') }}" method="POST" id="multipleUpdateProduct" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                        @csrf
                        <table id="productListMultipleUpdate" class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th style="width: 5%;">Sr. No.</th>
                                    <th style="width: 35%;">Product Name</th>
                                    <th>Category</th>
                                    @if ($criteria == 'product-name')
                                    <th>New Product Name</th>
                                    @elseif ($criteria == 'meta-title-description')
                                    <th>Meta Title</th>
                                    <th>Meta Description</th>
                                    @elseif ($criteria == 'product-description')
                                    <th>Product Description</th>
                                    @elseif ($criteria == 'product-specification')
                                    <th>Product Specification</th>
                                    @elseif ($criteria == 'product-image')
                                    <th>Product Image</th>
                                    @elseif ($criteria == 'video-id')
                                    <th>Product Video ID</th>
                                    <!-- <th>Upload Image</th> -->
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr_no = 0; @endphp
                                <input type="hidden" name="criteria" value="{{ $criteria }}">
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $sr_no }}</td>
                                    <td>
                                        <a href="https://www.google.com/search?q={{ urlencode($product->title) }}&udm=2" target="_blank" class="text-primary">
                                            {{ ucwords(strtolower($product->title)) }}
                                        </a>
                                    </td>
                                    <td>{{ $product->category->title ?? 'No Category' }}</td>

                                    @if ($criteria == 'product-name')
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <input type="text" name="products_name[]" value="{{ $product->title }}" class="form-control form-control-sm" placeholder="Enter new product name">
                                    </td>
                                    @elseif ($criteria == 'meta-title-description')
                                    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                    <td>
                                        <input type="text" name="products_meta_title[]" value="{{ $product->meta_title ?? '' }}" class="form-control form-control-sm" placeholder="Enter meta title">
                                    </td>
                                    <td>
                                        <textarea name="products_meta_description[]" class="form-control form-control-sm" placeholder="Enter meta description">{{ $product->meta_description ?? '' }}</textarea>
                                    </td>
                                    @elseif ($criteria == 'product-description')
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <div class="mb-0">
                                            <div class="snow-editor" style="height: 200px; width: 100%;">{!! $product->product_description !!}</div>
                                            <textarea name="products_description[]" class="hidden-textarea" style="display:none;">
                                            {!! $product->product_description !!}
                                            </textarea>
                                        </div>
                                       
                                    </td>
                                    @elseif ($criteria == 'product-specification')
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <div class="mb-0">
                                            <div class="snow-editor" style="height: 200px; width: 100%;">{!! $product->product_specification !!}</div>
                                            <textarea name="products_specification[]" class="hidden-textarea" style="display:none;">
                                            {!! $product->product_specification !!}
                                            </textarea>
                                        </div>
                                        
                                    </td>
                                    @elseif ($criteria == 'product-image')
                                    
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <input type="file" name="productsImage[{{$sr_no}}][]" class="form-control form-control-sm" multiple>
                                    </td>
                                    @elseif ($criteria == 'video-id')
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <input type="text" name="products_video_id[]" value="{{ $product->video_id }}" class="form-control form-control-sm" placeholder="Enter Video Id">
                                        
                                    </td>
                                    @endif
                                </tr>
                                @php $sr_no++; @endphp
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-check"></i> Update All
                            </button>
                        </div>
                    </form>
                    <div class="my-pagination" id="multiple_update" style="margin-top: 20px;">
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/components/form-quilljs.js')}}"></script>
<script>
    $('#selecte-criteria').on('change', function() {
        var selectedValue = $(this).val();
        var url = new URL(window.location.href);
        if (selectedValue) {
            url.searchParams.set('criteria', selectedValue);
        } else {
            url.searchParams.delete('criteria');
        }
        window.location.href = url.toString();
    });
    $(document).off('submit', '#multipleUpdateProduct').on('submit', '#multipleUpdateProduct', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        //console.log($(this).serializeArray());
        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false).html('<i class="ti ti-check"></i> Update All');
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-success",
                    close: true,
                    onClick: function() {}
                }).showToast();
                //$('#productListMultipleUpdate').load(location.href + " #productListMultipleUpdate");
            },
            error: function(xhr) {
                submitButton.prop('disabled', false).html('<i class="ti ti-check"></i> Update All');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = Object.values(errors).flat().join('<br>');
                    Toastify({
                        text: errorMessages || 'Please correct the errors in the form.',
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        escapeMarkup: false,
                        close: true,
                        onClick: function() {}
                    }).showToast();
                    $.each(errors, function(field, messages) {
                        if (field === 'product_id[]') {
                            let input = form.find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        } else {
                            let inputName = field.replace('products.', '');
                            let input = form.find(`[name="products[${inputName}]"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        }
                    });
                } else {
                    let errorMessage = xhr.responseJSON.message || 'An error occurred. Please try again.';
                    Toastify({
                        text: errorMessage,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                        escapeMarkup: false,
                        onClick: function() {}
                    }).showToast();
                }
            }
        });
    });
</script>
@endpush