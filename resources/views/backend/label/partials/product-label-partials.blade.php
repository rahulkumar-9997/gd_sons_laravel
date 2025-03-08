@if (isset($productsWithLabel) && $productsWithLabel->count() > 0)
    <form action="{{ route('label-product-form.submit', ['labelId' => $label_row->id]) }}" method="POST" id="multipleUpdateProductLabel" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
        @csrf
        <table id="productWithLabel" class="table align-middle mb-0 table-hover table-centered">
            <thead class="bg-light-subtle">
                <tr>
                    <th style="width: 5%;">Sr. No.</th>
                    <th style="width: 35%;">Product Name</th>
                    <th>Category</th>
                    <th>Label Name</th>
                </tr>
            </thead>
            <tbody>
                @php $sr_no = 0; @endphp
                @foreach($productsWithLabel as $product)
                <tr>
                    <td>
                        {{ $sr_no }}
                        <input type="hidden" name="product_id[]" value="{{$product->id}}">
                    </td>
                    <td>
                        <a class="text-primary">
                            {{ ucwords(strtolower($product->title)) }}
                        </a>
                    </td>
                    <td>
                        {{ $product->category->title ?? 'No Category' }}
                    </td>
                    <td>
                        <input type="checkbox" class="label-checkbox form-check-input"
                            name="label_id[{{ $product->id }}]"
                            value="{{ $label_row->id }}"
                            {{ $product->label_id == $label_row->id ? 'checked' : '' }}>
                        <span class="{{ $product->label ? 'text-success' : 'text-danger' }}">
                            {{ $product->label->title ?? 'No Label Defined' }}
                        </span>
                    </td>
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
    <div class="my-pagination" id="multiple_update_label" style="margin-top: 20px;">
        {{ $productsWithLabel->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif