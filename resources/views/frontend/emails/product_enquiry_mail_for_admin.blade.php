<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Enquiry Received - GDsons Admin</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#1f9d55; padding:18px 30px; text-align:center;">
                            <span style="font-size:18px; font-weight:bold; color:#ffffff;">🔔 New Product Enquiry — GDsons.co.in</span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px; color:#333333; margin:0 0 20px 0;">
                                A new enquiry has been submitted on the website. Details below:
                            </p>

                            <!-- Customer Details -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:bold; color:#0d3b3e; border-bottom:1px solid #ddd; padding-bottom:6px;">Customer Details</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:130px;">Name:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $enquiry->name ?: 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Phone:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;"><a href="tel:{{ $enquiry->phone_number }}" style="color:#0d3b3e; text-decoration:none;">{{ $enquiry->phone_number }}</a></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Email:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;"><a href="mailto:{{ $enquiry->email }}" style="color:#0d3b3e; text-decoration:none;">{{ $enquiry->email }}</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Enquiry Details -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8f8; border-radius:6px; margin-bottom:25px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 10px 0; font-size:14px; font-weight:bold; color:#0d3b3e; border-bottom:1px solid #ddd; padding-bottom:6px;">Product / Enquiry Info</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0; width:130px;">Product:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ ucwords(strtolower($product->title)) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Price:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">Rs. {{ number_format($enquiry->product_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Product URL:</td>
                                                <td style="font-size:13px; padding:3px 0;"><a href="{{ $enquiry->current_page_url }}" style="color:#0d3b3e;">{{ $enquiry->current_page_url }}</a></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Enquiry ID:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">#{{ $enquiry->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:13px; color:#777; padding:3px 0;">Date/Time:</td>
                                                <td style="font-size:13px; color:#222; padding:3px 0;">{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA -->
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td align="center" style="border-radius:5px; background-color:#0d3b3e;">
                                        <a href="tel:{{ $enquiry->phone_number }}" style="display:inline-block; padding:12px 28px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">Call Customer Now</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:12px; color:#c0392b; text-align:center; margin:20px 0 0 0; font-weight:bold;">
                                ⏱ Respond within 12 hours as promised to the customer.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f0f0f0; padding:15px 30px; text-align:center;">
                            <p style="font-size:11px; color:#999999; margin:0;">Automated notification from gdsons.co.in enquiry system</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>