@if(isset($coupons) && $coupons->count() > 0)
<div class="table-responsive">
    <table class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>Sr. No.</th>
                <th>Code</th>
                <th>Mode</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Max Discount</th>
                <th>Valid From</th>
                <th>Valid Till</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $sr = 1; @endphp
            @foreach($coupons as $row)
            <tr>
                <td>{{ $sr++ }}</td>
                <td>{{ $row->discount_code }}</td>
                <td>{{ $row->mode }}</td>
                <td>
                    @if($row->mode == 'Percentage')
                        {{ $row->discount_value }} %
                    @else
                        ₹ {{ $row->discount_value }}
                    @endif
                </td>
                <td>₹ {{ $row->minimum_order_value }}</td>
                <td>₹ {{ $row->maximum_discount }}</td>
                <td>
                    {{ optional($row->valid_from)->format('d-m-Y') }}
                </td>
                <td>
                    {{ optional($row->valid_till)->format('d-m-Y') }}
                </td>
                <td>
                    <div class="d-flex flex-column gap-1">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input coupon-status-toggle"
                                type="checkbox"
                                data-id="{{ $row->id }}"
                                {{ $row->is_active ? 'checked' : '' }}>
                        </div>
                        @if($row->usage_limit > 0 && $row->total_used >= $row->usage_limit)
                            <span class="badge bg-danger">
                                Usage limit reached
                            </span>
                        @else
                            @if($row->usage_limit > 0)
                                <span class="badge bg-success">
                                    {{ $row->usage_limit - $row->total_used }} left
                                </span>
                            @else
                                <span class="badge bg-info">
                                    Unlimited
                                </span>
                            @endif
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="javascript:void(0);"
                            class="btn btn-soft-primary btn-sm editCoupon"
                            data-id="{{ $row->id }}"
                            data-ajax-editcoupon-popup="true"
                            data-size="lg"
                            data-title="Edit Coupon"
                            data-url="{{ route('manage-coupon.edit', $row->id) }}">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('manage-coupon.destroy', $row->id) }}">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:void(0);"
                               class="btn btn-soft-danger btn-sm show_confirm"
                               data-name="{{ $row->discount_code }}">
                                <i class="ti ti-trash"></i>
                            </a>
                        </form>

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="my-pagination" id="pagination-links">
    {{ $coupons->links('vendor.pagination.bootstrap-4') }}
</div>
@endif
