@if (isset($vendor_purchase_bills) && $vendor_purchase_bills->count() > 0)
    <form id="delete-multiple-bills-form" method="POST" action="{{ route('manage-item.delete-multiple') }}">
        @csrf
        @method('DELETE')
        <div class="table-responsive" id="vendor-purchase_bill">
        <div class="accordion" id="accordionExample">
            @foreach ($vendor_purchase_bills as $bill)
                <div class="accordion-item">
                    <h2 class="accordion-header d-flex align-items-center" id="heading{{ $bill->id }}">
                    <input type="checkbox" name="selected_bills[]" value="{{ $bill->id }}" class="form-check-input ms-1 me-1 select-bill">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $bill->id }}" aria-expanded="true" aria-controls="collapse{{ $bill->id }}">
                        Vendor: {{ $bill->vendor->vendor_name }} | Bill Date: {{ $bill->formatted_bill_date ?? $bill->bill_date }} Bill No: {{ $bill->bill_no ?? $bill->bill_no }}
                    </button>
                    </h2>
                    <div id="collapse{{ $bill->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $bill->id }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>Sr. No.</th>
                                <th>Product Name</th>
                                <th>HSN Code</th>
                                <th>Mrp</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Purchase Rate</th>
                                <th>Offer Rate</th>
                                <th>GST Discount (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr_no = 1; @endphp
                                @foreach ($bill->purchaseLines as $line)
                                <tr>
                                    <td>{{ $sr_no }}</td>
                                    <td>{{ $line->product->title }}</td>
                                    <td>{{ $line->hsn_code }}</td>
                                    <td>{{ $line->mrp }}</td>
                                    <td>{{ $line->qty }}</td>
                                    <td>{{ $line->total_amount }}</td>
                                    <td>{{ $line->purchase_rate }}</td>
                                    <td>{{ $line->offer_rate }}</td>
                                    <td>{{ $line->product->gst_in_per }}</td>
                                </tr>
                                @php $sr_no++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
        <div class="text-end mt-3">
        <div class="form-check form-check-inline">
            <label for="select-all-bills" class="form-check-label">Select All Bills</label>
            <input type="checkbox" id="select-all-bills" class="form-check-input me-2">
        </div>
        <button type="button" id="confirm-delete-btn" class="btn btn-danger btn-sm ms-2">Delete Selected Bills</button>
        </div>
    </form>
    <div class="my-pagination" id="vendor_purchase_list_pagination" style="margin-top: 30px;">
        {{ $vendor_purchase_bills->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif