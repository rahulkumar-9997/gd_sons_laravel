<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Delivered - G.D. Sons</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0d3b3e; padding:22px 30px; text-align:center;">
                            <span style="font-size:24px; font-weight:bold; color:#ffffff; font-family:Georgia, serif;">Girdhar Das &amp; Sons</span>
                        </td>
                    </tr>
                    <!-- Status Banner -->
                    <tr>
                        <td style="background-color:#1f9d55; padding:14px 30px; text-align:center;">
                            <span style="font-size:15px; font-weight:bold; color:#ffffff;">✅ Your Order Has Been Delivered!</span>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            @php
                            $customerName = $order->shippingAddress->full_name ?? optional($order->customer)->name ?? 'Customer';  
                            $shopUrl = url('/');
                            $gmbReviewUrl = 'https://g.page/r/CYdyYgptq7c5EBM/review';
                            $itemsSubTotal = $order->orderLines->sum(fn($line) => $line->quantity * $line->price);
                            $discountAmount = $order->coupon_discount_amount ?? 0;
                            @endphp
                            <p style="font-size:16px; color:#222222; margin:0 0 10px 0;">Hi {{ $customerName }},</p>
                            <p style="font-size:15px; color:#444444; line-height:1.6; margin:0 0 25px 0;">
                                Your order <strong>{{ $order->order_id }}</strong> has been delivered. We hope you love it! As a small business, your feedback means a lot to us.
                            </p>
                            <p style="font-size:14px; font-weight:bold; color:#0d3b3e; margin:0 0 10px 0;">Items Delivered</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eeeeee; border-radius:6px; margin-bottom:25px;">
                                <tr style="background-color:#f0f0f0;">
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold;">Product</td>
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold; text-align:center;">Qty</td>
                                    <td style="font-size:12px; color:#777; padding:10px 12px; font-weight:bold; text-align:right;">Amount</td>
                                </tr>
                                @foreach($order->orderLines as $orderLine)
                                @php
                                $attributesValue = 'na';
                                if ($orderLine->product->ProductAttributesValues->isNotEmpty()) {
                                $attributesValue = $orderLine->product->ProductAttributesValues->first()->attributeValue->slug;
                                }
                                $productUrl = url('products/' . $orderLine->product->slug . '/' . $attributesValue);
                                
                                @endphp
                                <tr>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee;">
                                        <a href="{{ $productUrl }}" style="color:#0d3b3e; text-decoration:none; font-weight:600;">{{ ucwords(strtolower($orderLine->product->title)) }}</a>
                                        <br><a href="{{ $gmbReviewUrl }}#reviewssection" style="font-size:11px; color:#f39c12; text-decoration:none;">★ Write a GMB Review</a>
                                    </td>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee; text-align:center;">{{ $orderLine->quantity }}</td>
                                    <td style="font-size:13px; color:#222; padding:10px 12px; border-top:1px solid #eeeeee; text-align:right;">Rs. {{ number_format($orderLine->quantity * $orderLine->price, 2) }}</td>
                                </tr>
                                @endforeach
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
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fff8e1; border-radius:6px; margin-bottom:25px;">
                                <tr>
                                    <td style="padding:20px; text-align:center;">
                                        <p style="margin:0 0 12px 0; font-size:14px; color:#333333;">Loved your purchase? A quick review helps us grow!</p>
                                        <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                            <tr>
                                                <td align="center" style="border-radius:5px; background-color:#f39c12;">
                                                    <a href="{{ $gmbReviewUrl }}" style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">Leave us a Review</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @if($coupon)
                            @php
                            $discountLabel = $coupon->mode === 'Percentage'
                            ? $coupon->discount_value . '%'
                            : 'Rs. ' . number_format($coupon->discount_value, 2);
                            $expiryFormatted = $coupon->valid_till
                            ? \Carbon\Carbon::parse($coupon->valid_till)->format('d M Y')
                            : null;
                            @endphp
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0d3b3e; border-radius:8px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:25px; text-align:center;">
                                        <p style="margin:0 0 8px 0; font-size:13px; color:#c8e6c9; text-transform:uppercase; letter-spacing:1px;">A Thank You Gift For You</p>
                                        <p style="margin:0 0 15px 0; font-size:14px; color:#ffffff;">Use this code on your next order</p>
                                        <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto 15px auto; background-color:#ffffff; border-radius:6px; border:2px dashed #1f9d55;">
                                            <tr>
                                                <td style="padding:14px 30px;">
                                                    <span style="font-size:22px; font-weight:bold; color:#0d3b3e; letter-spacing:2px;">{{ $coupon->discount_code }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <p style="margin:0; font-size:13px; color:#ffffff;">Get <strong>{{ $discountLabel }}</strong> off your next purchase</p>
                                        <p style="margin:5px 0 0 0; font-size:12px; color:#c8e6c9;">
                                            @if($coupon->minimum_order_value > 0)
                                            Min order Rs. {{ number_format($coupon->minimum_order_value, 2) }} &nbsp;•&nbsp;
                                            @endif
                                            @if($expiryFormatted)
                                            Expires {{ $expiryFormatted }}
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td align="center" style="border-radius:5px; background-color:#1f9d55;">
                                        <a href="{{ $shopUrl }}" style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">Shop Again</a>
                                    </td>
                                </tr>
                            </table>
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