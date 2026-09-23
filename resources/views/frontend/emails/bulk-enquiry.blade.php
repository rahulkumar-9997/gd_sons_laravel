<!DOCTYPE html>
<html>

<body style="margin:0;padding:24px;background:#f4f7f7;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;">
        <tr>
            <td style="background:#0b2545;padding:20px 24px;">
                <h2 style="margin:0;color:#ffffff;font-size:20px;">New Bulk Order Enquiry</h2>
                <p style="margin:4px 0 0;color:#cfe3e3;font-size:13px;">Received {{ $data['submitted_at'] }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                @php
                $rows = [
                'Contact person' => $data['name'],
                'Phone' => $data['phone'],
                'Email' => $data['email'],
                'Location' => $data['location'],
                'Budget' => '₹' . number_format($data['budget']),
                'Quantity' => $data['quantity'],
                'Delivery date' => $data['delivery_date_text'] ?? '—',
                'Gift wrapped' => $data['gift_wrapped'] ?? '—',
                ];
                @endphp
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
                    @foreach ($rows as $label => $value)
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;width:40%;border-bottom:1px solid #eef2f2;">{{ $label }}</td>
                        <td style="padding:8px 0;color:#111827;font-weight:bold;border-bottom:1px solid #eef2f2;">{{ $value }}</td>
                    </tr>
                    @endforeach
                </table>

                <p style="margin:20px 0 6px;color:#6b7280;font-size:13px;">Requirement</p>
                <div style="background:#f4f7f7;border-radius:8px;padding:14px;font-size:14px;color:#111827;line-height:1.6;">
                    {!! nl2br(e($data['requirement'])) !!}
                </div>

                <p style="margin:24px 0 0;">
                    <a href="https://wa.me/91{{ $data['phone'] }}"
                        style="display:inline-block;background:#25D366;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:bold;">
                        WhatsApp {{ $data['name'] }}
                    </a>
                </p>
                <p style="margin:16px 0 0;color:#9ca3af;font-size:11px;">IP: {{ $data['ip_address'] }}</p>
            </td>
        </tr>
    </table>
</body>

</html>