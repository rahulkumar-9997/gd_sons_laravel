<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Enquiry Received - G.D. Sons</title>
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
                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:16px; color:#222222; margin:0 0 15px 0;">Hi {{ $enquiry->name ?: 'there' }},</p>
                            <p style="font-size:15px; color:#444444; line-height:1.6; margin:0 0 20px 0;">
                                Thank you for your enquiry! We've received your request and our team will get back to you <strong>within 12 hours</strong>.
                            </p>
                            <!-- Product Card -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px; width:90px;">
                                        <img src="{{ $productImage }}" width="80" height="80" alt="{{ $product->title }}" style="border-radius:4px; display:block;">
                                    </td>
                                    <td style="padding:15px 15px 15px 0;">
                                        <p style="margin:0 0 5px 0; font-size:15px; font-weight:bold; color:#0d3b3e;">{{ ucwords(strtolower($product->title)) }}</p>
                                        <p style="margin:0; font-size:14px; color:#1f9d55; font-weight:bold;">Rs. {{ number_format($enquiry->product_price, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                            <!-- Enquiry Details -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px;">
                                <tr>
                                    <td style="font-size:13px; color:#777777; padding:4px 0;">Enquiry ID:</td>
                                    <td style="font-size:13px; color:#333333; padding:4px 0; text-align:right;">#{{ $enquiry->id }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px; color:#777777; padding:4px 0;">Date:</td>
                                    <td style="font-size:13px; color:#333333; padding:4px 0; text-align:right;">{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px; color:#777777; padding:4px 0;">Phone Number:</td>
                                    <td style="font-size:13px; color:#333333; padding:4px 0; text-align:right;">{{ $enquiry->phone_number }}</td>
                                </tr>
                            </table>
                            <!-- CTA -->
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto 10px auto;">
                                <tr>
                                    <td align="center" style="border-radius:5px; background-color:#0d3b3e;">
                                        <a href="{{ $enquiry->current_page_url }}" style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">View Product</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size:13px; color:#888888; text-align:center; margin:20px 0 0 0;">
                                Need it faster? Call us directly or reply on WhatsApp.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f0f0f0; padding:20px 30px; text-align:center;">
                            <p style="font-size:12px; color:#888888; margin:0 0 6px 0;">G.D. Sons | <a href="https://www.gdsons.co.in" style="color:#888888;">www.gdsons.co.in</a></p>
                            <p style="font-size:12px; color:#888888; margin:0;">Support: +91 - 8318894257 &nbsp;|&nbsp; support@gdsons.co.in</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>