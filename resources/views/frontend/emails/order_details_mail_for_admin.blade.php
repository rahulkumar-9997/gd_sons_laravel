<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Order Received - GDsons Admin</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:#1f9d55; padding:18px 30px; text-align:center;">
                            <span style="font-size:18px; font-weight:bold; color:#ffffff;">🛒 New Order Received — GDsons.co.in</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px; color:#333333; margin:0 0 20px 0;">
                                A new order has been placed on the website. Details below:
                            </p>

                            @php
                            $customerNameResolved = $order->customer->name ?? $customerName;
                            $customerPhone = $order->customer->phone_number ?? ($order->shippingAddress->phone_number ?? 'N/A');
                            $customerEmail = $order->customer->email ?? ($order->shippingAddress->email_id ?? 'N/A');
                            $itemsSubTotal = $order->orderLines->sum(fn($line) => $line->quantity * $line->price);
                            $shippingCharge = $order->shiprocketCourier->courier_shipping_rate ?? 0;
                            $discountAmount = $order->coupon_discount_amount ?? 0;
                            $totalPayable = $order->grand_total_amount;
                            $billing = $order->billingAddress ?? $order->shippingAddress;
                            @endphp
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:bold; color:#0d3b3e; border-bottom:1px solid #ddd; padding-bottom:6px;">Order Details</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:150px;">Order ID:</td>
                                                <td style="font-size:13px; color:#222; font-weight:bold; padding:3px 0;">{{ $order->order_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Order Date:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Order Status:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->orderStatus->status_name ?? 'New' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Payment Mode:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->payment_mode ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Payment Status:</td>
                                                <td style="font-size:13px; color:{{ $order->payment_received ? '#1f9d55' : '#c0392b' }}; font-weight:bold; padding:3px 0;">{{ $order->payment_received ? 'Paid' : 'Unpaid' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:bold; color:#0d3b3e; border-bottom:1px solid #ddd; padding-bottom:6px;">Customer Details</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:150px;">Name:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $customerNameResolved }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Phone:</td>
                                                <td style="font-size:13px; padding:3px 0;"><a href="tel:{{ $customerPhone }}" style="color:#0d3b3e; text-decoration:none;">{{ $customerPhone }}</a></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Email:</td>
                                                <td style="font-size:13px; padding:3px 0;"><a href="mailto:{{ $customerEmail }}" style="color:#0d3b3e; text-decoration:none;">{{ $customerEmail }}</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Product Table -->
                            <p style="font-size:14px; font-weight:bold; color:#0d3b3e; margin:0 0 10px 0;">Order Summary</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eeeeee; border-radius:6px; margin-bottom:20px;">
                                <tr style="background-color:#f0f0f0;">
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold;">Product</td>
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold; text-align:center;">Qty</td>
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold; text-align:right;">Amount</td>
                                </tr>

                                @foreach($order->orderLines as $orderLine)
                                <tr>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee;">{{ ucwords(strtolower($orderLine->product->title)) }}</td>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee; text-align:center;">{{ $orderLine->quantity }}</td>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee; text-align:right;">₹{{ number_format($orderLine->quantity * $orderLine->price, 2) }}</td>
                                </tr>
                                @endforeach

                            </table>

                            <!-- Price Breakdown -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                                <tr>
                                    <td style="font-size:13px; color:#777; padding:3px 0;">Sub Total</td>
                                    <td style="font-size:13px; color:#333; padding:3px 0; text-align:right;">₹{{ number_format($itemsSubTotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px; color:#777; padding:3px 0;">Discount</td>
                                    <td style="font-size:13px; color:#c0392b; padding:3px 0; text-align:right;">- ₹{{ number_format($discountAmount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px; color:#777; padding:3px 0;">Delivery Charge ({{ $order->shiprocketCourier->courier_name ?? 'N/A' }})</td>
                                    <td style="font-size:13px; color:#333; padding:3px 0; text-align:right;">₹{{ number_format($shippingCharge, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#0d3b3e; font-weight:bold; padding:10px 0 0 0; border-top:1px solid #eeeeee;">Total Payable</td>
                                    <td style="font-size:15px; color:#0d3b3e; font-weight:bold; padding:10px 0 0 0; border-top:1px solid #eeeeee; text-align:right;">₹{{ number_format($totalPayable, 2) }}</td>
                                </tr>
                            </table>

                            <!-- Payment Info (Online orders only) -->
                            @if($order->razorpay_order_id)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:bold; color:#0d3b3e; border-bottom:1px solid #ddd; padding-bottom:6px;">Payment Info</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:180px;">Razorpay Order ID:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->razorpay_order_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Razorpay Payment ID:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->razorpay_payment_id }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Shipping Address -->
                            @if($order->shippingAddress)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                                <tr>
                                    <td>
                                        <p style="font-size:14px; font-weight:bold; color:#0d3b3e; margin:0 0 8px 0;">Shipping Address</p>
                                        <p style="font-size:13px; color:#444; line-height:1.6; margin:0;">
                                            {{ $order->shippingAddress->full_name }}, {{ $order->shippingAddress->phone_number }}, {{ $order->shippingAddress->full_address }}, {{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->pin_code }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Billing Address -->
                            @if($billing)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px;">
                                <tr>
                                    <td>
                                        <p style="font-size:14px; font-weight:bold; color:#0d3b3e; margin:0 0 8px 0;">Billing Address</p>
                                        <p style="font-size:13px; color:#444; line-height:1.6; margin:0;">
                                            {{ $billing->full_name }}, {{ $billing->phone_number }}, {{ $billing->full_address }}, {{ $billing->city_name }}, {{ $billing->state }} {{ $billing->pin_code }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- CTA -->
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td align="center" style="border-radius:5px; background-color:#0d3b3e;">
                                       <a href="{{ url('/order-list') . '?order-status=1&id=' . $order->id }}"
                                        style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">
                                            View Order in Admin Panel
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f0f0f0; padding:15px 30px; text-align:center;">
                            <p style="font-size:11px; color:#999999; margin:0;">Automated notification from gdsons.co.in order system</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>