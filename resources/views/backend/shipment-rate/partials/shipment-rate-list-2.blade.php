<table class="table align-middle mb-0 table-hover table-centered">
    <thead class="bg-light-subtle">
        <tr>
            <th>#</th>
            <th>Pincode</th>
            <th>District</th>
            <th>State</th>
            @foreach($weight_categories as $weight)
                <th class="text-center">
                    <div>
                        <strong>
                            {{ $weight->primary_weight }} KG
                            
                        </strong>
                        <span
                            class="badge bg-success cursor-pointer update-weight-category-shipping-rate"
                            data-url="{{ route('shipment-rate.update-weight-category', 
                            $weight->id) }}"
                            data-title="{{ $weight->primary_weight }} KG"
                            data-size="md">
                            Shipping Update
                            (₹{{ number_format($weight->weightCategoryShippingRate->rate ?? 0, 2) }})
                        </span>
                    </div>
                    <small class="text-muted">
                        @if($weight->max_weight)
                            {{ number_format($weight->min_weight,2) }}
                            -
                            {{ number_format($weight->max_weight,2) }} KG
                        @else
                            {{ number_format($weight->min_weight,2) }}+ KG
                        @endif
                    </small>
                </th>
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
                <td class="text-center">
                    @if($rate)
                        <span class="">
                            ₹{{ number_format($rate->shipping_rate, 0) }}
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            N/A
                        </span>
                    @endif
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