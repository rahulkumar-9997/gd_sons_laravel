
    @if (isset($shipping_rates) && $shipping_rates->count() > 0)
        <table class="table align-middle mb-0 table-hover table-centered">
            <thead class="bg-light-subtle">
                <tr>
                    <th>Sr. No.</th>
                    <th style="width: 15%;">Pin Code</th>
                    <th>Post Office</th>
                    <th>Weight (450gm)</th>
                    <th>Weight (750gm)</th>
                    <th>Weight (1350gm)</th>
                    <th>Weight (3400gm)</th>
                    <th>Weight (7500gm)</th>
                    <th>Weight (14kg)</th>
                    <th>Weight (25kg)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sr_no = 1;
                @endphp
                @foreach($shipping_rates as $shipping_rate)
                <tr>
                    <td>
                        {{ $sr_no }}
                    </td>
                    <td>
                        {{ $shipping_rate->pincode }}                       
                    </td>
                    <td>
                        {{ $shipping_rate->post_office }}
                    </td>
                    <td>
                        {{ $shipping_rate->weight_450gm }}
                    </td>
                    <td>
                        {{ $shipping_rate->weight_750gm }}
                    </td>
                    <td>
                        {{ $shipping_rate->weight_1350gm }}

                    </td>
                    <td>
                        {{ $shipping_rate->weight_3400gm }}
                    </td>
                    <td>
                        {{ $shipping_rate->weight_7500gm }}
                    
                    </td>
                    <td>
                        {{ $shipping_rate->weight_14kg }}
                    </td>
                    <td>
                        {{ $shipping_rate->weight_25kg }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">                            
                            <button 
                                class="btn btn-soft-primary btn-sm refresh-single"
                                data-id="{{ $shipping_rate->id }}">
                                Refresh
                            </button>
                            <form method="POST" action="{{ route('shipment-rate.destroy', $shipping_rate->id) }}" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-soft-danger btn-sm show_confirm">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @php
                $sr_no++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Total Shipping Rates: {{ $shipping_rates->total() }} | 
                Page {{ $shipping_rates->currentPage() }} of {{ $shipping_rates->lastPage() }}
            </div>

            <div class="my-pagination" id="pagination-links-shipping-rates">
                {{ $shipping_rates->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    @endif