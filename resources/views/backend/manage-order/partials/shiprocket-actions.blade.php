@php
$sr = $order->shiprocketOrderResponse;
@endphp

@if(!$sr || !$sr->shiprocket_order_id)
    {{-- NOT CREATED --}}
    <button class="btn btn-sm btn-info sr-create-order"
        data-bs-toggle="tooltip" data-bs-original-title="Create Shiprocket Order"
        data-url="{{ route('shiprocket.create.order', $order->id) }}"
        data-order-status-id="{{ $order_status_id }}">
        Create Order
    </button>
@else
    <div class="d-flex flex-wrap gap-1">
        <button class="btn btn-sm btn-warning sr-update-order"
            data-bs-toggle="tooltip" data-bs-original-title="Update Shiprocket Order"
            data-url="{{ route('shiprocket.update.order', $order->id) }}"
            data-order-status-id="{{ $order_status_id }}">
            Update Order
        </button>
        <button class="btn btn-sm btn-danger sr-cancel-order"
            data-bs-toggle="tooltip" data-bs-original-title="Cancel Shiprocket Order"
            data-url="{{ route('shiprocket.cancel.order', $order->id) }}"
            data-order-status-id="{{ $order_status_id }}">
            Cancel Order
        </button>

        <button class="btn btn-sm btn-info sr-update-address"
            data-bs-toggle="tooltip" data-bs-original-title="Update Shipping Address"
            data-url="{{ route('shiprocket.update.address', $order->id) }}"
            data-order-status-id="{{ $order_status_id }}">
            Update Address
        </button>

        @if(!$sr->shiprocket_awb_code)
        <button class="btn btn-sm btn-secondary sr-generate-awb"
            data-bs-toggle="tooltip" data-bs-original-title="Generate AWB"
            data-url="{{ route('shiprocket.generate.awb', $order->id) }}"
            data-order-status-id="{{ $order_status_id }}">
            Generate AWB
        </button>
        @endif

        @if($sr->shiprocket_awb_code && !$order->pickup_scheduled)
        <button class="btn btn-sm btn-success sr-pickup"
            data-bs-toggle="tooltip" data-bs-original-title="Schedule Pickup"
            data-url="{{ route('shiprocket.pickup', $order->id) }}"
            data-order-status-id="{{ $order_status_id }}">
            Pickup Request
        </button>
        @endif

        @if($order->pickup_scheduled)
        <span class="badge bg-success"
        data-bs-toggle="tooltip" data-bs-original-title="Pickup Scheduled"
        >Pickup Scheduled</span>
        @endif
    </div>
@endif
