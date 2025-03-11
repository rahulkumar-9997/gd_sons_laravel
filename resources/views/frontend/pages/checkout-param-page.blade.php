@extends('frontend.layouts.master')
@section('title','GD Sons - Your Shopping Cart')
@section('description', 'GD Sons - Your Shopping Cart')
@section('keywords', 'GD Sons - Your Shopping Cart')

@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Order Param</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Cart Section Start -->
<section class="checkout-section-2 section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-8 col-lg-8 col-md-8">
                <div class="param-btn-area">
                    <div class="row">
                        <div class="col-xxl-12 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-xxl-6 col-lg-6 col-md-6">
                                    <a href="{{ route('pick-up-store') }}" class="pickup_from_stor_btn btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">
                                        Pickup From Store
                                        <div class="additional-info">
                                            <div class="help-tip">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <defs>
                                                        <circle id="b" cx="8" cy="8" r="8"></circle>
                                                        <filter id="a" width="130%" height="130%" x="-15%" y="-8.8%" filterUnits="objectBoundingBox">
                                                            <feMorphology in="SourceAlpha" operator="dilate" radius=".4" result="shadowSpreadOuter1"></feMorphology>
                                                            <feOffset dy="1" in="shadowSpreadOuter1" result="shadowOffsetOuter1"></feOffset>
                                                            <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation=".5"></feGaussianBlur>
                                                            <feComposite in="shadowBlurOuter1" in2="SourceAlpha" operator="out" result="shadowBlurOuter1"></feComposite>
                                                            <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0"></feColorMatrix>
                                                        </filter>
                                                    </defs>
                                                    <g fill="none">
                                                        <g transform="translate(2 1)">
                                                            <use fill="#000" filter="url(#a)" xlink:href="#b"></use>
                                                            <use fill="#FCFCFC" stroke="#000" stroke-opacity=".3" stroke-width=".8" xlink:href="#b"></use>
                                                        </g>
                                                        <text fill="#1D1D1D" font-family="Roboto, sans-serif" font-size="11" font-weight="400" opacity="0.59" transform="translate(2 1)">
                                                            <tspan x="6.6" y="12.2">i</tspan>
                                                        </text>
                                                    </g>
                                                </svg>
                                                <div class="tooltips-class tooltips-other">
                                                    <p>
                                                        If you Pick up your Order from our Varanasi Sigra Store, you get additional discount on all our Products.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxl-6 col-lg-6 col-md-6">
                                    <button onclick="location.href = '{{ route('checkout') }}';" class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Checkout</button>
                                </div>
                                <div class="col-lg-12">
                                    <div class="store-information mt-4 text-center">
                                        <a target="_blank" href="https://maps.app.goo.gl/HKTvX9CWbDNAwGwr5">
                                            <h4>Visit My Store</h4>
                                        </a>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-side-summery-box">
                    <div class="summery-box-2">
                        <div class="summery-header">
                            <h3>Order Summary</h3>
                        </div>
                        <ul class="summery-contain">
                            @php
                            $subtotal = 0;
                            @endphp
                            @foreach ($carts as $cart)
                            @php
                            $mrp = $cart->product->inventories->first() ? $cart->product->inventories->first()->mrp : 0;

                            if($cart->product->offer_rate){
                            $final_offer_rate = $cart->product->offer_rate;
                            if($groupCategory){
                            $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                if ($group_categoty_percentage > 0) {
                                    $purchase_rate = $cart->product->purchase_rate;
                                    $offer_rate = $cart->product->offer_rate;
                                    $percent_discount = 100/$group_categoty_percentage;
                                    $final_offer_rate =
                                    $purchase_rate+($offer_rate-$purchase_rate)*$percent_discount/100;
                                    $final_offer_rate = floor($final_offer_rate);
                                }
                            }
                            $totalPrice = $final_offer_rate * $cart->quantity;
                            $subtotal += $totalPrice;
                            }
                            @endphp
                            <input type="hidden" name="product_id[]" value="{{ $cart->product->id }}">
                            <input type="hidden" name="cart_quantity[]" value="{{ $cart->quantity }}">
                            <input type="hidden" name="cart_offer_rate[]" value="{{ $final_offer_rate }}">
                            <input type="hidden" name="total_price[]" value="{{ $totalPrice }}">
                            <li>
                                @if ($cart->product->images->first())
                                <img src="{{ asset('images/product/thumb/' . $cart->product->images->first()->image_path) }}"
                                    class="img-fluid blur-up lazyloaded checkout-image" alt="{{ $cart->product->name }}" loading="lazy">
                                @else
                                <img src="{{ asset('images/default.png') }}" class="img-fluid blur-up lazyloaded checkout-image" alt="Default Image" loading="lazy">
                                @endif
                                <h4>
                                    {{ ucwords(strtolower($cart->product->title)) }}
                                    <p>
                                        <span>{{$final_offer_rate}} X {{ $cart->quantity }}</span>
                                    </p>
                                </h4>
                                <h4 class="price">
                                    Rs.
                                    {{ number_format($totalPrice, 2) }}
                                </h4>
                            </li>
                            @endforeach
                        </ul>

                        <ul class="summery-total">
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price">Rs.

                                    {{ number_format($subtotal, 2) }}
                                </h4>
                            </li>
                            <li>
                                <h4>Shipping</h4>
                                <h4 class="price">Rs. 0</h4>
                            </li>
                            <li>
                                <h4>Tax</h4>
                                <h4 class="price">Rs. 0</h4>
                            </li>

                            <li>
                                <h4>Coupon/Code</h4>
                                <h4 class="price">Rs. 0</h4>
                            </li>

                            <li class="list-total">
                                <h4>Total (Rs.)</h4>
                                <h4 class="price">Rs.
                                    @php
                                    $total = $subtotal;
                                    @endphp
                                    {{ number_format($total, 2) }}
                                    <input type="hidden" name="grand_total_amount" value="{{$total}}">
                                </h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Cart Section End -->
@endsection
@push('scripts')
@endpush