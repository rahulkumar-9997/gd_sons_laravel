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
                <th>Reviews</th>
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
                        </a>
                        <span class="badge bg-info ms-1" title="Visitor Count {{ $product->visitor_count }}">
                            <i class="ti ti-eye"></i> {{ $product->visitor_count }}
                        </span>
                        @if($product->length && $product->breadth && $product->height && $product->weight)
                            <div class="mt-1 d-flex flex-wrap gap-1">
                                <span class="badge bg-light text-dark">L: {{ number_format($product->length, 1) }}cm</span>
                                <span class="badge bg-light text-dark">B: {{ number_format($product->breadth, 1) }}cm</span>
                                <span class="badge bg-light text-dark">H: {{ number_format($product->height, 1) }}cm</span>
                                <span class="badge bg-light text-dark">W: {{ number_format($product->weight, 1) }}kg</span>
                                <span class="badge bg-purple text-white">VW: {{ number_format($product->volumetric_weight_kg, 1) }}kg</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        @php
                            $imagePath = null;
                            if ($product->images->isNotEmpty()) {
                                $file = 'images/product/thumb/' . $product->images[0]->image_path;
                                if (file_exists(public_path($file))) {
                                    $imagePath = asset($file);
                                }
                            }
                        @endphp
                        @if($imagePath)
                            <img src="{{ $imagePath }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $product->title }}">
                        @else
                            <span>No image found.</span>
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
                        @php
                            $reviewCount = $product->reviews->count();
                            $averageRating = $product->reviews->avg('rating_star_value');
                        @endphp
                        <span class="badge bg-info">
                            {{ $reviewCount }} {{ Str::plural('Review', $reviewCount) }}
                        </span>
                        @if($reviewCount > 0)
                        <br>
                        <small class="text-warning">
                            @php $roundedRating = (int) round((float) $averageRating); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $roundedRating)
                                    <i class="ti ti-star-filled"></i>
                                @else
                                    <i class="ti ti-star"></i>
                                @endif
                            @endfor
                            ({{ number_format((float)$averageRating, 1) }})
                        </small>
                    @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->product_status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->product_status == 1 ? 'Published' : 'Not Published' }}
                        </span>
                    </td>
                    <td>{{ $product->category->title ?? 'No Category' }}</td>
                    <td><span class="text-success">{{ $product->created_at->toFormattedDateString() }}</span></td>
                    <td>
                        <div class="overflow-auto" style="max-width: 200px; max-height: 80px; overflow: auto; white-space: nowrap;">
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
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-eye"></i></a>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-pencil"></i></a>
                            <button class="btn btn-soft-success btn-sm generate-ai-review" 
                                data-url="{{ route('generate.ai.review.single', $product->id) }}"
                                data-title="Generate AI Reviews for {{ ucwords(strtolower($product->title)) }}"
                                title="Generate AI Reviews"
                                data-size="xl">
                                <i class="ti ti-robot"></i> 
                            </button>
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
    <div class="my-pagination mt-2 mb-2" id="pagination-links">
        {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
    </div>
@else
    <p>No products found in this category.</p>
@endif

