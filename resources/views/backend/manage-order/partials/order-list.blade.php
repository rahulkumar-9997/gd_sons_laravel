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
            <td>Rs. {{ number_format($order->grand_total_amount, 2) }}</td>
            <td>
                <span class="badge border border-success text-success  px-2 py-1 fs-13">{{ $order->payment_mode }}</span>
            </td>
            <td>
                @if($order->payment_received == 1)
                <span class="badge bg-success text-light  px-2 py-1 fs-13">Paid</span>
                @else
                <span class="badge bg-light text-dark  px-2 py-1 fs-13">Unpaid</span>
                @endif

            </td>
            <td>{{ $order->orderLines->count() }}</td>
            <td>
                <!--<span class="badge border border-secondary text-secondary px-2 py-1 fs-13">{{ $order->orderStatus->status_name }}</span>-->
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
            <td>
                <div class="d-flex gap-2">
                    @if($order->payment_mode !== 'Pick Up From Store')
                        @include('backend.manage-order.partials.shiprocket-actions')
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
            <td colspan="8" class="text-center">No orders found for the selected status.</td>
        </tr>
        @endif
    </tbody>
</table>