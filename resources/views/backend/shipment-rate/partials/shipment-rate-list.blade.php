
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
                <tr id="row-{{ $shipping_rate->id }}" class="editable-row">
                    <td class="sr-no">{{ $sr_no }}</td>
                    <td class="pincode-cell">
                        <span class="view-mode">{{ $shipping_rate->pincode }}</span>
                        <input type="text" class="form-control edit-mode" value="{{ $shipping_rate->pincode }}" style="display: none;">
                    </td>
                    <td class="post-office-cell">
                        <span class="view-mode">{{ $shipping_rate->post_office }}</span>
                        <input type="text" class="form-control edit-mode" value="{{ $shipping_rate->post_office }}" style="display: none;">
                    </td>
                    <td class="weight-450gm-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_450gm }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_450gm }}" style="display: none;">
                    </td>
                    <td class="weight-750gm-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_750gm }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_750gm }}" style="display: none;">
                    </td>
                    <td class="weight-1350gm-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_1350gm }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_1350gm }}" style="display: none;">
                    </td>
                    <td class="weight-3400gm-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_3400gm }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_3400gm }}" style="display: none;">
                    </td>
                    <td class="weight-7500gm-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_7500gm }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_7500gm }}" style="display: none;">
                    </td>
                    <td class="weight-14kg-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_14kg }}</span>
                        <input type="number" class="form-control p-1 edit-mode" value="{{ $shipping_rate->weight_14kg }}" style="display: none;">
                    </td>
                    <td class="weight-25kg-cell">
                        <span class="view-mode">{{ $shipping_rate->weight_25kg }}</span>
                        <input type="number" class="form-control edit-mode" value="{{ $shipping_rate->weight_25kg }}" style="display: none;">
                    </td>
                    <td>
                        <div class="d-flex gap-1">                            
                            <button 
                                class="btn btn-orange btn-sm refresh-single"
                                data-id="{{ $shipping_rate->id }}">
                                Refresh
                            </button>
                            
                            <!-- <form method="POST" action="{{ route('shipment-rate.destroy', $shipping_rate->id) }}" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm show_confirm">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form> -->
                            <button class="btn btn-info btn-sm edit-row" data-id="{{ $shipping_rate->id }}">
                            <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-success btn-sm save-row" data-id="{{ $shipping_rate->id }}" style="display: none;">
                                <i class="ti ti-check"></i> Save
                            </button>
                            <button class="btn btn-secondary btn-sm cancel-row" data-id="{{ $shipping_rate->id }}" style="display: none;">
                                <i class="ti ti-x"></i> Cancel
                            </button>
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