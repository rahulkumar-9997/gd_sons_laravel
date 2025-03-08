@if (isset($data['product_list']) && $data['product_list']->count() > 0)
    <div class="table-responsive1">
        <form action="{{ route('product-update-gst.store') }}" method="POST" id="updatehsngst">
            @csrf
            @method('POST')
            <table id="productList" class="table align-middle mb-0 table-hover table-centered">
                <thead class="bg-light-subtle">
                    <tr>
                        <th>Sr. No.</th>
                        <th style="width: 25%;">Name</th>
                        <th>Category</th>
                        <th>GST%</th>
                        <th>HSN Code</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sr_no = 1;
                    @endphp
                    @foreach($data['product_list'] as $product_list_row)
                        <tr>
                            <td>{{ $sr_no }}</td>
                            <td>{{ $product_list_row->title }}</td>
                            <td>
                                {{ $product_list_row->category->title ?? 'No Category' }}

                            </td>
                            <td>
                                <input type="hidden" name="product_id" value="{{ $product_list_row->id }}">
                                <input type="number" name="products[{{ $product_list_row->id }}][gst_in_per]" 
                                    value="{{ $product_list_row->gst_in_per ?? '' }}" 
                                    placeholder="GST%" 
                                    class="form-control form-control-sm" >
                            </td>
                            <td>
                                <input type="text" name="products[{{ $product_list_row->id }}][hsn_code]" 
                                    value="{{ $product_list_row->hsn_code ?? '' }}" 
                                    placeholder="HSN Code" 
                                    class="form-control form-control-sm" >
                            </td>
                        </tr>
                        @php
                            $sr_no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-check"></i> Update All
                </button>
            </div>
        </form>
    </div>
    <div class="my-pagination" id="hsn-gst-pagination" style="margin-top: 20px;">
        {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif