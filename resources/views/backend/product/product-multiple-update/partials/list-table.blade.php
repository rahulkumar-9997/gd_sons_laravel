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
                @elseif ($criteria == 'g-tin-no')
                <th>Product GTIN No. (Global Trade Item Number)</th>
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
                @elseif ($criteria == 'g-tin-no')
                <td>
                    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                    <input type="text" name="products_gtin_no[]" value="{{ $product->g_tin_no }}" class="form-control form-control-sm" placeholder="Enter Products GTIN No.">

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