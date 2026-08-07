<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Shipped - G.D. Sons</title>
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
                        <td style="background-color:#2e86de; padding:14px 30px; text-align:center;">
                            <span style="font-size:15px; font-weight:bold; color:#ffffff;">🚚 Your Order Has Been Shipped!</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            @php
                            $customerName = $order->shippingAddress->full_name ?? optional($order->customer)->name ?? 'Customer';
                            $itemsSubTotal = $order->orderLines->sum(fn($line) => $line->quantity * $line->price);
                            $discountAmount = $order->coupon_discount_amount ?? 0;
                            @endphp
                            <p style="font-size:16px; color:#222222; margin:0 0 10px 0;">Hi {{ $customerName }},</p>
                            <p style="font-size:15px; color:#444444; line-height:1.6; margin:0 0 20px 0;">
                                Your order <strong>{{ $order->order_id }}</strong> is on its way!
                            </p>
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

                                <!-- Order Summary rows appended right after items -->
                                <tr>
                                    <td colspan="2" style="font-size:13px; color:#777; padding:8px 12px; border-top:1px solid #eeeeee; text-align:right;">Sub Total</td>
                                    <td style="font-size:13px; color:#333; padding:8px 12px; border-top:1px solid #eeeeee; text-align:right;">₹{{ number_format($itemsSubTotal, 2) }}</td>
                                </tr>
                                @if($discountAmount > 0)
                                <tr>
                                    <td colspan="2" style="font-size:13px; color:#777; padding:8px 12px; text-align:right;">
                                        Discount
                                        @if($order->coupon_code)
                                        <br><span style="font-size:11px;color:#1f9d55;">Coupon: {{ $order->coupon_code }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size:13px; color:#c0392b; padding:8px 12px; text-align:right;">- ₹{{ number_format($discountAmount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2" style="font-size:15px; color:#0d3b3e; font-weight:bold; padding:10px 12px; border-top:1px solid #eeeeee; text-align:right;">Grand Total</td>
                                    <td style="font-size:15px; color:#0d3b3e; font-weight:bold; padding:10px 12px; border-top:1px solid #eeeeee; text-align:right;">₹{{ number_format($order->grand_total_amount, 2) }}</td>
                                </tr>
                            </table>
                            @if($order->tracking_link)
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td align="center" style="border-radius:5px; background-color:#0d3b3e;">
                                        <a href="{{ $order->tracking_link }}" style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">Track Your Order</a>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f0f0f0; padding:20px 30px; text-align:center;">
                            <p style="font-size:12px; color:#888888; margin:0 0 6px 0;">G.D. Sons | <a href="https://www.gdsons.co.in" style="color:#888888;">www.gdsons.co.in</a></p>
                            <p style="font-size:12px; color:#888888; margin:0;">Support: +91 83188 94257 &nbsp;|&nbsp; support@gdsons.co.in</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>