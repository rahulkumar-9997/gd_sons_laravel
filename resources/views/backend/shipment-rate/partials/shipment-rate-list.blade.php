@if(isset($shipping_rates) && $shipping_rates->count()>0)

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Pincode</th>
            <th>District</th>
            <th>State</th>
            <th>Weight (KG)</th>
            <th>Range</th>
            <th>Shipping Rate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shipping_rates as $shipping_rate)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $shipping_rate->pincode->pincode }}
                </td>
                <td>
                    {{ $shipping_rate->pincode->district }}
                </td>
                <td>
                    {{ $shipping_rate->pincode->state }}
                </td>
                <td>
                    {{ $shipping_rate->weightCategory->primary_weight }} KG
                </td>
                <td>
                    {{ $shipping_rate->weightCategory->min_weight }}
                    -
                    {{ $shipping_rate->weightCategory->max_weight }}
                </td>
                <td>
                    ₹{{ number_format($shipping_rate->shipping_rate, 2) }}
                </td>
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
@endif