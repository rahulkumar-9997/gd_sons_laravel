
@if($orders->count() > 0)
<div class="row g-3 mb-2">
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 p-3 text-center" style="background:#E6F1FB;
            border:1px solid #85B7EB !important">
            <i class="fas fa-box-open fs-4 text-secondary mb-2"></i>
            <small class="text-muted d-block">Total orders</small>
            <h4 class="mb-0 fw-semibold">{{ $summary['total_orders'] }}</h4>
            <small class="text-muted">Delivered</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 p-3 text-center" style="background:#E6F1FB;
            border:1px solid #85B7EB !important">
            <i class="fas fa-receipt fs-4 text-secondary mb-2"></i>
            <small class="text-muted d-block">Total sales</small>
            <h4 class="mb-0 fw-semibold text-success">₹{{ number_format($summary['total_order_amount'], 2) }}</h4>
            <small class="text-muted">Money received from buyers</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 p-3 text-center" style="background:#E6F1FB;
             border:1px solid #85B7EB !important">
            <i class="fas fa-arrow-down fs-4 text-secondary mb-2"></i>
            <small class="text-muted d-block">Total charges</small>
            <h4 class="mb-0 fw-semibold text-danger">
                ₹{{ number_format($summary['total_deductions'], 2) }}
            </h4>
            <small class="text-muted">Cost + discount + shipping + fees</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 p-3 text-center"
             style="background:{{ $summary['total_profit'] >= 0 ? '#E6F1FB' : '#FCEBEB' }};
                    border:1px solid {{ $summary['total_profit'] >= 0 ? '#85B7EB' : '#F09595' }} !important">
            <i class="fas fa-wallet fs-4 mb-2"
               style="color:{{ $summary['total_profit'] >= 0 ? '#185FA5' : '#A32D2D' }}"></i>
            <small class="d-block"
                   style="color:{{ $summary['total_profit'] >= 0 ? '#185FA5' : '#A32D2D' }}">Net profit</small>
            <h4 class="mb-0 fw-semibold"
                style="color:{{ $summary['total_profit'] >= 0 ? '#0C447C' : '#791F1F' }}">
                {{ $summary['total_profit'] >= 0 ? '' : '−' }}₹{{ number_format(abs($summary['total_profit']), 2) }}
            </h4>
            <small style="color:{{ $summary['total_profit'] >= 0 ? '#185FA5' : '#A32D2D' }}">
                {{ number_format(abs($summary['profit_percentage']), 1) }}%
                {{ $summary['total_profit'] >= 0 ? 'return on cost' : 'loss on cost' }}
            </small>
        </div>
    </div>

</div>

@foreach($orders as $order)
    @php
    $purchaseCost = 0;
    foreach ($order->orderLines as $line) {
        $purchaseCost += ($line->product->inventories->first()->purchase_rate ?? 0) * $line->quantity;
    }

    $actual_shipping_amount = (float) $order->actual_shipping_amount > 0
    ? $order->actual_shipping_amount
    : ($order->shiprocketCourier->courier_shipping_rate ?? 0);
    $shipping_charge_when_customer_order = $order->shiprocketCourier->courier_shipping_rate ?? 0;
    $discountAmount = $order->coupon_discount_amount ?? 0;
    $gatewayCharges = $order->payment_gateway_charges ?? 0;
    $smsCharge = $order->sms_charges ?? 0;
    $totalDeductions = $purchaseCost + $discountAmount + $actual_shipping_amount + $gatewayCharges + $smsCharge;
    $profit = $order->grand_total_amount - $totalDeductions;
    $profitPercent = $purchaseCost > 0 ? ($profit / $purchaseCost) * 100 : 0;
    $isProfit = $profit >= 0;
@endphp

<div class="card border rounded-3 mb-3 overflow-hidden shadow-sm">
    <div class="card-header bg-light border-bottom px-3 py-1">
        <div class="row align-items-center g-2">
            <div class="col-6 col-md-3">
                <small class="text-muted d-block" style="font-size:11px;letter-spacing:.3px">Order ID</small>
                <a href="{{ route('order-details', ['id' => $order->id]) }}" target="_blank" class="badge bg-success text-light mt-1"><strong class="fs-6">#{{ $order->order_id }} </strong>
                 <i class="ti ti-eye"></i>
                </a> 
            </div>
            <div class="col-6 col-md-3">
                <small class="text-muted d-block" style="font-size:11px;letter-spacing:.3px">Order date</small>
                <strong style="font-size:13px">
                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y · h:i A') }}
                </strong>
            </div>
            <div class="col-6 col-md-3">
                <small class="text-muted d-block" style="font-size:11px;letter-spacing:.3px">Payment mode</small>
                <span class="badge rounded-pill" style="background:#FCEBEB;color:#791F1F;font-size:11px">
                    {{ $order->payment_mode }}
                </span>
            </div>
            <div class="col-6 col-md-3 text-end">
                <small class="text-muted d-block" style="font-size:11px;letter-spacing:.3px">Order total+Shipping Charges</small>
                <strong class="fs-5">₹{{ number_format($order->grand_total_amount, 2) }}</strong>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="d-flex align-items-center justify-content-between px-3 py-1 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">Money received from customer</div>
                    <small class="text-muted">Amount paid by the buyer</small>
                </div>
            </div>
            <span class="fw-semibold" style="color:#27500A;font-size:13px">
                ₹{{ number_format($order->grand_total_amount, 2) }}
            </span>
        </div>
        <div class="d-flex align-items-center justify-content-between px-3 py-0.5 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">Product purchase cost</div>
                    <small class="text-muted">What we paid to buy the items</small>
                </div>
            </div>
            <span class="fw-semibold text-info" style="font-size:13px">
                ₹{{ number_format($purchaseCost, 2) }}
            </span>
        </div>
        @if($discountAmount > 0)
        <div class="d-flex align-items-center justify-content-between px-3 py-1 border-bottom">
            <div class="d-flex align-items-center gap-2">
               
                <div>
                    <div class="fw-semibold" style="font-size:13px">Discount given to customer</div>
                    <small class="text-muted">
                        @if($order->coupon_code)
                        Coupon applied: {{ $order->coupon_code }}
                        @else
                        Discount applied on order
                        @endif
                    </small>
                </div>
            </div>
            <span class="fw-semibold text-warning" style="font-size:13px">
                −₹{{ number_format($discountAmount, 2) }}
            </span>
        </div>
        @endif
        <div class="d-flex align-items-center justify-content-between px-3 py-1 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">Shipping Charge When customer Order</div>
                    <small class="text-muted">
                        @if($order->shiprocketCourier)
                        Courier: {{ $order->shiprocketCourier->courier_name }}
                        @else
                        Delivery charge paid to courier
                        @endif
                    </small>
                </div>
            </div>
            <span class="fw-semibold" style="color:#27500A;font-size:13px">
                ₹{{ number_format($shipping_charge_when_customer_order, 2) }}
            </span>
        </div>
        <div class="d-flex align-items-center justify-content-between px-3 py-1 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">Actual Shipping Charges</div>
                </div>
            </div>
            <span class="fw-semibold" style="color:#27500A;font-size:13px">
                ₹{{ number_format($actual_shipping_amount, 2) }}
            </span>
        </div>
        @if($gatewayCharges > 0)
        <div class="d-flex align-items-center justify-content-between px-3 py-1 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">Payment gateway fee</div>
                    <small class="text-muted">Razorpay transaction charge</small>
                </div>
            </div>
            <span class="fw-semibold text-danger" style="font-size:13px">
                {{ number_format($gatewayCharges, 2) }}
            </span>
        </div>
        @endif
        <div class="d-flex align-items-center justify-content-between px-3 py-1">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <div class="fw-semibold" style="font-size:13px">SMS notification charge</div>
                    <small class="text-muted">Order status message sent to buyer</small>
                </div>
            </div>
            <span class="fw-semibold text-danger" style="font-size:13px">−₹{{ number_format($smsCharge, 2) }}</span>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center px-3 py-1 border-top border-bottom bg-light">
        <span class="text-muted" style="font-size:12px;font-weight:500">
            <i class="fas fa-calculator me-1"></i> Total amount deducted
        </span>
        <span class="fw-semibold text-danger" style="font-size:13px">
            −₹{{ number_format($totalDeductions, 2) }}
        </span>
    </div>
    <div class="d-flex align-items-center justify-content-between px-3 py-1
                {{ $isProfit ? '' : '' }}"
        style="background:{{ $isProfit ? '#EAF3DE' : '#FCEBEB' }}">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:38px;height:38px;background:{{ $isProfit ? '#C0DD97' : '#F7C1C1' }}">
                <i class="fas {{ $isProfit ? 'fa-trending-up' : 'fa-trending-down' }}"
                    style="color:{{ $isProfit ? '#27500A' : '#791F1F' }};font-size:16px"></i>
            </div>
            <div>
                <div class="fw-semibold" style="color:{{ $isProfit ? '#27500A' : '#791F1F' }};font-size:14px">
                    {{ $isProfit ? 'You earned a profit on this order' : 'You made a loss on this order' }}
                </div>
                <small style="color:{{ $isProfit ? '#3B6D11' : '#A32D2D' }}">
                    {{ $isProfit ? 'Great! Keep it up' : 'Review your pricing and shipping costs' }}
                </small>
            </div>
        </div>
        <div class="text-end">
            <div class="fw-bold" style="color:{{ $isProfit ? '#27500A' : '#791F1F' }};font-size:18px">
                {{ $isProfit ? '+' : '−' }}₹{{ number_format(abs($profit), 2) }}
            </div>
            <small style="color:{{ $isProfit ? '#3B6D11' : '#A32D2D' }}">
                {{ number_format(abs($profitPercent), 1) }}% {{ $isProfit ? 'return on cost' : 'loss on cost' }}
            </small>
        </div>
    </div>
    <details>
        <summary class="px-3 py-1 border-top text-primary"
            style="cursor:pointer;list-style:none;font-size:13px">
            <i class="fas fa-chevron-down me-1" style="font-size:12px"></i>
            View products in this order ({{ $order->orderLines->count() }} {{ Str::plural('item', $order->orderLines->count()) }})
        </summary>
        <div class="table-responsive">
            <table class="table table-sm mb-0" style="font-size:12px">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Product name</th>
                        <th class="text-center" style="width:60px">Qty</th>
                        <th class="text-end">We sold at</th>
                        <th class="text-end">We bought at</th>
                        <th class="text-end pe-3">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderLines as $line)
                    @php
                    $rate = $line->product->inventories->first()->purchase_rate ?? 0;
                    $lineProfit = ($line->price - $rate) * $line->quantity;
                    $image = $line->product->images->first();
                    $imagePath = $image ? public_path('images/product/thumb/' . $image->image_path) : null;
                    @endphp
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                @if($image && file_exists($imagePath))
                                <img src="{{ asset('images/product/thumb/' . $image->image_path) }}"
                                    width="26" height="26" class="rounded-2 object-fit-cover flex-shrink-0"
                                    alt="{{ $line->product->title }}">
                                @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center fw-semibold flex-shrink-0"
                                    style="width:26px;height:26px;background:#E6F1FB;color:#0C447C;font-size:10px">
                                    {{ strtoupper(substr($line->product->title ?? 'N', 0, 1)) }}
                                </div>
                                @endif
                                <span>{{ ucwords(strtolower($line->product->title ?? 'N/A')) }}</span>
                            </div>
                        </td>
                        <td class="text-center align-middle">{{ $line->quantity }}</td>
                        <td class="text-end align-middle">₹{{ number_format($line->price, 2) }}</td>
                        <td class="text-end align-middle">₹{{ number_format($rate, 2) }}</td>
                        <td class="text-end align-middle pe-3 fw-semibold"
                            style="color:{{ $lineProfit >= 0 ? '#27500A' : '#A32D2D' }}">
                            {{ $lineProfit >= 0 ? '+' : '−' }}₹{{ number_format(abs($lineProfit), 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </details>
</div>
@endforeach
@if($orders->count())
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }}
            of {{ $orders->total() }} orders
        </div>

        <div class="my-pagination" id="pagination-link-order-list">
            {{ $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endif
@else
<div class="text-center py-5">
    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle"
        style="width:64px;height:64px;background:#EAF3DE">
        <i class="fas fa-box-open fs-3" style="color:#3B6D11"></i>
    </div>
    <h5 class="fw-semibold">No delivered orders found</h5>
    <p class="text-muted">Try adjusting your date range or filters to see results.</p>
</div>
@endif