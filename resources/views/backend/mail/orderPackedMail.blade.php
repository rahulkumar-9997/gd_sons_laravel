<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Packed - G.D. Sons</title>
</head>
@php
    $customerName = $order->shippingAddress->full_name ?? optional($order->customer)->name ?? 'Customer';
@endphp
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
                        <td style="background-color:#f39c12; padding:14px 30px; text-align:center;">
                            <span style="font-size:15px; font-weight:bold; color:#ffffff;">📦 Your Order Has Been Packed!</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:16px; color:#222222; margin:0 0 10px 0;">Hi {{$customerName}},</p>
                            <p style="font-size:15px; color:#444444; line-height:1.6; margin:0 0 20px 0;">
                                Good news! Your order <strong>{{ $order->order_id }}</strong> has been packed and is ready to ship. It'll be handed over to our courier partner shortly.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:10px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:120px;">Order ID:</td>
                                                <td style="font-size:13px; color:#222; font-weight:bold; padding:3px 0;">{{ $order->order_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Status:</td>
                                                <td style="font-size:13px; color:#f39c12; font-weight:bold; padding:3px 0;">Packed</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size:13px; color:#888888; margin:20px 0 0 0;">
                                We'll notify you again once it's shipped with tracking details.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f0f0f0; padding:20px 30px; text-align:center;">
                            <p style="font-size:12px; color:#888888; margin:0 0 6px 0;">G.D. Sons | www.gdsons.co.in</p>
                            <p style="font-size:12px; color:#888888; margin:0;">Support: +91 - 8318894257 &nbsp;|&nbsp; support@gdsons.co.in</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>