@if(isset($data['product_list']) && $data['product_list']->count() > 0)
    <table id="example-2" class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th><input type="checkbox" class="form-check-input select-all-checkbox"></th>
                <th>No.</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 10%;">Image</th>
                <th>HSN</th>
                <th>GST%</th>
                <th>Status</th>
                <th>Category</th>
                <th>Created Date</th>
                <th>Attributes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sr_no = 1;
            @endphp
            @foreach($data['product_list'] as $product)
                <tr class="product-row">
                    <td><input type="checkbox" class="product-checkbox form-check-input" value="{{ $product->id }}"></td>
                    <td>{{ $sr_no++ }}</td>
                    <td>
                        <a href="https://www.google.com/search?q={{ urlencode($product->title) }}&udm=2" target="_blank" class="text-primary">
                            
                            {{ ucwords(strtolower($product->title)) }}
                            <span class="badge bg-warning">{{ $product->visitor_count }}</span>
                        </a>
                        @if($product->length && $product->breadth && $product->height && $product->weight)
                            <br>
                            <small class="text-muted">
                                <div style="line-height: 1.1; margin: 0; padding: 0;">Length in CM: {{ number_format($product->length, 2) }}</div>
                                <div style="line-height: 1.1; margin: 0; padding: 0;">Breadth in CM: {{ number_format($product->breadth, 2) }}</div>
                                <div style="line-height: 1.1; margin: 0; padding: 0;">Height in CM: {{ number_format($product->height, 2) }}</div>
                                <div style="line-height: 1.1; margin: 0; padding: 0;">Weight in Kg: {{ number_format($product->weight, 2) }}</div>
                                <div style="line-height: 1.1; margin: 0; padding: 0;">Volumetric Weight Kg: {{ number_format($product->volumetric_weight_kg, 2) }}</div>
                            </small>
                        @endif
                        <!-- {{ $product->title }} -->
                    </td>
                    <td>
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('images/product/thumb/' . $product->images[0]->image_path) }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $product->title }}">
                        @else
                            <span>No images.</span>
                        @endif
                        <br>
                        <a href="javascript:void(0)" data-ajax-image-popup="true" data-size="lg" data-title="Upload Image ({{ $product->title }})" data-url="{{route('products.modal-image-form')}}" data-bs-toggle="tooltip" data-pid="{{$product->id}}" data-bs-original-title="Upload Image">
                            <span class="badge bg-primary">
                                Upload Image
                            </span>
                        </a>
                    </td>
                    <td>{{ $product->hsn_code }}</td>
                    <td>{{ $product->gst_in_per }}</td>
                    <td>
                        <span class="badge {{ $product->product_status === 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->product_status === 1 ? 'Published' : 'Not Published' }}
                        </span>
                    </td>
                    <td>{{ $product->category->title ?? 'No Category' }}</td>
                    <td><span class="text-success">{{ $product->created_at->toFormattedDateString() }}</span></td>
                    <td>
                        <table class="table table-striped table-centered">
                            @foreach($product->attributes as $attribute)
                                <tr>
                                    <td><strong>{{ $attribute->attribute->title ?? 'No Title' }}:</strong>
                                        @foreach($attribute->values as $value)
                                            <span>{{ $value->attributeValue->name ?? 'No Value' }}</span>@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-eye"></i></a>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-pencil"></i></a>
                            <form method="POST" action="{{ route('product.destroy', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No products found in this category.</p>
@endif

<div class="my-pagination" id="pagination-links">
    {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
</div>
