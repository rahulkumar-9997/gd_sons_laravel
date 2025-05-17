<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment Failed for Order #{{ $order->order_id }}</title>
    <style type="text/css">
        /* Base styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.5;
            color: #333333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Email container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }
        
        /* Header */
        .header {
            color: #d9534f;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eeeeee;
        }
        
        /* Content */
        .content {
            margin-bottom: 30px;
        }
        
        /* Details */
        .detail-box {
            background-color: #f9f9f9;
            border-left: 4px solid #d9534f;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .detail {
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
            color: #555555;
        }
        
        /* Button */
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #d9534f;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #999999;
            border-top: 1px solid #eeeeee;
            padding-top: 15px;
        }
        
        /* Responsive */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .detail-label {
                width: 100px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">Payment Failed for Order #{{ $order->order_id }}</div>
        
        <div class="content">
            <p>Dear {{ $customerName ?? 'Customer' }},</p>
            
            <div class="detail-box">
                <p>We were unable to process your payment for the following order:</p>
                
                <div class="detail">
                    <span class="detail-label">Order Number:</span>
                    <span>#{{ $order->order_id }}</span>
                </div>
                
                <div class="detail">
                    <span class="detail-label">Date:</span>
                    <span>{{ $order->order_date->format('F j, Y') }}</span>
                </div>
                
                <div class="detail">
                    <span class="detail-label">Amount:</span>
                    <span>₹{{ number_format($order->grand_total_amount, 2) }}</span>
                </div>
                
                <div class="detail">
                    <span class="detail-label">Payment Method:</span>
                    <span>{{ $order->payment_mode }}</span>
                </div>
                
                <div class="detail">
                    <span class="detail-label">Reason:</span>
                    <span>{{ $reason ?? 'Payment processing failed' }}</span>
                </div>
            </div>
            
            <p>Please try placing your order again:</p>
            <a href="{{ route('checkout') }}" class="button">Retry Payment</a>
            
            
        </div>
        
        
    </div>
</body>
</html>