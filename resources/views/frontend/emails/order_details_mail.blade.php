
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title>Order Success</title>

    <!-- Google Font css -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 650px;
            font-family: 'Public Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        h5 {
            margin: 10px;
            color: #777;
        }

        .text-center {
            text-align: center
        }

        .main-bg-light {
            background-color: #fafafa;
        }

        .header-menu ul li a {
            font-size: 14px;
            color: #252525;
            font-weight: 500;
        }

        .product-table tbody tr td img {
            /* width: 86%; */
            margin-right: 26px;
        }

        .product-table tbody tr td .product-detail {
            text-align: left;
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .product-table tbody tr td .product-detail li {
            display: block;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            white-space: nowrap;
        }

        .product-table tbody tr td .product-detail li span {
            color: #939393;
        }

        .order-table {
            background-image: url(images/order-poster.jpg);
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 5px;
            overflow: hidden;
            padding: 18px 27px;
            margin-top: 40px;
        }

        .footer-table {
            position: relative;
            margin-top: 34px;
        }

        .footer-table::before {
            position: absolute;
            content: "";
            background-image: url(images/footer-left.svg);
            background-position: top right;
            top: 0;
            left: -71%;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }

        .footer-table::after {
            position: absolute;
            content: "";
            background-image: url(images/footer-right.svg);
            background-position: top right;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }
    </style>
</head>

<body style="margin: 20px auto;">
    <div style="margin: 0; padding: 0 !important;  color: rgba(0,0,0,.4); line-height: 1.8; font-family: 'Playfair Display', serif;  font-weight: 400; font-size: 15px;">
        <center style="width: 100%; background-color: #f1f1f1;">
            <table align="center" border="0" cellpadding="0" cellspacing="0"
                style="background-color: #fff; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);-webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353); width: 500px;">
                <tbody>
                    <tr>
                        <td>
                            <table class="header-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr class="header"
                                    style="background-color: #f7f7f7;display: flex;align-items: center;justify-content: center;width: 100%;">
                                    <td class="header-logo" style="padding: 10px 32px;">
                                        <a href="{{URL::to('')}}" style="display: block; text-align: center;">
                                            <img src="{{asset('frontend/assets/gd-img/footer-img/gd-footer-logo.png')}}" class="main-logo" alt="logo" style="width: 20%;">
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <table style="padding: 27px;" align="center" border="0" cellpadding="0" cellspacing="0"
                                width="100%">
                                <tr>
                                    <td>
                                        <img src="{{ asset('/frontend/assets/gd-img/order-success-poster.png') }}" alt="" style="width: 100%; height: 100%;">
                                    </td>
                                </tr>
                            </table>

                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="padding: 0 27px;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="title title-2 text-center">
                                                <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0;">Thanks For your
                                                    Order
                                                </h2>
                                                <p
                                                    style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                                                    You'll receive an email when your items are shipped. <br>if you have any
                                                    questions, Call Us +91 - 83188 94257.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @if($order->shippingAddress)
                                <table class="dilivery-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                    style="padding: 20px 32px;width: 100%; background-color:
                                    #f7f7f7;">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="    text-align: left;padding-right: 28px;border-right: 2px solid rgba(217, 217, 217, 0.5);">
                                                <div class="title title-2" style="text-align: left;">
                                                    <h2 style="font-size: 16px;font-weight: 700;margin: 0 0 12px;">Shipping address</h2>
                                                    <p
                                                        style="font-size: 14px;margin: 0;line-height: 1.5;color: #939393;font-weight: 500;">
                                                        
                                                        {{ $order->shippingAddress->full_name }}
                                                        <br>
                                                        {{ $order->shippingAddress->phone_number }}
                                                        <br>
                                                        {{ $order->shippingAddress->full_address }}
                                                        <br>
                                                        {{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->pin_code }}
                                                    </p>
                                                </div>
                                            </td>
                                            @if($order->billingAddress)
                                                <td style="text-align: left;padding-left: 32px;">
                                                    <div class="title title-2" style="text-align: left;">
                                                        <h2 style="font-size: 16px;font-weight: 700;margin: 0 0 12px;">Billing address</h2>
                                                        <p
                                                            style="font-size: 14px;margin: 0;line-height: 1.5;color:#939393;font-weight: 500;">
                                                            
                                                            {{ $order->billingAddress->full_name }}
                                                            <br>
                                                            {{ $order->billingAddress->phone_number }}
                                                            <br>
                                                            {{ $order->billingAddress->full_address }}
                                                            <br>
                                                            {{ $order->billingAddress->city_name }}, {{ $order->billingAddress->state }} {{ $order->billingAddress->pin_code }}
                                                        </p>
                                                    </div>
                                                </td>
                                            @else
                                                <td style="text-align: left;padding-left: 32px;">
                                                    <div class="title title-2" style="text-align: left;">
                                                        <h2 style="font-size: 16px;font-weight: 700;margin: 0 0 12px;">Billing address</h2>
                                                        <p
                                                            style="font-size: 14px;margin: 0;line-height: 1.5;color: #939393;font-weight: 500;">
                                                            
                                                            {{ $order->shippingAddress->full_name }}
                                                            <br>
                                                            {{ $order->shippingAddress->phone_number }}
                                                            <br>
                                                            {{ $order->shippingAddress->full_address }}
                                                            <br>
                                                            {{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->pin_code }}
                                                        </p>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

                            <table class="shipping-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="padding: 0 27px;">
                                <thead>
                                    <tr>
                                        <th
                                            style="font-size: 17px;font-weight: 700;padding-bottom: 8px;border-bottom: 1px solid rgba(217, 217, 217, 0.5);text-align: left;">
                                            Shipped Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        style="column-count: 2;column-rule-style: dashed;column-rule-color: rgba(82, 82, 108, 0.7);column-gap: 22px;column-rule-width: 1px;display: flex;align-items: center;">
                                        <td style="width: 100%;">
                                            <table class="product-table" align="center" border="0" cellpadding="0"
                                                cellspacing="0" width="100%">
                                                <tbody>
                                                @foreach($order->orderLines as $orderLine)
                                                    @php
                                                        $attributes_value ='na';
                                                        if($orderLine->product->ProductAttributesValues->isNotEmpty()){
                                                            $attributes_value = $orderLine->product->ProductAttributesValues->first()->attributeValue->slug;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td
                                                            style="padding: 10px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            <a href="{{url('products/'.$orderLine->product->slug.'/'. $attributes_value) }}">
                                                            @if($orderLine->product->images->first())
                                                                <img style="width: 100%;" src="{{ asset('images/product/thumb/' . $orderLine->product->images->first()->image_path) }}"
                                                                alt="{{ $orderLine->product->title }}">
                                                            @else
                                                                <img style="width: 20%;" src="{{ asset('images/default.png') }}" alt="Default Image">
                                                            @endif
                                                            </a>
                                                            
                                                        </td>
                                                        <td
                                                            style="padding: 28px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                           
                                                                <p>
                                                                    {{ ucwords(strtolower($orderLine->product->title)) }}</p>
                                                                <p>
                                                                    Qty: <span>{{ $orderLine->quantity }}</p>
                                                                <p>
                                                                    Rs.: <span> {{ number_format($orderLine->price, 2) }}
                                                                </p>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>

                                        <td style="width: 70%;">
                                            <table class="dilivery-table" align="center" border="0" cellpadding="0"
                                                style="background-color: #F7F7F7;padding: 14px;" cellspacing="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight: 700;font-size: 17px;padding-bottom: 15px;border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                                            colspan="2">Order summary</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="text-align: left;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            Subtotal</td>
                                                        <td
                                                            style="text-align: right;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            Rs. {{ number_format($order->grand_total_amount, 2) }}</td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td
                                                            style="text-align: left;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            Discount</td>
                                                        <td
                                                            style="text-align: right;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            20,00</td>
                                                    </tr> -->
                                                    <!-- <tr>
                                                        <td
                                                            style="text-align: left;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            Shipping</td>
                                                        <td
                                                            style="text-align: right;font-size: 15px;font-weight: 400;padding: 15px 0;border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                            $00,00</td>
                                                    </tr> -->
                                                    <tr>
                                                        <td
                                                            style="text-align: left;font-size: 15px;font-weight: 600;padding-top: 15px;">
                                                            Total</td>
                                                        <td
                                                            style="text-align: right;font-size: 15px;font-weight: 600;padding-top: 15px;">
                                                            Rs. {{ number_format($order->grand_total_amount, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>
