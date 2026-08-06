<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmed - G.D. Sons</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:#0d3b3e; padding:22px 30px; text-align:center;">
                            <span style="font-size:24px; font-weight:bold; color:#ffffff; font-family:Georgia, serif;">Girdhar Das &amp; Sons</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#1f9d55; padding:14px 30px; text-align:center;">
                            <span style="font-size:15px; font-weight:bold; color:#ffffff;">✅ Your Order is Confirmed!</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            @php
                            $customerName = $order->shippingAddress->full_name ?? optional($order->customer)->name ?? 'Customer';
                            $itemsSubTotal = $order->orderLines->sum(fn($line) => $line->quantity * $line->price);
                            $shippingCharge = $order->shiprocketCourier->courier_shipping_rate ?? 0;
                            $discountAmount = $order->coupon_discount_amount ?? 0;
                            $totalPayable = $order->grand_total_amount;
                            @endphp
                            <p style="font-size:16px; color:#222222; margin:0 0 10px 0;">Hi {{ $customerName }},</p>
                            <p style="font-size:15px; color:#444444; line-height:1.6; margin:0 0 20px 0;">
                                Thank you for shopping with us! We've received your order and it's now being processed.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px;">
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
                                                <td style="font-size:13px; color:#1f9d55; font-weight:bold; padding:3px 0;">{{ $order->orderStatus->status_name ?? 'New' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Payment Mode:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->payment_mode ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Payment Status:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $order->payment_received ? 'Paid' : 'Pending' }}</td>
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
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px;">
                                <tr>
                                    <td>
                                        <p style="font-size:14px; font-weight:bold; color:#0d3b3e; margin:0 0 8px 0;">Shipping Address</p>
                                        <p style="font-size:13px; color:#444; line-height:1.6; margin:0;">
                                            @if($order->shippingAddress)
                                            {{ $order->shippingAddress->full_name }}, {{ $order->shippingAddress->phone_number }}, {{ $order->shippingAddress->full_address }}, {{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->pin_code }}
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f0f0f0; padding:20px 30px; text-align:center;">
                            <p style="font-size:12px; color:#888888; margin:0 0 6px 0;">G.D. Sons | www.gdsons.co.in</p>
                            <p style="font-size:12px; color:#888888; margin:0;">Support: +91 - 8318894257 &nbsp;|&nbsp; gdsons.vns@gmail.com</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>