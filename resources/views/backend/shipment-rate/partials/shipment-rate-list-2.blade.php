<table class="table align-middle mb-0 table-hover table-centered">
    <thead class="bg-light-subtle">
        <tr>
            <th>#</th>
            <th>Pincode</th>
            <th>District</th>
            <th>State</th>

            @foreach($weight_categories as $weight)
            <th>{{ $weight->primary_weight }} KG</th>
            @endforeach
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shipping_rates as $shipping_rate)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $shipping_rate->pincode }}</td>
            <td>{{ $shipping_rate->district }}</td>
            <td>{{ $shipping_rate->state }}</td>
            @foreach($weight_categories as $weight)
            @php
            $rate = $shipping_rate->shippingRates
            ->where('weight_category_id', $weight->id)
            ->first();
            @endphp
            <td>
                ₹{{ number_format(optional($rate)->shipping_rate ?? 0, 2) }}
            </td>
            @endforeach
            <td>
                <div class="d-flex gap-1">             
                    <button
                        class="btn btn-orange btn-sm refresh-single"
                        data-id="{{ $shipping_rate->id }}">
                        Refresh
                    </button>
                    <form method="POST" action="{{ route('shipment-rate.destroy', $shipping_rate->id) }}" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm show_confirm">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Total Shipping Rates: {{ $shipping_rates->total() }}
    </div>
    <div>
        {{ $shipping_rates->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>