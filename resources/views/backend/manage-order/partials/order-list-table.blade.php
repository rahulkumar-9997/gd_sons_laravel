<table class="table table-hover">
    <thead class="bg-light-subtle">
        <tr>
            <th>Order ID</th>
            <th style="width: 10%;">Order Date</th>
            <th>
                Customer
            </th>
            <th style="width: 10%;">Total</th>
            <th>Payment Mode</th>
            <th>Payment Status</th>
            <th>Items</th>
            <th>
                <span class="text-info">Order Status</span>
            </th>
            <th style="width: 25%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @if($orders->isNotEmpty())
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>
                {!! \Carbon\Carbon::parse($order->order_date)->format('d M Y') !!}
                <br>
                {!! \Carbon\Carbon::parse($order->order_date)->format('h:i:s A') !!}
            </td>
            <td>
                <a href="#!" class="link-primary fw-medium">{{ $order->customer->name }}</a>
                <!-- <br><span class="badge border border-success text-success  px-2 py-1 fs-13">
                    {{ ucfirst(str_replace('_', ' ', $order->pick_up_status)) }}
                </span> -->
            </td>
            <td>
                Rs. {{ number_format($order->grand_total_amount, 2) }}
                @if($order->shiprocketCourier)
                    <labe class="ms-2 fs-20 text-success cursor-pointer"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Shiprocket Courier: {{ $order->shiprocketCourier->courier_name }}
                        / Rs. {{ $order->shiprocketCourier->courier_shipping_rate }}">
                        <i class="ti ti-question-mark"></i>
                    </labe>
                    
                @endif
            </td>
            <td>
                <span class="badge border border-success text-success">{{ $order->payment_mode }}</span>
            </td>
            <td>
                @if($order->payment_received == 1)
                <span class="badge bg-success text-light">Paid</span>
                @else
                <span class="badge bg-light text-dark">Unpaid</span>
                @endif

            </td>
            <td>{{ $order->orderLines->count() }}</td>
            <td>
                @if (isset($orders_status) && $orders_status->count() > 0)
                    <select class="form-control"
                        id="select_order_status_{{ $order->id }}"
                        name="update_order_status"
                        data-cusid="{{ $order->customer->id }}"
                        data-url="{{ route('update-order-status', ['orderId' => $order->id]) }}">
                        <option value="">Update Order Status</option>
                        @foreach($orders_status as $order_status)
                        <option
                            value="{{ $order_status->id }}"
                            {{ $order->order_status_id == $order_status->id ? 'selected' : '' }}>
                            {{ $order_status->status_name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                
            </td>
            @php
                $sr = $order->shiprocketOrderResponse;
            @endphp
            <td>
                <div class="d-flex gap-2">
                    @if($order->shiprocketCourier)
                        @if($order->payment_mode !== 'Pick Up From Store')

                        <style>
                            .disabled-dropdown {
                                pointer-events: none !important;
                                opacity: 0.6;
                            }
                        </style>

                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-primary" data-bs-toggle="dropdown">
                                Shiprocket Actions
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">

                                {{-- ================================================== --}}
                                {{-- IF ORDER CANCELLED → SHOW ONLY CANCEL STATUS       --}}
                                {{-- ================================================== --}}
                                @if($sr && $sr->is_order_cancelled)
                                    <span class="dropdown-item disabled-dropdown text-danger fw-bold">
                                        ✘ Order Cancelled
                                    </span>
                                @else

                                    {{-- ========================= --}}
                                    {{-- CREATE ORDER BUTTON       --}}
                                    {{-- ========================= --}}
                                    @if(!$sr || !$sr->is_order_created)
                                        <a href="javascript:void(0)" 
                                            class="dropdown-item sr-action"
                                            data-url="{{ route('shiprocket.create.order', $order->id) }}"
                                            data-order-status-id="{{ $order_status_id }}"
                                            data-action-text="Create Order">
                                            Create Order
                                        </a>
                                    @else
                                        <span class="dropdown-item disabled-dropdown text-success fw-bold">
                                            ✔ Order Created
                                        </span>

                                        {{-- PICKUP REQUEST --}}
                                        @if(!$sr->is_pickup_requested)
                                            <a href="javascript:void(0)" 
                                                class="dropdown-item sr-action"
                                                data-url="{{ route('shiprocket.pickup', $order->id) }}"
                                                data-order-status-id="{{ $order_status_id }}"
                                                data-action-text="Pickup Request">
                                                Request For Pickup
                                            </a>
                                        @else
                                            <span class="dropdown-item disabled-dropdown text-success fw-bold">
                                                ✔ Requested For Pickup
                                            </span>
                                        @endif
                                    @endif

                                    {{-- ========================= --}}
                                    {{-- ONLY SHOW THESE IF ORDER CREATED --}}
                                    {{-- ========================= --}}
                                    @if($sr && $sr->is_order_created)

                                        {{-- AWB --}}
                                        @if($sr->is_awb_generated)
                                            <span class="dropdown-item disabled-dropdown text-success fw-bold">
                                                ✔ AWB Generated ({{ $sr->shiprocket_awb_code }})
                                            </span>
                                        @else
                                            <a href="javascript:void(0)" 
                                                class="dropdown-item sr-action"
                                                data-url="{{ route('shiprocket.generate.awb', $order->id) }}"
                                                data-order-status-id="{{ $order_status_id }}"
                                                data-action-text="Generate AWB">
                                                Generate AWB
                                            </a>
                                        @endif

                                        {{-- CANCEL ORDER --}}
                                        <a href="javascript:void(0)" 
                                            class="dropdown-item sr-action"
                                            data-url="{{ route('shiprocket.cancel.order', $order->id) }}"
                                            data-order-status-id="{{ $order_status_id }}"
                                            data-action-text="Cancel Order">
                                            Cancel Order
                                        </a>
                                        {{-- UPDATE ADDRESS --}}
                                        @if($sr->is_address_updated)
                                            <span class="dropdown-item disabled-dropdown text-success fw-bold">
                                                ✔ Address Updated
                                            </span>
                                        @else
                                            <a href="javascript:void(0)" 
                                                class="dropdown-item sr-action"
                                                data-url="{{ route('shiprocket.update.address', $order->id) }}"
                                                data-order-status-id="{{ $order_status_id }}"
                                                data-action-text="Update Address">
                                                Update Address
                                            </a>
                                        @endif
                                        {{-- PICKUP ALREADY REQUESTED --}}
                                        @if($sr->is_pickup_requested)
                                            <span class="dropdown-item disabled-dropdown text-success fw-bold">
                                                ✔ Pickup Scheduled
                                            </span>
                                        @endif
                                    @endif                                
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif

                    <a href="{{ route('download-invoice', ['orderId' => $order->id]) }}" class="btn btn-light btn-sm"
                        data-bs-toggle="tooltip" data-bs-original-title="Print Invoice">
                        <i class="ti ti-file-invoice"></i>
                    </a>
                    <a href="{{ route('order-details', ['id' => $order->id]) }}" class="btn btn-light btn-sm"
                        data-bs-toggle="tooltip" data-bs-original-title="View Order Details">
                        <i class="ti ti-eye"></i>
                    </a>

                    <form method="POST" action="{{ route('order-list.destroy', $order->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-name="{{ $order->order_id }}" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"
                        data-bs-toggle="tooltip" data-bs-original-title="Delete Order"></i></button>
                    </form>
                </div>                
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="9" class="text-center">No orders found for the selected status.</td>
        </tr>
        @endif
    </tbody>
</table>