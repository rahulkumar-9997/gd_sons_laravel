@if($orders->count() > 0)
{{-- Summary Statistics --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Total Orders</p>
                <h3 class="mb-0 fw-bold">{{ $summary['total_orders'] }}</h3>
                <small class="text-success"><i class="fas fa-check-circle me-1"></i>Delivered</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Total Sales</p>
                <h3 class="mb-0 fw-bold text-success">₹{{ number_format($summary['total_order_amount'], 2) }}</h3>
                <small class="text-muted">Before Charges</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Total Charges</p>
                <h3 class="mb-0 fw-bold text-danger">₹{{ number_format($summary['total_deductions'], 2) }}</h3>
                <small class="text-muted">Discount + Shipping + Fees</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body text-center">
                <p class="text-white-50 mb-1">Net Earnings</p>
                <h3 class="mb-0 fw-bold text-white">₹{{ number_format($summary['total_net_sale'], 2) }}</h3>
                <small class="text-white-50">Final Amount</small>
            </div>
        </div>
    </div>
</div>

{{-- Quick Breakdown --}}
<div class="row g-2 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body py-2 text-center">
                <span class="text-muted">Discount: </span>
                <span class="fw-bold text-warning">₹{{ number_format($summary['total_discount'], 2) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body py-2 text-center">
                <span class="text-muted">Shipping: </span>
                <span class="fw-bold text-info">₹{{ number_format($summary['total_shipping'], 2) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body py-2 text-center">
                <span class="text-muted">Gateway Fees: </span>
                <span class="fw-bold text-danger">₹{{ number_format($summary['total_gateway_charges'], 2) }}</span>
            </div>
        </div>
    </div>
</div>
@foreach($orders as $order)
<div class="card shadow-sm border-1 mb-4">
    <div class="card-header bg-primary text-white rounded-3 p-1">
        <div class="row align-items-center">
            <div class="col-md-3">
                <p class="mb-0" style="font-size:14px;">
                    <i class="fas fa-hashtag me-1"></i>Order ID
                </p>
                <h5 class="mb-0 fw-bold">{{ $order->order_id }}</h5>
            </div>
            <div class="col-md-3">
                <p class="mb-0" style="font-size:14px;">
                    <i class="fas fa-calendar-alt me-1"></i>Date
                </p>
                <h5 class="mb-0 fw-bold">
                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                    <span style="font-size:14px;">
                        {{ \Carbon\Carbon::parse($order->order_date)->format('h:i A') }}
                    </span>
                </h5>
            </div>
            <div class="col-md-3">
                <p class="mb-0" style="font-size:14px;">
                    <i class="fas fa-credit-card me-1"></i>Payment
                </p>
                <h5 class="mb-0 fw-bold">
                    <span class="badge bg-warning text-dark">{{ $order->payment_mode }}</span>
                    
                </h5>
            </div>
            <div class="col-md-3 text-md-end">
                <p class="mb-0" style="font-size:14px;">
                    <i class="fas fa-money-bill-wave me-1"></i>Order Total
                </p>
                <h4 class="mb-0 fw-bold">₹{{ number_format($order->grand_total_amount,2) }}</h4>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover table-centered">
                <thead class="bg-light-subtle border-bottom">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->orderLines->isNotEmpty())
                    @php
                    $itemsSubTotal = $order->orderLines->sum(function ($line) {
                    return $line->quantity * $line->price;
                    });
                    $shippingCharge = (float) $order->actual_shipping_amount > 0
                    ? $order->actual_shipping_amount
                    : ($order->shiprocketCourier->courier_shipping_rate ?? 0);
                    $discountAmount = $order->coupon_discount_amount ?? 0;
                    $finalPayable = ($itemsSubTotal - $discountAmount) + $shippingCharge;
                    @endphp

                    @foreach($order->orderLines as $line)
                    @php
                    $attributes_value = 'na';
                    if($line->product && $line->product->productAttributesValues->isNotEmpty()){
                    $attributes_value = $line->product->productAttributesValues->first()->attributeValue->slug ?? 'na';
                    }
                    @endphp
                    <tr>
                        <td>
                            @php
                                $image = $line->product->images->first();
                                $imagePath = $image ? public_path('images/product/thumb/' . $image->image_path) : null;
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                    @if($image && file_exists($imagePath))
                                        <img src="{{ asset('images/product/thumb/' . $image->image_path) }}"
                                            class="avatar-md"
                                            alt="{{ $line->product->title }}">
                                    @else
                                        <div class="avatar-md d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold">
                                            {{ strtoupper(substr($line->product->title ?? 'N', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        @if($line->product)
                                        <a href="{{ url('products/'.$line->product->slug.'/'.$attributes_value) }}" target="_blank" class="text-orange fw-medium text-decoration-none">
                                            <span class="text-orange fw-medium fs-16">
                                                {{ ucwords(strtolower($line->product->title)) }}
                                            </span>
                                        </a>
                                        @endif
                                    </div>

                                    
                                </div>
                            </div>
                        </td>
                        <td>{{ $line->quantity }}</td>
                        <td>Rs. {{ number_format($line->price, 2) }}</td>
                        <td>
                            Rs. {{ number_format($line->quantity * $line->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg-light">
                        <td colspan="3" class="text-end fw-bold">
                            Items Sub Total
                        </td>
                        <td class="fw-bold">
                            Rs. {{ number_format($itemsSubTotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">
                            Discount
                            @if($order->coupon_code)
                            <br>
                            <small class="text-info">
                                Coupon : {{ $order->coupon_code }}
                            </small>
                            @endif
                        </td>
                        <td class="fw-bold text-danger">
                            - Rs. {{ number_format($discountAmount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">
                            Actual Shipping Charges
                            @if($order->shiprocketCourier)
                            <br>
                            <small class="text-info">
                                {{ $order->shiprocketCourier->courier_name }}
                            </small>
                            @endif
                        </td>
                        <td class="fw-bold">
                            Rs. {{ number_format($shippingCharge, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">
                            Payment Gateway Charges
                        </td>
                        <td class="fw-bold text-warning">
                            Rs. {{ number_format($order->payment_gateway_charges, 2) }}
                        </td>
                    </tr>
                    <tr class="table-active">
                        <td colspan="3" class="text-end fw-bold fs-16">
                            Total Payable
                        </td>
                        <td class="fw-bold fs-16 text-success">
                            Rs. {{ number_format($finalPayable, 2) }}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4" class="text-center">No order items found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach

@else
<div class="text-center py-5">
    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
    <h4>No Delivered Orders Found</h4>
    <p class="text-muted">Try changing your filters to see more orders.</p>
</div>
@endif